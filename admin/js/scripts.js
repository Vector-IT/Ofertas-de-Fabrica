$(document).ready(function() {
	$(".menu").vectorMenu({
		trigger: ".btnMenu",
		duration: 300,
		opacity: 0.7,
		background: "#000",
		closeWidth: "30px"
	});
	
	$('.btnMenu').click(function() {
		if ($(".vectorMenu").vectorMenu.isOpen())
			$( ".btnMenu" ).html('<i class="fa fa-times"></i>');
		else
			$( ".btnMenu" ).html('<i class="fa fa-bars"></i>');
	});
});