<?php 
	session_start();
	include_once 'admin/php/conexion.php';
	
	if (isset($_GET["blog"])) {
		$dominioBlog = $_GET["blog"];

		$blog = cargarTabla("SELECT NumeBlog, Dominio, Titulo, Imagen, Copete, Descripcion, DATE_FORMAT(Fecha, '%Y-%m-%d') Fecha FROM blog WHERE Dominio = '{$dominioBlog}'");
	}
	else {
		$dominioBlog = "";
		
		$rec_limit = 3;
		$rec_count = buscarDato("SELECT COUNT(*) FROM blog b");
		
		//Verifico en que pagina estoy
		if (isset($_GET["page"])) {
			$page = $_GET["page"];
			$offset = $rec_limit * ($page - 1) ;
		}
		else {
			$page = 1;
			$offset = 0;
		}
		$left_rec = $rec_count - ($page * $rec_limit);
		
		$strSQL = "SELECT b.NumeBlog, b.Titulo, b.Dominio, b.Imagen, b.Copete, DATE_FORMAT(b.Fecha, '%Y-%m-%d') Fecha";
		$strSQL.= " FROM blog b";
		$strSQL.= " ORDER BY b.Fecha DESC";
		$strSQL.= " LIMIT {$offset}, {$rec_limit}";
		
		$blog = cargarTabla($strSQL);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ofertas de F&aacute;brica - Blog</title>
	
	<?php include_once 'php/linksHead.php';?>

	<link href="<?php echo $raiz;?>css/equal-height-columns.css" rel="stylesheet" type="text/css">

<?php 
	if ($dominioBlog != "") {
		$fila = $blog->fetch_assoc();
?>
	<meta property="og:title" content="Ofertas de Fábrica! - <?php echo utf8_decode($fila["Titulo"])?>" />
	<meta property="og:image" content="http://ofertasdefabrica.com.ar/admin/<?php echo str_replace(' ', '%20', $fila["Imagen"])?>" />
	<meta property="og:description" content="<?php echo utf8_decode($fila["Copete"])?>" />
<?php 
		$blog->data_seek(0);
	}
?>
</head>
<body>
	<?php include_once 'php/header.php';?>
	
	<div class="container-fluid">
		<div class="row">
			<h1>Blog</h1>
		</div>
		<?php
		
			$salida = "";
			
			if ($dominioBlog != "") {
				$salida.= $crlf . '<div class="row">';
				$salida.= $crlf . '<div class="cajaRoja clickable" data-url="blog.php"><span class="glyphicon glyphicon-arrow-left"></span> Volver</div>';
				$salida.= $crlf . '</div>';
			}
			
			if (isset($blog)) {
				if ($dominioBlog == "") {
					$salida.= $crlf . '<div class="row row-eq-height" style="border:1px dotted #ccc;">';
				}
				while ($fila = $blog->fetch_assoc()) {
					if ($dominioBlog == "") {
						$salida.= $crlf . '<div class="col-md-4" style="border-left:1px dotted #ccc; border-right:1px dotted #ccc;">';
						$salida.= $crlf . '<br />';
					}
					else {
						$salida.= $crlf . '<div class="col-md-8 col-md-offset-2">';
						// $salida.= $crlf . '<div class="cajaRoja clickable" data-url="blog.php"><span class="glyphicon glyphicon-arrow-left"></span> Volver</div>';
					}
					
					$salida.= $crlf . '<article>';
					$salida.= $crlf . '<div class="cajaRoja txtBig '. ($dominioBlog == ''?'clickable':'') .'" data-url="blog/'.$fila["Dominio"].'">'.utf8_decode($fila["Titulo"]).'</div>';
					$salida.= $crlf . '<div>';
					$salida.= $crlf . '<span class="glyphicon glyphicon-time"></span> ' . $fila["Fecha"];
					$salida.= $crlf . '</div>';
					$salida.= $crlf . '<hr>';
					
					if ($dominioBlog == "") {
						$salida.= $crlf . '<div class="text-center"><a href="blog/'.$fila["Dominio"].'"> <img src="admin/'.$fila["Imagen"].'" class="img-responsive" style="display:inherit;"></a></div>';
						$salida.= $crlf . '<br />';
						$salida.= $crlf . '<p class="text-justify">'.utf8_decode($fila["Copete"]).'</p>';
						$salida.= $crlf . '<div><a href="blog/'.$fila["Dominio"].'" target="_self"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true" style="font-size: 20px; margin-right: 25px; float: right !important; margin-bottom: 35px;"></span></a></div>';
					}
					else {
						$salida.= $crlf . '<div class="text-center"><img src="admin/'.$fila["Imagen"].'" class="img-responsive" style="display:inherit;"></div>';
						$salida.= $crlf . '<p class="text-justify">'.utf8_decode($fila["Descripcion"]).'</p>';
					}
					$salida.= $crlf . '<br />';
					$salida.= $crlf . '</article>';
					
					$salida.= $crlf . '</div>';
				}
				if ($dominioBlog == "") {
					$salida.= $crlf . '</div>';
				}
			
				//Armo el paginador
				if ($dominioBlog == "") {
					$salida.= $crlf . '<div class="clearer"></div>';
					$salida.= $crlf . '<ul class="pager">';
					$salida.= $crlf . '';
					if ($page > 1) {
						$last = $page - 1;
						$salida.= $crlf . '<li class="previous"><a href="blog.php?page='.$last.'">&larr; Anterior</a></li>';
				
						if ($left_rec > 0)
							$salida.= $crlf . '<li class="next"><a href="blog.php?page='.($page + 1).'">Siguiente &rarr;</a></li>';
					}
					else if ($left_rec > 0) {
						$salida.= $crlf . '<li class="next"><a href="blog.php?page='.($page + 1).'">Siguiente &rarr;</a></li>';
					}
					$salida.= $crlf . '</ul>';
				}
				echo $salida;
			}
		?>
	</div>
	
	<div class="clearer marginTop40"></div>
	
	<?php include_once 'php/footer.php';?>
</body>
</html>
