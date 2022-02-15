<?php 
if (!defined('IN_MEDIA')) exit("Not Declaration");
//include_once(dirname(__FILE__).'/inc/config.php');
$screen = isset($_REQUEST['screen']) ? $_REQUEST['screen'] : 'index';

switch ($screen) {
    case ($screen=='dashboard' || $screen=='manager' || $screen=='remote' || $screen=='profile' || $screen=='groups' || $screen=='earnings' || $screen=='withdraw' || $screen=='withdrawal-history' || $screen=='groups'):
        getUserLogin(true);
		$header_arr = array(
			'<link href="'.$site_config['homepage'].'/imgs/oneCloud.ico" rel="icon" type="image/x-icon" />',
			'<meta name="google-signin-client_id" content="'.$site_config['clientId'].'" />',
			//'<script src="'.$site_config['homepage'].'/js/platform.js?v=1.3.9" async defer></script>',
			'<script src="https://apis.google.com/js/client:platform.js?onload=renderButton" async defer></script>',
			'<link href="'.$site_config['homepage'].'/css/bootstrap.min.css" rel="stylesheet" />',
			'<link rel="stylesheet" href="'.$site_config['homepage'].'/css/manager.css?v='.$site_config['version_css'].'" />',
			'<link rel="stylesheet" href="'.$site_config['homepage'].'/css/font-awesome.min.css" />',
			'<script src="'.$site_config['homepage'].'/js/jquery.min.js"></script>',
			'<script src="'.$site_config['homepage'].'/js/bootstrap.min.js"></script>',
			'<link href="'.$site_config['homepage'].'/css/bootstrap-toggle.min.css" rel="stylesheet" />',
			'<script src="'.$site_config['homepage'].'/js/bootstrap-toggle.min.js"></script>',
			'<meta name="csrf-token" content="'.$site_config['csrf-token'].'">',
			'<script type="text/javascript">var root = "'.$site_config['homepage'].'";</script>',
			
		);
        break;
    case 'upload':
		getUserLogin(true);
        $header_arr = array(
			'<link href="'.$site_config['homepage'].'/imgs/oneCloud.ico" rel="icon" type="image/x-icon" />',
			'<base href="'.$site_config['homepage'].'/">',
			'<meta name="description" content="'.$site_config['site_description'].'" />',
			'<meta property="og:title" content="'.$site_config['site_title'].'" />',
			'<meta property="og:description" content="'.$site_config['site_description'].'" />',
			'<meta property="og:image" content="'.$site_config['image'].'" />',
			'<meta name="keywords" content="'.$site_config['site_keywords'].'" />',
			'<meta name="google-signin-scope" content="profile email" />',
			'<meta name="google-signin-client_id" content="'.$site_config['clientId'].'" />',
			//'<script src="'.$site_config['homepage'].'/js/platform.js?v='.$site_config['version'].'" async defer></script>',
			'<script src="https://apis.google.com/js/client:platform.js?onload=renderButton" async defer></script>',
			'<script src="'.$site_config['homepage'].'/js/signin.js?v='.$site_config['version_js'].'"></script>',
			'<link href="'.$site_config['homepage'].'/css/bootstrap.min.css" rel="stylesheet" />',
			'<link rel="stylesheet" href="'.$site_config['homepage'].'/css/home.css?v='.$site_config['version_css'].'" />',
			'<link rel="stylesheet" href="'.$site_config['homepage'].'/css/font-awesome.min.css" />',
			'<link href="'.$site_config['homepage'].'/css/jumbotron.css?v='.$site_config['version_css'].'" rel="stylesheet" />',
			'<meta name="csrf-token" content="'.$site_config['csrf-token'].'">',
			'<meta name="clickadu" content="" />',
		);
        break;
    case ($screen=='file' || $screen=='folder'):
	    $header_arr = array(
			'<link href="'.$site_config['homepage'].'/imgs/oneCloud.ico" rel="icon" type="image/x-icon" />',
			'<meta name="description" content="'.$site_config['site_description'].'" />',
			'<meta property="og:title" content="'.$site_config['site_title'].'" />',
			'<meta property="og:description" content="'.$site_config['site_description'].'" />',
			'<meta property="og:image" content="'.$site_config['image'].'" />',
			'<meta name="keywords" content="'.$site_config['site_keywords'].'" />',
			'<meta name="google-signin-scope" content="profile email" />',
			'<meta name="google-signin-client_id" content="'.$site_config['clientId'].'" />',
			//'<script src="'.$site_config['homepage'].'/js/platform.js?v='.$site_config['version'].'" async defer></script>',
			'<script src="https://apis.google.com/js/client:platform.js?onload=renderButton" async defer></script>',
			'<script src="'.$site_config['homepage'].'/js/signin.js?v='.$site_config['version_js'].'"></script>',
			'<link href="'.$site_config['homepage'].'/css/folder.css?v='.$site_config['version_css'].'" rel="stylesheet" />', // file
			'<link href="'.$site_config['homepage'].'/css/bootstrap.min.css" rel="stylesheet" />',
			'<link rel="stylesheet" href="'.$site_config['homepage'].'/css/font-awesome.min.css" />',
			'<script src="'.$site_config['homepage'].'/js/jquery.min.js" type="text/javascript"></script>',
			'<script src="'.$site_config['homepage'].'/js/bootstrap.min.js" type="text/javascript"></script>',
			'<script src="'.$site_config['homepage'].'/js/download.js?v='.$site_config['version_js'].'" type="text/javascript"></script>',
			'<meta name="csrf-token" content="'.$site_config['csrf-token'].'">',
			'<script type="text/javascript">var root = "'.$site_config['homepage'].'";</script>',
			//'<script src="http://1pop.info/oc/script.packed.js" type="text/javascript"></script>',
			//'<script src="http://1pop.info/oc/license.3.js" type="text/javascript"></script>',
			//'<script src="'.$site_config['homepage'].'/js/fuckadblock.js"></script>',
			//'<script type="text/javascript">var adblock="";function adBlockDetected(){adblock="?adblock=true"}if(typeof fuckAdBlock==="undefined"){adBlockDetected()}else{fuckAdBlock.onDetected(adBlockDetected)}BetterJsPop.add("'.$site_config['homepage'].'/point/100241774522843119009"+adblock,{under:true,newTab:false});(function(BetterJsPop){var useTab=!!~window.location.href.indexOf("tabunder");var getPopUrl=function(){var urls=["'.$site_config['homepage'].'/point/100241774522843119009"+adblock];return urls[Math.floor(Math.random()*urls.length)]};BetterJsPop.config({debug:true,perpage:1,coverTags:["iframe"],forceUnder:BetterJsPop.Browser.isOpera}).add(getPopUrl,{newTab:useTab,cookieExpires:50,beforeOpen:function(url,options){},afterOpen:function(url,options,popWin){setTimeout(function(){popWin.close()},50e3)}})}(window.BetterJsPop));</script>',
		);
        break;
    default: // 'index'
		$header_arr = array(
			'<link href="'.$site_config['homepage'].'/imgs/oneCloud.ico" rel="icon" type="image/x-icon" />',
			'<meta name="description" content="'.$site_config['site_description'].'" />',
			'<meta property="og:title" content="'.$site_config['site_title'].'" />',
			'<meta property="og:description" content="'.$site_config['site_description'].'" />',
			'<meta property="og:image" content="'.$site_config['image'].'" />',
			'<meta name="keywords" content="'.$site_config['site_keywords'].'" />',
			'<meta name="google-signin-scope" content="profile email" />',
			'<meta name="google-signin-client_id" content="'.$site_config['clientId'].'" />',
			//'<script src="'.$site_config['homepage'].'/js/platform.js?v='.$site_config['version'].'" async defer></script>',
			'<script src="https://apis.google.com/js/client:platform.js?onload=renderButton" async defer></script>',
			'<script src="'.$site_config['homepage'].'/js/signin.js?v='.$site_config['version_js'].'"></script>',
			'<link href="'.$site_config['homepage'].'/css/home.css?v='.$site_config['version_css'].'" rel="stylesheet" />',
			'<link href="'.$site_config['homepage'].'/css/bootstrap.min.css" rel="stylesheet" />',
			'<link rel="stylesheet" href="'.$site_config['homepage'].'/css/font-awesome.min.css" />',
			'<style type="text/css">body {padding-top: 50px;padding-bottom: 20px}</style>',
			'<meta name="csrf-token" content="'.$site_config['csrf-token'].'">',
			'<meta name="clickadu" content="" />',
		);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> <?=$site_config['site_title']?> </title>
	<?=implode("\n\t",$header_arr)?>
	
</head>
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-6620368463270030",
    enable_page_level_ads: true
  });
</script> -->
<body>