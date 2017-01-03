$(document).ready(function() {
	$("#owl-imagenes").owlCarousel({
		items: 4,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3]
	});
	
	$("#divMsjCoti").hide();
	
	$("#hdnPaso").val("1");
	
	checkPag();
	
	$('#proceso-dialog').on('shown.bs.modal', function () {
		$("#hdnPaso").val("1");
		$("#btnAtras").hide();
		$("#btnSiguiente").data("fin", "0");
		$("#btnSiguiente").html("Siguiente");
		$(".paso").hide();
		$("#paso-1").show();
		
		//selecTipo($("#hdnNumeTipo").val());
		if ($("#hdnAdicionales").val() == "")
			cargarAdicionales($("#hdnNumeTipo").val());

		initMap();
	});

	
	$(".itemImagen").click(function() {
		if (!$(this).hasClass("imgActiva")) {
			$(".imgActiva").removeClass("imgActiva");
			$(this).addClass("imgActiva");
			
			var imagen = "url('" + $(this).find("img").attr("src") + "')";
			
			$("#imgPreview").fadeOut(500, function() {
				$("#imgPreview").css("background-image", imagen);
				$("#imgPreview").fadeIn(500);
			});
			
		}
	});

	$(".pagRight").click(function() {
		var numePagi = $("#numepagi").val();
		
		$(".pagGalActiva").fadeOut(500, function() {
			$(".pagGalActiva").removeClass("pagGalActiva");
			
			$($(".pagGal")[numePagi]).fadeIn(500, function() {
				$($(".pagGal")[numePagi]).addClass("pagGalActiva");
				
				numePagi++;
				
				$("#numepagi").val(numePagi)
				checkPag();
			});
		});
	});

	$(".pagLeft").click(function() {
		var numePagi = $("#numepagi").val();
		
		$(".pagGalActiva").fadeOut(500, function() {
			$(".pagGalActiva").removeClass("pagGalActiva");
			numePagi--;
			
			$($(".pagGal")[numePagi-1]).fadeIn(500, function() {
				$($(".pagGal")[numePagi-1]).addClass("pagGalActiva");
				
				
				$("#numepagi").val(numePagi)
				checkPag();
			});
		});
	});

	$(".itemRender").click(function() {
		if (!$(this).hasClass("renderActiva")) {
			$(".renderActiva").removeClass("renderActiva");
			$(this).addClass("renderActiva");
			
			var imagen = $(this).css("background-image");
			
			$("#renderPreview").fadeOut(500, function() {
				$("#renderPreview").css("background-image", imagen);
				$("#renderPreview").fadeIn(500);
			});
			
		}
	});
	
	$("#btnSiguiente").click(function() {
		var fin = $(this).data("fin");
		
		if (fin == 0) {
			//Siguiente
			
			var paso = $("#hdnPaso").val();
			$("#btnAtras").fadeIn(500);
			
			$("#paso-" + paso).fadeOut(500, function () {
				paso++;
				$("#paso-" + paso).fadeIn(500);
				
				if (paso == 3) {
					$("#btnSiguiente").data("fin", "1");
					$("#btnSiguiente").html("Fin");
				}
				$("#hdnPaso").val(paso);
			});
		}
		else {
			//Fin
			fin = $("#hdnTipoFin").val();

			if (!validarCoti()) {
                return;
			}
			
            var frmData = new FormData();

            frmData.append("operacion", 0);
            frmData.append("NumeTipo", $("#hdnNumeTipo").val());
            frmData.append("TipoCoti", $("#hdnTipoCoti").val());
            frmData.append("Nombre", $("#nombre").val());
            frmData.append("Email", $("#email").val());
            frmData.append("Telefono", $("#telefono").val());
            frmData.append("Adicionales", $("#hdnAdicionales").val().substring(1).replace(new RegExp("#", 'g'), ", "));
            frmData.append("Precio", $("#precio").val());
            frmData.append("Entrega", $("#entrega").val());
            frmData.append("Porcentaje", $("#porcentaje").val());
            frmData.append("CantCuotas", $("#cantcuotas").val());
            frmData.append("MontoCuota", $("#impocuota").val());
            frmData.append("LatLng", $("#latlng").val());
            frmData.append("Distancia", $("#distancia").val());
            frmData.append("Dispone", $("#dispone").val());
            frmData.append("HoraCont", $("#horadesde").val() + " - " + $("#horahasta").val());
			frmData.append("Provincia", $("#provincia").val());
			frmData.append("Ciudad", $("#txtCiudad").val());

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
					
					if (xmlhttp.responseText.indexOf('Error') == -1) {
						$('#proceso-dialog').modal('hide');
						
						var numeCoti = xmlhttp.responseText.replace("EXITO-", "");
						
						switch (fin) {
							case "1":
								location.href='cotizacionPDF.php?NumeCoti=' + numeCoti;
								break;
						
							case "2":
								location.href='cotizacionPrint.php?NumeCoti=' + numeCoti;
								break;
						}

					}
						
				}
			};

			xmlhttp.open("POST","admin/php/cotizacionesProcesar.php",true);
			xmlhttp.send(frmData);
		}
	});
	
	$("#btnAtras").click(function() {
		var paso = $("#hdnPaso").val();
		
		$("#paso-" + paso).fadeOut(500, function () {
			paso--;
			$("#paso-" + paso).fadeIn();
			
			$("#btnSiguiente").data("fin", "0");
			$("#btnSiguiente").html("Siguiente");
			
			if (paso == 1) {
				$("#btnAtras").fadeOut(500);
			}
			$("#hdnPaso").val(paso);
		});
	});
	
	$("#btnCalcularCuota").click(function() {
		var impocuota = 0;
		var precio = parseFloat($("#precio").val());
		var entrega = parseFloat($("#entrega").val());
		var porcentaje = parseFloat($("#porcentaje").val());
		var maxcuotas = parseFloat($("#maxcantcuotas").html());
		var cantcuotas = parseFloat($("#cantcuotas").val());
		var numeTipo = $("#hdnNumeTipo").val();
		
		var mensaje = "";
		
		if (entrega > precio) {
			mensaje+= "La entrega no puede ser mayor al precio ($" + precio + ") de la tipolog&iacute;a seleccionada.";
			$('#entrega').parent().parent().addClass("has-error");
		}

		if (entrega < parseFloat($("#entrega"+numeTipo).val())) {
	    	mensaje+= "La entrega no puede ser menor a $" + $("#entrega"+numeTipo).val() + ".<br>";
	    	$('#entrega').parent().parent().addClass("has-error");
	    }		
		
		if (cantcuotas > maxcuotas) {
			mensaje+= "La cantidad de cuotas establecida no puede superar el máximo permitido.";
			$('#cantcuotas').parent().parent().addClass("has-error");
		}
		
		if (mensaje != "") {
			$("#txtError").html(mensaje);
			return false;
		}
		else {
			$("#txtError").html("");
			$('#entrega').parent().parent().removeClass("has-error");
			$('#cantcuotas').parent().parent().removeClass("has-error");
		}
		
		porcentaje = (porcentaje/100/12);
		
		impocuota = (precio - entrega);
		impocuota = impocuota * ((cantcuotas * porcentaje) + 1) / cantcuotas;
		impocuota = Math.round(impocuota * 100) / 100;
		
		$("#impocuota").val(impocuota);
		
		return false;
	});
});

