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
  
  if(isset($_GET["type"], $_GET["id"])){
  	if($_GET["type"] == "game_embed" && $secure->isNumber($_GET["id"])){
  		$find_game = $db->query("SELECT id FROM games WHERE id = ".$_GET["id"]." LIMIT 1");
  		if($find_game->num_rows > 0){
  			$data = $get->game($_GET["id"], $get->system("smart_cache"));  		  		  		
  		} else {
  			die("error");
  		}
  	} else if($_GET["type"] == "user_data"){
  		$username = $secure->purify($_GET["id"]);
  		$find_user = $db->query("SELECT username, fullname, exp, website, quote, about FROM users WHERE username = '$username' LIMIT 1");
  		if($find_user->num_rows > 0){
  			$data = json_encode(array(
  			"status" => "success",
  			"data" => array(
  			$find_user->fetch_assoc()
  			)));
  			header("Content-type: application/json; charset=utf-8"); 	  			
  			die($data);
  		} else {
  			header("Content-type: application/json; charset=utf-8"); 	  			
  			die(json_encode(array("status" => "failed")));
  		}
  	} else {
  		die("error");
  	}
  } else if(isset($_GET["type"]) && $_GET["type"] == "game_feed"){
  	if(isset($_GET["start"]) && $secure->isNumber($_GET["start"])){
  		$start = $secure->purify($_GET["start"]);
  		if(isset($_GET["limit"]) && $secure->isNumber($_GET["limit"])){
  			if($_GET["limit"] > 100 OR $_GET["limit"] < 1){
  				$limit = 100;  			  			  				
  			} else {
  				$limit = $secure->purify($_GET["limit"]);  			  				
  			}
  		} else {
  			$limit = 100;
  		}
  		$get_games = $db->query("SELECT id, category, name, description, help, thumb, width, height, mobile, type, plays FROM games WHERE status = 1 ORDER BY id DESC LIMIT $start, $limit");
  		$array = array();
  		while($data = $get_games->fetch_assoc()){
  			if($secure->isUrl($data["thumb"])){
  				$thumb = $data["thumb"];
  			} else {
  				$thumb = $get->system("site_url")."/uploads/thumbs/".$data["thumb"];
  			}
  			if($data["mobile"] == 1){
  				$mobile = true;
  			} else {
  				$mobile = false;
  			}
  			if($data["type"] == 1){
  				$type = "HTML5";
  			} else {
  				$type = "Flash";
  			}  			
  			$find_cat = $db->query("SELECT name FROM categories WHERE id = ".$data["id"]." LIMIT 1");
  			if($find_cat->num_rows > 0){
  				$cat_data = $find_cat->fetch_assoc();
  				$category = ucfirst($cat_data["name"]);
  			} else {
  				$category = "None";
  			}
  			$array[] = array(
  			"id" => $data["id"]."_".strtolower($get->system("site_name")),
  			"category" => $category,
  			"name" => $data["name"],
  			"description" => $data["description"],
  			"instructions" => $data["help"],
  			"gameThumb" => $thumb,
  			"gameUrl" => $get->system("site_url")."/embed/game/".$data["id"],
  			"width" => intval($data["width"]),
  			"height" => intval($data["height"]),
  			"mobile" => $mobile,
  			"type" => $type,
  			"plays" => intval($data["plays"])
  			);
  		}
  		header("Content-type: application/json; charset=utf-8"); 	  		
  		die(json_encode($array));
  	} else {
  		if(isset($_GET["limit"]) && $secure->isNumber($_GET["limit"])){
  			if($_GET["limit"] > 100 OR $_GET["limit"] < 1){
  				$limit = 100;
  			} else {
  				$limit = $secure->purify($_GET["limit"]);
  			}
  		} else {
  			$limit = 100;
  		}
  		$get_games = $db->query("SELECT id, category, name, description, help, thumb, width, height, mobile, type, plays FROM games WHERE status = 1 ORDER BY id DESC LIMIT $limit");
  		$array = array();
  		while($data = $get_games->fetch_assoc()){
  			if($secure->isUrl($data["thumb"])){
  				$thumb = $data["thumb"];
  			} else {
  				$thumb = $get->system("site_url")."/uploads/thumbs/".$data["thumb"];
  			}
  			if($data["mobile"] == 1){
  				$mobile = true;
  			} else {
  				$mobile = false;
  			}
  			if($data["type"] == 1){
  				$type = "HTML5";
  			} else {
  				$type = "Flash";
  			}  			
  			$find_cat = $db->query("SELECT name FROM categories WHERE id = ".$data["id"]." LIMIT 1");
  			if($find_cat->num_rows > 0){
  				$cat_data = $find_cat->fetch_assoc();
  				$category = ucfirst($cat_data["name"]);
  			} else {
  				$category = "None";
  			}
  			$array[] = array(
  			"id" => $data["id"]."_".strtolower($get->system("site_name")),
  			"category" => $category,
  			"name" => $data["name"],
  			"description" => $data["description"],
  			"instructions" => $data["help"],
  			"gameThumb" => $thumb,
  			"gameUrl" => $get->system("site_url")."/embed/game/".$data["id"],
  			"width" => intval($data["width"]),
  			"height" => intval($data["height"]),
  			"mobile" => $mobile,
  			"type" => $type,
  			"plays" => intval($data["plays"])
  			);
  		}
  		header("Content-type: application/json; charset=utf-8"); 	  		
  		die(json_encode($array));  		
  	}
  } else {
  	die("error");
  }
  
 /**
  * Print Template
  */
  
  $print->body("api", $data);  
  
/* End */
?>  