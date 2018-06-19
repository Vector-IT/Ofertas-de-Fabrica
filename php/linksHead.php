<meta charset="UTF-8">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<!-- <meta name="author" content="Vector-IT" /> -->
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

<link rel="shortcut icon" href="img/logo.png" type="image/png" />
<link rel="apple-touch-icon" href="img/logo.png"/>

<?php if (
		(strpos($_SERVER['QUERY_STRING'], 'tipologia=') === false) 
		&& (strpos($_SERVER['QUERY_STRING'], 'fabrica=') === false) 
		&& (strpos($_SERVER['QUERY_STRING'], 'blog=') === false)
		&& (strpos($_SERVER['PHP_SELF'], '/financiacion100.php') === false)
		) {?>
<!-- <?php echo $_SERVER["QUERY_STRING"]?> -->
<!-- <?php echo $_SERVER["PHP_SELF"]?> -->

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

<!-- Facebook Pixel Code -->

<script>

!function(f,b,e,v,n,t,s)

{if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};

if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];

s.parentNode.insertBefore(t,s)}(window,document,'script',

'https://connect.facebook.net/en_US/fbevents.js');


fbq('init', '931966370312114'); 

fbq('track', 'PageView');

</script>

<noscript>

<img height="1" width="1" 

src="https://www.facebook.com/tr?id=931966370312114&ev=PageView

&noscript=1"/>

</noscript>

<!-- End Facebook Pixel Code -->

<script type="application/javascript" src="//script2.chat-robot.com/?token=7861a76c58225b1c870b980e248894d5"></script>

