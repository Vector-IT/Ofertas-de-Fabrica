<?php 
	session_start();
	
	if (!isset($_SESSION['is_logged_in'])){
		header("Location:login.php?returnUrl=" . $_SERVER[REQUEST_URI]);
		die();
	}
	
	include_once 'php/conexion.php';
	
	$tipoGal = $_GET["tipo"];
	$NumeTipo = $_GET["numeTipo"];
	$NombTipo = buscarDato("SELECT NombTipo FROM tipologias WHERE NumeTipo = " . $NumeTipo);
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'php/linkshead.php'; ?>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("#imagen").change( previewImg );
			
			$("#divMsj").hide();
			
			listar();
		});

		function previewImg(event) {
		    var divPreview = $("#divPreview");
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
					$("#actualizando").css("display", "none");
					$("#divDatos").html(xmlhttp.responseText);
				}
			};

			xmlhttp.open("POST","php/galeriaProcesar.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("operacion=10&tipo=" + $("#hdnTipo").val() + "&NumeTipo=" + $("#numetipo").val());
			
		}

		function aceptar(){
		    $("#actualizando").css("display", "block");
		    
		    var frmData = new FormData();

		    if ($("#hdnOperacion").val() != "2") {
		        if (!validar())
		            return;
			}

		    frmData.append("operacion", $("#hdnOperacion").val());
		    frmData.append("tipo", $("#hdnTipo").val());
		    frmData.append("NumeImag", $("#numero").val());
		    frmData.append("NumeTipo", $("#numetipo").val());
		    frmData.append("NumeOrde", $("#numeorde").val());
		    frmData.append("Imagen", $("#imagen").get(0).files[0]);

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
					
					if (xmlhttp.responseText.indexOf("Error") == -1) {
						$("#divMsj").removeClass("alert-danger");
						$("#divMsj").addClass("alert-success");
						listar();
						editar(0);
					}
					else {
						$("#divMsj").removeClass("alert-success");
						$("#divMsj").addClass("alert-danger");
					}
						
					$("#actualizando").css("display", "none");
					$("#divMsj").show();
				}
			};

			xmlhttp.open("POST","php/galeriaProcesar.php",true);
			xmlhttp.send(frmData);
		}

		function editar(strID) {
			if (strID > 0) {
		    	$("html, body").animate({
		            scrollTop: $("#formulario").offset().top
		        }, 1000);
		        
		        $("#hdnOperacion").val("1");

		        $("#numero").val(strID);
		    	$("#numeorde").val($("#NumeOrde" + strID).html());
		    	$("#divPreview").html("<img class='thumbnail' src='" + $("#Imagen" + strID).attr("src") + "' />");
		    }
		    else {
		        $("#hdnOperacion").val("0");

		        $("#numero").val("");
		        $("#numeorde").val("");
		    	$("#divPreview").html("");
			}
		}

		function validar() {
			var mensaje = "";

		    if ($('#hdnOperacion').val() == "0") {
		        //Nuevo
		    	if ($('#imagen').val() == "") {
			        if (mensaje != "")
				        mensaje+= "<br>";
		    		mensaje+= "Debe seleccionar una imagen.";
		    	}
		    }
		    else {
		        //Editando
		    	if (($('#imagen').val() == "") && ($("#divPreview").html() == "")) {
			        if (mensaje != "")
				        mensaje+= "<br>";
		    		mensaje+= "Debe seleccionar una imagen.";
		    	}
		    }
		        
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

		function borrar(strID){
		    if (confirm("Desea borrar la imagen " + $("#NumeOrde" + strID).html())){
		    	$("#hdnOperacion").val("2");
		    	$("#numero").val(strID);
		        aceptar();
		    }
		}

		function subir(strID) {
			var NumeOrde = $("#NumeOrde" + strID).html();
			
			if (NumeOrde > 1) {
				NumeOrde--;
				
		        $("#hdnOperacion").val("3");

		        $("#numero").val(strID);
		    	$("#numeorde").val(NumeOrde);
		    	$("#divPreview").html("<img class='thumbnail' src='" + $("#Imagen" + strID).attr("src") + "' />");
				
		    	aceptar();
			}
			else {
				$("#txtHint").html("La imagen ya se encuentra en su posici&oacute;n m&aacute;s alta.");
				$("#divMsj").removeClass("alert-success");
				$("#divMsj").addClass("alert-danger");
				$("#divMsj").show();
			}
		}

		function bajar(strID) {
			var NumeOrde = $("#NumeOrde" + strID).html();
			var CantImag = $(".thumbs").size();
			
			if (NumeOrde < CantImag) {
				NumeOrde++;
				
		        $("#hdnOperacion").val("4");

		        $("#numero").val(strID);
		    	$("#numeorde").val(NumeOrde);
		    	$("#divPreview").html("<img class='thumbnail' src='" + $("#Imagen" + strID).attr("src") + "' />");
				
		    	aceptar();
			}
			else {
				$("#txtHint").html("La imagen ya se encuentra en su posici&oacute;n m&aacute;s baja.");
				$("#divMsj").removeClass("alert-success");
				$("#divMsj").addClass("alert-danger");
				$("#divMsj").show();
			}
		}
	</script>	
<body>
	<?php
		include 'php/menu.php';
	?>

	<div class="container">
		<div class="page-header">
			<?php if ($tipoGal == 1) {?>
				<h2>Galer&iacute;a de im&aacute;genes de <?php echo $NombTipo;?></h2>
			<?php } else {?>
				<h2>Galer&iacute;a de renders de <?php echo $NombTipo;?></h2>
			<?php }?>
		</div>
		
		<form class="form-horizontal" id="formulario" method="post" onSubmit="return false;">
			<input type="hidden" id="hdnOperacion" value="0" />
			<input type="hidden" id="hdnTipo" value="<?php echo $tipoGal;?>" />
			<div class="form-group">
				<div class="col-md-4">
					<input type="button" class="btn btn-primary" onclick="history.go(-1);" value="Volver" />
					<input type="button" class="btn btn-primary" onclick="editar(0);" value="Nuevo" />
					<input type="hidden" id="numero" />
					<input type="hidden" id="numetipo" value="<?php echo $NumeTipo;?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="numeorde" class="control-label col-md-2">N&uacute;mero:</label>
				<div class="col-md-2">
					<input type="text" class="form-control" id="numeorde" disabled />
				</div>
			</div>
			<div class="form-group">
				<label for="imagen" class="control-label col-md-2">Imagen:</label>
				<div class="col-md-4">
					<div id="divPreview">
					</div>
					<input type="file" class="form-control" id="imagen" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-4">
					<button type="submit" class="btn btn-primary" onclick="aceptar();">Aceptar</button>
					&nbsp;
					<button type="reset" class="btn btn-default" onclick="editar(0);">Cancelar</button>
				</div>
			</div>
		</form>	
		
		<div id="actualizando" class="alert alert-info" role="alert">
			<i class="fa fa-refresh fa-spin"></i> Actualizando datos, por favor espere...
		</div>
		
		<div id="divMsj" class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span id="txtHint">info</span>
		</div>
		
		<div class="table-responsive" id="divDatos">
		</div>	
		
	</div>	
</body>
</html>