<?php 
	session_start();
	
	if (!isset($_SESSION['is_logged_in'])){
		header("Location:login.php?returnUrl=" . $_SERVER[REQUEST_URI]);
		die();
	}
	
	if ($_SESSION['TipoUsua'] != "1") {
		header("Location:index.php");
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'php/linkshead.php'; ?>
	
	<!-- bootstrap3-wysiwyg -->
	<link rel="stylesheet" href="css/wysihtml.css">
	<script src="js/advanced.js"></script>
	<script src="js/wysihtml5-0.3.0.js"></script>
	
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUKpFZhPAAWZeSm2Hig0O6xrcR0tNbld4&callback=initMap"></script>
	<script type="text/javascript">
		var editor;
		
		$(document).ready(function() {
			$("#logo").change( previewLogo );
			$("#portada").change( previewPortada );
			$("#menu").change( previewMenu );
			
			$("#divMsj").hide();
			
			editor = new wysihtml5.Editor("descripcion", {
				toolbar:      "toolbar",
				stylesheets:  "css/wysihtml-stylesheet.css",
				parserRules:  wysihtml5ParserRules
			});


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

		function previewLogo(event) {
            var divPreview = $("#divPreviewLogo");

            preview(event, divPreview);
		}

		function previewPortada(event) {
            var divPreview = $("#divPreviewPortada");

            preview(event, divPreview);
		}

		function previewMenu(event) {
            var divPreview = $("#divPreviewMenu");

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

			xmlhttp.open("POST","php/fabricasProcesar.php",true);
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
            frmData.append("NumeFabr", $("#numero").val());
            frmData.append("NombFabr", $("#nombre").val());
            frmData.append("Dominio", $("#dominio").val());
            frmData.append("Telefono", $("#telefono").val());
            frmData.append("Email", $("#email").val());
            frmData.append("PrecioKm", $("#preciokm").val());
            frmData.append("LatLng", $("#latlng").val());
            frmData.append("Descripcion", editor.getValue());
            frmData.append("Logo", $("#logo").get(0).files[0]);
            frmData.append("Menu", $("#menu").get(0).files[0]);
            frmData.append("Portada", $("#portada").get(0).files[0]);
			frmData.append("Estado", $("#chkEstado").prop("checked") ? 1 : 0);

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

			xmlhttp.open("POST","php/fabricasProcesar.php",true);
			xmlhttp.send(frmData);
		}

	    function editar(strID){
		    if (strID > 0) {
		    	$('html, body').animate({
		            scrollTop: $("#formulario").offset().top
		        }, 1000);
		        
		        $('#hdnOperacion').val("1");

	            $('#numero').val(strID);
	        	$('#nombre').val($('#NombFabr' + strID).html());
	        	$('#dominio').val($('#Dominio' + strID).html());
	        	$('#telefono').val($('#Telefono' + strID).val());
	        	$('#email').val($('#Email' + strID).html());
	        	$('#preciokm').val($('#PrecioKm' + strID).val());
	        	$("#buscar").val("");
	        	$('#latlng').val($('#LatLng' + strID).val());
				$("#chkEstado").prop("checked", Boolean(parseInt($("#Estado" + strID).val())));

	        	editor.setValue($('#Descripcion' + strID).val());
		        
		        if ($("#Logo" + strID).val() != "")
		        	$("#divPreviewLogo").html("<img class='thumbnail' src='" + $("#Logo" + strID).val() + "' />");
		        else
		        	$("#divPreviewLogo").html("Seleccione una imagen para el logo de la F&aacute;brica.");
	        	
	        	$('#logo').val("");

	        	if ($("#Menu" + strID).val() != "")
	        		$("#divPreviewMenu").html("<img class='thumbnail' src='" + $("#Menu" + strID).val() + "' />");
	        	else
	        		$("#divPreviewMenu").html("Seleccione una imagen para el menu de la F&aacute;brica.");
        		
	        	$('#menu').val("");

	        	if ($("#Portada" + strID).val() != "")
	        		$("#divPreviewPortada").html("<img class='thumbnail' src='" + $("#Portada" + strID).val() + "' />");
	        	else
	        		$("#divPreviewPortada").html("Seleccione una imagen para la portada de la F&aacute;brica.");
        		
	        	$('#portada').val("");

        		if (marker != null)
					marker.setMap(null);
        	
	        	if ($('#latlng').val() != "") {

	        		var aux = $('#latlng').val();
	        		var lat = aux.substring(0, aux.indexOf(','));
	        		var lng = aux.substring(aux.indexOf(',')+1);
	        		
					var pos = new google.maps.LatLng(lat, lng);
					
					marker = new google.maps.Marker({
						position: pos,
						map: map
					});

					map.setCenter(pos);
	        	}
		    }
		    else {
		    	$("#divPreviewLogo").html("Seleccione una imagen para el logo de la F&aacute;brica.");
		    	$("#divPreviewMenu").html("Seleccione una imagen para el menu de la F&aacute;brica.");
		    	$("#divPreviewPortada").html("Seleccione una imagen para la portada de la F&aacute;brica.");
		    					
		        $('#hdnOperacion').val("0");

		        $("#numero").val("");
		        $("#nombre").val("");
		        $("#dominio").val("");
		        $("#telefono").val("");
		        $("#email").val("");
		        $("#preciokm").val("");
		        $("#latlng").val("");
		        $("#buscar").val("");
		        editor.setValue("");
		        $("#logo").val("");
		        $("#menu").val("");
		        $("#portada").val("");
				$("#chkEstado").prop("checked", false);

		        if (marker != null)
					marker.setMap(null);
			}
		}

		function borrar(strID){
	        if (confirm("Desea borrar la fábrica " + $("#NombFabr" + strID).html())){
                $('#hdnOperacion').val("2");
                $('#numero').val(strID);
                aceptar();
	        }
	    }

	    function validar() {
		    var mensaje = "";

	        if ($('#nombre').val().trim().length == 0)
		        mensaje+= "El Nombre de la fábrica no puede estar vac&iacute;a.<br>";

	        if ($('#dominio').val().trim().length == 0)
		        mensaje+= "El Dominio de la fábrica no puede estar vac&iacute;a.<br>";

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

		var map;
		var marker;
		function initMap() {
			map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: -31.420083, lng: -64.188776},
				zoom: 8
			});

			map.addListener('click', function(event){
				if (marker != null)
					marker.setMap(null);
				
				marker = new google.maps.Marker({
					position: event.latLng,
					map: map
				});

				$("#latlng").val(event.latLng.lat() + ',' + event.latLng.lng()); 
			});

			var geocoder = new google.maps.Geocoder();
			document.getElementById('btnBuscar').addEventListener('click', function() {
				buscarLoc(geocoder);
			});
		}			

		function buscarLoc(geocoder) {
			
			var address = $("#buscar").val();
			
			geocoder.geocode({'address': address}, function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					
					if (marker != null)
						marker.setMap(null);
					
					marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location
					});
					
					$("#latlng").val(results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng());
				} else {
					alert('Localidad no encontrada');
				}
			});
		}
	</script>
