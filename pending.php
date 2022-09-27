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
  	die($sys->go($get->system("site_url") . "/warning/notfound"));
  }
        
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "pending",
  "tagline" => $lang["tagline_pending"]
  );
   
 /**
  * Print Template
  */
  
  $print->header("pending", $data);
  $print->body("pending", $data);
  $print->footer("pending", $data);
   
/* End */
?>