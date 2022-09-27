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
  
  if(isset($_GET["slug"], $_GET["id"]) && !empty($_GET["slug"]) && !empty($_GET["id"]) && $secure->isNumber($_GET["id"])){
  	$page_id = $secure->purify($_GET["id"]);
  	$check_slug = $db->query("SELECT name, content FROM pages WHERE id = $page_id LIMIT 1");
  	if($check_slug->num_rows > 0){
  		$page_data = $check_slug->fetch_assoc();
  		$name = $page_data["name"];
  		$content = $secure->printData($page_data["content"]);
  	} else {
  		die($sys->go($get->system("site_url")."/warning/notfound"));
  	}
  } else {
  	die($sys->go($get->system("site_url")."/warning/notfound"));
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "custom_page",
  "tagline" => ucfirst($name),
  "name" => $name,
  "content" => htmlspecialchars_decode($content)
  );
   
 /**
  * Print Template
  */
  
  $print->header("page", $data);
  $print->body("page", $data);
  $print->footer("page", $data);        
    
/* End */
?>