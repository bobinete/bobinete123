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
  
  if($check->isLogged() && isset($_GET["do"]) && $_GET["do"] == "new" OR $check->isLogged() && isset($_GET["do"], $_GET["id"]) && $_GET["do"] == "edit" && !empty($_GET["id"])){
  	if($check->isLogged() && isset($_GET["do"], $_GET["id"]) && $_GET["do"] == "edit" && $secure->isNumber($_GET["id"])){
   		$id = $secure->purify($_GET["id"]);
   		$check_game = $db->query("SELECT id FROM games WHERE id = $id LIMIT 1");
   		if($check_game->num_rows < 1){
   			die($sys->go($get->system("site_url")."/warning/notfound"));   			
   		} else {
   			$game_id = $id;  
   			$game = $get->game($game_id, $get->system("smart_cache"));   			 			
   			if($user["position"] == 3 && $user["id"] !== $game["uid"] OR $user["position"] == 4){
   				die($sys->go($get->system("site_url")."/warning/permission"));   		   				
   			}
   		}   		
   	} else {
   		$game_id = NULL;
   	}
   	if($_GET["do"] == "edit"){
   		$tagline = $lang["tagline_game_edit"];   		
   		$game = $get->game($game_id, $get->system("smart_cache"));
   		if($secure->isUrl($game["thumb"])){
   			$thumb = $game["thumb"];   			
   		} else {
   			$thumb = $get->system("site_url")."/uploads/thumbs/".$game["thumb"];   			
   		}
   		if($secure->isUrl($game["source"])){
   			$source = $game["source"];   			
   		} else {
   			$source = $get->system("site_url")."/uploads/games/".$game["source"];   			
   		}
   		$redirect = "/play/".$secure->washName($game["name"])."-".$game["id"].".html";
   	} else if($_GET["do"] == "new"){
   		if($get->system("submissions") == 0 && !in_array($user["position"], array(1, 2))){
   			die($sys->go($get->system("site_url")."/warning/notfound"));   			
   		}
   		$tagline = $lang["tagline_game_submit"];   		
   	}   	
  } else {
  	die($sys->go($get->system("site_url")."/warning/notfound"));
  }
  
 /**
  * Template Data
  */
  
  if(isset($_GET["do"]) && $_GET["do"] == "edit"){
   	$data = array(
   "page" => "game",
   "tagline" => $tagline,
   "gid" => $game_id,
   "game" => $game,
   "thumb" => $thumb,
   "source" => $source,
   "redirect" => $redirect
   );
  } else {
  	$data = array(
   "page" => "game",
   "tagline" => $tagline,
   );   	
  }
   
 /**
  * Print Template
  */
  
  $print->header("game", $data);
  $print->body("game", $data);
  $print->footer("game", $data);
   
/* End */
?>