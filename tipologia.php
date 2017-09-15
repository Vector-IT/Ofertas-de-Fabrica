<?php 
	session_start();
	include_once 'admin/php/conexion.php';
	
	$dominioFabrica = $_GET["fabrica"];
	$dominioTipologia = str_replace("%20", " ", $_GET["tipologia"]);
	$dominioTipologia = str_replace("-", " ", $_GET["tipologia"]);
	
	$tabla = cargarTabla("SELECT NumeFabr, NombFabr, Logo, LatLng, PrecioKm, Telefono FROM fabricas WHERE Dominio = '{$dominioFabrica}'");
	
	if ($tabla->num_rows > 0) {
		$fabrica = $tabla->fetch_array();
		
		$tabla->free();
		
		$strSQL = "SELECT NumeTipo, NombTipo, Subtitulo, Tipologia, Superficie, Opcionales, Portada, Plano,";
		$strSQL.= " chkBano, chkGriferia, chkPinturaExt, chkPinturaInt, chkBacha, chkMesada, chkBajoMesada,";
		$strSQL.= " chkAlacena, chkTanqueAgua, chkElectrico, Oferta, Premium, Precio, Entrega, Porcentaje,";
		$strSQL.= " CantCuotas, Financiacion, PDF, Imagen";
		$strSQL.= " FROM tipologias";
		$strSQL.= " WHERE NombTipo = '{$dominioTipologia}' AND NumeFabr = {$fabrica["NumeFabr"]}";
				
		$tabla = cargarTabla($strSQL);
		if ($tabla->num_rows > 0)
			$tipologia = $tabla->fetch_array();
		else
			header("location:index.php");	}
	else
		header("location:index.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - <?php echo $tipologia["NombTipo"]?></title>
	
	<?php include_once 'php/linksHead.php';?>
	
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCejt6Qtfm6iuDhzNDyQKIWkYo7U3nrhY4"></script>
	
	<link href="<?php echo $raiz;?>css/tipologia.css" rel="stylesheet" type="text/css">

	<!-- OWL Carousel -->	
	<link rel="stylesheet" href="<?php echo $raiz;?>owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo $raiz;?>owl-carousel/owl.theme.css">
	<script src="<?php echo $raiz;?>owl-carousel/owl.carousel.js"></script>
	
	<script src="<?php echo $raiz;?>js/tipologia.js"></script>
	
    
    <meta property="og:title" content="<?php echo $tipologia["NombTipo"]?>" />
    <meta property="og:description" content="<?php echo $tipologia["Subtitulo"]?>" />
	<meta property="og:image" content="http://ofertasdefabrica.com.ar/admin/<?php echo $tipologia["Imagen"]?>" />
	
</head>
<body>
<script>
  //This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      $('#status').html('');

      $('#nombre').val('');
      $('#email').val('');
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
    	$('#status').html('');

    	$('#nombre').val('');
    	$('#email').val('');
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '237103856628974',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use graph api version 2.5
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/es_LA/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');

    FB.api('/me', {fields: 'id,name,email'}, function(response) {
      console.log('Successful login for: ' + response.name);
      
      //$('#status').html('Has iniciado sesión como, ' + response.name + '!');

      $('#nombre').val(response.name);
      $('#email').val(response.email);
    });
  }  
