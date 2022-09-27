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
  
  if($check->isLogged() && $check->isAdmin() && isset($_GET["type"]) && $_GET["type"] == "manual" && $get->system("import_games") == 1){
  		$get_data = json_decode($sys->gamecenter("?pcode=" . base64_encode(urlencode($get->system("pcode")))."&protocol=".$get->system("protocol")."&type=".$get->system("import_type")."&limit=".$get->system("import_limit")), true);		
  		if($get_data["status"] == "success"){
  			shuffle($get_data["games"]);  			
  			foreach($get_data["games"] as $game){
  				$id = $game['unique_id'];
  				$status = $get->system("auto_publish");	
  				$title = $game['name'];
  				$category = $game["category"];  	  				
  				$unique_id = strtolower(str_replace(" ", "_", str_replace("-", " ", $category)));
  				$desc = $game["description"];  						  			
  				$thumb = $game["thumb"];  				
  				$source = $game["source"];
  				$help = $game["help"];	  				
  				$width = $game["width"];
  				$height = $game["height"];
  				$type = $game["type"];  				
  				$mobile = $game["mobile"];
  				$plays = 0;  				
  		
  				$check_cat = $db->query("SELECT * FROM categories WHERE unique_id = '$unique_id' LIMIT 1");
  				if($check_cat->num_rows < 1){
  					if($category == "None"){
  						$desc = "List of games that doesn't have particular categories are thrown here!";
  					} else {
  						$desc = "Play tons of ".$category." games for free! Earn EXP and climb the leaderboard!";  				  							
  					}
  					$db->query("INSERT INTO categories (unique_id, name, description) VALUES ('$unique_id', '$category', '$desc');");  
  				}
  				$find_cat = $db->query("SELECT * FROM categories WHERE unique_id = '$unique_id' LIMIT 1");
  				$cat_id = $find_cat->fetch_assoc();
  				$unique = $db->query("SELECT * FROM games WHERE unique_id = '$id'");
  				$dump = $db->query("SELECT * FROM dump WHERE unique_id = '$id'");
  				if($unique->num_rows < 1 && $dump->num_rows < 1){
  					$insert = $db->query("INSERT INTO games (unique_id, uid, name, status, category, source, description, thumb, width, height, type, mobile, help, plays) VALUES ('$id', 1, '$title', '$status', '".$cat_id["id"]."', '$source', '$desc', '$thumb', '$width', '$height', '$type', '$mobile', '$help', '$plays');");  			  					
  				}  		  				
  			} 
  			die("success");
  		} else {
  			die("error");
  		}  	  	
  } else if($check->isLogged() && $check->isAdmin() && isset($_GET["type"]) && $_GET["type"] == "sitemap" && $get->system("sitemap") == 1){
  		require 'system/external/sitemap.php';
  		$sitemap = new Sitemap($get->system("site_url"));
  		$sitemap->addItem('/', '1.0', 'daily', 'Today');  		
  		$get_cat = $db->query("SELECT name, seo FROM categories");
  		while($category = $get_cat->fetch_assoc()){
  			if(!empty($category["seo"])){
  				$slug = $category["seo"];
  			} else {
  				$slug = $category["name"];
  			}
  			$sitemap->addItem('/category/'.urlencode(strtolower($category['name'])), '0.8', 'monthly', 'Today'); 
  		}
  		$get_pages = $db->query("SELECT id, name FROM pages");
  		while($page = $get_pages->fetch_assoc()){
  			$sitemap->addItem('/page/'.$secure->washName($page['name'])."-".$page["id"].".html", '0.8', 'monthly', 'Today'); 
  		}
  		$get_games = $db->query("SELECT id, name FROM games");
  		while($game = $get_games->fetch_assoc()){
  			$sitemap->addItem('/play/'.$secure->washName($game['name'])."-".$game["id"].".html", '0.8', 'monthly', 'Today'); 
  		}  		  		
  		$sitemap->createSitemapIndex($get->system("site_url")."/", 'Today');  		  
  		if(file_exists("sitemap.xml") && file_exists("sitemap-index.xml")){
  			die("success");
  		} else {
  			die("error");
  		}
  	} else if($check->isLogged() && $check->isAdmin() && isset($_GET["type"]) && $_GET["type"] == "check"){
  		$gcdata = json_decode($sys->gamecenter("?do=total"), true);
  		if(isset($gcdata["totalGames"])){
  			die(number_format($gcdata["totalGames"]));
  		} else {
  			die("error");
  		}
  	} else if($check->isLogged() && $check->isAdmin() && isset($_GET["type"]) && $_GET["type"] == "updates"){
  		$gcdata = json_decode($sys->gamecenter("?do=version"), true);
  		if(isset($gcdata["latestVersion"])){
  			$version = @file_get_contents("system/version.txt");
  			if($version < $gcdata["latestVersion"]){
  				die("old");
  			} else{
  				die("updated");
  			}
  		} else {
  			die("error");
  		}
  	} else if(isset($_GET["type"], $_GET["password"])){
  	if($_GET["password"] !== $get->system("cron_password")){
  		die("error");
  	} 
	if($_GET["type"] == "challenge_daily" && $get->system("challenge_daily") == 1){
		$get_users = $db->query("SELECT id, dgp FROM users");
		while($u = $get_users->fetch_assoc()){
			$db->query("UPDATE users SET dgp = 0 WHERE id = ".$u["id"]." LIMIT 1");
		}
		die("Daily Challengers Cleared!");
	} else if($_GET["type"] == "challenge_weekly" && $get->system("challenge_weekly") == 1){
		$get_users = $db->query("SELECT id, wgp FROM users");
		while($u = $get_users->fetch_assoc()){
			$db->query("UPDATE users SET wgp = 0 WHERE id = ".$u["id"]." LIMIT 1");
		}
		die("Weekly Challengers Cleared!");		
	} else if($_GET["type"] == "challenge_monthly" && $get->system("challenge_monthly") == 1){
		$get_users = $db->query("SELECT id, mgp FROM users");
		while($u = $get_users->fetch_assoc()){
			$db->query("UPDATE users SET mgp = 0 WHERE id = ".$u["id"]." LIMIT 1");
		}
		die("Monthly Challengers Cleared!");		
	} else if($_GET["type"] == "cleartrash" && $get->system("trash_clear") == 1){
  		$garbage_avatars = glob("uploads/avatars/*.*");
  		$garbage_covers = glob("uploads/covers/*.*");
  		$garbage_thumbs = glob("uploads/thumbs/*.*");  		  		
  		$garbage_games = glob("uploads/games/*.*");  		
  		
  		foreach($garbage_avatars as $trash){
  			$trash_find = str_replace("uploads/avatars/", "", $trash);
  			$check_trash = $db->query("SELECT avatar FROM users WHERE avatar = '$trash_find' LIMIT 1");
  			if($check_trash->num_rows < 1){
  				@unlink($trash);
  			}
  		}
  		foreach($garbage_covers as $trash){
  			$trash_find = str_replace("uploads/covers/", "", $trash);
  			$check_trash = $db->query("SELECT cover FROM users WHERE cover = '$trash_find' LIMIT 1");
  			if($check_trash->num_rows < 1){
  				@unlink($trash);
  			}
  		}
  		foreach($garbage_thumbs as $trash){
  			$trash_find = str_replace("uploads/thumbs/", "", $trash);
  			$check_trash = $db->query("SELECT thumb FROM games WHERE thumb = '$trash_find' LIMIT 1");
  			if($check_trash->num_rows < 1){
  				@unlink($trash);
  			}
  		}
  		foreach($garbage_games as $trash){
  			$trash_find = str_replace("uploads/games/", "", $trash);
  			$check_trash = $db->query("SELECT source FROM games WHERE source = '$trash_find' LIMIT 1");
  			if($check_trash->num_rows < 1){
  				@unlink($trash);
  			}
  		}
  		die("Trash Cleared!");
  	} else if($_GET["type"] == "clearcache" && $get->system("cache_clear") == 1){
  		$cache_games = glob("cache/games/*.*");  		  		
  		$cache_users = glob("cache/users/*.*");  		  			  		
  		
  		foreach($cache_games as $cache){
  			@unlink($cache);
  		}
  		foreach($cache_users as $cache){
  			@unlink($cache);
  		}  		  		  
  		die("Cache Cleared");
  	} else if($_GET["type"] == "clearchat" && $get->system("shoutbox_clear") == 1){
  		$db->query("TRUNCATE shoutbox");
  		die("Shoutbox Cleared!");
  	} else if($_GET["type"] == "import" && $get->system("import_games") == 1){
  		$get_data = json_decode($sys->gamecenter("?pcode=" . base64_encode(urlencode($get->system("pcode")))."&protocol=".$get->system("protocol")."&type=".$get->system("import_type")."&limit=".$get->system("import_limit")), true);  		
  		if($get_data["status"] == "success"){
  			shuffle($get_data["games"]);  			
  			foreach($get_data["games"] as $game){
  				$id = $game['unique_id'];
  				$status = $get->system("auto_publish");	
  				$title = $game['name'];
  				$category = $game["category"];  	  				
  				$unique_id = strtolower(str_replace(" ", "_", str_replace("-", " ", $category)));
  				$desc = $game["description"];  						  			
  				$thumb = $game["thumb"];  				
  				$source = $game["source"];
  				$help = $game["help"];	  				
  				$width = $game["width"];
  				$height = $game["height"];
  				$type = $game["type"];  				
  				$mobile = $game["mobile"];
  				$plays = 0;  				
  				
  				$check_cat = $db->query("SELECT * FROM categories WHERE unique_id = '$unique_id' LIMIT 1");
  				if($check_cat->num_rows < 1){
  					if($category == "None"){
  						$desc = "List of games that doesn't have particular categories are thrown here!";
  					} else {
  						$desc = "Play tons of ".$category." games for free! Earn EXP and climb the leaderboard!";  				  							
  					}
  					$db->query("INSERT INTO categories (unique_id, name, description) VALUES ('$unique_id', '$category', '$desc');");  
  				}
  				$find_cat = $db->query("SELECT * FROM categories WHERE unique_id = '$unique_id' LIMIT 1");
  				$cat_id = $find_cat->fetch_assoc();
  				$unique = $db->query("SELECT * FROM games WHERE unique_id = '$id'");
				$dump = $db->query("SELECT * FROM dump WHERE unique_id = '$id'");
  				if($unique->num_rows < 1 && $dump->num_rows < 1){
  					$insert = $db->query("INSERT INTO games (unique_id, uid, name, status, category, source, description, thumb, width, height, type, mobile, help, plays) VALUES ('$id', 1, '$title', '$status', '".$cat_id["id"]."', '$source', '$desc', '$thumb', '$width', '$height', '$type', '$mobile', '$help', '$plays');");  			  					
  				}  		  				
  			} 
  			die("Import Success!");
  		} else {
  			die("Import Failed!");
  		}
  	} else {
  		die("error");
  	}
  } else {
  	die("error");
  }
  
/* End */
?>