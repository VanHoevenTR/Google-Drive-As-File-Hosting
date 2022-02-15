<?php
include_once('inc/config.php');
include_once('inc/functions.php');

$all_scopes = array(
	'drive' => array(
		'https://www.googleapis.com/auth/drive',//	View and manage the files in your Google Drive
		'https://www.googleapis.com/auth/drive.appdata',//	View and manage its own configuration data in your Google Drive
		'https://www.googleapis.com/auth/drive.file',//	View and manage Google Drive files and folders that you have opened or created with this app
		//'https://www.googleapis.com/auth/drive.metadata',//	View and manage metadata of files in your Google Drive
		//'https://www.googleapis.com/auth/drive.metadata.readonly',//	View metadata for files in your Google Drive
		//'https://www.googleapis.com/auth/drive.photos.readonly',//	View the photos, videos and albums in your Google Photos
		'https://www.googleapis.com/auth/drive.readonly',//	View the files in your Google Drive
		//'https://www.googleapis.com/auth/drive.scripts',//	Modify your Google Apps Script scripts' behavior
	),
);
$scopes = array();
foreach ($all_scopes as $items) {
	foreach ($items as $item) {
		$scopes[] = $item;
	}
}

$scopes = implode('+',array_map("urlencode", $scopes));

$site_config['redirectURL'] = $site_config['homepage'].'/token.php';

$url = 'https://accounts.google.com/o/oauth2/auth?redirect_uri='.urlencode($site_config['redirectURL']).'&response_type=code&client_id='.$site_config['clientId'].'&scope='.$scopes.'&approval_prompt=force&access_type=offline';
echo '<a href="'.$url.'">'.$url.'</a><br /><br />'."\n";

if(isset($_REQUEST['code'])) {
	echo "<br/>Code: ".$_REQUEST['code']."<br/>";
	$curl = new cURL();
	$post_string = 'code='.$_REQUEST['code'].'&client_id='.$site_config['clientId'].'&client_secret='.$site_config['clientSecret'].'&redirect_uri='.urlencode($site_config['redirectURL']).'&grant_type=authorization_code';
	$curl->header(array('Content-Type: application/x-www-form-urlencoded'));
	$html = $curl->post('https://accounts.google.com/o/oauth2/token',$post_string);
	$data = json_decode($html,true);
	echo '<br/><pre>';
	print_r ($data);
	echo '</pre><br/>';
	echo '<form method="POST" action=""><textarea rows="6" cols="80">'.$html.'</textarea></form><br/>';
	if(isset($data['refresh_token'])) {
		exit();
	} else echo 'Not found refresh_token.';
} else {
	echo '<form method="GET" action=""><input type="text" name="code"><input type="submit" value="GO"></form>';
	exit();
}
exit();