function checkPag() {
	var cantPagi = $("#cantpagi").val();
	var numePagi = $("#numepagi").val();
	
	if (numePagi == 1)
		$(".pagLeft").css("visibility", "hidden");
	else
		$(".pagLeft").css("visibility", "visible");
	
	if (numePagi == cantPagi)
		$(".pagRight").css("visibility", "hidden");
	else
		$(".pagRight").css("visibility", "visible");
}

function selecTipo(numeTipo) {
	$("#hdnNumeTipo").val(numeTipo);
	
	var $este = $("#check-" + numeTipo);
	
	$(".check").fadeOut(500, function() {
		$este.fadeIn(500);			
	});
	
	$("#precio").val($("#precio"+numeTipo).val());
	$("#entrega").attr("min", $("#entrega"+numeTipo).val());
	$("#porcentaje").val($("#porcentaje"+numeTipo).val());
	$("#maxcantcuotas").html($("#cantcuotas"+numeTipo).val());
	
	if ($("#financiacion"+numeTipo).val() == "1")
		$("#optFinanciacion").css("display", "block");
	else
		$("#optFinanciacion").css("display", "none");
	
	cargarAdicionales(numeTipo);
}

function cargarAdicionales(numeTipo) {
	var strAdicionales = $("#adicionales" + numeTipo).val();
	
	if (strAdicionales.indexOf("#chkBano#") > -1) 
		$("#chkBano").removeClass("oculto");
	else
		$("#chkBano").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkGriferia#") > -1) 
		$("#chkGriferia").removeClass("oculto");
	else
		$("#chkGriferia").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkPinturaExt#") > -1) 
		$("#chkPinturaExt").removeClass("oculto");
	else
		$("#chkPinturaExt").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkPinturaInt#") > -1) 
		$("#chkPinturaInt").removeClass("oculto");
	else
		$("#chkPinturaInt").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkBacha#") > -1) 
		$("#chkBacha").removeClass("oculto");
	else
		$("#chkBacha").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkMesada#") > -1) 
		$("#chkMesada").removeClass("oculto");
	else
		$("#chkMesada").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkBajoMesada#") > -1) 
		$("#chkBajoMesada").removeClass("oculto");
	else
		$("#chkBajoMesada").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkAlacena#") > -1) 
		$("#chkAlacena").removeClass("oculto");
	else
		$("#chkAlacena").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkTanqueAgua#") > -1) 
		$("#chkTanqueAgua").removeClass("oculto");
	else
		$("#chkTanqueAgua").addClass("oculto");
	
	if (strAdicionales.indexOf("#chkElectrico#") > -1) 
		$("#chkElectrico").removeClass("oculto");
	else
		$("#chkElectrico").addClass("oculto");
	
	var strOpcionales = $("#opcionales" + numeTipo).val();
	
	if (strOpcionales != "") {
		$("#chkOpcionales").find("span").html(strOpcionales);
		$("#chkOpcionales").removeClass("oculto");
	}
	else
		$("#chkOpcionales").addClass("oculto");
	
	$(".adicional .fa").removeClass("fa-check").addClass("fa-times");
	$("#hdnAdicionales").val("");
}

