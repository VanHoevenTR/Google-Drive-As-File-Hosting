<?php date_default_timezone_set("Asia/Ho_Chi_Minh");
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP']; }         
if(isset($_SERVER["REQUEST_SCHEME"]))
	$PROTO = $_SERVER["REQUEST_SCHEME"];
elseif(isset($_SERVER["HTTP_CF_VISITOR"]["scheme"]))
	$PROTO = $_SERVER["HTTP_CF_VISITOR"]["scheme"];
elseif(isset($_SERVER["HTTP_X_FORWARDED_PROTO"]))
	$PROTO = $_SERVER["HTTP_X_FORWARDED_PROTO"];
else $PROTO = 'http';

if((@$_SERVER['SERVER_NAME'] == 'localhost') || (@$_SERVER['SERVER_NAME'] == '127.0.0.1')) {
	define('LOCALHOST',true);
	ini_set('display_errors', 'On');
	$site_config['homepage'] = $PROTO . "://" . 'localhost/4file';
	$site_config['dbPassword'] = $config['db_pass'] = "kenviet1988@@";
} else {
	define('LOCALHOST',false);
	ini_set('display_errors', 'Off');
	$site_config['dbPassword'] = $config['db_pass'] = "kenviet1988@@";
	$site_config['homepage'] = $PROTO . "://" . @$_SERVER['HTTP_HOST']; // warning in command linux
}
if(preg_match('@^(?:'.$site_config['homepage']."/dashboard/manager".')@i',@$_SERVER["HTTP_REFERER"])) $IN_MANAGER = true;
else $IN_MANAGER = false;
define('IN_MANAGER',$IN_MANAGER);
parse_str(@explode('?',$_SERVER['REQUEST_URI'])[1], $querys);
if(!empty($querys) && isset($querys['lang'])) $_REQUEST['lang'] = $querys['lang'];

if(isset($_REQUEST['lang']) && preg_match('/(vi|en)/i', $_REQUEST['lang'],$prex_lang)) {
	$site_config['prex_lang'] = $prex_lang[1];
	setcookie('lang', $site_config['prex_lang'], time() + (86400 * 30),'/');
} elseif(isset($_COOKIE['lang']) && preg_match('/(vi|en)/i', $_COOKIE['lang'],$prex_lang)) {
	$site_config['prex_lang'] = $prex_lang[1];
} else {
	$isVN = function_exists('ip2ipsVN') ? ip2ipsVN() : true;
	if($isVN) {
		setcookie('lang', 'vi', time() + (86400 * 30),'/');
		$site_config['prex_lang'] = 'vi';
	} else {
		$site_config['prex_lang'] = 'en';
		setcookie('lang', 'en', time() + (86400 * 30),'/');
	}
}
$prex_lang = $site_config['prex_lang'];

$site_config['proxy'] = array(
	'v4' => '',
);

$site_config['url'] = $site_config['homepage'];
$site_config['image'] = $site_config['homepage'].'/imgs/4FileUs.jpg';
//$site_config['logo_player'] = $site_config['homepage'].'/imgs/logo-player-50px.png';
$site_config['email'] = 'admin@mGame.us';
$site_config['fanpage'] = 'https://www.facebook.com/mGame.us';
$site_config['admins_id'] = '';
$site_config['app_id'] = '';
$site_config['pages_id'] = '';

$site_config['clientId'] = '329778535356-i2s29t4i5fc2a2plva4dg61c0ltjr7hj.apps.googleusercontent.com';
$site_config['clientSecret'] = 'SzaZdKVYtXtZyt4wXPGS0Zzp';
$site_config['redirectURL'] = $site_config['homepage'].'/viet/ken';
$site_config['apiKey'] = 'AIzaSyA-U6ABJlleEqpaMtpPQ_izS0mRfQPsvyo';


$site_config['server'][] = array('email' => 'kenviet1988@gmail.com',
								'refresh_token' => '1/Un098_Gyd2EIBH5HsFwghS85n3UEG3LwTjDF362A90M');
								
$site_config['server'][] = array('email' => 'toantnph04465@fpt.edu.vn',
								'refresh_token' => '1/OVZhWu0cKDU2QrxqAd2JE7Y-rO-U4t3OerCO2UblgSY');
								
$site_config['server'][] = array('email' => 'ducnhph04596@fpt.edu.vn',  
								'refresh_token' => '1/Qe2BHTag5qULeSPecYDZ-oKyqZP236uIBJe2kvq-jC8');
								
$site_config['server'][] = array('email' => 'dungvtph04516@fpt.edu.vn',
								'refresh_token' => '1/k5ykLF2QEcnVv2SkbJTIMpZKOmC611D1ixbXviuW94p0RoxcXDUBYPtAO7UuHo4e');
								
$site_config['server'][] = array('email' => 'thendph04509@fpt.edu.vn',  
								'refresh_token' => '1/K9EyyaAIMMvRlk3VlOfkGzlg4ym30b-G6iWA8fHtVvY');
								
$site_config['server'][] = array('email' => 'thachndph04533@fpt.edu.vn',  
								'refresh_token' => '1/7yeSSLUo4bZg_nl9cHVZmrEADx6Aa9c7S5qqXOB7uTY');								
															
$site_config['server'][] = array('email' => 'download.mgame.us@gmail.com',               
								'refresh_token' => '1/24gR9nHAZtA4XPpZC2ZwzmH4aVSZ0QlWdm4dUpVxENM');							
								           		
$site_config['server'][] = array('email' => 'download1.mgame.us@gmail.com',
								'refresh_token' => '1/GLvTID372ScNw8pIlN4sK_2db6IUvwZms838d33ZGUg7yCsoGXBxwhwlrsG6XuZX');
								
$site_config['server'][] = array('email' => 'download2.mgame.us@gmail.com',  
								'refresh_token' => '1/8jo-dz1XUPOztLS4jTgLpGCvXl_1XqL7AF4sebjG2oU');
								
$site_config['refresh_token'] = $site_config['server'][0]['refresh_token']; 
$site_config['num_server_copy'] = 5;


$site_config['dbHost']    = $config['db_host'] = "localhost";            
$site_config['dbUsername'] = $config['db_user'] = "mgame_file";

$site_config['dbName']     = $config['db_name'] = "mgame_file";  
$site_config['userTbl']    = 'users';
$site_config['fileTbl']    = 'files';
$site_config['folderTbl']    = 'folders';
$site_config['groupTbl']    = 'groups';

include('_dbconnect.php');
$mysql = new mysql; 

$site_config['csrf-token'] = null;
$site_config['version_js'] = '1';
$site_config['version_css'] = '1';
?>
