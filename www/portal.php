<?php
error_log("\n\n");
error_log("------------------- GLOBALS\n\n");
error_log(print_r($GLOBALS, true));
error_log("\n\n");
error_log("------------------- END GLOBALS\n\n");
error_log("\n\n");
// require_once('_system/config/config.main.php');
// require_once('_system/class/class.pdo.php');
// $DBPASS = decrypt(PASSWORD);
// $db = new Db(HOST, DATABASE, USER, $DBPASS);

// require_once('_system/function/function.main.php');
// require_once ('/home/xapicode/iptv_xapicode/wwwdir/portaldata.php');

@header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma: no-cache");
@header("Content-type: text/javascript");

error_log("\n\n");
error_log("---------- START _REQUEST\n\n");
error_log("\n\n");
error_log(print_r($_REQUEST,true));
error_log("---------- STOP _REQUEST\n\n");
error_log("\n\n");
error_log("---------- START _POST\n\n");
error_log("\n\n");
error_log(print_r($_POST,true));
error_log("\n\n");
error_log("---------- STOP _POST\n\n");
error_log("\n\n");
error_log("---------- START _GET\n\n");
error_log("\n\n");
error_log(print_r($_GET,true));
error_log("\n\n");
error_log("---------- STOP _GET\n\n");
error_log("\n\n");

$data                       = array();

$data['timestamp']          = time();
$data['req_ip']             = (!empty($_SERVER["REMOTE_ADDR"])                  ? $_SERVER["REMOTE_ADDR"] : NULL);
$data['req_type']           = (!empty($_REQUEST["type"])                        ? $_REQUEST["type"] : NULL);
$data['type']               = (!empty($_REQUEST["type"])                        ? $_REQUEST["type"] : NULL);
$data['req_action']         = (!empty($_REQUEST["action"])                      ? $_REQUEST["action"] : NULL);
$data['sn']                 = (!empty($_REQUEST["sn"])                          ? $_REQUEST["sn"] : NULL);
$data['stb_type']           = (!empty($_REQUEST["stb_type"])                    ? $_REQUEST["stb_type"] : NULL);
$data['mac']                = (!empty($_REQUEST["mac"])                         ? $_REQUEST["mac"] : NULL);
$data['ver']                = (!empty($_REQUEST["ver"])                         ? $_REQUEST["ver"] : NULL);
$data['user_agent']         = (!empty($_SERVER["HTTP_X_USER_AGENT"])            ? $_SERVER["HTTP_X_USER_AGENT"] : NULL);
$data['image_version']      = (!empty($_REQUEST["image_version"])               ? $_REQUEST["image_version"] : NULL);
$data['device_id']          = (!empty($_REQUEST["device_id"])                   ? $_REQUEST["device_id"] : NULL);
$data['device_id2']         = (!empty($_REQUEST["device_id2"])                  ? $_REQUEST["device_id2"] : NULL);
$data['hw_version']         = (!empty($_REQUEST["hw_version"])                  ? $_REQUEST["hw_version"] : NULL);
$data['gmode']              = (!empty($_REQUEST["gmode"])                       ? intval($_REQUEST["gmode"]) : NULL);
$data['continue']           = false;
$data['debug']              = true;

// error logging

foreach($data as $key => $value){
    // error_log("MAG VAR: key = '".$key."'' => value = '".$value."'");
}

//Query String compile fix.
// $data = $_REQUEST;
$data2 = array(
    "req_ip" => $data['req_ip'],
    "user_agent" => $data['user_agent'],
    "time" => $data['timestamp']
);

$final_data = array_merge($data, $data2);

$url = "http://144.76.175.42/api/index.php?c=mag_device_api";

error_log("---------- START FINAL_DATA");
error_log(print_r($final_data));
error_log("---------- STOP FINAL_DATA");

/*
$options = array(
    'http' => array(
        'method'  => 'POST',
        'content' => json_encode( $final_data ),
        'header'=>  "Content-Type: application/json\r\n" .
        "Accept: application/json\r\n"
    )
);

$context    = stream_context_create($options);
$result     = file_get_contents($url, false, $context);
$response   = json_decode($result, true);
*/

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_VERBOSE, true );
curl_setopt( $ch, CURLOPT_HEADER, true );
curl_setopt( $ch, CURLOPT_TIMEOUT, strtotime("+2 minute") );
curl_setopt( $ch, CURLOPT_ENCODING, '' );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $final_data ) );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
) );

$result = curl_exec($ch);
curl_close ($ch);

echo $result;

/*

$url = "http://144.76.175.42/api/index.php?c=mag_device_api";
$payload = json_encode( $final_data );
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('payload' => $payload)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close ($ch);
echo $result;
*/

