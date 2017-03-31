<?php
class msg
{
 static function error( $string )
 {
  $arr = array('answer' => 'error', 'string' => $string);
  echo json_encode($arr);
  exit;
 }

 static function success( $string )
 {
  $arr = array('answer' => 'success', 'string' => $string);
  echo json_encode($arr);
  exit;  
 }	

 static function warning( $string )
 {
  $arr = array('answer' => 'warning', 'string' => $string);
  echo json_encode($arr);
  exit;  
 }	
}
?>