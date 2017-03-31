/*
------------------------------
 Ilya Bobkov 2017(c) 
 https://github.com/heksen84
------------------------------*/
$(document).ready(function() 
{
	// загрузить процесс
	$("body").load( "view/main.php", function() {
		InitMain();
	});
	
});