function selectAdi(strAdicional) {
	$("#" + strAdicional).find("i.fa").toggleClass("fa-times fa-check");
	var strAdicionales = $("#hdnAdicionales").val();
	
	if ($("#" + strAdicional).find("i.fa").hasClass("fa-check"))
		strAdicionales+= "#" + $("#" + strAdicional).find("span").html();
	else
		strAdicionales = strAdicionales.replace("#" + $("#" + strAdicional).find("span").html(), "");
	
	$("#hdnAdicionales").val(strAdicionales);
}

function selectCoti(strCoti) {
	$("#hdnTipoCoti").val(strCoti);
	
	$(".optCoti").removeClass("optCotiActivo");
	$("#optCoti-" + strCoti).addClass("optCotiActivo");
	$('.optCotiText:not(#optCotiText-' + strCoti + ')').fadeOut();
	$("#optCotiText-" + strCoti).fadeIn();
}

function selectFin(strFin) {
	$("#hdnTipoFin").val(strFin);
	
	$(".optFin").removeClass("optFinActivo");
	$("#optFin-" + strFin).addClass("optFinActivo");
}

function validarCoti() {
	var mensaje = "";
	var numeTipo = $("#hdnNumeTipo").val();
	var tipoCoti = $("#hdnTipoCoti").val();

	/*
    if ($('#latlng').val().trim().length == 0) {
        mensaje+= "Debe seleccionar la ubicación en el mapa.<br>";
    }
	*/
    if ($('#nombre').val().trim().length == 0) {
        mensaje+= "El Nombre no puede estar vac&iacute;o.<br>";
        $('#nombre').parent().addClass("has-error");
    }

    if (($('#telefono').val().trim().length == 0) || ($('#email').val().trim().length == 0)) {
        mensaje+= "Debe proporcionar un Tel&eacute;fono y un E-mail de contacto.<br>";
        $('#telefono').parent().addClass("has-error");
        $('#email').parent().addClass("has-error");
    }
    
    if (tipoCoti == 2) {
	    if (parseFloat($("#entrega").val()) < parseFloat($("#entrega"+numeTipo).val())) {
	    	mensaje+= "La entrega no puede ser menor a $" + $("#entrega"+numeTipo).val() + ".<br>";
	    	$('#entrega').parent().parent().addClass("has-error");
	    }
    }
    
	if ($('#txtCiudad').val().trim().length == 0) {
        mensaje+= "La Ciudad no puede estar vac&iacute;a.<br>";
        $('#txtCiudad').parent().addClass("has-error");
    }

    if (mensaje != "") {
		$("#txtHintCoti").html(mensaje);
		$("#divMsjCoti").removeClass("alert-success");
		$("#divMsjCoti").addClass("alert-danger");
		$("#divMsjCoti").show();
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
	var geocoder = new google.maps.Geocoder();
	
	map.addListener('click', function(event){
		if (marker != null)
			marker.setMap(null);
		
		marker = new google.maps.Marker({
			position: event.latLng,
			map: map
		});

		$("#latlng").val(event.latLng.lat() + ',' + event.latLng.lng());
		
		calcDistancia(geocoder);
	});

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
			
			calcDistancia(geocoder);
		} else {
			alert('Localidad no encontrada');
		}
	});
}

