<?php 
	session_start();
	
	if (!isset($_SESSION['is_logged_in'])){
		header("Location:login.php?returnUrl=" . $_SERVER[REQUEST_URI]);
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'php/linkshead.php'; ?>
		
	<script type="text/javascript">
		$(document).ready(function() {
			$("#imagen").change( previewImagen );
			$("#portada").change( previewPortada );
			$("#plano").change( previewPlano );
			
			$("#divMsj").hide();
			
			listar();
		});

		function preview(event, divPreview) {
        	divPreview.html("");

            var files = event.target.files; //FileList object
            
            for(var i = 0; i< files.length; i++)
            {
                var file = files[i];
                
                //Solo imagenes
                if(!file.type.match('image'))
                  continue;
                
                var picReader = new FileReader();
                
                picReader.addEventListener("load",function(event){
                    
                    var picFile = event.target;
                    
                    divPreview.append("<img id='img" + divPreview.children().length + "' class='thumbnail' src='" + picFile.result + "' />");
                    
                });
                
                 //Leer la imagen
                picReader.readAsDataURL(file);
            }                               
		}

		function previewImagen(event) {
            var divPreview = $("#divPreviewImagen");

            preview(event, divPreview);
		}

		function previewPortada(event) {
            var divPreview = $("#divPreviewPortada");

            preview(event, divPreview);
		}

		function previewPlano(event) {
            var divPreview = $("#divPreviewPlano");

            preview(event, divPreview);
		}
		
	    function listar() {
			//Borro los datos
	    	$("#divDatos").html(""); 
		    	
	    	if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					$('#actualizando').css('display', 'none');
					$("#divDatos").html(xmlhttp.responseText);
				}
			};

			xmlhttp.open("POST","php/tipologiasProcesar.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("operacion=10");
		}

		function aceptar(){
		    $('#actualizando').css('display', 'block');
		    
            var frmData = new FormData();

            if ($("#hdnOperacion").val() != "2") {
                if (!validar())
                    return;
			}
            frmData.append("operacion", $("#hdnOperacion").val());
            frmData.append("NumeTipo", $("#numero").val());
            frmData.append("NombTipo", $("#nombre").val());
            frmData.append("Subtitulo", $("#subtitulo").val());
            frmData.append("NumeFabr", $("#fabrica").val());
            frmData.append("CantHabi", $("#canthabi").val());
            frmData.append("Precio", $("#precio").val());
            frmData.append("Entrega", $("#entrega").val());
            frmData.append("Tipologia", $("#tipologia").val());
            frmData.append("Superficie", $("#superficie").val());
            frmData.append("Opcionales", $("#opcionales").val());

            frmData.append("chkBano", $("#chkBano").prop("checked") ? 1 : 0);
            frmData.append("chkGriferia", $("#chkGriferia").prop("checked") ? 1 : 0);
            frmData.append("chkPinturaExt", $("#chkPinturaExt").prop("checked") ? 1 : 0);
            frmData.append("chkPinturaInt", $("#chkPinturaInt").prop("checked") ? 1 : 0);
            frmData.append("chkBacha", $("#chkBacha").prop("checked") ? 1 : 0);
            frmData.append("chkMesada", $("#chkMesada").prop("checked") ? 1 : 0);
            frmData.append("chkBajoMesada", $("#chkBajoMesada").prop("checked") ? 1 : 0);
            frmData.append("chkAlacena", $("#chkAlacena").prop("checked") ? 1 : 0);
            frmData.append("chkTanqueAgua", $("#chkTanqueAgua").prop("checked") ? 1 : 0);
            frmData.append("chkElectrico", $("#chkElectrico").prop("checked") ? 1 : 0);
            frmData.append("Oferta", $("#chkOferta").prop("checked") ? 1 : 0);
            frmData.append("Premium", $("#chkPremium").prop("checked") ? 1 : 0);
            frmData.append("Mayorista", $("#chkMayorista").prop("checked") ? 1 : 0);
            frmData.append("Financiacion", $("#chkFinanciacion").prop("checked") ? 1 : 0);
            frmData.append("ModificarPDF", $("#chkModificarPDF").prop("checked") ? 1 : 0);

            frmData.append("Porcentaje", $("#porcentaje").val());
            frmData.append("CantCuotas", $("#cantcuotas").val());
                        
            frmData.append("Imagen", $("#imagen").get(0).files[0]);
            frmData.append("Portada", $("#portada").get(0).files[0]);
            frmData.append("Plano", $("#plano").get(0).files[0]);
			if ($("#chkModificarPDF").prop("checked"))
            	frmData.append("ArchivoPDF", $("#archivopdf").get(0).files[0]);

			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					$("#txtHint").html(xmlhttp.responseText);
					
					if (xmlhttp.responseText.indexOf('Error') == -1) {
						$("#divMsj").removeClass("alert-danger");
						$("#divMsj").addClass("alert-success");
						listar();
						editar(0);
					}
					else {
						$("#divMsj").removeClass("alert-success");
						$("#divMsj").addClass("alert-danger");
					}
						
					$('#actualizando').css('display', 'none');
					$("#divMsj").show();
				}
			};

			xmlhttp.open("POST","php/tipologiasProcesar.php",true);
			xmlhttp.send(frmData);
		}

	    function editar(strID){
		    if (strID > 0) {
		    	$('html, body').animate({
		            scrollTop: $("#formulario").offset().top
		        }, 1000);
		        
		        $('#hdnOperacion').val("1");

	            $('#numero').val(strID);
	        	$('#nombre').val($('#NombTipo' + strID).html());
	        	$('#subtitulo').val($('#Subtitulo' + strID).val());
	        	$('#fabrica').val($('#NumeFabr' + strID).val());
	        	$('#canthabi').val($('#CantHabi' + strID).val());
	        	$('#precio').val($('#Precio' + strID).val());
	        	$('#entrega').val($('#Entrega' + strID).val());
	        	$('#tipologia').val($('#Tipologia' + strID).val());
	        	$('#superficie').val($('#Superficie' + strID).val());
	        	$('#opcionales').val($('#Opcionales' + strID).val());
	        	$('#porcentaje').val($('#Porcentaje' + strID).val());
	        	$('#cantcuotas').val($('#CantCuotas' + strID).val());

	        	$("#chkBano").prop("checked", Boolean(parseInt($("#chkBano" + strID).val())));
	        	$("#chkGriferia").prop("checked", Boolean(parseInt($("#chkGriferia" + strID).val())));
	        	$("#chkPinturaExt").prop("checked", Boolean(parseInt($("#chkPinturaExt" + strID).val())));
	        	$("#chkPinturaInt").prop("checked", Boolean(parseInt($("#chkPinturaInt" + strID).val())));
	        	$("#chkBacha").prop("checked", Boolean(parseInt($("#chkBacha" + strID).val())));
	        	$("#chkMesada").prop("checked", Boolean(parseInt($("#chkMesada" + strID).val())));
	        	$("#chkBajoMesada").prop("checked", Boolean(parseInt($("#chkBajoMesada" + strID).val())));
	        	$("#chkAlacena").prop("checked", Boolean(parseInt($("#chkAlacena" + strID).val())));
	        	$("#chkTanqueAgua").prop("checked", Boolean(parseInt($("#chkTanqueAgua" + strID).val())));
	        	$("#chkElectrico").prop("checked", Boolean(parseInt($("#chkElectrico" + strID).val())));
	        	$("#chkOferta").prop("checked", Boolean(parseInt($("#Oferta" + strID).val())));
	        	$("#chkPremium").prop("checked", Boolean(parseInt($("#Premium" + strID).val())));
	        	$("#chkMayorista").prop("checked", Boolean(parseInt($("#Mayorista" + strID).val())));
	        	$("#chkFinanciacion").prop("checked", Boolean(parseInt($("#Financiacion" + strID).val())));
	        	$("#chkModificarPDF").prop("checked", false);
	        	
		        if ($("#Imagen" + strID).val() != "")
		        	$("#divPreviewImagen").html("<img class='thumbnail' src='" + $("#Imagen" + strID).val() + "' />");
		        else
		        	$("#divPreviewImagen").html("Seleccione una imagen.");
	        	
	        	$('#imagen').val("");

	        	if ($("#Portada" + strID).val() != "")
	        		$("#divPreviewPortada").html("<img class='thumbnail' src='" + $("#Portada" + strID).val() + "' />");
	        	else
	        		$("#divPreviewPortada").html("Seleccione una imagen de portada.");
        		
	        	$('#portada').val("");

	        	if ($("#Plano" + strID).val() != "")
		        	$("#divPreviewPlano").html("<img class='thumbnail' src='" + $("#Plano" + strID).val() + "' />");
		        else
		        	$("#divPreviewPlano").html("Seleccione una imagen de plano.");
	        	
	        	$('#plano').val("");
	        	
	        	$('#archivopdf').val("");
		    }
		    else {
		    	$("#divPreviewImagen").html("Seleccione una imagen.");
		    	$("#divPreviewPortada").html("Seleccione una imagen de portada.");
		    	$("#divPreviewPlano").html("Seleccione una imagen de plano.");
		    					
		        $('#hdnOperacion').val("0");

		        $("#numero").val("");
		        $("#nombre").val("");
		        $("#subtitulo").val("");
		        $("#fabrica").val("<?php echo $_SESSION["NumeFabr"];?>");
		        $('#canthabi').val("");
		        $('#precio').val("");
		        $('#entrega').val("");
		        $("#imagen").val("");
		        $("#portada").val("");
		        $("#plano").val("");
		        $("#archivopdf").val("");
		        $("#tipologia").val("");
		        $("#superficie").val("");
		        $("#opcionales").val("");
		        $('#porcentaje').val("");
	        	$('#cantcuotas').val("");

		        $("#chkBano").prop("checked", false);
		        $("#chkGriferia").prop("checked", false);
		        $("#chkPinturaExt").prop("checked", false);
		        $("#chkPinturaInt").prop("checked", false);
		        $("#chkBacha").prop("checked", false);
		        $("#chkMesada").prop("checked", false);
		        $("#chkBajoMesada").prop("checked", false);
		        $("#chkAlacena").prop("checked", false);
		        $("#chkTanqueAgua").prop("checked", false);
		        $("#chkElectrico").prop("checked", false);
		        $("#chkOferta").prop("checked", false);
		        $("#chkPremium").prop("checked", false);
		        $("#chkMayorista").prop("checked", false);
		        $("#chkFinanciacion").prop("checked", false);
		        $("#chkModificarPDF").prop("checked", false);
			}
		}

		function borrar(strID){
	        if (confirm("Desea borrar la Tipologia " + $("#NombTipo" + strID).html())){
                $('#hdnOperacion').val("2");
                $('#numero').val(strID);
                aceptar();
	        }
	    }

	    function validar() {
		    var mensaje = "";

	        if ($('#nombre').val().trim().length == 0)
		        mensaje+= "El Nombre no puede estar vac&iacute;o.<br>";

	        if (mensaje != "") {
				$("#txtHint").html(mensaje);
				$("#divMsj").removeClass("alert-success");
				$("#divMsj").addClass("alert-danger");
				$("#divMsj").show();
				$("#actualizando").css("display", "none");
				return false;
	        }
	        else
		        return true;
	    }

	    function galeria(strID, tipo) {
		    location.href = "galeria.php?tipo=" + tipo + "&numeTipo=" + strID;
	    }
	</script>