</script>
	<?php include_once 'php/header.php';?>

	<div class="row divLogo">
		<div class="col-md-3 txtLeft">
			<img alt="<?php echo $fabrica["NombFabr"]?>" src="admin/<?php echo $fabrica["Logo"];?>" style="width: 80%; height: auto;" />
			<br><br>
			<span class="cajaRoja clickable" data-js="history.go(-1);">&lt;- Volver</span>
		</div>
		<div class="col-md-6 txtCenter">
			<span class="cajaRoja txtBold clickable" data-js="$('#proceso-dialog').modal('show');">ELEG&Iacute; TU CASA</span>
			<h2><?php echo $tipologia["Subtitulo"];?></h2>
			<h3 class="fontAbel">Sin intermediarios, directo de f&aacute;brica</h3>			
		</div>
		<div class="col-md-3 txtRight">
			<div class="txtCenter clickable" data-toggle="modal" data-target="#chat-dialog">
				<img alt="Telemarketer" src="img/telemarketer.png" />
				<br><br>
				<span class="cajaRoja">Respondemos tu consulta online</span>
			</div>
		</div>
	</div>
	
	<div class="row text-center">
		<img alt="Portada" src="admin/<?php echo $tipologia["Imagen"];?>" style="width: 75%; height: auto; margin:0 auto;" />
	</div>
	
	<div class="row">
		<div class="col-md-6 txtCenter">
			<img alt="Plano" src="admin/<?php echo $tipologia["Plano"];?>" style="width: 100%; height: auto;" />
			<?php if ($tipologia["PDF"] != "") {?>
			<br><span class="cajaRoja clickable" data-url="admin/<?php echo $tipologia["PDF"]?>">Descargar Ficha Técnica</span>
			<?php }?>
		</div>
		<div class="col-md-6 txtCenter">
			<h3 class="fontAbel">Vivienda de <?php echo $dominioTipologia;?></h3>
			<div class="col-md-10 col-md-offset-1 marginTop40" style="font-size: 14pt;">
				<div class="row bordeAbajo">
					<div class="col-md-6 txtLeft txtBold">
						Tipolog&iacute;a
					</div>
					<div class="col-md-6 txtLeft">
						<?php echo $tipologia["Tipologia"];?>
					</div>
				</div>
				<div class="row bordeAbajo">
					<div class="col-md-6 txtLeft txtBold">
						Superficie
					</div>
					<div class="col-md-6 txtLeft">
						<?php echo $tipologia["Superficie"];?>
					</div>
				</div>
				<div class="row bordeAbajo">
					<div class="col-md-6 txtLeft txtBold">
						Precio
					</div>
					<div class="col-md-6 txtLeft">
						$ <?php echo $tipologia["Precio"];?>
					</div>
				</div>
				<div class="row bordeAbajo">
					<div class="col-md-6 txtLeft txtBold">
						Adicionales
					</div>
					<div class="col-md-6 txtLeft">
						<?php
							$strSalida = "";
							
							if ($tipologia["chkBano"]) $strSalida.= "Ba&ntilde;o<br>";
							if ($tipologia["chkGriferia"]) $strSalida.= "Grifer&iacute;a<br>";
							if ($tipologia["chkPinturaExt"]) $strSalida.= "Pintura exterior<br>";
							if ($tipologia["chkPinturaInt"]) $strSalida.= "Pintura interior<br>";
							if ($tipologia["chkBacha"]) $strSalida.= "Bacha<br>";
							if ($tipologia["chkMesada"]) $strSalida.= "Mesada<br>";
							if ($tipologia["chkBajoMesada"]) $strSalida.= "Bajo mesada<br>";
							if ($tipologia["chkAlacena"]) $strSalida.= "Alacena<br>";
							if ($tipologia["chkTanqueAgua"]) $strSalida.= "Tanque de agua<br>";
							if ($tipologia["chkElectrico"]) $strSalida.= "Kit el&eacute;ctrico<br>";
							
							$strSalida.= $tipologia["Opcionales"];
								
							echo $strSalida;
						?>
					</div>
				</div>
				<div class="row marginTop40" style="font-size: 12pt;">
					<div class="col-md-6">
						<button class="btn btn-default btnblink" data-toggle="modal" data-target="#proceso-dialog" onclick="selectCoti(1);">COMPRA DIRECTA</button>
					</div>
					<div class="col-md-6">
						<?php if ($tipologia["Financiacion"] == "1") {?>
							<button class="btn btn-default btnblink" data-toggle="modal" data-target="#proceso-dialog" onclick="selectCoti(2);">FINANCIACI&Oacute;N</button>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
	<?php
		$imagenes = cargarTabla("SELECT Imagen FROM tipologiasimagenes WHERE NumeTipo = {$tipologia["NumeTipo"]} AND Tipo = 1 ORDER BY NumeOrde");
		
		if ($imagenes->num_rows > 0) {
			$strSalida = '';
				
			$I = 0;
			
			while ($fila = $imagenes->fetch_array()) {
				if ($I == 0) {
					$strSalida.= $crlf.'<div id="imgPreview" style="background: url(\'admin/'. $fila["Imagen"] .'\') center/contain no-repeat;"></div>';
					$strSalida.= $crlf.'<div id="owl-imagenes">';
					$strSalida.= $crlf.'<div class="item itemImagen imgActiva clickable"><img src="admin/'. $fila["Imagen"] .'" alt="" style="width: 100%; height: 250px;"></div>';
				}
				else {
					$strSalida.= $crlf.'<div class="item itemImagen clickable"><img src="admin/'. $fila["Imagen"] .'" alt="" style="width: 100%; height: 250px;"></div>';
				}
				
				$I++;
			}
			
			$strSalida.= $crlf.'</div>';
			
			echo $strSalida;
			
			$imagenes->free();
		}
	?>		
	</div>
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2 txtCenter">
			<h1 class="fontAbel">Construir una vivienda es crear un hogar</h1>
			<h3>Sin sorteos, sin licitación</h3>
		</div>
		<div class="col-md-2 txtRight">
			<a href="#" onclick="return false;" data-toggle="modal" data-target="#proceso-dialog"><img alt="Cotizar ahora" src="img/cotizar-ahora.png" style="width: 100%; height: auto;" /></a>
		</div>
	</div>
	<div class="row">
	<?php
		$renders = cargarTabla("SELECT Imagen FROM tipologiasimagenes WHERE NumeTipo = {$tipologia["NumeTipo"]} AND Tipo = 2 ORDER BY NumeOrde");
		
		if ($renders->num_rows > 0) {
			$strSalida = '';
			$strSalida.= $crlf.'<div style="display: none;">';
			$strSalida.= $crlf.'<input type="hidden" id="numepagi" value="1" />';
			$strSalida.= $crlf.'<input type="hidden" id="cantpagi" value="'. ceil($renders->num_rows / 3) . '" />';
			$strSalida.= $crlf.'</div>';
				
			$I = 0;
				
			while ($fila = $renders->fetch_array()) {
				if ($I == 0) {
					$strSalida.= $crlf.'<div class="col-md-8" id="renderPreview" style="background: url(\'admin/'. $fila["Imagen"] .'\') center/contain no-repeat;"></div>';
					$strSalida.= $crlf.'<div class="col-md-4" id="renderThumbs">';
					$strSalida.= $crlf.'<div class="pagGal pagGalActiva">';
				}
				elseif (($I % 3) == 0) {
					$strSalida.= $crlf.'<div class="pagGal">';
				}

				if ($I == 0) {
					$strSalida.= $crlf.'<div class="item itemRender renderActiva clickable" style="background: url(\'admin/'. $fila["Imagen"] .'\') center/contain no-repeat;"></div>';
				}
				else {
					$strSalida.= $crlf.'<div class="item itemRender clickable" style="background: url(\'admin/'. $fila["Imagen"] .'\') center/contain no-repeat;"></div>';
				}
				
				if (($I > 0) && (($I % 2) == 0))
					$strSalida.= $crlf.'</div>';
		
				$I++;
			}
				
			$strSalida.= $crlf.'</div>';
			
			if (ceil($renders->num_rows / 3) > 1) {
				$strSalida.= $crlf.'<div class="galPaginador">';
				$strSalida.= '<span class="pagLeft clickable"><i class="fa fa-chevron-left"></i></span>';
				$strSalida.= '<span class="pagCent">&nbsp;</span>';
				$strSalida.= '<span class="pagRight clickable"><i class="fa fa-chevron-right"></i></span>';
				$strSalida.= $crlf.'</div>';
			}
			
			$strSalida.= $crlf.'</div>';
			$strSalida.= $crlf.'<div class="clearer"></div>';
			
			echo $strSalida;
				
			$renders->free();
		}		
	?>
	</div>
	
	<img alt="Portada" src="admin/<?php echo $tipologia["Portada"];?>" style="width: 100%; height: auto;" />
	
	<div class="row txtCenter marginTop40">
	<?php
		$tabla = cargarTabla("SELECT NombTipo FROM tipologias WHERE NombTipo <> '{$dominioTipologia}' AND NumeFabr = {$fabrica["NumeFabr"]} ORDER BY NombTipo LIMIT 1");
		if ($tabla->num_rows > 0) {
			$fila = $tabla->fetch_array();
			$strSalida = '<span class="cajaRoja clickable" data-url="fabrica/'. $dominioFabrica . "/" . str_replace(" ", "-", $fila["NombTipo"]) .'">SIGUIENTE</span><br><br>';
		
			echo $strSalida;
			
			$tabla->free();
		}
	?>
		<span class="clickable" data-js="$('#proceso-dialog').modal('show');"><span class="txtBold">ELEG&Iacute; TU CASA</span> / COTIZAR / COMPR&Aacute;</span>
	</div>
	
	<div class="clearer marginTop40"></div>
	
	<?php 
		include_once 'php/footer.php';
		
		include_once 'php/proceso.php';
		
		include_once 'php/chat-dialog.php';
	?>
</body>
</html>