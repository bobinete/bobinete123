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
   	die($sys->go($get->system("site_url")."/warning/login"));
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "favorites",
  "tagline" => $lang["tagline_favorites"]
  );
   
 /**
  * Print Template
  */
  
  $print->header("favorites", $data);
  $print->body("favorites", $data);
  $print->footer("favorites", $data);        
    
/* End */
?>