<body>
	<?php
		include 'php/menu.php';
	?>

	<div class="container">
		<div class="page-header">
			<h2>F&aacute;bricas</h2>
		</div>

		<form class="form-horizontal" id="formulario" method="post" onSubmit="return false;">
			<input type="hidden" id="hdnOperacion" value="0" />
			<div class="form-group">
				<div class="col-md-1">
					<input type="button" class="btn btn-primary" onclick="editar(0);" value="Nuevo" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="numero" class="control-label col-md-2">N&uacute;mero:</label>
				<div class="col-md-2">
					<input type="text" class="form-control" id="numero" disabled />
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-2 col-md-offset-2">
					<label class="labelCheck">
						<input id="chkEstado" type="checkbox"> Activa?
					</label>
				</div>
			</div>
			<div class="form-group">
				<label for="nombre" class="control-label col-md-2">Nombre:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="nombre" />
				</div>
			</div>
			<div class="form-group">
				<label for="dominio" class="control-label col-md-2">Dominio:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="dominio" />
				</div>
			</div>
			<div class="form-group">
				<label for="logo" class="control-label col-md-2">Logo:</label>
				<div class="col-md-4">
					<div id="divPreviewLogo">
						Seleccione una imagen para el logo de la F&aacute;brica.
					</div>
					<input type="file" class="form-control" id="logo" />
				</div>
			</div>
			<div class="form-group">
				<label for="menu" class="control-label col-md-2">Imagen de menu:</label>
				<div class="col-md-4">
					<div id="divPreviewMenu">
						Seleccione una imagen para el menu de la F&aacute;brica.
					</div>
					<input type="file" class="form-control" id="menu" />
				</div>
			</div>
			<div class="form-group">
				<label for="portada" class="control-label col-md-2">Imagen de portada:</label>
				<div class="col-md-4">
					<div id="divPreviewPortada">
						Seleccione una imagen para la portada de la F&aacute;brica.
					</div>
					<input type="file" class="form-control" id="portada" />
				</div>
			</div>
			<div class="form-group">
				<label for="telefono" class="control-label col-md-2">Tel&eacute;fono:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="telefono" />
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="control-label col-md-2">E-Mail:</label>
				<div class="col-md-4">
					<input type="email" class="form-control" id="email" />
				</div>
			</div>
			<div class="form-group">
				<label for="preciokm" class="control-label col-md-2">Precio del Km:</label>
				<div class="col-md-4">
					<input type="number" class="form-control" id="preciokm" step="0.01" />
				</div>
			</div>
			<div class="form-group">
				<label for="descripcion" class="control-label col-md-2">Descripci&oacute;n:</label>
				<div class="col-md-10">
					<div id="toolbar">
						<header>
							<ul class="commands">
								<li data-wysihtml5-command="bold" title="Negrita (CTRL + B)" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command="italic" title="Cursiva (CTRL + I)" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command="insertUnorderedList" title="Lista con vi&ntilde;etas" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command="insertOrderedList" title="Lista numerada" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command="createLink" title="Insertar un link" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command="insertImage" title="Insertar una imagen" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1" title="T&iacute;tulo 1" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" title="T&iacute;tulo 2" class="command" href="javascript:;" unselectable="on"></li>
								<li data-wysihtml5-command-group="foreColor" class="fore-color" title="Color del texto">
									<ul>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="silver" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="gray" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="maroon" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="purple" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="olive" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="navy" href="javascript:;" unselectable="on"></li>
										<li data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue" href="javascript:;" unselectable="on"></li>
									</ul>
								</li>
								<li data-wysihtml5-command="insertSpeech" title="Insert speech" class="command" href="javascript:;" unselectable="on" style="display: none;"></li>
								<li data-wysihtml5-action="change_view" title="Show HTML" class="action" href="javascript:;" unselectable="on"></li>
							</ul>
						</header>
	<!-- LINKS -->					
						<div data-wysihtml5-dialog="createLink" style="display: none;">
							<label>
							Link:
							<input class="form-control" style="display: inline;" data-wysihtml5-dialog-field="href" value="http://">
							</label>
							<button class="btn btn-primary btn-xs" data-wysihtml5-dialog-action="save">Aceptar</button>&nbsp;<button class="btn btn-default btn-xs" data-wysihtml5-dialog-action="cancel">Cancelar</button>
						</div>
	<!-- IMAGENES -->					
						<div data-wysihtml5-dialog="insertImage" style="display: none;">
							<label>
							Imagen: <input id="inpImagen" class="form-control" style="display: inline;" data-wysihtml5-dialog-field="src" value="http://">
							</label>
							<button class="btn btn-primary btn-xs" data-wysihtml5-dialog-action="save">Aceptar</button>&nbsp;<button class="btn btn-default btn-xs" data-wysihtml5-dialog-action="cancel">Cancelar</button>
						</div>
					</div>
					<textarea class="form-control" id="descripcion" name="descripcion" rows="25"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="map" class="control-label col-md-2">Ubicaci&oacute;n de la F&aacute;brica:</label>
				<div class="col-md-4">
					<input type="hidden" id="latlng" />
					<input type="text" class="form-control" id="buscar" placeholder="Ingrese localidad" /> 
				</div>
				<div class="col-md-2">
					<button class="btn btn-default" id="btnBuscar">Buscar</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-10 col-md-offset-2">
					<div id="map" style="height: 500px;"></div>
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