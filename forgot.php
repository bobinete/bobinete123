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
  "page" => "forgot",
  "tagline" => $lang["tagline_forgot"]
  );
   
 /**
  * Print Template
  */
  
  $print->header("forgot", $data);
  $print->body("forgot", $data);
  $print->footer("forgot", $data);        
    
/* End */
?>