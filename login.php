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
  * Check Session
  */
  
  if($check->isLogged()){
  	die($sys->go($get->system("site_url")));  	
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "login",
  "tagline" => $lang["tagline_login"]
  );
   
 /**
  * Print Template
  */
  
  $print->header("login", $data);  
  $print->body("login", $data);
  $print->footer("login", $data);
   
/* End */
?>