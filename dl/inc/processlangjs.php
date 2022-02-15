<?php 
$site_config['lang'] = array(
	'login_success_wait' => array(
		'vi' => 	'Quá trình đăng nhập Thành công.<br>Vui lòng chờ đôi chút.',
		'en' => 	'Login successfully.<br>Wait a sec!'
	),
	'login_error' => array(
		'vi' => 	'Có lỗi xảy ra! Vui lòng Tải lại trang rồi thử lại.',
		'en' => 	'Login error! Please referer page and try login again.'
	),

);
foreach($site_config['lang'] as $key => $value) {
	$code_js[] = '"'.$key.'": "{{'.$key.'}}"';
}
$content = "var config_lang = {\n\t".implode(",\n\t",$code_js)."\n};";
//$prex_lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'vi';
if(isset($_REQUEST['lang']) && preg_match('/(vi|en)/i', $_REQUEST['lang'],$prex_lang)) {
	$prex_lang = $prex_lang[1];
	setcookie('lang', $prex_lang, time() + (86400 * 30),'/'); 
} elseif(isset($_COOKIE['lang']) && preg_match('/(vi|en)/i', $_COOKIE['lang'],$prex_lang)) {
	$prex_lang = $prex_lang[1];
} else {
	$isVN = ip2ipsVN();
	if($isVN) {
		setcookie('lang', 'vi', time() + (86400 * 30),'/'); 
		$prex_lang = 'vi';
	} else {
		$prex_lang = 'en';
		setcookie('lang', 'en', time() + (86400 * 30),'/'); 
	}
}

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
		}
	}
}
//require 'class.JavaScriptPacker.php';
//$content = mb_convert_encoding($content, 'HTML-ENTITIES','UTF-8');
//$packer = new JavaScriptPacker($content, 'Numeric', true, false);
//$content = $packer->pack();
exit($content);
?>