<?php @session_start();
define('IN_MEDIA',true);
//include_once '../megavn.net/inc/_functions.php';
include_once 'inc/functions.php';
include_once('inc/ipVN.php');
include_once('inc/KZ_Crypt.php');
include_once('inc/config.php');
include_once 'inc/db.php';
include_once 'inc/lang.php';
include_once 'inc/user.php';

if($PROTO=='http' && !LOCALHOST) {
    //header('HTTP/1.1 301 Moved Permanently');
    //header('Location: ' . 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    //exit();
}

$site_config['site_name'] = $site_config['lang']['site_name'];
$site_config['site_title'] = isset($site_config['lang']['site_title'][$site_config['prex_lang']]) ? $site_config['lang']['site_title'][$site_config['prex_lang']] : $site_config['lang']['site_title']['vi'];
$site_config['site_description'] = isset($site_config['lang']['site_description'][$site_config['prex_lang']]) ? $site_config['lang']['site_description'][$site_config['prex_lang']] : $site_config['lang']['site_description']['vi'];
$site_config['site_keywords'] = isset($site_config['lang']['site_keywords'][$site_config['prex_lang']]) ? $site_config['lang']['site_keywords'][$site_config['prex_lang']] : $site_config['lang']['site_keywords']['vi'];
$kz_crypt = new KZ_Crypt;
$kz_crypt->_text = json_encode(array('time' => time(),'ip' => get_ip()));
if($kz_crypt->_encrypt() != false){
	$site_config['csrf-token'] = trim($kz_crypt->_result);
} else $site_config['csrf-token'] = null;


$id = isset($_REQUEST['id']) ? urldecode($_REQUEST['id']) : null;
$screen = isset($_REQUEST['screen']) ? urldecode($_REQUEST['screen']) : null;
$type = isset($_REQUEST['type']) ? urldecode($_REQUEST['type']) : null;

$userData = getUserLogin();
if(!empty($userData))
	$login = true;
else $login = false;

if(file_exists($screen.'.html')) $file = $screen.'.html';
else $file = 'index.html';

ob_start();
include $file;
$content = ob_get_clean();
if(preg_match_all('/{{(.*)}}/U',$content,$data)) {
	foreach($data[1] as $key) {
		if(isset($site_config['lang'][$key])) {
			if(isset($site_config['lang'][$key][$prex_lang]))
				$value = $site_config['lang'][$key][$prex_lang];
			elseif(isset($site_config['lang'][$key]['vi']))
				$value = $site_config['lang'][$key]['vi'];
			else
				$value = $site_config['lang'][$key];
			$content = str_replace('{{'.$key.'}}',$value,$content);
			//echo '{{'.$key.'}} => '.$site_config['lang'][$key]."\n";
		}
	}
}
exit($content);
?>
