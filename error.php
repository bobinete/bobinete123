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
  "page" => "error",
  "tagline" => $lang["tagline_error"]
  );
   
 /**
  * Print Template
  */
  
  $print->header("error", $data);
  $print->body("error", $data);
  $print->footer("error", $data);        
    
 /* End */
?>