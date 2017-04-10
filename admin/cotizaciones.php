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
	<?php 
		include_once 'php/linkshead.php';
		include_once 'php/conexion.php';
	?>
	<script src="<?php echo $raiz;?>js/jquery.ns-autogrow.min.js"></script>
	
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCejt6Qtfm6iuDhzNDyQKIWkYo7U3nrhY4&callback=initMap"></script>
				
	<script type="text/javascript">
		$(document).ready(function() {
			$("#divMsj").hide();

			$('#adicionales').css('overflow', 'hidden').autogrow({vertical: true, horizontal: false});
				
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

			xmlhttp.open("POST","php/cotizacionesProcesar.php",true);
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
            frmData.append("NumeCoti", $("#numero").val());
            frmData.append("NumeTipo", $("#tipologia").val());
            frmData.append("TipoCoti", $("#cotizacion").val());
            frmData.append("Adicionales", $("#adicionales").val());
            frmData.append("NumeEsta", $("#estado").val());
            frmData.append("Precio", $("#precio").val());
            frmData.append("Entrega", $("#entrega").val());
            frmData.append("Porcentaje", $("#porcentaje").val());
            frmData.append("CantCuotas", $("#cantcuotas").val());
            frmData.append("MontoCuota", $("#montocuota").val());
            frmData.append("LatLng", $("#latlng").val());

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

			xmlhttp.open("POST","php/cotizacionesProcesar.php",true);
			xmlhttp.send(frmData);
		}

	    function editar(strID){
		    if (strID > 0) {
		    	$('html, body').animate({
		            scrollTop: $("#formulario").offset().top
		        }, 1000);
		        
		        $('#hdnOperacion').val("1");

	            $('#numero').val(strID);
	        	$('#tipologia').val($('#NumeTipo' + strID).val());
	        	$('#cotizacion').val($('#TipoCoti' + strID).val());
	        	$('#adicionales').val($('#Adicionales' + strID).val());
	        	$('#adicionales').css('overflow', 'hidden').autogrow({vertical: true, horizontal: false});
	        	$('#precio').val($('#Precio' + strID).val());
	        	$('#entrega').val($('#Entrega' + strID).val());
	        	$('#porcentaje').val($('#Porcentaje' + strID).val());
	        	$('#cantcuotas').val($('#CantCuotas' + strID).val());
	        	$('#montocuota').val($('#MontoCuota' + strID).val());
	        	$('#latlng').val($('#LatLng' + strID).val());
	        	$("#buscar").val("");
	        	$('#estado').val($('#NumeEsta' + strID).val());

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
		        $('#hdnOperacion').val("0");

		        $("#numero").val("");
		        $("#tipologia").val("");
		        $("#cotizacion").val("");
		        $("#adicionales").val("");
		        $('#adicionales').css('overflow', 'hidden').autogrow({vertical: true, horizontal: false});
	        	$('#precio').val("");
	        	$('#entrega').val("");
	        	$('#porcentaje').val("");
	        	$('#cantcuotas').val("");
	        	$('#montocuota').val("");
	        	$('#latlng').val("");
	        	$("#buscar").val("");
		        $("#estado").val("");

		        if (marker != null)
					marker.setMap(null);
			}
		}

		function borrar(strID){
	        if (confirm("Desea borrar la Cotizacion " + strID)){
                $('#hdnOperacion').val("2");
                $('#numero').val(strID);
                aceptar();
	        }
	    }

	    function validar() {
		    var mensaje = "";

		    if ($("#tipologia").val() == "-1")
			    mensaje+= "Debe seleccionar una tipolog&iacute;a.";

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

	    function calcCuota() {
			var impocuota = 0;
			var precio = parseFloat($("#precio").val());
			var entrega = parseFloat($("#entrega").val());
			var porcentaje = parseFloat($("#porcentaje").val());
			var maxcuotas = parseFloat($("#maxcantcuotas").html());
			var cantcuotas = parseFloat($("#cantcuotas").val());
			
			if (entrega > precio) {
				$("#txtHint").html("La entrega no puede ser mayor al precio ($" + precio + ") de la tipolog&iacute;a seleccionada.");
				$("#divMsj").removeClass("alert-success");
				$("#divMsj").addClass("alert-danger");
				$("#divMsj").show();
				return false;
			}
				
			if (cantcuotas > maxcuotas) {
				$("#txtHint").html("La cantidad de cuotas establecida no puede superar el máximo permitido.");
				$("#divMsj").removeClass("alert-success");
				$("#divMsj").addClass("alert-danger");
				$("#divMsj").show();
				return false;
			}
			
			$("#divMsj").hide();
			
			porcentaje = (porcentaje/100/12);
			
			impocuota = porcentaje * (precio - entrega);
			impocuota = impocuota / (1 - Math.pow((1+porcentaje), (0-cantcuotas)));
			impocuota = Math.round(impocuota * 100) / 100;
			
			$("#montocuota").val(impocuota);
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

		function borrarVarias() {
		    
			var strNumeCoti = '';

			for (I = 0; I < $("input[name='chkNumeCoti']").size(); I++) {
				var chkCoti = $($("input[name='chkNumeCoti']")[I]);

				if (chkCoti.prop("checked")) {
					if (strNumeCoti != '') {
						strNumeCoti+= ', ';
					}

					strNumeCoti+= chkCoti.val();
				}
			}
			
			if (strNumeCoti != '') {
				if (confirm("Seguro que desea borrar las cotizaciones " + strNumeCoti + "?")) {
					 $('#actualizando').css('display', 'block');
					var frmData = new FormData();
					frmData.append("operacion", 3);
					frmData.append("NumeCoti", strNumeCoti);

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

					xmlhttp.open("POST","php/cotizacionesProcesar.php",true);
					xmlhttp.send(frmData);
				}
			}
		}
	</script>
<body>
	<?php
		include 'php/menu.php';
	?>

	<div class="container-fluid">
		<div class="page-header">
			<h2>Cotizaciones</h2>
		</div>

		<form class="form-horizontal" id="formulario" method="post" onSubmit="return false;">
			<input type="hidden" id="hdnOperacion" value="0" />
			<div class="form-group">
				<label for="numero" class="control-label col-md-2">N&uacute;mero:</label>
				<div class="col-md-2">
					<input type="text" class="form-control" id="numero" disabled />
				</div>
			</div>
			<div class="form-group">
				<label for="tipologia" class="control-label col-md-2">Tipolog&iacute;a:</label>
				<div class="col-md-4">
					<select class="form-control" id="tipologia" <?php if ($_SESSION['TipoUsua'] != "1") echo "disabled";?>>
					<?php
						$strSQL = "SELECT NumeTipo, CONCAT(NombFabr, ' - ', NombTipo) NombTipo";
						$strSQL.= " FROM tipologias t";
						$strSQL.= " INNER JOIN fabricas f ON t.NumeFabr = f.NumeFabr";
						$strSQL.= " ORDER BY 2";
						echo cargarCombo($strSQL, "NumeTipo", "NombTipo", '', true);
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="cotizacion" class="control-label col-md-2">Tipo de cotizaci&oacute;n:</label>
				<div class="col-md-4">
					<select class="form-control" id="cotizacion">
						<option value="1">Venta directa</option>
						<option value="2">Financiaci&oacute;n</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="adicionales" class="control-label col-md-2">Adiconales:</label>
				<div class="col-md-4">
					<textarea class="form-control" id="adicionales"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="precio" class="control-label col-md-2">Precio:</label>
				<div class="col-md-4">
					<input type="number" step="0.01" class="form-control" id="precio" />
				</div>
			</div>
			<div class="form-group">
				<label for="entrega" class="control-label col-md-2">Entrega:</label>
				<div class="col-md-4">
					<input type="number" step="0.01" class="form-control" id="entrega" />
				</div>
			</div>
			<div class="form-group">
				<label for="porcentaje" class="control-label col-md-2">Inter&eacute;s anual:</label>
				<div class="col-md-4">
					<input type="number" step="0.01" class="form-control" id="porcentaje" />
				</div>
			</div>
			<div class="form-group">
				<label for="cantcuotas" class="control-label col-md-2">Cantidad de cuotas:</label>
				<div class="col-md-4">
					<input type="number" step="0.01" class="form-control" id="cantcuotas" />
				</div>
				<div class="col-md-2">
					<button class="btn btn-default" onclick="calcCuota();">Calcular monto de la cuota</button>
				</div>
			</div>
			<div class="form-group">
				<label for=montocuota class="control-label col-md-2">Monto de la cuota:</label>
				<div class="col-md-4">
					<input type="number" step="0.01" class="form-control" id="montocuota" />
				</div>
			</div>
			<div class="form-group">
				<label for="estado" class="control-label col-md-2">Estado:</label>
				<div class="col-md-4">
					<select class="form-control" id="estado">
						<option value="0">Inactiva</option>
						<option value="1">Activa</option>
						<option value="2">Procesada</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="map" class="control-label col-md-2">Ubicaci&oacute;n:</label>
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
		
		<p>		
			<button class="btn btn-default" onclick="location.href = 'php/cotizacionesExcel.php';"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
			<button class="btn btn-danger" onclick="borrarVarias()"><i class="fa fa-trash"></i> Borrar varias</button>
		</p>
		<div class="table-responsive" id="divDatos">
		</div>		
	</div>	
</body>
</html>