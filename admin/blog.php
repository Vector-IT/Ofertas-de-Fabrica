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

	<script type="text/javascript">
		var editor;
		
		$(document).ready(function() {
			editor = new wysihtml5.Editor("descripcion", {
				toolbar:      "toolbar",
				stylesheets:  "css/wysihtml-stylesheet.css",
				parserRules:  wysihtml5ParserRules
			});

			$("#imagen").change( previewImg );
			$("#divMsj").hide();
			$("#divMsj2").hide();
			
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
		
		function cargarImagenes() {
			//Borro los datos
	    	$("#divImagenes").html(""); 
		    	
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
					$('#actualizandoImg').css('display', 'none');
					$("#divImagenes").html(xmlhttp.responseText);
				}
			};

			xmlhttp.open("POST","php/blogProcesar.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("operacion=4");
		}

		function selectImg(img) {
			var ruta = window.location.href.replace(window.location.pathname.split('/').pop(), "");
			$("#inpImagen").val(ruta + $(img).attr("src"));
		}

		function subirImg() {
			var mensaje = "";
			
			if ($('#imgNueva').val() == "")
        		mensaje+= "Debe seleccionar una imagen para cargar.";

	        if (mensaje != "") {
				$("#txtHint2").html(mensaje);
				$("#divMsj2").removeClass("alert-success");
				$("#divMsj2").addClass("alert-danger");
				$("#divMsj2").show();
				$("#actualizandoImg").css("display", "none");
				return false;
	        }

		    $('#actualizandoImg').css('display', 'block');
		    
            var frmData = new FormData();

            frmData.append("operacion", "3");
            frmData.append("Imagen", $("#imgNueva").get(0).files[0]);
                        
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
					$("#txtHint2").html(xmlhttp.responseText);
					
					if (xmlhttp.responseText.indexOf('Error') == -1) {
						$("#divMsj2").removeClass("alert-danger");
						$("#divMsj2").addClass("alert-success");
						cargarImagenes();
					}
					else {
						$("#divMsj2").removeClass("alert-success");
						$("#divMsj2").addClass("alert-danger");
					}
						
					$('#actualizandoImg').css('display', 'none');
					$("#divMsj2").show();
				}
			};

			xmlhttp.open("POST","php/blogProcesar.php",true);
			xmlhttp.send(frmData);
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

			xmlhttp.open("POST","php/blogProcesar.php",true);
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
            frmData.append("NumeBlog", $("#numero").val());
            frmData.append("Titulo", $("#titulo").val());
            frmData.append("Dominio", $("#dominio").val());
            frmData.append("Copete", $("#copete").val());
            frmData.append("Descripcion", editor.getValue());
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

			xmlhttp.open("POST","php/blogProcesar.php",true);
			xmlhttp.send(frmData);
		}

    	function editar(strID){
		    if (strID > 0) {
		    	$('html, body').animate({
		            scrollTop: $("#formulario").offset().top
		        }, 1000);

		        editar(0);
		        $('#hdnOperacion').val("1");

		        $('#numero').val(strID);
		    	$('#titulo').val($('#Titulo' + strID).html());
		    	$('#dominio').val($('#Dominio' + strID).val());
		    	$('#copete').val($('#Copete' + strID).val());
		    	editor.setValue($('#Descripcion' + strID).val());
		    	$("#divPreview").html("<img class='thumbnail' src='" + $("#Imagen" + strID).attr("src") + "' />");
	        	$('#imagen').val("");
		    }
		    else {
		        $('#hdnOperacion').val("0");

		        $("#numero").val("");
		        $("#titulo").val("");
		        $('#dominio').val("");
		        $('#copete').val("");
		        editor.setValue("");
		        $("#divPreview").html("");
		        $('#imagen').val("");
			}
		}

    	function borrar(strID){
	        if (confirm("Desea borrar el articulo " + $("#Titulo" + strID).html())){
                $('#hdnOperacion').val("2");
                $('#numero').val(strID);
                aceptar();
	        }
	    }

    	function validar() {
		    var mensaje = "";

	        if ($('#titulo').val().trim().length == 0)
		        mensaje+= "El T&iacute;tulo del art&iacute;culo no puede estar vac&iacute;o.";

	        if ($('#dominio').val().trim().length == 0) {
            	if (mensaje != "")
			        mensaje+= "<br>";

		    	mensaje+= "El campo dominio no puede estar vac&iacute;o.";
            }

	        if ($('#hdnOperacion').val() == "0") {
		        //Nuevo
	        	if ($('#imagen').val() == "") {
			        if (mensaje != "")
				        mensaje+= "<br>";
	        		mensaje+= "Debe seleccionar una imagen de vista previa.";
	        	}
	        }
	        else {
		        //Editando
	        	if (($('#imagen').val() == "") && ($("#divPreview").html() == "")) {
			        if (mensaje != "")
				        mensaje+= "<br>";
	        		mensaje+= "Debe seleccionar una imagen de vista previa.";
	        	}
	        }
	        
            if ($('#copete').val().trim().length == 0) {
		        if (mensaje != "")
			        mensaje+= "<br>";
        		mensaje+= "El campo copete no puede estar vac&iacute;o.";
        	}

		    if (editor.getValue().trim().length == 0) {
		    	if (mensaje != "")
			        mensaje+= "<br>";

		    	mensaje+= "El campo descripci&oacute;n no puede estar vac&iacute;o.";
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
	</script>
	
<body>
	<?php
		include 'php/menu.php';
	?>

	<div class="container">
		<div class="page-header">
			<h2>Blog</h2>
		</div>
		
		<form class="form-horizontal" id="formulario" method="post" onSubmit="return false;">
			<input type="hidden" id="hdnOperacion" value="0" />
			<div class="form-group">
				<div class="col-md-4">
					<input type="button" class="btn btn-primary" onclick="editar(0);" value="Nuevo" />
				</div>
			</div>
			
			<div class="form-group">
				<label for="numero" class="control-label col-md-2">N&uacute;mero:</label>
				<div class="col-md-2">
					<input type="text" class="form-control" id="numero" name="numero" disabled />
				</div>
			</div>
			<div class="form-group">
				<label for="titulo" class="control-label col-md-2">T&iacute;tulo:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="titulo" name="titulo" />
				</div>
			</div>
			<div class="form-group">
				<label for="dominio" class="control-label col-md-2">Dominio:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="dominio" name="dominio" />
				</div>
			</div>
			<div class="form-group">
				<label for="imagen" class="control-label col-md-2">Imagen de vista previa:</label>
				<div class="col-md-4">
					<div id="divPreview">
					</div>
					<input type="file" class="form-control" id="imagen" name="imagen" />
				</div>
			</div>
			<div class="form-group">
				<label for="copete" class="control-label col-md-2">Copete:</label>
				<div class="col-md-10">
					<textarea class="form-control" id="copete" name="copete"></textarea>
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
								<li data-wysihtml5-command="insertImage" title="Insertar una imagen" class="command" href="javascript:;" unselectable="on" onclick="cargarImagenes();"></li>
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
							
							<div id="actualizandoImg" class="alert alert-info" role="alert">
								<i class="fa fa-refresh fa-fw fa-spin"></i> Actualizando datos, por favor espere...
							</div>
							
							<div id="divImagenes"></div>	
							<div>
								<div id="divMsj2" class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<span id="txtHint2">info</span>
								</div>							
								<label>
								Cargar Imagen nueva: <input type="file" class="form-control" style="display: inline;" id="imgNueva" name="imgNueva" />
								</label>
								<button class="btn btn-primary btn-xs" onclick="subirImg();">Cargar</button>
							</div>											
						</div>
					</div>
					<textarea class="form-control" id="descripcion" name="descripcion" rows="25"></textarea>
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
			<span id="txtHint">info</span>
		</div>
		
		<div class="table-responsive" id="divDatos">
			
		</div>
	</div>	
</body>
</html>