function calcDistancia(geocoder) {
	//Calculo la distancia
	var service = new google.maps.DistanceMatrixService;
	
	var aux = $('#latlng').val();
	var lat = aux.substring(0, aux.indexOf(','));
	var lng = aux.substring(aux.indexOf(',')+1);
	var origen = new google.maps.LatLng(lat, lng);
	
	aux = $('#hdnLatLngFabrica').val();
	lat = aux.substring(0, aux.indexOf(','));
	lng = aux.substring(aux.indexOf(',')+1);
	var destino = new google.maps.LatLng(lat, lng);
	
	service.getDistanceMatrix({
		origins: [origen],
		destinations: [destino],
		travelMode: google.maps.TravelMode.DRIVING,
		unitSystem: google.maps.UnitSystem.METRIC,
		avoidHighways: false,
		avoidTolls: false
	}, function(response, status) {
		if (status == google.maps.DistanceMatrixStatus.OK) {
			var origins = response.originAddresses;
			var destinations = response.destinationAddresses;

			for (var i = 0; i < origins.length; i++) {
				var results = response.rows[i].elements;
				for (var j = 0; j < results.length; j++) {
					var element = results[j];
					var distance = element.distance.text;
					var duration = element.duration.text;
					var from = origins[i];
					var to = destinations[j];
					
					$("#distancia").val(distance);
					
					var preciokm = $("#preciokm").val();
					var flete = distance.replace(' km', '') * preciokm;
					flete = "$ " + Math.round(flete * 100) / 100;
					$("#txtDistancia").html("Distancia de traslado: " + distance);
					$("#txtFlete").html("Precio total del traslado: " + flete);
				}
			}
		}
	});	
}