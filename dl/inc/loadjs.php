<?php 
include_once(dirname(__FILE__).'/ipVN.php');
include_once(dirname(__FILE__).'/lang-js.php');
$file_js = isset($_REQUEST['file']) ? (dirname(__FILE__).'/../'.$_REQUEST['file']) : null;
if(!$file_js || !file_exists($file_js)) {
	http_response_code(404);
	exit();
}
$file_include = $file_js.'.lang';

if(file_exists($file_include)) {
	parse_str(@explode('?',$_SERVER['REQUEST_URI'])[1], $querys);
	if(!empty($querys)) foreach($querys as $key => $value) $_REQUEST[$key] = $value;
	//$prex_lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'vi';
	if(isset($_REQUEST['lang']) && preg_match('/(vi|en)/i', $_REQUEST['lang'],$prex_lang)) {
		$prex_lang = $prex_lang[1];
	} elseif(isset($_COOKIE['lang']) && preg_match('/(vi|en)/i', $_COOKIE['lang'],$prex_lang)) {
		$prex_lang = $prex_lang[1];
	} else {
		$isVN = ip2ipsVN();
		if($isVN) {
			$prex_lang = 'vi';
		} else {
			$prex_lang = 'en';
		}
	}
	$content = file_get_contents($file_include);
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
} else $content = file_get_contents($file_js);
header('Content-Type: application/javascript');
exit($content);
?>