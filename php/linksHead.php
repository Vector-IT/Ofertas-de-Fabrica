<meta charset="UTF-8">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<!-- <meta name="author" content="Vector-IT" /> -->
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

<link rel="shortcut icon" href="img/logo.png" type="image/png" />
<link rel="apple-touch-icon" href="img/logo.png"/>

<?php if (!strpos($_SERVER['QUERY_STRING'], 'tipologia=')) {?>
<!-- HOLA -->
<meta property="og:title" content="Ofertas de Fábrica!" />
<meta property="og:image" content="http://ofertasdefabrica.com.ar/img/logo2.png" />
<meta property="og:description" content="El sitio donde podrás encontrar las mejores ofertas y descuentos especiales de diferentes empresas desarrollistas de viviendas" />
<?php }?>

<script src="http://code.jquery.com/jquery-latest.js"></script>

<!-- BOOTSTRAP -->	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<link href="<?php echo $raiz;?>css/estilos.css" rel="stylesheet" type="text/css">	

<style>
	@import url(https://fonts.googleapis.com/css?family=Abel);
	@import url('<?php echo $raiz;?>fonts/PFDinTextCompPro-Light.css');
	@import url('<?php echo $raiz;?>fonts/MyriadWebPro-Regular.css');
</style>

<script src="<?php echo $raiz;?>js/comun.js"></script>
<script src="<?php echo $raiz;?>js/forms.js"></script>

<script src="https://cdn.jsdelivr.net/sharer.js/latest/sharer.min.js"></script>

<script src='https://www.google.com/recaptcha/api.js'></script>

<?php 
	echo '<base href="'. $raiz .'" />';
?>