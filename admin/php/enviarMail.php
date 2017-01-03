<?php
ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$nombre = $_POST['Nombre'];
		$email = $_POST['Email'];
		$mensaje = $_POST['Mensaje'];
		
		if (isset($_POST["Para"])) {
			$para = $_POST["Para"];
			//$para = 'jmperro@gmail.com';
		}
		else {
			$para = 'defabricaofertas@gmail.com';
			//$para = 'jmperro@gmail.com';
		}
		
		if (isset($_POST["Titulo"])) {
			$titulo = $_POST["Titulo"];
		}
		else {
			$titulo = 'Contacto en Ofertas de Fábrica';
		}

		$mensaje = "Nombre: $nombre<br>E-Mail: $email<br>Mensaje:<br>$mensaje";

		$msjCorreo = '<html><head><title>' . $titulo . '</title></head><body>';
		$msjCorreo.= $mensaje;
		$msjCorreo.= '</body></html>';
		
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header.= 'From: Ofertas de Fabrica <info@ofertasdefabrica.com.ar>' . "\r\n";;
		$header.= 'Cc: defabricaofertas@gmail.com' . "\r\n";
		
		if (mail($para, $titulo, $msjCorreo, $header)) {
			echo "Datos enviados!";
		}
		else {
			echo "Error al enviar datos!";
		}
		
		/*
		require("phpmailer/PHPMailerAutoload.php");
		$mail = new PHPMailer;
		
		$mail->CharSet = 'UTF-8';
		$mail->setLanguage('es', 'language');
		$mail->isSMTP();                                      // Set mailer to use SMTP
		
		$mail->SMTPDebug = 1; 								  // debugging: 1 = errors and messages, 2 = messages only
		$mail->Host = 'smtp.gmail.com';						  // Specify main and backup server
		$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
		$mail->Port = 465;                                    //Set the SMTP port number - 587 for authenticated TLS
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'odefabrica@gmail.com';		  	  // SMTP username
		$mail->Password = 'vector';               		  // SMTP password
		
		$mail->setFrom('odefabrica@gmail.com', 'Ofertas de Fábrica');     //Set who the message is to be sent from
		
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = $titulo;
		$mail->addAddress($para);  // Add a recipient
		$mail->addCC('defabricaofertas@gmail.com');

		$mail->Body    = $msjCorreo;
		$mail->AltBody = $mensaje;
		
		if($mail->send()) {
			echo "Datos enviados!";
		} 
		else {
			error_log($mail->ErrorInfo);

			echo "Error al enviar datos!";
		}
		*/
	} 
	else {
		header('HTTP/1.1 403 Forbidden');
		header('Status: 403 Forbidden');
	}	
?>
