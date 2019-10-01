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
// $data['type']               = (!empty($_REQUEST["type"])                        ? $_REQUEST["type"] : NULL);
$data['type']               = $_GET['type'];
// $data['req_action']         = (!empty($_REQUEST["action"])                      ? $_REQUEST["action"] : NULL);
$data['req_action']			= $_GET['action'];
$data['action']				= $_GET['action'];
$data['token']				= $_GET['token'];
$data['JsHttpRequest']		= $_GET['JsHttpRequest'];
$data['sn']                 = (!empty($_REQUEST["sn"])                          ? $_REQUEST["sn"] : NULL);
$data['stb_type']           = (!empty($_REQUEST["stb_type"])                    ? $_REQUEST["stb_type"] : NULL);
// $data['mac']                = (!empty($_REQUEST["mac"])                         ? $_REQUEST["mac"] : NULL);
$data['mac']                = $_COOKIE['mac'];
$data['ver']                = (!empty($_REQUEST["ver"])                         ? $_REQUEST["ver"] : NULL);
$data['user_agent']         = (!empty($_SERVER["HTTP_X_USER_AGENT"])            ? $_SERVER["HTTP_X_USER_AGENT"] : NULL);
$data['image_version']      = (!empty($_REQUEST["image_version"])               ? $_REQUEST["image_version"] : NULL);
$data['device_id']          = (!empty($_REQUEST["device_id"])                   ? $_REQUEST["device_id"] : NULL);
$data['device_id2']         = (!empty($_REQUEST["device_id2"])                  ? $_REQUEST["device_id2"] : NULL);
$data['hw_version']         = (!empty($_REQUEST["hw_version"])                  ? $_REQUEST["hw_version"] : NULL);
$data['gmode']              = (!empty($_REQUEST["gmode"])                       ? intval($_REQUEST["gmode"]) : NULL);
$data['continue']           = false;
$data['debug']              = true;

// Query String compile fix.
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

?>
