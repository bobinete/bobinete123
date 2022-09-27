<?php
/**
 * Arcadia - Arcade Gaming Platform
 * @author Norielle Cruz <http://noriellecruz.com>
 */
 
 /**
  * Require Autoloader
  */
  
  require 'system/autoloader.php';
 
  
 /**
  * Process Requests
  */
  
  if(isset($_SESSION["logged"])){	
  	$id = $user["id"];
   	$db->query("UPDATE users SET status = 0 WHERE id = $id LIMIT 1");
   	session_unset();
   	die($sys->go($get->system("site_url")));
  } else {
  	die($sys->go($get->system("site_url")."/login"));
  }
   
/* End */
?>