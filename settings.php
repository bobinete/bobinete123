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
  
  if(!$check->isLogged()){
  	die($sys->go($get->system("site_url") . "/warning/login"));  	
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "settings",
  "tagline" => $lang["tagline_settings"]
  );
  
 /**
  * Print Template
  */
  
  $print->header("settings", $data);
  $print->body("settings", $data);
  $print->footer("settings", $data);
   
/* End */
?>