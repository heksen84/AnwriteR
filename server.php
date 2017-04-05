<?php
/* 
----------------------------------------- 
 This is Server Part of AnwriteR
 from Ilya Bobkov 2017
 https://github.com/heksen84
------------------------------------------ */
include "php/class.msg.php";
include "php/class.mysqli.php";
include "php/class.util.php";

session_start();

// ---------------------
// конвертер
// ---------------------
function translit($str) 
{
    $rus = array(' ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('-', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}

// -------------------------------------------  
// генерация стаической страницы (SEO)
// -------------------------------------------
function GenerateHtmlPage($text,$id)
{			
	$fp = fopen("pages/".$id.'.html', 'w+');	
	fwrite($fp, "<!DOCTYPE html>");
	fwrite($fp, "<html lang='ru'>");
	fwrite($fp, "<head>");
	fwrite($fp, "<meta charset='utf-8'>");
	fwrite($fp, "<meta name='viewport' content='width=device-width'/>");
	fwrite($fp, "<meta name='description' content='".$text."'/>");
	fwrite($fp, "<meta name='keywords' content='".$text."'/>");
	fwrite($fp, "<meta name='robots' content='index, follow'/>");
	fwrite($fp, "<title>".$text."</title>");
	fwrite($fp, "</head>");
	fwrite($fp, "<script>window.location='http://anwriter/?user=".$_SESSION["user_login"]."&text=".$text."'</script>");
	fwrite($fp, "<body>");
	fwrite($fp, $text);
	fwrite($fp, "</body>");		
	fclose($fp);	
}


/* ------ [ РОУТИНГ ] ------ */
if (isset($_GET["func"])) 
{	    		
	$db = DataBase::getDB();
    
    switch ($_GET["func"]) 
	{
		
	// ------------------------
    // регистрация
	// ------------------------
	case "SRV_RegUser": 
	{            			
		if (!isset($_GET['login']) || !isset($_GET['email']) || !isset($_GET['password'])) 
			msg::error("нет данных");
				
		$login 	  = $_GET['login'];
        $email    = $_GET['email'];
        $password = $_GET['password'];
				
		// ---------------------------------
		// безопасность		
		// ---------------------------------
		$login 		= stripslashes($login);
		$login 		= htmlspecialchars($login);
		$login 		= trim($login);
		$email 		= stripslashes($email);
		$email 		= htmlspecialchars($email);
		$email 		= trim($email);
		$password 	= stripslashes($password);
		$password 	= htmlspecialchars($password);			
		$password 	= trim($password);
		
		if (empty($login) || empty($email) || empty($password)) 
			msg::warning("все поля должны быть заполнены");
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			msg::warning("укажите корректный email"); 		
		
		$table = $db->select("SELECT * FROM `users` WHERE login='".$login."' || email='".$email."'");		
		if ($table!=false) 
			msg::warning("пользователь уже существует");
		
		if (strlen($password) < 3) msg::warning("плохой пароль");
		
		$hash_password = password_hash($password, PASSWORD_BCRYPT); 	
		
		$table = $db->query("INSERT INTO `users` VALUES (NULL,'".$login."','".$email."','".$hash_password."',NOW())");		
		
		$_SESSION["user_id"] 	= $table;
		$_SESSION["user_login"] = $login;			
		
		msg::success($login);
        break;
    }
	
	// ------------------------
	// авторизация
	// ------------------------
	case "SRV_AuthUser": 
	{	
    	if (!isset($_GET['login']) || !isset($_GET['password'])) msg::error("нет данных");

		$login 		= $_GET['login'];        
        $password 	= $_GET['password'];		
						
		if (empty($login) || empty($password)) msg::warning("введите данные");
		
		$login 		= stripslashes($login);
		$login 		= htmlspecialchars($login);
		$login 	  	= trim($login);		
		$password 	= stripslashes($password);
		$password 	= htmlspecialchars($password);			
		$password 	= trim($password);
								
		$passindb = $db->selectCell("SELECT password FROM `users` WHERE login='".$login."' LIMIT 1");		
		if (!$passindb || !password_verify($password, $passindb)) 
			msg::error("не верные данные");	
		
		$userid = $db->selectCell("SELECT id FROM `users` WHERE login='".$login."' LIMIT 1");		
		if (!$userid) 
			msg::error("внутренняя ошибка");			
		
		$_SESSION["user_id"] 	= $userid;
		$_SESSION["user_login"] = $login;						
		
		msg::success($login);		
        break;
    }
	
	// ------------------------
	// получил тэги
	// ------------------------
	case "SRV_GetTags": 
	{
		$table = $db->select("SELECT id AS value, name AS label FROM `tags` WHERE user_id='".$_SESSION["user_id"]."'");
		msg::success($table);							
		break;
	}
	
	// ------------------------
	// полуть текст
	// ------------------------
	case "SRV_GetRecordList": 
	{
		$table = $db->select("SELECT id AS value, text AS label FROM `records` WHERE user_id='".$_SESSION["user_id"]."' ORDER BY text ASC");		
		msg::success($table);							
		break;
	}
	
	// ------------------------
	// проверить тег
	// ------------------------
	case "SRV_CheckTag": 
	{		
		if (!isset($_GET['tag_name'])) msg::error("нет данных");		
		$tag_name = trim($_GET["tag_name"]);
		$table = $db->select("SELECT id FROM `tags` WHERE name='".$tag_name."' AND user_id='".$_SESSION["user_id"]."' LIMIT 1");
		if ($table){
			msg::success($table);		
		}
		else 
		{
			$tag_id = $db->query("INSERT INTO `tags` VALUES (NULL,'".$_SESSION["user_id"]."','".$tag_name."')");
			$array[]["id"]=$tag_id;
			msg::success($array);		
		}		
		break;
	}
	
	// ------------------------
	// добавить запись
	// ------------------------
	case "SRV_AddRecord": 
	{		        
		if (!isset($_GET['text']) || !isset($_GET['tag_id']) || !isset($_GET['tag_name']) || !isset($_GET['show_mode']))
			msg::error("нет данных");
	
			$text   	= $_GET['text'];   	
			$rec_items 	= $_GET['rec_items']; 				
			$tag_id 	= $_GET['tag_id']; 	
			$tag_name 	= $_GET['tag_name'];
			$show_mode	= $_GET['show_mode'];
												
			$records = $db->query("INSERT INTO `records` VALUES (NULL,'".$_SESSION["user_id"]."','".$tag_id."','".$text."',NOW(),'".$show_mode."')");									
			
			if (isset($rec_items)){ 				
				foreach ($rec_items as $key => $value){
					$views	= $db->query("INSERT INTO `views` VALUES (NULL,'".$_SESSION["user_id"]."','".$records."','".$key."', NOW())");			
				}
			}
			
			if ($show_mode == 0) 
				util::GenerateHtmlPage($text, $records);
			
			msg::success($records);
			break;
    }
	
	// ------------------------
	// удалить запись
	// ------------------------
    case "SRV_DeleteRecord": 
	{
        if (isset($_GET['record_id'])) {
            $record_id = $_GET['record_id'];
        }
        $table = $db->query("DELETE FROM `records` WHERE id=".$record_id);
        msg::success($table);
        break;
    }
	
	// ------------------------
	// получить записи
	// ------------------------
    case "SRV_GetRecords": 
	{
        $table = $db->select("SELECT * FROM `records` WHERE user_id='".$_SESSION["user_id"]."'");
        msg::success($table);
        break;
    }
	
	// ------------------------
	// получить записи
	// ------------------------
    case "SRV_Search": 
	{
		if (!isset($_GET['search_string']) || !isset($_GET['date1']) || !isset($_GET['date2']))
		msg::error("нет данных");
        				
		$search_string  = $_GET['search_string'];   	
		$date1 			= $_GET['date1']; 							
		$date2 			= $_GET['date2']; 							
				
		$date_format1 = DateTime::createFromFormat("d.m.Y", $date1 );
		$date_format2 = DateTime::createFromFormat("d.m.Y", $date2 );									
		$table = $db->select("SELECT id, text, DATE_FORMAT(date,'%d.%m.%Y') AS date FROM `records` WHERE user_id='".$_SESSION["user_id"]."' AND text LIKE '%".$search_string ."%' AND date BETWEEN '".$date_format1->format('Y-m-d')."' AND '".$date_format2->format('Y-m-d')."'");		
		
		msg::success($table);
		break;
    }
	
	// ------------------------
	// получить под уровень
	// ------------------------
    case "SRV_GetSubLevel": 
	{				
		if (!isset($_GET['rec_id'])) msg::error("нет данных");        				
		$rec_id  = $_GET['rec_id'];   								
		$table = $db->select("SELECT views.rec1 AS rec1_id, records.id, records.text, DATE_FORMAT(views.date,'%d.%m.%Y') AS date FROM `records` LEFT JOIN `views` ON records.id=views.rec1 WHERE views.rec2='".$rec_id."'");		
		msg::success($table);
		break;
    }
	
	// ------------------------
	// обновить запись
	// ------------------------
	case "SRV_UpdateRecord":
	{
		if (!isset($_GET['rec_id']) || !isset($_GET['rec_text'])) 
		msg::error("нет данных");	   
		
		$rec_id		= $_GET['rec_id']; 							
		$rec_text 	= $_GET['rec_text']; 											
		
		$table = $db->query("UPDATE `records` SET text='".$rec_text."' WHERE id='".$rec_id."'");
		msg::success($table);	
		break;
	}
}
}
?>