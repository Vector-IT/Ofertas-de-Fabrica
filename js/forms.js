$(function() {
    
    var $form;
    var $msgShowTime = 1000;

    $("form").submit(function () {
    	$form = $(this);
    	
        switch(this.id) {
            case "login-form":
                var frmData = new FormData();
                frmData.append("usuario", $('#usuario').val().trim());
                frmData.append("password", $('#password').val().trim());
                frmData.append("returnUrl", $("#returnUrl").val());

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
    					if (xmlhttp.responseText.indexOf('ERROR') == -1) {
    						msgChange($('#divMsjLogin'), $('#divBotones'), true, "Login OK", true);
    					}
    					else {
    						msgChange($('#divMsjLogin'), $('#divBotones'), false, "Usuario o contrase&ntilde;a incorrectos.", false);
    					}
    				}
    			};

    			xmlhttp.open("POST","admin/php/loginProcesar.php",true);
    			xmlhttp.send(frmData);
                break;
            	
            case "contacto-form":
				$.post(
					'admin/php/recaptcha.php',
					{
						'response': grecaptcha.getResponse()
					},
					function (data) {
						$msgShowTime = 3000;

						if (!data.success) {
							msgChange($('#divMsjConsulta'), $('#divBotones'), false, "Error de Captcha", false);
							return false;
						} 

						var frmData = new FormData();
						frmData.append("Nombre", $('#nombre').val().trim() + " " + $('#apellido').val().trim());
						frmData.append("Email", $("#email").val().trim());
						frmData.append("Telefono", $("#telefono").val().trim());
						frmData.append("Mensaje", $("#mensaje").val().trim());
						
						if ($("#para").length) {
							frmData.append("Para", $("#para").val().trim());
						}

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
									$('#contacto-form')[0].reset();
									msgChange($('#divMsjContacto'), $('#divBotones'), true, xmlhttp.responseText, false);
								}
								else {
									msgChange($('#divMsjContacto'), $('#divBotones'), false, xmlhttp.responseText, false);
								}
							}
						};

						xmlhttp.open("POST","admin/php/enviarMail.php", true);
						xmlhttp.send(frmData);
					}
				);
            	break;
            
            case "consulta-form":
				$.post(
					'admin/php/recaptcha.php',
					{
						'response': grecaptcha.getResponse()
					},
					function (data) {
						$msgShowTime = 3000;

						if (!data.success) {
							msgChange($('#divMsjConsulta'), $('#divBotones'), false, "Error de Captcha", false);
							return false;
						} 
						
						var strMensaje = "<strong>Nueva consulta en sitio.</strong><br>";
						
						strMensaje+= "<br>Teléfono: " + $form.find("#telefono").val();
						strMensaje+= "<br>Forma de pago: " + $form.find("#tipocoti").val();
						strMensaje+= "<br>Entrega inicial: " + $form.find("#entrega").val();
						strMensaje+= "<br>Monto estimado de cuota que puede abonar: " + $form.find("#cuota").val();
						strMensaje+= "<br>Dispone de: " + $form.find("#dispone").val();
						strMensaje+= "<br>Horario de contacto: " + $form.find("#horadesde").val() + " a " + $form.find("#horahasta").val();
						strMensaje+= "<br>Provincia: " + $form.find("#provincia").val();
						strMensaje+= "<br>Ciudad: " + $form.find("#ciudad").val();
						
						var frmData = new FormData();
						frmData.append("Nombre", $('#nombre').val().trim());
						frmData.append("Email", $("#email").val().trim());
						frmData.append("Mensaje", strMensaje);
						
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
									$('#consulta-form')[0].reset();
									msgChange($('#divMsjConsulta'), $('#divBotones'), true, xmlhttp.responseText, false);
								}
								else {
									msgChange($('#divMsjConsulta'), $('#divBotones'), false, xmlhttp.responseText, false);
								}
							}
						};

						xmlhttp.open("POST","admin/php/enviarMail.php", true);
						xmlhttp.send(frmData);

					}
				);
            	break;
            	
            default: 
            	return true;
        }

		return false;
    });
    
    function msgChange($divMensaje, $divBotones, respuesta, mensaje, refresh) {
    	$divMensaje.find("#txtHint").html(mensaje);
		
		if (respuesta) {
			$divMensaje.removeClass("alert-danger");
			$divMensaje.addClass("alert-success");
			$divBotones.hide();
		}
		else {
			$divMensaje.removeClass("alert-success");
			$divMensaje.addClass("alert-danger");
			$divBotones.show();
		}
		
		$divMensaje.show();

		if (respuesta) {
			setTimeout(function() {
				$divMensaje.hide();
				var dialog = $form.data("dialog");
				if (dialog != "")
					$(dialog).modal('toggle');
				
				if (refresh)
					location.reload();
				
	  		}, $msgShowTime);
		}
    }
});