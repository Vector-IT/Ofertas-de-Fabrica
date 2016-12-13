<?php 
	session_start();
	
	if (!isset($_SESSION['is_logged_in'])) {
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

	<script type="text/javascript">
		$(document).ready(function() {
			$("#divMsj").hide();
			
			listar();
		});

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

			xmlhttp.open("POST","php/usuariosProcesar.php",true);
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
            frmData.append("NumeUsua", $("#numero").val());
            frmData.append("NombComp", $("#nombre").val());
            frmData.append("NombMail", $("#mail").val());
            frmData.append("NombUsua", $("#usuario").val());
            frmData.append("NombPass", $("#password").val());
            frmData.append("TipoUsua", $("#tipo").val());
            frmData.append("NumeFabr", $("#fabrica").val());
            frmData.append("NumeEsta", $("#estado").val());
            
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

			xmlhttp.open("POST","php/usuariosProcesar.php",true);
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
				$("#nombre").val($("#NombComp" + strID).html());
				$("#mail").val($("#NombMail" + strID).val());
				$("#usuario").val($("#NombUsua" + strID).html());
				$("#password").val("****");
				$("#tipo").val($("#TipoUsua" + strID).val());
				$("#fabrica").val($("#NumeFabr" + strID).val());
				$('#estado').val($('#NumeEsta' + strID).val());

				change_tipoUsuario();
		    }
		    else {
		        $('#hdnOperacion').val("0");

		        $("#numero").val("");
				$("#nombre").val("");
				$("#mail").val("");
				$("#usuario").val("");
				$("#password").val("");
				$("#tipo").val(1);
				$("#fabrica").val(-1);
				$("#estado").val(1);
			}
		}

		function borrar(strID){
	        if (confirm("Desea borrar el registro " + $("#NombComp" + strID).html())){
                $('#hdnOperacion').val("2");
                $('#numero').val(strID);
                aceptar();
	        }
	    }

	    function validar() {
		    var mensaje = "";

		    if (parseInt($('#tipo').val()) <= 3) {
		    	if ($('#nombre').val().trim().length == 0) {
		    		if (mensaje != "")
				        mensaje+= "<br>";
				        
			        mensaje+= "El Nombre no puede estar vac&iacute;o.";
		    	}
		    	
		        if ($('#usuario').val().trim().length == 0) {
			        if (mensaje != "")
				        mensaje+= "<br>";
	        		mensaje+= "El Usuario no puede estar vac&iacute;o.";
	        	}	        
	
		        if ($('#password').val().trim().length < 4) {
			        if (mensaje != "")
				        mensaje+= "<br>";
	        		mensaje+= "La Contrase&ntilde;a no puede tener menos de 4 caracteres.";
	        	}	        
		    }

		    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

		    if ($('#mail').val().trim().length == 0) {
	    		if (mensaje != "")
			        mensaje+= "<br>";
			        
		        mensaje+= "El E-Mail no puede estar vac&iacute;o.";
	    	}
		    else if (!re.test($('#mail').val().trim())) {
		    	if (mensaje != "")
			        mensaje+= "<br>";
			        
		        mensaje+= "El E-Mail tiene que tener el formato usuario@servidor.com.";
		    }

		    if ($("#tipo").val() != "1") {
			    if ($("#fabrica").val() == "-1") {
			    	if (mensaje != "")
				        mensaje+= "<br>";
				        
			        mensaje+= "Debe seleccionar una f&aacute;brica.";
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

	    function change_tipoUsuario() {
		    if ($("#tipo").val() == "1") {
		    	$("#fabrica").val("-1");
			    $("#fabrica").prop("disabled", true);
		    }
		    else
		    	$("#fabrica").prop("disabled", false);
	    }
	</script>
</head>
<body>
	<?php
		include("php/menu.php");
	?>

	<div class="container">
		<div class="page-header">
			<h2>Administraci&oacute;n de Usuarios</h2>
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
				<label for="nombre" class="control-label col-md-2">Nombre completo:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="nombre" name="nombre" />
				</div>
			</div>
			<div class="form-group">
				<label for="mail" class="control-label col-md-2">E-Mail:</label>
				<div class="col-md-4">
					<input type="email" class="form-control" id="mail" name="mail" />
				</div>
			</div>
			<div class="form-group">
				<label for="usuario" class="control-label col-md-2">Usuario:</label>
				<div class="col-md-4">
					<input type="text" class="form-control" id="usuario" name="usuario" />
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="control-label col-md-2">Contrase&ntilde;a:</label>
				<div class="col-md-4">
					<input type="password" class="form-control" id="password" name="password" />
				</div>
			</div>
			<div class="form-group">
				<label for="tipo" class="control-label col-md-2">Tipo de usuario:</label>
				<div class="col-md-4">
					<select class="form-control" id="tipo" name="tipo" onchange="change_tipoUsuario();">
						<option value="1">Administrador</option>
						<option value="2">F&aacute;brica</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="fabrica" class="control-label col-md-2">F&aacute;brica:</label>
				<div class="col-md-4">
					<select class="form-control" id="fabrica" disabled>
					<?php echo cargarCombo("SELECT NumeFabr, NombFabr FROM fabricas ORDER BY NombFabr", "NumeFabr", "NombFabr", "", true); ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="control-label col-md-2">Estado:</label>
				<div class="col-md-4">
					<select class="form-control" id="estado" name="estado">
						<option value="1">Activo</option>
						<option value="0">Inactivo</option>
					</select>
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