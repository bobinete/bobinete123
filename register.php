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
  "page" => "register",
  "tagline" => $lang["tagline_register"]
  );
   
 /**
  * Print Template
  */
  
  $print->header("register", $data);
  $print->body("register", $data);
  $print->footer("register", $data);
     
/* End */
?>