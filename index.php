<!---------------------------- 
 Ilya Bobkov 2017(c) 
 https://github.com/heksen84
------------------------------>
<!DOCTYPE html>
<html lang="ru">
<title>Записная книжка AnwriteR</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<meta charset = "utf-8">
<meta name = "viewport" 	content	= "width=device-width"/>
<meta name = "description" 	content = "AnwriteR - записная книжка"/>
<meta name = "keywords"    	content = "anwriter, анвритер, записная книжка, записи, заметки"/>
<meta name = "robots" 	   	content = "index, follow"/>
<!-- стили -->
<link href = "css/lib/bootstrap.min.css"	     	rel = "stylesheet"/>   
<link href = "css/lib/sweet-alert.css"	     		rel = "stylesheet"/>
<link href = "css/lib/scroll.css"	             	rel = "stylesheet"/>
<link href = "css/index.css?<?php echo time()?>"  	rel = "stylesheet"/>
<!-- библиотеки -->
<script src = "js/lib/jquery-3.1.1.min.js"></script>
<script src = "js/lib/bootstrap.min.js"></script>
<script src = "js/lib/sweet-alert.min.js"></script>      
<script src = "js/lib/jquery.msg.js"></script>      
<script src = "js/index.js?<?php echo time()?>"></script>
<?php 
	if (isset($_GET["user"]) &&  isset($_GET["text"])) 
		echo "<script>localStorage.setItem('user','".$_GET["user"]."');localStorage.setItem('text','".$_GET["text"]."');</script>"; 
?>

