$(document).ready(function() {
	$("#fabricas").click(function (){
		$(this).toggleClass("activo");
		
		var $menuFabricas = $("#menuFabricas");
		
		if (!$menuFabricas.is(':visible')) {
			$menuFabricas.fadeIn();
			$('body').addClass("noscroll");
			
			if ($("body").height() > $(window).height())
				$('body').addClass("noscroll2");
		}
		else {
			$menuFabricas.fadeOut();
			$('body').removeClass("noscroll noscroll2");
		}
			
		return false;
	});

	$("#cerrarMenu").click(function () {
		$("#fabricas").toggleClass("activo");
		$("#menuFabricas").fadeOut();
		$('body').removeClass("noscroll noscroll2");
	});
	
	$(".clickable").click(function () {
		var url = $(this).data("url");
		
		var js = $(this).data("js");
		
		if (url != undefined) {
			location.href = url;
		}
		
		if (js != undefined) {
			eval(js);
		}
	});
	
	$('#login-dialog').on('shown.bs.modal', function () {
		  $('#usuario').focus()
	});
	
	checkMenu();
	
});

function checkMenu() {
	var direccion = location.href;
	
	if (direccion.indexOf("quienes-somos.php") > -1) {
		$("#quienes").addClass("activo");
	}
	else if (direccion.indexOf("caracteristicas.php") > -1) {
		$("#caracteristicas").addClass("activo");		
	}
	else if (direccion.indexOf("/fabrica/") > -1 || direccion.indexOf("/tipologia/") > -1) {
		$("#fabricas").addClass("activo");
	}
	else if (direccion.indexOf("proceso") > -1) {
		$("#proceso").addClass("activo");
	}
	else if (direccion.indexOf("ofertas.php") > -1) {
		$("#ofertas").addClass("activo");
	}
	else if (direccion.indexOf("premium") > -1) {
		$("#premium").addClass("activo");
	}
	else if (direccion.indexOf("mayorista") > -1) {
		$("#mayorista").addClass("activo");
	}
	else if (direccion.indexOf("blog") > -1) {
		$("#blog").addClass("activo");
	}
	else if (direccion.indexOf("contacto") > -1) {
		$("#contacto").addClass("activo");
	}
}

function scrolar(target) {
	var $target = $(target);
     
	$target = $target.length && $target || $('[name=' + target.slice(1) +']');
	
	if ($target.length) {
	
		var targetOffset = $target.offset().top;
		
		$('html,body').animate({scrollTop: targetOffset}, 1000);
		
		return false;
	}
}