/*
$set_settings = $db->query('SELECT * FROM cms_settings');
function getstreamfromuser($category_id, $line_id){
	global $dev;
	global $player;
	global $db;
	
	$streams = array();
	$streams["streams"] = array();	
	
	$set_line_array = array($line_id);
    $set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);
    
	$line_bouquets = json_decode($set_line[0]['line_bouquet_id'], true);
	foreach($line_bouquets as $bouquet_id){		
		$set_bouquet_array = array($bouquet_id);
		$set_bouquet = $db->query('SELECT bouquet_streams FROM cms_bouquets WHERE bouquet_id = ?', $set_bouquet_array);
		
		$bouquet_streams_decode = json_decode($set_bouquet[0]['bouquet_streams'], true);
		foreach($bouquet_streams_decode as $key => $value){
			$bouquets_stream_array[] = $value;
		}
	}

	foreach ($bouquets_stream_array as $stream_id ){
		
		if ($category_id != NULL) {
			$statement = ' AND stream_category_id = '.$category_id;
		} else {
			$statement = '';
		}

		$set_stream_array = array($stream_id);
		$set_stream = $db->query('SELECT * FROM cms_streams WHERE stream_id = ?' . $statement, $set_stream_array);	
		
		$streams["streams"][$set_stream[0]["stream_id"]] = $set_stream[0];
	}
	
	return $streams;
}

function getStreams($category_id = NULL, $all = false, $fav = NULL, $orderby = NULL) {
    global $dev;
    global $player;
	global $db;	
	
    $page = (isset($_REQUEST["p"]) ? intval($_REQUEST["p"]) : 0);
    $page_items = 14;
    $default_page = false;
	$streams = getstreamfromuser($category_id, $dev["total_info"]["line_id"]);
	$counter = count($streams["streams"]) - 1;
	 $ch_idx = 0;
	
    if ($page == 0) {
        $default_page = true;
        $page = ceil($ch_idx / $page_items);

        if ($page == 0) {
            $page = 1;
        }
    }
	
	if (!$all) {
		$streams = array_slice($streams["streams"], ($page - 1) * $page_items, $page_items);
	} else {
		$streams = $streams["streams"];
	}
	
	$epgInfo = '';
	$datas = array();
    $i = 1;

	$set_line_array = array($dev["total_info"]["line_id"]);
    $set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);
    		
	$set_server_array = array(1);
	$set_server = $db->query('SELECT server_ip, server_dns_name, server_broadcast_port FROM cms_server WHERE server_main = ?', $set_server_array);	

	if($set_server[0]['server_dns_name'] == ''){
		$server = $set_server[0]['server_ip'];
	} else {
		$server = $set_server[0]['server_dns_name'];
	}	
		
    foreach(array_filter($streams) as $key => $stream){
		if (!is_null($fav) && ($fav == 1)) {
			if (!in_array($stream["id"], $dev["fav_channels"]["live"])) {
				continue;
			}
		}
		
        $stream_url = 'http://' . $server . ':' . $set_server[0]['server_broadcast_port'] . '/live/' . $set_line[0]['line_user'] . '/' . $set_line[0]['line_pass'] . '/' . $stream['stream_id'] . '.ts';

		$datas[] = array(
            "id" => $stream['stream_id'],
            "name" => $stream["stream_name"],
            "number" => (string)(($page - 1) * $page_items) + $i++,
            "censored" => "0",
            "cmd" => $player . $stream_url,
            "cost" => "0",
            "count" => "0",
            "status" => "1",
            "tv_genre_id" => $stream["stream_category_id"],
            "base_ch" => "1",
            "hd" => "0",
            "xmltv_id" => !empty($stream["stream_id"]) ? $stream["stream_id"] : "",
            "service_id" => "",
            "bonus_ch" => "0",
            "volume_correction" => "0",
            "use_http_tmp_link" => "0",
            "mc_cmd" => 1,
            "enable_tv_archive" => 0,
            "wowza_tmp_link" => "0",
            "wowza_dvr" => "0",
            "monitoring_status" => "1",
            "enable_monitoring" => "0",
            "enable_wowza_load_balancing" => "0",
            "cmd_1" => "",
            "cmd_2" => "",
            "cmd_3" => "",
            "logo" => 'http://'.$server.':'.$set_server[0]['server_broadcast_port'].'/_tvlogo/'.$stream['stream_logo'],
            "correct_time" => "0",
            "allow_pvr" => "",
            "allow_local_pvr" => "",
            "modified" => "",
            "allow_local_timeshift" => "1",
            "nginx_secure_link" => "0",
            "tv_archive_duration" => 0,
            "lock" => 0,
            "fav" => in_array($stream['stream_id'], $dev["fav_channels"]["live"]) ? 1 : 0,
            "archive" => 0,
            "genres_str" => "",
            "cur_playing" => "[No channel info]",
            "epg" => "",
            "open" => 1,
            "cmds" => array(
                array(
                    "id" => $stream['stream_id'],
                    "ch_id" => $stream['stream_id'],
                    "priority" => "0",
                    "url" => $player . $stream_url,
                    "status" => "1",
                    "use_http_tmp_link" => "0",
                    "wowza_tmp_link" => "0",
                    "user_agent_filter" => "",
                    "use_load_balancing" => "0",
                    "changed" => "",
                    "enable_monitoring" => "0",
                    "enable_balancer_monitoring" => "0",
                    "nginx_secure_link" => "0",
                    "flussonic_tmp_link" => "0"
                )
            ) ,
            "use_load_balancing" => 0,
            "pvr" => 0
        );
    }

    if ($default_page) {
        $cur_page = $page;
        $selected_item = $ch_idx - (($page - 1) * $page_items);
    } else {
        $cur_page = 0;
        $selected_item = 0;
    }

    $output = array(
        "js" => array(
            "total_items" => $counter,
            "max_page_items" => $page_items,
            "selected_item" => $all ? 0 : $selected_item,
            "cur_page" => $all ? 0 : $cur_page,
            "data" => $datas
        )
    );

    return json_encode($output);
}

function getMovie($category_id = NULL, $fav = NULL, $orderby = NULL) {
    global $dev;
    global $player;
    global $_LANG;
	global $db;

    $page = (isset($_REQUEST["p"]) ? intval($_REQUEST["p"]) : 0);
    $page_items = 14;
    $default_page = false;
    $datas = array();
    $ch_idx = 0;
    $epgInfo = '';
	
	$set_line_array = array($dev["total_info"]["line_id"]);
    $set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);
    
	$set_server_array = array(1);
	$set_server = $db->query('SELECT server_ip, server_dns_name, server_broadcast_port FROM cms_server WHERE server_main = ?', $set_server_array);

    $bouquets_movies_array = array();
	$line_bouquets = json_decode($set_line[0]['line_bouquet_id'], true);
	foreach($line_bouquets as $bouquet_id){		
		$set_bouquet_array = array($bouquet_id);
		$set_bouquet = $db->query('SELECT bouquet_movies FROM cms_bouquets WHERE bouquet_id = ?', $set_bouquet_array);
		
		$bouquet_movies_decode = json_decode($set_bouquet[0]['bouquet_movies'], true);
		foreach($bouquet_movies_decode as $key => $value){
			$bouquets_movies_array[] = $value;
		}
	}	
	
	$counter = count($bouquets_movies_array);
	
    if ($page == 0) {
        $default_page = true;
        $page = ceil($ch_idx / $page_items);

        if ($page == 0) {
            $page = 1;
        }
    }
	
    $movies = array_slice($bouquets_movies_array, ($page - 1) * $page_items, $page_items);
    if ($category_id != NULL) {
        $statement = ' AND movie_category_id = '.$category_id;
    } else {
        $statement = '';
    }

    foreach ($movies as $movie_id) {
		$set_movie_array = array($movie_id);
        $set_movie = $db->query('SELECT * FROM cms_movies WHERE movie_id = ? ' . $statement, $set_movie_array);

        if (!is_null($fav) && ($fav == 1)) {
            if (!in_array($movie_id, $dev["fav_channels"]["live"])) {
                continue;
            }
        }

        $this_mm = date("m");
        $this_dd = date("d");
        $this_yy = date("Y");

        if (mktime(0, 0, 0, $this_mm, $this_dd, $this_yy) < $set_movie[0]["movie_create_date"]) {
            $added_key = "today";
            $added_val = $_LANG["today"];
        }
        else if (mktime(0, 0, 0, $this_mm, $this_dd - 1, $this_yy) < $set_movie[0]["movie_create_date"]) {
            $added_key = "yesterday";
            $added_val = $_LANG["yesterday"];
        }
        else if (mktime(0, 0, 0, $this_mm, $this_dd - 7, $this_yy) < $set_movie[0]["movie_create_date"]) {
            $added_key = "week_and_more";
            $added_val = $_LANG["last_week"];
        }
        else {
            $added_key = "week_and_more";
            $added_val = date("F", $set_movie[0]["movie_create_date"]) . " " . date("Y", $set_movie[0]["movie_create_date"]);
        }

		if(isset($set_movie[0]["movie_duration"])){
			$movie_duration_explode = explode(' ', $set_movie[0]['movie_duration']);
		}
       
		$duration = (isset($set_movie[0]["movie_duration"]) ? trim($movie_duration_explode[0]) : 60);
        $data_to_post = array(
            "username" => $set_line[0]['line_user'],
            "password" => $set_line[0]['line_pass'],
            "server_dns_name" => $set_server[0]['server_dns_name'],
            "server_broadcast_port" => $set_server[0]['server_broadcast_port'],
            "movie_display_name" => $set_movie[0]["movie_name"],
            "movie_id" => $movie_id,
            "direct_source_url" => $set_movie[0]['movie_remote_source'],
            "category_id" => $set_movie[0]["movie_category_id"],
            "sub_category_id" => "",
            "movie_container" => $set_movie[0]["movie_extension"]
        );

        $datas[] = array(
            "id" => $movie_id,
            "age" => "",
            "cmd" => base64_encode(json_encode($data_to_post)) ,
            "genres_str" => $set_movie[0]['movie_genre'],
            "for_rent" => 0,
            "lock" => 0,
            "sd" => 0,
            "hd" => 1,
            "screenshots" => 1,
            "comments" => "",
            "low_quality" => 0,
            "country" => "",
            "rating_mpaa" => "",
            $added_key => $added_val,
            "high_quality" => 0,
            "last_played" => "",
            "rating_last_update" => "",
            "rating_count_imdb" => "",
            "rating_imdb" => "",
            "rating_count_kinopoisk" => "",
            "kinopoisk_id" => "",
            "rating_kinopoisk" => "",
            "for_sd_stb" => 0,
            "last_rate_update" => NULL,
            "rate" => NULL,
            "vote_video_good" => 0,
            "vote_video_bad" => 0,
            "vote_sound_bad" => 0,
            "vote_sound_good" => 0,
            "count_first_0_5" => 0,
            "accessed" => 1,
            "status" => 1,
            "disable_for_hd_devices" => 0,
            "count" => 0,
            "added" => date("Y-m-d H:i:s", $set_movie[0]['movie_create_date']) ,
            "owner" => "",
            "actors" => $set_movie[0]['movie_cast'],
            "director" => $set_movie[0]['movie_director'],
            "year" => $set_movie[0]['movie_release'],
            "cat_genre_id_4" => 0,
            "cat_genre_id_3" => 0,
            "cat_genre_id_2" => 0,
            "cat_genre_id_1" => 0,
            "genre_id_4" => 0,
            "genre_id_3" => 0,
            "genre_id_2" => 0,
            "genre_id_1" => $set_movie[0]['movie_genre'],
            "category_id" => $set_movie[0]["movie_category_id"],
            "name" => $set_movie[0]["movie_name"],
            "o_name" => $set_movie[0]["movie_name"],
            "old_name" => "",
            "fname" => "",
            "description" => base64_decode($set_movie[0]["movie_short_description"]),
            "pic" => 0,
            "screenshot_uri" => $set_movie[0]['movie_pic'],
            "cost" => 0,
            "time" => $duration,
            "file" => "",
            "path" => "",
            "fav" => in_array($movie_id, $dev["fav_channels"]["movie"]) ? 1 : 0,
            "protocol" => "http",
            "rtsp_url" => "",
            "censored" => 0,
            "series" => array() ,
            "volume_correction" => 0
        );
    }

    if ($default_page) {
        $cur_page = $page;
        $selected_item = $ch_idx - (($page - 1) * $page_items);
    } else {
        $cur_page = 0;
        $selected_item = 0;
    }

    $output = array(
        "js" => array(
            "total_items" => $counter,
            "max_page_items" => $page_items,
            "selected_item" => $selected_item,
            "cur_page" => $cur_page,
            "data" => $datas
        )
    );
    
	return json_encode($output);
}

function getSerie($category_id = NULL, $serie_id = NULL, $season_id = NULL, $episode_id = NULL, $fav = NULL, $orderby = NULL) {
    
	global $dev;
    global $player;
    global $_LANG;
	global $db;

    $page = (isset($_REQUEST["p"]) ? intval($_REQUEST["p"]) : 0);
    $page_items = 14;
    $default_page = false;
    $datas = array();
    $ch_idx = 0;
			
	if($serie_id != NULL){
	
		$set_line_array = array($dev["total_info"]["line_id"]);
		$set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);
		
		$set_server_array = array(1);
		$set_server = $db->query('SELECT server_ip, server_dns_name, server_broadcast_port FROM cms_server WHERE server_main = ?', $set_server_array);	
	
		$set_season_array = array($serie_id);
		$set_season = $db->query('SELECT cms_serie_episodes.*, cms_series.*, Count(cms_serie_episodes.serie_episode_number) AS episodes FROM cms_serie_episodes INNER JOIN cms_series ON cms_serie_episodes.serie_id = cms_series.serie_id WHERE cms_serie_episodes.serie_id = ? GROUP BY cms_serie_episodes.serie_episode_season', $set_season_array);
		
		$counter = count($set_season);
		foreach($set_season as $get_season){
					
			$set_episode_array = array($get_season['serie_episode_season']);
			$set_episode = $db->query('SELECT * FROM cms_serie_episodes WHERE serie_episode_season = ?', $set_episode_array);
			$episode_array = array();
			foreach($set_episode as $get_episode){
				$episode_array = array($get_episode['serie_episode_number']);
			}
		
			$data_to_post = array(
				"type" => 'series',
				"series_id" => $get_season['serie_id'],
				"season_num" => $get_season['serie_episode_season'],
				"serie_extension" => $get_season['serie_episode_extension'],
				"username" => $set_line[0]['line_user'],
				"password" => $set_line[0]['line_pass'],
				"server_dns_name" => $set_server[0]['server_dns_name'],
				"server_broadcast_port" => $set_server[0]['server_broadcast_port'],		
			);	

			$datas[] = array(
				"id" => $serie_id.':'.$get_season['serie_episode_season'],
				"owner" => "",
				"name" => 'Season '.$get_season['serie_episode_season'],
				"old_name" => "",
				"o_name" => 'Season '.$get_season['serie_episode_season'],
				"fname" => "",
				"description" => base64_decode($get_season['serie_episode_short_description']),
				"pic" => "",
				"cost" => 0,
				"time" => "",
				"file" => "",
				"path" => "",
				"protocol" => "",
				"rtsp_url" => "",
				"censored" => 0,
				"series" => $episode_array,
				"volume_correction" => 0,
				"category_id" => $get_season['serie_category_id'],
				"genre_id" => 0,
				"genre_id_1" => 0,
				"genre_id_2" => 0,
				"genre_id_3" => 0,
				"hd" => 1,
				"genre_id_4" => 0,
				"cat_genre_id_1" => $get_season['serie_category_id'],
				"cat_genre_id_2" => 0,
				"cat_genre_id_3" => 0,
				"cat_genre_id_4" => 0,
				"director" => $get_season['serie_director'],
				"actors"=> "",
				"year" => $get_season['serie_episode_release_date'],
				"accessed" => 1,
				"status" => 1,
				"disable_for_hd_devices" => 0,
				"added"=> "",
				"count"=> 0,
				"count_first_0_5" => 0,
				"count_second_0_5" => 0,
				"vote_sound_good" => 0,
				"vote_sound_bad" => 0,
				"vote_video_good" => 0,
				"vote_video_bad" => 0,
				"rate" => "",
				"last_rate_update" => "",
				"last_played" => "",
				"for_sd_stb" => 0,
				"rating_imdb" => "",
				"rating_count_imdb" => "",
				"rating_last_update" => "0000-00-00 00:00:00",
				"age" => "",
				"high_quality" => 0,
				"rating_kinopoisk" => "",
				"comments" => "",
				"low_quality" => 0,
				"is_series" => 1,
				"year_end" => 0,
				"autocomplete_provider "=> "imdb",
				"screenshots"=> "",
				"is_movie" => 1,
				"lock" => 0,
				"fav" => 0,
				"for_rent" => 0,
				"screenshot_uri" => $get_season['serie_pic'],
				"genres_str" => $get_season['serie_genre'],
				"cmd" => base64_encode(json_encode($data_to_post)),
				"week_and_more" => "",
				"has_files" => 0
			);
		}
		
	} else {
	
		$set_line_array = array(1);
		$set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);
		
		$set_server_array = array(1);
		$set_server = $db->query('SELECT server_ip, server_dns_name, server_broadcast_port FROM cms_server WHERE server_main = ?', $set_server_array);

		$bouquets_movies_array = array();
		$line_bouquets = json_decode($set_line[0]['line_bouquet_id'], true);
		foreach($line_bouquets as $bouquet_id){		
			$set_bouquet_array = array($bouquet_id);
			$set_bouquet = $db->query('SELECT bouquet_series FROM cms_bouquets WHERE bouquet_id = ?', $set_bouquet_array);
			
			$bouquet_series_decode = json_decode($set_bouquet[0]['bouquet_series'], true);
			foreach($bouquet_series_decode as $key => $value){
				$bouquets_series_array[] = $value;
			}
		}	
		
		$counter = count($bouquets_series_array);
		
		if ($page == 0) {
			$default_page = true;
			$page = ceil($ch_idx / $page_items);

			if ($page == 0) {
				$page = 1;
			}
		}
		
		$series = array_slice($bouquets_series_array, ($page - 1) * $page_items, $page_items);
		if ($category_id != NULL) {
			$statement = ' AND serie_category_id = '.$category_id;
		} else {
			$statement = '';
		}

		foreach ($series as $serie_id) {
			
			$set_serie_array = array($serie_id);
			$set_serie = $db->query('SELECT * FROM cms_series WHERE serie_id = ? ' . $statement, $set_serie_array);

			if (!is_null($fav) && ($fav == 1)) {
				if (!in_array($serie_id, $dev["fav_channels"]["series"])) {
					continue;
				}
			}

			$datas[] = array(
				"id" => $serie_id,
				"owner" => '',
				"name" => $set_serie[0]["serie_name"],
				"old_name" => '',
				"o_name" => $set_serie[0]['serie_original_name'],
				"fname" => '',
				"description" => base64_decode($set_serie[0]['serie_short_description']),
				"pic" => '',
				"cost" => 0,
				"time" => 'N\/a',
				"file" => '',
				"path" => '',
				"protocol" => '',
				"rtsp_url" => '',
				"censored" => 0,
				"series" => array(),
				"volume_correction" => 0,
				"category_id" => $set_serie[0]['serie_category_id'],
				"genre_id_1" => 0,
				"genre_id_2" => 0,
				"genre_id_3" => 0,
				"genre_id_4" => 0,
				"cat_genre_id_1" => 0,
				"cat_genre_id_2" => 0,
				"cat_genre_id_3" => 0,
				"cat_genre_id_4" => 0,			
				"hd" => 1,
				"director" => $set_serie[0]['serie_director'],
				"actors" => '',
				"year" => $set_serie[0]['serie_release_date'],
				"accessed" => 1,
				"status" => 1,
				"disable_for_hd_devices" => 0,
				"added" => '',
				"count" => 0,
				"count_first_0_5" => 0,
				"count_second_0_5" => 0,
				"vote_sound_good" => 0,
				"vote_sound_bad" => 0,
				"vote_video_good" => 0,
				"vote_video_bad" => 0,
				"rate" => '',
				"last_rate_update" => '',
				"last_played" => '',
				"for_sd_stb" => 0,
				"rating_imdb" => '',
				"rating_count_imdb" => '',
				"rating_last_update" => "0000-00-00 00:00:00",
				"age" => '',
				"high_quality" => 0,
				"rating_kinopoisk" => 0,
				"comments" => '',
				"low_quality" => 0,
				"is_series" => 1,
				"year_end" => 0,
				"autocomplete_provider" => "imdb",
				"screenshots" => "",
				"is_movie" => 1,
				"lock" => 0,
				"fav" => 0,
				"for_rent" => 0,
				"screenshot_uri" => $set_serie[0]['serie_pic'],
				"genres_str" => $set_serie[0]['serie_genre'],
				"cmd" => '',
				"week_and_more" => '',
				"has_files" => 1
			);
		}
	}

	if ($default_page) {
		$cur_page = $page;
		$selected_item = $ch_idx - (($page - 1) * $page_items);
	} else {
		$cur_page = 0;
		$selected_item = 0;
	}

	$output = array(
		"js" => array(
			"total_items" => $counter,
			"max_page_items" => $page_items,
			"selected_item" => $selected_item,
			"cur_page" => $cur_page,
			"data" => $datas
		)
	);
	
	return json_encode($output);
}

function getEpgdata($short = 0, $stream_id = NULL) {
    global $dev;
    global $player;
	global $db;

    if ($short == 0) {
		$set_line_array = array($dev["total_info"]["line_id"]);
		$set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);
		
		$set_server_array = array(1);
		$set_server = $db->query('SELECT server_ip, server_dns_name, server_broadcast_port FROM cms_server WHERE server_main = ?', $set_server_array);
		
		$line_bouquets = json_decode($set_line[0]['line_bouquet_id'], true);
		foreach($line_bouquets as $bouquet_id){		
			$set_bouquet_array = array($bouquet_id);
			$set_bouquet = $db->query('SELECT bouquet_streams FROM cms_bouquets WHERE bouquet_id = ?', $set_bouquet_array);
			
			$bouquet_streams_decode = json_decode($set_bouquet[0]['bouquet_streams'], true);
			foreach($bouquet_streams_decode as $key => $value){
				$bouquets_stream_array[] = $value;
			}
		}			
		
		$epg = array("js" => array());				
		foreach($bouquets_stream_array as $stream_id){		
			$set_epg_array = array($stream_id);
			$set_epg_data = $db->query('SELECT cms_epg_data.*, cms_epg_sys.epg_stream_id FROM cms_epg_data LEFT JOIN cms_epg_sys ON (cms_epg_data.epg_data_stream_id = cms_epg_sys.epg_stream_name) WHERE cms_epg_data.epg_data_end >= NOW() AND cms_epg_sys.epg_stream_id = ? ORDER BY cms_epg_data.epg_data_start ASC LIMIT 10', $set_epg_array);
			
			for ($i = 0; $i < count($set_epg_data); $i++) {
			
				$start_time = strtotime($set_epg_data[$i]["epg_data_start"]);
				$end_time = strtotime($set_epg_data[$i]["epg_data_end"]);		

				$epg["js"]["data"][$stream_id][$i]["id"] = $set_epg_data[$i]["epg_id"];
				$epg["js"]["data"][$stream_id][$i]["ch_id"] = $set_epg_data[$i]['epg_stream_id'];
				$epg["js"]["data"][$stream_id][$i]["time"] = date("Y-m-d H:i:s", $start_time);
				$epg["js"]["data"][$stream_id][$i]["time_to"] = date("Y-m-d H:i:s", $end_time);
				$epg["js"]["data"][$stream_id][$i]["duration"] = $end_time - $start_time;
				$epg["js"]["data"][$stream_id][$i]["name"] = base64_decode($set_epg_data[$i]["epg_data_title"]);
				$epg["js"]["data"][$stream_id][$i]["descr"] = base64_decode($set_epg_data[$i]["epg_data_description"]);
				$epg["js"]["data"][$stream_id][$i]["real_id"] = $set_epg_data[$i]['epg_stream_id'] . "_" . $set_epg_data[$i]["epg_data_start"];
				$epg["js"]["data"][$stream_id][$i]["category"] = "";
				$epg["js"]["data"][$stream_id][$i]["director"] = "";
				$epg["js"]["data"][$stream_id][$i]["actor"] = "";
				$epg["js"]["data"][$stream_id][$i]["start_timestamp"] = $start_time;
				$epg["js"]["data"][$stream_id][$i]["stop_timestamp"] = $end_time;
				$epg["js"]["data"][$stream_id][$i]["t_time"] = date("h:i", $start_time);
				$epg["js"]["data"][$stream_id][$i]["t_time_to"] = date("h:i", $end_time);
				$epg["js"]["data"][$stream_id][$i]["display_duration"] = $end_time - $start_time;
				$epg["js"]["data"][$stream_id][$i]["larr"] = 0;
				$epg["js"]["data"][$stream_id][$i]["rarr"] = 0;
				$epg["js"]["data"][$stream_id][$i]["mark_rec"] = 0;
				$epg["js"]["data"][$stream_id][$i]["mark_memo"] = 0;
				$epg["js"]["data"][$stream_id][$i]["mark_archive"] = 0;
				$epg["js"]["data"][$stream_id][$i]["on_date"] = date("l d.m.Y", $start_time);
			
			}
		}

		return json_encode($epg);			
	
    } else {
		
		$epg = array("js" => array());
		
		$set_epg_array = array($stream_id);
		$set_epg_data = $db->query('SELECT cms_epg_data.* FROM cms_epg_data LEFT JOIN cms_epg_sys ON (cms_epg_data.epg_data_stream_id = cms_epg_sys.epg_stream_name) WHERE cms_epg_data.epg_data_end >= NOW() AND cms_epg_sys.epg_stream_id = ? ORDER BY cms_epg_data.epg_data_start ASC LIMIT 10', $set_epg_array);
		
		for($i = 0; $i < count($set_epg_data); $i++){
		
			$start_time = strtotime($set_epg_data[$i]["epg_data_start"]);
			$end_time = strtotime($set_epg_data[$i]["epg_data_end"]);
			
			$epg["js"][$i]["id"] = $set_epg_data[$i]["epg_id"];
			$epg["js"][$i]["ch_id"] = $stream_id;
			$epg["js"][$i]["time"] = $set_epg_data[$i]["epg_data_start"];
			$epg["js"][$i]["time_to"] = $set_epg_data[$i]["epg_data_end"];
			$epg["js"][$i]["duration"] = $set_epg_data[$i]["epg_data_end"] - $set_epg_data[$i]["epg_data_start"];
			$epg["js"][$i]["name"] = base64_decode($set_epg_data[$i]["epg_data_title"]);
			$epg["js"][$i]["descr"] = base64_decode($set_epg_data[$i]["epg_data_description"]);
			$epg["js"][$i]["real_id"] = $stream_id . "_" . $set_epg_data[$i]["epg_data_start"];
			$epg["js"][$i]["category"] = "";
			$epg["js"][$i]["director"] = "";
			$epg["js"][$i]["actor"] = "";
			$epg["js"][$i]["start_timestamp"] = $set_epg_data[$i]["epg_data_start"];
			$epg["js"][$i]["stop_timestamp"] = $set_epg_data[$i]["epg_data_end"];
			$epg["js"][$i]["t_time"] = date('H:i', $start_time);
			$epg["js"][$i]["t_time_to"] = date('H:i', $end_time);
			$epg["js"][$i]["mark_memo"] = 0;
			$epg["js"][$i]["mark_archive"] = 0;
		}
		
		return json_encode($epg);	
    }
}

if (($req_type == "stb") && ($req_action == "handshake")) {
    $output["js"]["token"] = strtoupper(md5(mktime(1) . uniqid()));
    exit(json_encode($output));
}

$dev = array();

$mac = get_from_cookie($_SERVER["HTTP_COOKIE"], "mac");
if ($dev = portal_auth($sn, $mac, $ver, $stb_type, $image_version, $device_id, $device_id2, $hw_version, $req_ip)) {
	$continue = true;
} else {
	if (!empty($_SERVER["HTTP_COOKIE"]) || $debug) {
		if ($debug) {
            $mac = base64_encode("00:1A:79:0E:38:B3");
        } else {
            $mac = get_from_cookie($_SERVER["HTTP_COOKIE"], "mac");
        }

        if (!empty($mac)) {
			$set_mag_array = array($mac);
            $set_mag = $db->query('SELECT * FROM mag_devices WHERE mac = ? LIMIT 1', $set_mag_array);
            if (count($set_mag) > 0) {
                $dev["mag_info_db"] = prepair_mag_cols($set_mag);
                $dev["fav_channels"] = json_decode($set_mag[0]["fav_channels"], true);

                if (empty($dev["fav_channels"])) {
                    $dev["fav_channels"] = array();
                    $dev["fav_channels"]["live"] = array();
                    $dev["fav_channels"]["movie"] = array();
                    $dev["fav_channels"]["radio_streams"] = array();
                }
				
				$set_line_array = array($dev["mag_info_db"]["line_id"]);
                $set_line = $db->query('SELECT * FROM cms_lines WHERE line_id = ?', $set_line_array);
                $dev["total_info"] = array_merge($dev["mag_info_db"], $dev["total_info"]);

                $continue = true;
            }
        }
    
	} else {
        exit();
    }
}

$dev["mag_info_db"] = (empty($dev["mag_info_db"]) ? array() : $dev["mag_info_db"]);
$dev["total_info"] = (empty($dev["total_info"]) ? array() : $dev["total_info"]);
$portal_status = (!empty($dev["total_info"]) && !empty($dev["mag_info_db"]) ? 0 : 1);

file_put_contents('/home/xapicode/iptv_xapicode/wwwdir/portal.txt', print_r($dev, true));

switch ($req_type) {
    case "stb":
        switch ($req_action) {
            case "get_profile":
                $total = array_merge($_MAG_DATA["get_profile"], $dev["mag_info_db"]);
                $total["status"] = $portal_status;
                $total["update_url"] = null;
                $total["test_download_url"] = null;
                $total["default_timezone"] = 'Europe/Berlin';
                $total["default_locale"] = 'en_GB.utf8';
                $total["allowed_stb_types"] = json_decode($set_settings[0]["setting_stb_types"], true);
                $total["expires"] = null;
                $total["storages"] = array();
                exit(json_encode(array("js" => $total)));
            break;

            case "get_localization":
                exit(json_encode(array("js" => $_MAG_DATA["get_localization"])));
            break;

            case "log":
                exit(json_encode(array("js" => 1)));
            break;

            case "get_modules":
                $modules = array(
                    "js" => array(
                        "all_modules" => $_MAG_DATA["all_modules"],
                        "switchable_modules" => $_MAG_DATA["switchable_modules"],
                        "disabled_modules" => $_MAG_DATA["disabled_modules"],
                        "restricted_modules" => $_MAG_DATA["restricted_modules"],
                        "template" => $_MAG_DATA["template"]
                    )
                );
                
				exit(json_encode($modules));
            
			break;
        }

    break;
	
    case "watchdog":
        $mag_update_array = array('last_watchdog' => time(), 'mag_id' => $dev["total_info"]["mag_id"]);
		$mag_update = $db->query('
			UPDATE mag_devices SET 
				last_watchdog = :last_watchdog
			WHERE mag_id = :mag_id', $mag_update_array
		);	
		        
		switch ($req_action) {
            case "get_events":
				$set_mag_events_array = array($dev["total_info"]["mag_id"], 0);
                $set_mag_events = $db->query('SELECT * FROM mag_events WHERE mag_device_id = ? AND status = ? ORDER BY id ASC LIMIT 1', $set_mag_events_array);
                if (count($set_mag_events) > 0){
					$data = array(
                        "data" => array(
                            "msgs" => $set_mag_events,
                            "id" => $set_mag_events[0]["id"],
                            "event" => $set_mag_events[0]["event"],
                            "need_confirm" => $set_mag_events[0]["need_confirm"],
                            "msg" => $set_mag_events[0]["msg"],
                            "reboot_after_ok" => $set_mag_events[0]["reboot_after_ok"],
                            "auto_hide_timeout" => $set_mag_events[0]["auto_hide_timeout"],
                            "send_time" => date("d-m-Y H:i:s", $set_mag_events[0]["send_time"]) ,
                            "additional_services_on" => $set_mag_events[0]["additional_services_on"],
                            "updated" => array("anec" => $set_mag_events[0]["anec"],"vclub" => $set_mag_events[0]["vclub"])
                        )
                    );
					
                    $auto_status = array("reboot","reload_portal","play_channel","cut_off");
                    if (in_array($events["event"], $auto_status)) {						
						$mag_update_array = array('status' => 1, 'id' => $set_mag_events[0]["id"]);
						$mag_update = $db->query('
							UPDATE mag_events SET 
								status = :status
							WHERE id = :id', $mag_update_array
						);							
                    }
					
					exit(json_encode(array("js" => $data)));
                }
				
            break;

            case "confirm_event":

                if (!empty($_REQUEST["event_active_id"])) {
                    $event_active_id = $_REQUEST["event_active_id"];
					$mag_update_array = array('status' => 1, 'id' => $event_active_id);
					$mag_update = $db->query('
						UPDATE mag_events SET 
							status = :status
						WHERE id = :id', $mag_update_array
					);						

                    exit(json_encode(array("js" => array("data" => "ok"))));
                }

            break;
        }
}

if (!empty($dev["total_info"]["mag_player"])) {
    $player = $dev["total_info"]["mag_player"];
} else {
    $player = "";
}
$player = "ffmpeg ";

switch ($req_type) {
    case "stb":
        switch ($req_action) {
            case "get_preload_images":
                switch ($gmode) {
                    case "720":
                        exit(json_encode(array("js" => $_MAG_DATA["gmode_720"])));
                    break;

                    case "480":
                        exit(json_encode(array("js" => $_MAG_DATA["gmode_480"])));
                    break;

                    default:
                        exit(json_encode(array("js" => $_MAG_DATA["gmode_default"])));
                }

            break;

            case "get_settings_profile":
				$set_mag_array = array($dev["total_info"]["mag_id"]);
                $set_mag = $db->query('SELECT * FROM mag_devices WHERE mag_id = ?', $set_mag_array);
 
                $_MAG_DATA["settings_array"]["js"]["parent_password"] = $set_mag[0]["parent_password"];
                $_MAG_DATA["settings_array"]["js"]["update_url"] = null;
                $_MAG_DATA["settings_array"]["js"]["test_download_url"] = null;
                $_MAG_DATA["settings_array"]["js"]["playback_buffer_size"] = $set_mag[0]["playback_buffer_size"];
                $_MAG_DATA["settings_array"]["js"]["screensaver_delay"] = $set_mag[0]["screensaver_delay"];
                $_MAG_DATA["settings_array"]["js"]["plasma_saving"] = $set_mag[0]["plasma_saving"];
                $_MAG_DATA["settings_array"]["js"]["spdif_mode"] = $set_mag[0]["spdif_mode"];
                $_MAG_DATA["settings_array"]["js"]["ts_enabled"] = $set_mag[0]["ts_enabled"];
                $_MAG_DATA["settings_array"]["js"]["ts_enable_icon"] = $set_mag[0]["ts_enable_icon"];
                $_MAG_DATA["settings_array"]["js"]["ts_path"] = $set_mag[0]["ts_path"];
                $_MAG_DATA["settings_array"]["js"]["ts_max_length"] = $set_mag[0]["ts_max_length"];
                $_MAG_DATA["settings_array"]["js"]["ts_buffer_use"] = $set_mag[0]["ts_buffer_use"];
                $_MAG_DATA["settings_array"]["js"]["ts_action_on_exit"] = $set_mag[0]["ts_action_on_exit"];
                $_MAG_DATA["settings_array"]["js"]["ts_delay"] = $set_mag[0]["ts_delay"];
                $_MAG_DATA["settings_array"]["js"]["hdmi_event_reaction"] = $set_mag[0]["hdmi_event_reaction"];
                $_MAG_DATA["settings_array"]["js"]["pri_audio_lang"] = $_MAG_DATA["get_profile"]["pri_audio_lang"];
                $_MAG_DATA["settings_array"]["js"]["show_after_loading"] = $set_mag[0]["show_after_loading"];
                $_MAG_DATA["settings_array"]["js"]["sec_audio_lang"] = $_MAG_DATA["get_profile"]["sec_audio_lang"];
                $_MAG_DATA["settings_array"]["js"]["pri_subtitle_lang"] = $_MAG_DATA["get_profile"]["pri_subtitle_lang"];
                $_MAG_DATA["settings_array"]["js"]["sec_subtitle_lang"] = $_MAG_DATA["get_profile"]["sec_subtitle_lang"];
                exit(json_encode($_MAG_DATA["settings_array"]));
            break;

            case "get_locales":
				$set_mag_array = array($dev["total_info"]["mag_id"]);
                $set_mag = $db->query('SELECT * FROM mag_devices WHERE mag_id = ?', $set_mag_array);
                $output = array();

                foreach ($_MAG_DATA["get_locales"] as $country => $code) {
                    $selected = ($set_mag[0]["locale"] == $code ? 1 : 0);
                    $output[] = array("label" => $country, "value" => $code, "selected" => $selected);
                }

                exit(json_encode(array("js" => $output)));
            break;

            case "get_countries":
                exit(json_encode(array("js" => true)));
            break;

            case "get_timezones":
                exit(json_encode(array("js" => true)));
            break;

            case "get_cities":
                exit(json_encode(array("js" => true)));
            break;

            case "get_tv_aspects":
                if (!empty($dev["mag_info_db"]["aspect"])) {
                    exit($dev["mag_info_db"]["aspect"]);
                } else {
                    exit(json_encode($dev["mag_info_db"]["aspect"]));
                }

            break;

            case "set_volume":
                $volume = $_REQUEST["vol"];

                if (!empty($volume)) {
                    $mag_update_array = array('volume' => $volume, 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							volume = :volume
						WHERE mag_id = :mag_id', $mag_update_array
					);
                    exit(json_encode(array("data" => true)));
                }

            break;

            case "set_aspect":
                $ch_id = $_REQUEST["ch_id"];
                $req_aspect = array($request["aspect"]);
                $current_aspect = $dev["mag_info_db"]["aspect"];

                if (empty($current_aspect)) {
                    $mag_update_array = array(
                        'aspect' => json_encode(array(
                            "js" => array(
                                $ch_id => $req_aspect
                            )
                        ))
                    );
					
                    $mag_update_array = array('aspect' => $mag_update_array, 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							aspect = :aspect
						WHERE mag_id = :mag_id', $mag_update_array
					);
                
				} else {
                    $current_aspect = json_decode($current_aspect, true);
                    $current_aspect["js"][$ch_id] = $req_aspect;
					
                    $mag_update_array = array('aspect' => json_encode($current_aspect), 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							aspect = :aspect
						WHERE mag_id = :mag_id', $mag_update_array
					);					
					
                    exit(json_encode(array("js" => true)));
                }

                exit("Identification failed");
           
			break;

            case "set_stream_error":
                exit(json_encode(array("js" => true)));
            break;

            case "set_screensaver_delay":
                if (!empty($_SERVER["HTTP_COOKIE"])) {
                    $screensaver_delay = intval($_REQUEST["screensaver_delay"]);					
                    $mag_update_array = array('screensaver_delay' => $screensaver_delay, 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							screensaver_delay = :screensaver_delay
						WHERE mag_id = :mag_id', $mag_update_array
					);							
					
                    exit(json_encode(array("js" => true)));
                
				} else {
                    exit("Identification failed");
                }

            break;

            case "set_playback_buffer":
                if (!empty($_SERVER["HTTP_COOKIE"])) {
                    $playback_buffer_bytes = intval($_REQUEST["playback_buffer_bytes"]);
                    $playback_buffer_size = intval($_REQUEST["playback_buffer_size"]);					
                    $mag_update_array = array('playback_buffer_bytes' => $playback_buffer_bytes, 'playback_buffer_size' => $playback_buffer_size, 'screensaver_delay' => $screensaver_delay, 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							playback_buffer_bytes = :playback_buffer_bytes,
							playback_buffer_size = :playback_buffer_size
						WHERE mag_id = :mag_id', $mag_update_array
					);					

                    exit(json_encode(array("js" => true)));
                } else {
                    exit("Identification failed");
                }

            break;

            case "set_plasma_saving":
                if (!empty($_SERVER["HTTP_COOKIE"])) {
                    $plasma_saving = intval($_REQUEST["plasma_saving"]);
					
                    $mag_update_array = array('plasma_saving' => $plasma_saving, 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							plasma_saving = :plasma_saving
						WHERE mag_id = :mag_id', $mag_update_array
					);					
					
					
                    exit(json_encode(array("js" => true)));
                } else {
                    exit("Identification failed");
                }

            break;

            case "set_parent_password":
                if (!empty($_SERVER["HTTP_COOKIE"]) && isset($_REQUEST["parent_password"]) && isset($_REQUEST["pass"]) && isset($_REQUEST["repeat_pass"]) && ($_REQUEST["pass"] == $_REQUEST["repeat_pass"])) {
					$set_mag_array = array($dev["total_info"]["mag_id"]);
                    $set_mag = $db->query('SELECT parent_password FROM mag_devices WHERE mag_id = ?', $set_mag_array);
                   
					if(count($set_mag) > 0){
                        $pass = $_REQUEST["pass"];
                        $repeat_pass = $_REQUEST["repeat_pass"];
						
						$mag_update_array = array('parent_password' => $pass, 'mag_id' => $dev["mag_info_db"]["mag_id"]);
						$mag_update = $db->query('
							UPDATE mag_devices SET 
								parent_password = :parent_password
							WHERE mag_id = :mag_id', $mag_update_array
						);							
						
                        exit(json_encode(array("js" => true)));
                    }
                
				} else {
                    exit("Identification failed");
                }

            break;

            case "set_locale":
                if (!empty($_SERVER["HTTP_COOKIE"])) {
                    exit(json_encode(array("js" => true)));
                } else {
                    exit("Identification failed");
                }

            break;

            case "set_hdmi_reaction":
                if (!empty($_SERVER["HTTP_COOKIE"]) && isset($_REQUEST["data"])) {
                    $hdmi_event_reaction = $_REQUEST["data"];					
					$mag_update_array = array('hdmi_event_reaction' => $hdmi_event_reaction, 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							hdmi_event_reaction = :hdmi_event_reaction
						WHERE mag_id = :mag_id', $mag_update_array
					);						
					
                    exit(json_encode(array("js" => true)));
                } else {
                    exit("Identification failed");
                }
        }

    break;

    case "itv":
        switch ($req_action) {
            case "set_fav":
                $fav_channels = (empty($_REQUEST["fav_ch"]) ? "" : $_REQUEST["fav_ch"]);
                $fav_channels = array_filter(array_map("intval", explode(",", $fav_channels)));
                $dev["fav_channels"]["live"] = $fav_channels;
				
				$mag_update_array = array('fav_channels' => json_encode($dev["fav_channels"]), 'mag_id' => $dev["mag_info_db"]["mag_id"]);
				$mag_update = $db->query('
					UPDATE mag_devices SET 
						fav_channels = :fav_channels
					WHERE mag_id = :mag_id', $mag_update_array
				);						
									
                exit(json_encode(array("js" => true)));
            break;

            case "get_fav_ids":
                echo json_encode(array("js" => $dev["fav_channels"]["live"]));
                exit();
            break;

            case "get_all_channels":
                exit(getStreams(NULL, true));
            break;

            case "get_ordered_list":
                $fav = (!empty($_REQUEST["fav"]) ? 1 : NULL);
                $sortby = (!empty($_REQUEST["sortby"]) ? $_REQUEST["sortby"] : NULL);
                $genre = (empty($_REQUEST["genre"]) || !is_numeric($_REQUEST["genre"]) ? NULL : intval($_REQUEST["genre"]));

                exit(getStreams($genre, false, $fav, $sortby));
            break;

            case "get_all_fav_channels":
                $genre = (empty($_REQUEST["genre"]) || !is_numeric($_REQUEST["genre"]) ? NULL : intval($_REQUEST["genre"]));
                exit(getStreams($genre, true, 1));
            break;
            case "get_epg_info":
                exit(getEpgdata(0));
            break;

            case "set_fav_status":
                exit(json_encode(array("js" => array())));
            break;

            case "get_short_epg":
                $ch_id = (empty($_REQUEST["ch_id"]) || !is_numeric($_REQUEST["ch_id"]) ? NULL : intval($_REQUEST["ch_id"]));
                exit(getEpgdata(1, $ch_id));
            break;

            case "set_played":
                exit(json_encode(array("js" => true)));
            break;

            case "set_last_id":
                exit(json_encode(array("js" => true)));
            break;

            case "get_genres":
                $output = array();
                $output["js"][] = array("id" => "*","title" => "All","alias" => "All");

				$set_stream = $db->query('SELECT stream_category_id FROM cms_streams');
				$stream_categories = array();
				foreach($set_stream as $get_streams){
					array_push($stream_categories, $get_streams['stream_category_id']);
				}
				
				foreach(array_unique($stream_categories) as $stream_category_id){
					$set_stream_category_array = array($stream_category_id);
					$set_stream_category = $db->query('SELECT * FROM cms_stream_category WHERE stream_category_id = ?', $set_stream_category_array);
                    $output["js"][] = array(
                        "id" => $set_stream_category[0]["stream_category_id"],
                        "title" => $set_stream_category[0]["stream_category_name"],
                        "alias" => $set_stream_category[0]["stream_category_name"]
                    );
				}
                exit(json_encode($output));
            break;
        }

    break;

    case "remote_pvr":
        switch ($req_action) {
            case "get_active_recordings":
                exit(json_encode(array("js" => array())));
            break;
        }

    break;

    case "media_favorites":
        switch ($req_action) {
            case "get_all":
                exit(json_encode(array("js" => array())));
            break;
        }

    break;

    case "tvreminder":
        switch ($req_action) {
            case "get_all_active":
                exit(json_encode(array("js" => array())));
            break;
        }

    break;

    case "vod":
        switch ($req_action) {
            case "set_fav":

                if (!empty($_REQUEST["video_id"])) {
                    $video_id = intval($_REQUEST["video_id"]);

                    if (!in_array($video_id, $dev["fav_channels"]["movie"])) {
                        $dev["fav_channels"]["movie"][] = $video_id;
                    }
					
					$mag_update_array = array('fav_channels' => json_encode($dev["fav_channels"]), 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							fav_channels = :fav_channels
						WHERE mag_id = :mag_id', $mag_update_array
					);						
					
                }

                exit(json_encode(array("js" => true)));
            break;

            case "del_fav":

                if (!empty($_REQUEST["video_id"])) {
                    $video_id = intval($_REQUEST["video_id"]);

                    foreach ($dev["fav_channels"]["movie"] as $key => $val) {
                        if ($val == $video_id) {
                            unset($dev["fav_channels"]["movie"][$key]);
                            break;
                        }
                    }

					$mag_update_array = array('fav_channels' => json_encode($dev["fav_channels"]), 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							fav_channels = :fav_channels
						WHERE mag_id = :mag_id', $mag_update_array
					);	
					
                    break;
                }

                exit(json_encode(array("js" => true)));
           
			break;

            case "get_categories":

                $output = array();
                $output["js"] = array();

                if ($get_settings['setting_show_all_category_mag'] == 1) {
                    $output["js"][] = array(
                        "id" => "*",
                        "title" => "All",
                        "alias" => "All"
                    );
                }

                $set_movie_category = $db->query('SELECT * FROM cms_movie_category');
                foreach($set_movie_category as $get_movie_category) {
                    $output["js"][] = array(
                        "id" => $get_movie_category["movie_category_id"],
                        "title" => $get_movie_category["movie_category_name"],
                        "alias" => $get_movie_category["movie_category_name"]
                    );
                }
                exit(json_encode($output));
            break;

            case "get_genres_by_category_alias":

                $output = array();
                $output["js"][] = array(
                    "id" => "*",
                    "title" => "*"
                );

                $set_movie_category = $db->query('SELECT * FROM cms_movie_category');
                foreach($set_movie_category as $get_movie_category) {
                    $output["js"][] = array(
                        "id" => $get_movie_category["movie_category_id"],
                        "title" => $get_movie_category["movie_category_name"]
                    );
                }

                exit(json_encode($output));
            break;

            case "get_years":
                exit(json_encode($_MAG_DATA["get_years"]));
            break;

            case "get_ordered_list":

                $category = (!empty($_REQUEST["category"]) && is_numeric($_REQUEST["category"]) ? $_REQUEST["category"] : NULL);
                $fav = (!empty($_REQUEST["fav"]) ? 1 : NULL);
                $sortby = (!empty($_REQUEST["sortby"]) ? $_REQUEST["sortby"] : "added");
                exit(getMovie($category, $fav, $sortby));
            break;

            case "create_link":

                $data = json_decode(base64_decode($_REQUEST["cmd"]) , true);

                $movie_url = 'http://' . $data['server_dns_name'] . ':' . $data['server_broadcast_port'] . '/movie/' . $data['username'] . '/' . $data['password'] . '/' . $data['movie_id'] . '.' . $data["movie_container"];
                $output = array(
                    "js" => array(
                        "id" => $data["movie_id"],
                        "cmd" => $movie_url,
                        "load" => 0,
                        "error" => "",
                        "from_cache" => 1
                    )
                );
                exit(json_encode($output));
            break;

            case "log":
                exit(json_encode(array("js" => 1)));
            break;

            case "get_abc":
                exit(json_encode($_MAG_DATA["get_abc"]));
            break;
        }

    break;

    case "series":
        switch ($req_action) {
            case "set_fav":

                if (!empty($_REQUEST["movie_id"])) {
                    $video_id = intval($_REQUEST["movie_id"]);

                    if (!in_array($video_id, $dev["fav_channels"]["series"])) {
                        $dev["fav_channels"]["series"][] = $video_id;
                    }
					
					$mag_update_array = array('fav_channels' => json_encode($dev["fav_channels"]), 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							fav_channels = :fav_channels
						WHERE mag_id = :mag_id', $mag_update_array
					);						
					
                }

                exit(json_encode(array("js" => true)));
            break;

            case "del_fav":

                if (!empty($_REQUEST["movie_id"])) {
                    $video_id = intval($_REQUEST["movie_id"]);

                    foreach ($dev["fav_channels"]["series"] as $key => $val) {
                        if ($val == $video_id) {
                            unset($dev["fav_channels"]["series"][$key]);
                            break;
                        }
                    }

					$mag_update_array = array('fav_channels' => json_encode($dev["fav_channels"]), 'mag_id' => $dev["mag_info_db"]["mag_id"]);
					$mag_update = $db->query('
						UPDATE mag_devices SET 
							fav_channels = :fav_channels
						WHERE mag_id = :mag_id', $mag_update_array
					);	
					
                    break;
                }

                exit(json_encode(array("js" => true)));
           
			break;

            case "get_categories":

                $output = array();
                $output["js"] = array();

                if ($get_settings['setting_show_all_category_mag'] == 1) {
                    $output["js"][] = array(
                        "id" => "*",
                        "title" => "All",
                        "alias" => "All"
                    );
                }

                $set_serie_category = $db->query('SELECT * FROM cms_serie_category');
                foreach($set_serie_category as $get_serie_category) {
                    $output["js"][] = array(
                        "id" => $get_serie_category["serie_category_id"],
                        "title" => $get_serie_category["serie_category_name"],
                        "alias" => $get_serie_category["serie_category_name"]
                    );
                }
                exit(json_encode($output));
            break;

            case "get_genres_by_category_alias":

                $output = array();
                $output["js"][] = array(
                    "id" => "*",
                    "title" => "*"
                );

                $set_serie_category = $db->query('SELECT * FROM cms_serie_category');
                foreach($set_serie_category as $get_serie_category) {
                    $output["js"][] = array(
                        "id" => $get_serie_category["serie_category_id"],
                        "title" => $get_serie_category["serie_category_name"]
                    );
                }

                exit(json_encode($output));
            break;

            case "get_years":
                exit(json_encode($_MAG_DATA["get_years"]));
            break;

            case "get_ordered_list":
				$category = (!empty($_REQUEST["category"]) && is_numeric($_REQUEST["category"]) ? $_REQUEST["category"] : NULL);
                $fav = (!empty($_REQUEST["fav"]) ? 1 : 0);
                $sortby = (!empty($_REQUEST["sortby"]) ? $_REQUEST["sortby"] : "added");
					
                exit(getSerie($category, $_REQUEST["movie_id"], $_REQUEST["season_id"], $_REQUEST["episode_id"], $fav, $sortby));
            break;

            case "create_link":						
					
				$data = json_decode(base64_decode($_REQUEST["cmd"]) , true);	
				
				$set_episode_array = array($data['season_num'], $data['series_id'], $_REQUEST['series']);
				$set_episode = $db->query('SELECT * FROM cms_serie_episodes WHERE serie_episode_season = ? AND serie_id = ? AND serie_episode_number = ?', $set_episode_array);
			
				$output = array(
					"js" => array(
						"id" => $_REQUEST['series'],
						"cmd" => 'http://' . $data['server_dns_name'] . ':' . $data['server_broadcast_port'] . '/serie/'.$data['series_id']. '/' . $data['username'] . '/' . $data['password'] . '/' . $set_episode[0]['episode_id'] . '.' . $set_episode[0]["serie_episode_extension"],
						"load" => 0,
						"error" => "",
						"from_cache" => 1
					)
				);
										
				exit(json_encode($output));
				
			break;

            case "log":
                exit(json_encode(array("js" => 1)));
            break;

            case "get_abc":
                exit(json_encode($_MAG_DATA["get_abc"]));
            break;
        }

    break;	
	
    case "downloads":
        switch ($req_action) {
            case "get_all":
                exit(json_encode(array("js" => "\"\"")));
            break;

            case "get_all":
                exit(json_encode(array("js" => true)));
            break;
        }

    break;

    case "weatherco":
        switch ($req_action) {
            case "get_current":
                exit(json_encode(array("js" => false)));
            break;
        }

    break;

    case "course":
        switch ($req_action) {
            case "get_data":
                exit(json_encode(array("js" => true)));
            break;
        }

    break;

    case "account_info":
        switch ($req_action) {
            case "get_terms_info":
                exit(json_encode(array("js" => true)));
            break;

            case "get_payment_info":
                exit(json_encode(array("js" => true)));
            break;

            case "get_main_info":
                exit(json_encode(array("js" => true)));
            break;

            case "get_demo_video_parts":
                exit(json_encode(array("js" => true)));
            break;

            case "get_agreement_info":
                exit(json_encode(array("js" => true)));
            break;
        }

    break;

    case "radio":
        switch ($req_action) {
            case "get_ordered_list":

            break;

            case "get_all_fav_radio":

            break;

            case "set_fav":
                exit(json_encode(array("js" => true)));
            break;

            case "get_fav_ids":
            break;
        }

    break;

    case "tv_archive":
        switch ($req_action) {
            case "create_link":
                exit(json_encode(array("js" => true)));
            break;
        }
    break;

    case "epg":
        switch ($req_action) {
            case "get_week":
                $k = - 3;
                $i = 0;
                $epg_week = array();
                $curDate = strtotime(date("Y-m-d"));

                while ($k < 10) {
                    $thisDate = $curDate + ($k * 86400);
                    $epg_week["js"][$i]["f_human"] = date("D d F", $thisDate);
                    $epg_week["js"][$i]["f_mysql"] = date("Y-m-d", $thisDate);
                    $epg_week["js"][$i]["today"] = ($k == 0 ? 1 : 0);
                    $k++;
                    $i++;
                }

                exit(json_encode($epg_week));
            break;

            case "get_simple_data_table":
                if (!empty($_REQUEST["ch_id"]) && !empty($_REQUEST["date"])) {
										
					$req_date = $_REQUEST["date"];
					$date = explode("-", $req_date);
					$page_items = 10;
					$default_page = false;
					$total_items = 0;
					$ch_idx = 0;							
					
					$start_up_limit = mktime(0, 0, 0, $date[1], $date[2], $date[0]);
					$start_dn_limit = mktime(23, 59, 59, $date[1], $date[2], $date[0]);
				
					$set_stream_array = array($_REQUEST['ch_id']);
					$set_stream = $db->query('SELECT stream_id FROM cms_streams WHERE stream_id = ?', $set_stream_array);
					
					$set_epg_array = array($set_stream[0]['stream_id'], $start_up_limit, $start_dn_limit);
					$set_epg_data = $db->query('SELECT cms_epg_data.* FROM cms_epg_data LEFT JOIN cms_epg_sys ON (cms_epg_data.epg_data_stream_id = cms_epg_sys.epg_stream_name) WHERE cms_epg_sys.epg_stream_id = ? AND UNIX_TIMESTAMP(cms_epg_data.epg_data_start) >= ? AND UNIX_TIMESTAMP(cms_epg_data.epg_data_start) <= ? ORDER BY UNIX_TIMESTAMP(cms_epg_data.epg_data_start) ASC', $set_epg_array);

					if(count($set_epg_data) > 0){
					
						$total_items = count($set_epg_data);
						foreach ($set_epg_data[0] as $key => $epg_data ) {
							if (($epg_data["epg_data_start"] <= time()) && (time() <= $epg_data["epg_data_end"])) {
								$ch_idx = $key + 1;
								break;
							}
						}
					}
				
					if ($page == 0) {
						$default_page = true;
						$page = ceil($ch_idx / $page_items);

						if ($page == 0) {
							$page = 1;
						}

						if ($req_date != date("Y-m-d")) {
							$page = 1;
							$default_page = false;
						}
					}		

					$program = array_slice($set_epg_data, ($page - 1) * $page_items, $page_items);
					$data = array();	

					for ($i = 0; $i < count($program); $i++) {
						$open = 0;

						if (time() <= $program[$i]["end"]) {
							$open = 1;
						}

						$data[$i]["id"] = $program[$i]["epg_id"];
						$data[$i]["ch_id"] = $_REQUEST['ch_id'];
						$data[$i]["time"] = $program[$i]["epg_data"];
						$data[$i]["time_to"] =	$program[$i]["epg_data_end"];
						$data[$i]["duration"] = strtotime($program[$i]["epg_data_end"]) - strtotime($program[$i]["epg_data_start"]);
						$data[$i]["name"] = base64_decode($program[$i]["epg_data_title"]);
						$data[$i]["descr"] = base64_decode($program[$i]["epg_data_description"]);
						$data[$i]["real_id"] = $_REQUEST['ch_id'] . "_" . $program[$i]["epg_data_start"];
						$data[$i]["category"] = "";
						$data[$i]["director"] = "";
						$data[$i]["actor"] = "";
						$data[$i]["start_timestamp"] = $program[$i]["epg_data_start"];
						$data[$i]["stop_timestamp"] = $program[$i]["epg_data_end"];
						$data[$i]["t_time"] = date("h:i", strtotime($program[$i]["epg_data_start"]));
						$data[$i]["t_time_to"] = date("h:i", strtotime($program[$i]["epg_data_end"]));
						$data[$i]["open"] = $open;
						$data[$i]["mark_memo"] = 0;
						$data[$i]["mark_rec"] = 0;
						$data[$i]["mark_archive"] = 0;
					}						

					if ($default_page) {
						$cur_page = $page;
						$selected_item = $ch_idx - (($page - 1) * $page_items);
					}
					else {
						$cur_page = 0;
						$selected_item = 0;
					}

					$output = array();
					$output["js"]["cur_page"] = $cur_page;
					$output["js"]["selected_item"] = $selected_item;
					$output["js"]["total_items"] = $total_items;
					$output["js"]["max_page_items"] = $page_items;
					$output["js"]["data"] = $data;

					echo json_encode($output);
				}
            break;

            case "get_data_table":
                $from_ts = $_REQUEST["from_ts"];
                $to_ts = $_REQUEST["to_ts"];
                $from = $_REQUEST["from"];
                $to = $_REQUEST["to"];
                exit();
            break;
        }

    break;
}

*/

?>
