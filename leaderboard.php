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
  "page" => "leaderboard",
  "tagline" => $lang["tagline_leaderboard"]
  );
  
 /**
  * Print Template
  */
  
  $print->header("leaderboard", $data);
  $print->body("leaderboard", $data);
  $print->footer("leaderboard", $data);        
    
/* End */
?>