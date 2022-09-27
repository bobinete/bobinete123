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
  
  if(isset($_GET["slug"], $_GET["id"]) && $secure->isNumber($_GET["id"])){
   	$gid = $secure->purify($_GET["id"]);   	
   	if($user["position"] == 1 OR $user["position"] == 2){
   		$find = $db->query("SELECT name, mobile, plays FROM games WHERE id = $gid LIMIT 1"); 
   	} else {
   		$find = $db->query("SELECT name, mobile, plays FROM games WHERE status = 1 AND id = $gid LIMIT 1");   	   		
   	}
   	if($check->isMobile()){
   			if($find->num_rows < 1){
   				die($sys->go($get->system("site_url") . "/warning/notfound"));   				
   			} else {
   				$game = $find->fetch_assoc();
   				if($game["mobile"] == 0){
   					die($sys->go($get->system("site_url")."/warning/mobile"));
   				}   				   				
   				$game_id = $gid;   				   		   				 
   				$game_name = $game["name"];   				
   				$new = $game["plays"] + 1;   				
   				$db->query("UPDATE games SET plays = $new WHERE id = $gid LIMIT 1");
   				$find_lp = $db->query("SELECT id FROM lastplayed WHERE gid = $game_id LIMIT 1");
   				if($find_lp->num_rows > 0){
   					$db->query("DELETE FROM lastplayed WHERE gid = $game_id LIMIT 1");
   					$db->query("INSERT INTO lastplayed (gid) VALUES ($game_id);");
   				} else {
   					$db->query("INSERT INTO lastplayed (gid) VALUES ($game_id);");   					
   				}
   			}   			
   	} else {
   		if($find->num_rows < 1){
   			die($sys->go($get->system("site_url") . "/warning/notfound"));   			
   		} else {
   			$game = $find->fetch_assoc();	
   			$game_id = $gid;   			   				 
   			$game_name = $game["name"];   		   			
   			$new = $game["plays"] + 1;   				
   			$db->query("UPDATE games SET plays = $new WHERE id = $gid LIMIT 1");   		
   			$find_lp = $db->query("SELECT id FROM lastplayed WHERE gid = $game_id LIMIT 1");
   			if($find_lp->num_rows > 0){
   				$db->query("DELETE FROM lastplayed WHERE gid = $game_id LIMIT 1");
   				$db->query("INSERT INTO lastplayed (gid) VALUES ($game_id);");   				
   			} else {
   				$db->query("INSERT INTO lastplayed (gid) VALUES ($game_id);");   					
   			}   				
   		}   		
   	} 
  } else {
  	die($sys->go($get->system("site_url") . "/warning/notfound"));
  }
  
 /**
  * Template Data
  */
  
  $data = array(
  "page" => "play",
  "tagline" => $game_name,
  "gid" => $game_id
  );
   
 /**
  * Print Template
  */
  
  $print->header("play", $data);
  $print->body("play", $data);
  $print->footer("play", $data);
   
/* End */
?>