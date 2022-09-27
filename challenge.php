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
  * Check If Disabled
  */
  
  if($get->system("challenge_daily") == 0 && $get->system("challenge_weekly") == 0 && $get->system("challenge_monthly") == 0){
  	die($sys->go($get->system("site_url")."/warning/notfound"));
  }
        
 /**
  * Template Data
  */  
  
  $data = array(
  "page" => "challenge",
  "tagline" => $lang["tagline_challenge"]
  );
   
 /**
  * Print Template
  */
    
  $print->header("challenge", $data);
  $print->body("challenge", $data);
  $print->footer("challenge", $data);
   
/* End */
?>