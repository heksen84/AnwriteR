<?php
class util
{
 // -------------------------------------------  
 // генерация стаической страницы (SEO)
 // -------------------------------------------
 static function GenerateHtmlPage($id, $text)
 {			
	$fp = fopen("pages/".$id.'.html', 'w+');	
	fwrite($fp, "<!DOCTYPE html>");
	fwrite($fp, "<html lang='ru'>");
	fwrite($fp, "<head>");
	fwrite($fp, "<meta charset='utf-8'>");
	fwrite($fp, "<meta name='viewport' content='width=device-width'/>");
	//fwrite($fp, "<meta name='description' content='".$text."'/>");
	//fwrite($fp, "<meta name='keywords' content='".$text."'/>");
	fwrite($fp, "<meta name='robots' content='index, follow'/>");
	fwrite($fp, "<title>".$text."</title>");
	fwrite($fp, "</head>");
	fwrite($fp, "<script>window.location='http://anwriter/?user=".$_SESSION["user_login"]."&text=".$text."'</script>");
	fwrite($fp, "<body>");
	fwrite($fp, $text);
	fwrite($fp, "</body>");		
	fclose($fp);	
 }
}
?>