<body>
	<?php
		include 'php/menu.php';
	?>

	<div class="container">
		<div class="page-header">
			<h2>Tipolog&iacute;as</h2>
		</div>

		<form class="form-horizontal" id="formulario" method="post" onSubmit="return false;">
			<input type="hidden" id="hdnOperacion" value="0" />
			<div class="form-group">
				<div class="col-md-4">
					<input type="button" class="btn btn-primary" onclick="editar(0);" value="Nuevo" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="numero" class="control-label col-md-4">N&uacute;mero:</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="numero" disabled />
					</div>
				</div>
				<div class="form-group">
					<label for="nombre" class="control-label col-md-4">Nombre:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="nombre" />
					</div>
				</div>
				<div class="form-group">
					<label for="subtitulo" class="control-label col-md-4">Subtitulo:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="subtitulo" />
					</div>
				</div>
				<div class="form-group">
					<label for="fabrica" class="control-label col-md-4">F&aacute;brica:</label>
					<div class="col-md-8">
						<select class="form-control" id="fabrica" <?php if ($_SESSION['TipoUsua'] != "1") echo "disabled";?>>
						<?php echo cargarCombo("SELECT NumeFabr, NombFabr FROM fabricas ORDER BY NombFabr", "NumeFabr", "NombFabr", $_SESSION["NumeFabr"]); ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="canthabi" class="control-label col-md-4">Cantidad de habitaciones:</label>
					<div class="col-md-8">
						<input type="number" class="form-control" id="canthabi" />
					</div>
				</div>
				<div class="form-group">
					<label for="precio" class="control-label col-md-4">Precio:</label>
					<div class="col-md-8">
						<input type="number" class="form-control" id="precio" />
					</div>
				</div>
				<div class="form-group">
					<label for="entrega" class="control-label col-md-4">Entrega:</label>
					<div class="col-md-8">
						<input type="number" class="form-control" id="entrega" />
					</div>
				</div>
				<div class="form-group">
					<label for="imagen" class="control-label col-md-4">Imagen:</label>
					<div class="col-md-8">
						<div id="divPreviewImagen">
							Seleccione una imagen.
						</div>
						<input type="file" class="form-control" id="imagen" />
					</div>
				</div>
				<div class="form-group">
					<label for="portada" class="control-label col-md-4">Imagen de portada:</label>
					<div class="col-md-8">
						<div id="divPreviewPortada">
							Seleccione una imagen de portada.
						</div>
						<input type="file" class="form-control" id="portada" />
					</div>
				</div>
				<div class="form-group">
					<label for="plano" class="control-label col-md-4">Imagen de plano:</label>
					<div class="col-md-8">
						<div id="divPreviewPlano">
							Seleccione una imagen de plano.
						</div>
						<input type="file" class="form-control" id="plano" />
					</div>
				</div>
				<div class="form-group">
					<label for="tipologia" class="control-label col-md-4">Tipologia:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="tipologia" />
					</div>
				</div>
				<div class="form-group">
					<label for="superficie" class="control-label col-md-4">Superficie:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="superficie" />
					</div>
				</div>
				<div class="form-group">
					<label for="porcentaje" class="control-label col-md-4">Porcentaje de interés:</label>
					<div class="col-md-8">
						<input type="number" class="form-control" id="porcentaje" />
					</div>
				</div>
				<div class="form-group">
					<label for="cantcuotas" class="control-label col-md-4">M&aacute;xima cantidad de cuotas:</label>
					<div class="col-md-8">
						<input type="number" class="form-control" id="cantcuotas" />
					</div>
				</div>
				<div class="form-group">
					<label for="archivopdf" class="control-label col-md-4">Archivo PDF:</label>
					<div class="col-md-8">
						<label class="labelCheck">
							<input id="chkModificarPDF" type="checkbox"> Subir PDF?
						</label>
						<input type="file" class="form-control" id="archivopdf" />
					</div>
				</div>
				
			</div>
			
			<div class="col-md-5 col-md-offset-1">
				<div class="form-group">
					<label class="control-label col-md-12" style="text-align: left !important;">Adicionales</label>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkBano" type="checkbox"> Ba&ntilde;o
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkGriferia" type="checkbox"> Griferia
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkPinturaExt" type="checkbox"> Pintura exterior
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkPinturaInt" type="checkbox"> Pintura interior
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkBacha" type="checkbox"> Bacha
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkMesada" type="checkbox"> Mesada
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkBajoMesada" type="checkbox"> Bajo mesada
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkAlacena" type="checkbox"> Alacena
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkTanqueAgua" type="checkbox"> Tanque de agua
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkElectrico" type="checkbox"> Kit el&eacute;ctrico
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="opcionales" class="control-label col-md-2" style="text-align: left !important;">Otros:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="opcionales" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkOferta" type="checkbox"> Es oferta?
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkPremium" type="checkbox"> Es Premium?
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkMayorista" type="checkbox"> Es Mayorista?
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-10">
						<label class="labelCheck">
							<input id="chkFinanciacion" type="checkbox"> Financiaci&oacute;n?
						</label>
					</div>
				</div>
			</div>
			<div class="col-md-12">			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
						<button type="submit" class="btn btn-primary" onclick="aceptar();">Aceptar</button>
						&nbsp;
						<button type="reset" class="btn btn-default" onclick="editar(0);">Cancelar</button>
					</div>
				</div>
			</div>
			<div class="clearer"></div>
		</form>	
		
		<div id="actualizando" class="alert alert-info" role="alert">
			<i class="fa fa-refresh fa-fw fa-spin"></i> Actualizando datos, por favor espere...
		</div>
		
		<div id="divMsj" class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span id="txtHint">Info</span>
		</div>
		
		<div class="table-responsive" id="divDatos">
		</div>		
	</div>	
</body>
</html>