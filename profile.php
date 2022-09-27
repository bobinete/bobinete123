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
  
  if(isset($_GET["name"]) && !empty($_GET["name"])){
   	$name = $secure->purify(urldecode($_GET["name"]));
   	$find = $db->query("SELECT id, position, username, exp, avatar, cover, fullname, website, quote, fb_link, gp_link, tw_link, about, status, robohash FROM users WHERE username = '".$name."' LIMIT 1");
   	
   	if($find->num_rows > 0){
   		$data = $find->fetch_assoc();   		
   		$data_id = $data["id"];
   		$data_position = $data["position"];
   		$data_name = $data["username"];
   		$data_exp = $data["exp"];
   		$data_avatar = $data["avatar"];
   		$data_cover = $data["cover"];   		
   		$data_fullname = $data["fullname"];
   		$data_website = $data["website"];
   		$data_quote = $data["quote"]; 
   		$data_fb = $data["fb_link"]; 
   		$data_gp = $data["gp_link"]; 
   		$data_tw = $data["tw_link"];   		  		  		  		
   		$data_about = $data["about"];
   		$data_status = $data["status"];
   		$data_robohash = $data["robohash"];   		
   	} else {
   	 	die($sys->go($get->system("site_url") . "/warning/notfound"));
   	}   	
  } else if(!isset($_GET["name"]) && $check->isLogged()){
   	$data_id = $user["id"];
   	$data_position = $user["position"];   	
   	$data_name = $user["username"];
   	$data_exp = $user["exp"];
   	$data_avatar = $user["avatar"];
   	$data_cover = $user["cover"];   	
   	$data_fullname = $user["fullname"];
   	$data_website = $user["website"];
   	$data_quote = $user["quote"];   	
   	$data_fb = $user["fb_link"];   	
   	$data_gp = $user["gp_link"];   	
   	$data_tw = $user["tw_link"];   	   	   	   	
   	$data_about = $user["about"];
   	$data_status = $user["status"];
   	$data_robohash = $user["robohash"];   	
  } else {
   	die($sys->go($get->system("site_url") . "/warning/login"));
  }
  
  if (!empty($data_avatar)) {
   	$avatar = '<img src="'.$get->system("site_url").'/templates/'.$get->system("template").'/assets/images/loader.gif" data-src="' . $get->system("site_url") . '/uploads/avatars/' . $data_avatar . '" class="lazy-avatar b-radius">';   	
  } else {
   	$avatar = $get->avatar($secure->hashed($data_id), $data_name, $data_robohash, $get->system("default_avatar"), "", $get);   		
  }   
     
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "profile",
  "tagline" => ucfirst($data_name),
  "id" => $data_id,
  "position" => $get->position($data_position, $lang),
  "username" => ucfirst($data_name),
  "rank" => $get->userRank($data_exp, $get->system("exp_game") + $get->system("exp_time"), $lang),
  "exp" => number_format($data_exp),
  "posts" => number_format($get->userPosts($data_id)),
  "comments" => number_format($get->userComments($data_id)),
  "avatar" => $avatar,
  "cover" => $get->profileCover($data_cover, $get->system("site_url")), 
  "fullname" => ucfirst($get->profileFullname($data_name, $data_fullname)),
  "website" => $get->profileWebsite($data_website, $lang),
  "quote" => $get->profileQuote($data_quote, $lang),
  "fb_link" => $data_fb,  
  "gp_link" => $data_gp,  
  "tw_link" => $data_tw,    
  "about" => $get->profileAbout($data_about, $lang),
  "status" => $get->profileStatus($data_status, $lang),
  );
   
 /**
  * Print Template
  */
  
  $print->header("profile", $data);
  $print->body("profile", $data);
  $print->footer("profile", $data);        
    
/* End */
?>