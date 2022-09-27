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
  * Template Data
  */  
  
  $data = array(
  "page" => "home",
  "tagline" => $lang["tagline_home"]
  );
   
 /**
  * Print Template
  */
    
  $print->header("home", $data);
  $print->body("home", $data);
  $print->footer("home", $data);
   
/* End */
?>