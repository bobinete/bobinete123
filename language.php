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
  * Process Requests
  */
  
  if(isset($_GET["code"]) && !empty($_GET["code"])){
  	$lang_code = strtolower($secure->purify(urldecode($_GET["code"])));
  	if(file_exists("languages/".$lang_code.".lang")){
  		$check_lang = $db->query("SELECT id FROM languages WHERE code = '$lang_code' LIMIT 1");
  		if($check_lang->num_rows > 0){
  			$_SESSION["lang"] = $lang_code;
  			if($check->isLogged()){
  				$language = $_SESSION["lang"];
   	 			$set = $db->query("UPDATE users SET language = '".$_SESSION["lang"]."' WHERE id = ".$user["id"]." LIMIT 1");
   	 		}
   	 		die($sys->go($get->system("site_url"))); 
   	 	} else {
   	 		die($sys->go($get->system("site_url")."/warning"));   	    	 		
   	 	}   	 	
   	} else {
   		die($sys->go($get->system("site_url")."/warning"));   	 	
   	}   	
  } else {
  	die($sys->go($get->system("site_url")."/warning"));
  }
   
/* End */
?>