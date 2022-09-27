<?php
/**
 * Arcadia - Arcade Gaming Platform
 * @author Norielle Cruz <http://noriellecruz.com>
 */
 
 /**
  * Require Autoloader
  */
  
  require 'system/autoloader.php';
  use \DetectLanguage\DetectLanguage;
  
 /**
  * Process Requests
  */
  
  if(isset($_GET["s"])){
   	 $find = $secure->purify(urldecode($_GET["s"]));
   	 if(strlen($find) > $get->system("search_max")){
   	 	 die($sys->go($get->system("site_url")."/warning/notfound"));   	 	
   	 }
	 if($get->system("advance_search") == 1 && $get->system("detectlang_api") !== ""){
		require 'system/external/translate.class.php';
		require 'system/external/detectlanguage.php';
		DetectLanguage::setApiKey($get->system("detectlang_api"));
		$ad = new GoogleTranslate();
		$lang_c = DetectLanguage::simpleDetect($find);
		if($lang_c !== "en" && !empty($lang_c)){
			$get_en = $ad->translate($lang_c, "en", $find);
			if(empty($get_en)){
				$adv_search = $find;		
			} else {
				$adv_search = $get_en;		
			}
		} else {
			$adv_search = $find;	
		}	
	 } else {
		 $adv_search = NULL;
	 }
   	 $find_search = $db->query("SELECT id FROM search WHERE query = '$find' LIMIT 1");
   	 if($find_search->num_rows > 0){
   	 	 $db->query("DELETE FROM search WHERE query = '$find' LIMIT 1");
   	 	 if(!empty($find) && strlen($find) > 3){
   	 	 	 $db->query("INSERT INTO search (query) VALUES ('$find')");
   	 	 }
   	 } else {
   	 	 if(!empty($find) && strlen($find) > 3){
   	 	 	 $db->query("INSERT INTO search (query) VALUES ('$find')");
   	 	 }
   	 }
   	 $count_recent = $db->query("SELECT id FROM search");
   	 if($count_recent->num_rows > $get->system("recent_search_limit")){
   	 	 $rs_limit = $get->system("recent_search_limit");
   	 	 $db->query("DELETE FROM search LIMIT ".$rs_limit++.", ".$count_recent->num_rows);
   	 }
   	 if(strlen($find) > 0){
   	 	$tagline = $lang["tagline_search_live"]." ".$find;   	 	
   	 } else {
   	 	$tagline = $lang["tagline_search"];   	 	
   	 }   	 
  } else {
  	die($sys->go($get->system("site_url")."/warning/notfound"));
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "search",
  "tagline" => $tagline,
  "search" => $find,
  "adv_search" => $adv_search
  );
   
 /**
  * Print Template
  */
  
  $print->header("search", $data);
  $print->body("search", $data);
  $print->footer("search", $data);        
    
/* End */
?>