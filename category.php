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
  
  if(isset($_GET["name"]) && !empty($_GET["name"]) && strtolower($_GET["name"]) == "all"){
  	$id = "all";
  	$title = $lang["parts_allgames_category"]; 
  	$seo = "all";
  	$desc = "All HTML5 and Flash Games free to play!";   	   	   	  	
 	} else if(isset($_GET["name"]) && !empty($_GET["name"])){
 		$name = $secure->purify(urldecode($_GET["name"]));
 		$find = $db->query("SELECT id, seo, name, description FROM categories WHERE name = '$name' LIMIT 1");   	
 		$find2 = $db->query("SELECT id, seo, name, description FROM categories WHERE seo = '$name' LIMIT 1");   	 		
   	if($find->num_rows > 0){
   		$category = $find->fetch_assoc();
   		$id = $category["id"];
   		$title = $category["name"];
   		$seo = $category["seo"];
   		$desc = $category["description"];
   	} else	 if($find2->num_rows > 0){
   		$category = $find2->fetch_assoc();
   		$id = $category["id"];
   		$title = $category["name"];
   		$seo = $category["seo"];
   		$desc = $category["description"];
   	} else {
   		die($sys->go($get->system("site_url") . "/warning/notfound"));   	
   	}   	   	
  } else {
  	die($sys->go($get->system("site_url")));   	
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "category",
  "tagline" => ucfirst($title),
  "cat_id" => $id,
  "cat_name" => ucfirst($title),
  "cat_seo" => $seo,  
  "cat_desc" => $desc
  );
   
 /**
  * Print Template
  */
  
  $print->header("category", $data);
  $print->body("category", $data);
  $print->footer("category", $data);        
    
/* End */
?>