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
  
  if(!$check->isAdmin() && !$check->isModerator()){
  	if($check->isLogged()){
   	 die($sys->go($get->system("site_url") . "/warning/permission"));
   	} else {
   		die($sys->go($get->system("site_url") . "/warning/login"));
   	}
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "panel",
  "tagline" => $lang["tagline_panel"]
  );
   
 /**
  * Print Template
  */
  
  $print->header("panel", $data);
  $print->body("panel", $data);
  $print->footer("panel", $data);        
    
/* End */
?>