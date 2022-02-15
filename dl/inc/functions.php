<?php
function getInfoToken($access_token) { // ko xem dc email tk drive upload file -> only dribe not profile
	$q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$access_token;
	$json = @file_get_contents($q);
	$gpUserProfile = json_decode($json,true);
	if(isset($gpUserProfile['email'])) return $gpUserProfile;
	return false;
}
function getDriveId($url) {
	if(preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:(?:(?:docs|drive)\.google|googledrive)\.com\/)(?:(?:a\/(?:[^\/]+)\/)?)(?:host|file\/d|open\?id=|uc\?id=)([\w-]{10,40})(?:\?|\/|&)?/i', $url, $matches)) return $matches[1];
	else return false;
}
function getFolderIdUser($userID) {
	global $site_config,$mysqli;
	$user_idfolder = $site_config['drive_parents'];
	$mysqli = new QueryDB();
	if((($user_idfolder = $mysqli->get_data('user_idfolder','users','user_id',$userID)) == '') && ($access_token = getAccessToken($site_config['refresh_token']))) {
		$curl = new cURL();
		$post_string = '{"title": "Folder of user '.$userID.'","parents": [{"id":"'.$site_config['drive_parents'].'"}],"mimeType": "application/vnd.google-apps.folder"}';
		$curl->header(array('Authorization: Bearer '.$access_token,'Content-Type: application/json'));
		$html = $curl->post('https://www.googleapis.com/drive/v2/files',$post_string);
		$data = json_decode($html,true);
		if(isset($data['id'])) {
			$user_idfolder = $data['id'];
			$mysqli = new QueryDB();
			$q = "UPDATE users SET user_idfolder='".$user_idfolder."' WHERE user_id = '".$userID."'";
			$result = $mysqli->db->query($q);
		}
	}
	return $user_idfolder;
}

function getAccessToken($refresh_token,$renew=false) {
	global $site_config;
	$file_token = dirname(__FILE__).'/token_'.preg_replace('/[\/\\\?:\^\*<>"]/i','~',$refresh_token).'.json';
	//if(!is_writable($file_token)) chmod(__DIR__, 0755);
	if($renew || !file_exists($file_token) || ((time() - filemtime($file_token)) > 3500)) {
		$curl = new cURL();
		$post_string = 'client_id='.$site_config['clientId'].'&client_secret='.$site_config['clientSecret'].'&refresh_token='.$refresh_token.'&grant_type=refresh_token';
		$curl->header(array('Content-Type: application/x-www-form-urlencoded'));
		$html = $curl->post('https://www.googleapis.com/oauth2/v4/token',$post_string);
		$access_token = json_decode($html,true);
		if(isset($access_token['access_token'])) {
			file_put_contents($file_token, $html);
			return $access_token['access_token'];
		} //else return $html;
	} else {
		$html = file_get_contents($file_token);
		$access_token = json_decode($html,true);
		if(isset($access_token['access_token'])) {
			return $access_token['access_token'];
		}
	}
	return false;
}
if (!function_exists('getAccessTokenGsuite0')) {
function getAccessTokenGsuite0($renew=false) {
	$refresh_token = '1/6QaQHkZUxmov5HzaLNOhU3Zu8UtdeKtShYLp22B2YO0';
	$file_token = dirname(__FILE__).'/token_'.preg_replace('/[\/\\\?:\^\*<>"]/i','~',$refresh_token).'.json';
	if($renew || !file_exists($file_token) || ((time() - filemtime($file_token)) > 3500)) {
		$curl = new cURL();
		$post_string = 'client_id=455062964424-vj6gnhup3tos3mdf7vj1vraoo51j6akp.apps.googleusercontent.com&client_secret=IJNHT6S6Y9YB-32tjOf5Y6LW&refresh_token='.$refresh_token.'&grant_type=refresh_token';
		$curl->header(array('Content-Type: application/x-www-form-urlencoded'));
		$html = $curl->post('https://www.googleapis.com/oauth2/v4/token',$post_string);
		$access_token = json_decode($html,true);
		if(isset($access_token['access_token'])) {
			file_put_contents($file_token, $html);
			return $access_token['access_token'];
		}
	} else {
		$html = file_get_contents($file_token);
		$access_token = json_decode($html,true);
		if(isset($access_token['access_token'])) {
			return $access_token['access_token'];
		}
	}
	return false;
}
}


function getUserLogin($redirect=false) {
	global $site_config;
	if (!class_exists('User')) include_once(dirname(__FILE__).'/User.php');
	$user = new User();
	if(isset($_SESSION['userData']) || isset($_COOKIE['userData'])) {
		if (!class_exists('KZ_Crypt')) include_once(dirname(__FILE__).'/KZ_Crypt.php');
		$kz_crypt = new KZ_Crypt;
		$kz_crypt->_text = isset($_SESSION['userData']) ? $_SESSION['userData'] : $_COOKIE['userData'];
		if($kz_crypt->_decrypt() != false) {
			$result = json_decode(trim($kz_crypt->_result),true);
			if(isset($result['user_id'])) {
				if($redirect) {
					$userData = $user->checkUser($result);
					if(!empty($userData)) return $userData;
				} else return $result;
			}
		}
		unset($_SESSION['userData']);
		@session_destroy();
		setcookie('userData', null, -1,'/');
	}
	return $redirect ? header("Location: ".$site_config['homepage']) : null;
}
function get_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = null;
	return $ipaddress;
}
if (!function_exists('formatBytes')) {
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}}
class cURL {
  var $ch, $headers, $agent, $error, $info, $cookiefile;
  //function cURL() {
  function __construct() {
    $this -> headers[] = "Accept: text/html,application/xhtml+xml,application/xml,image/gif, image/x-bitmap, image/jpeg, image/pjpeg";
    $this -> headers[] = "Accept-Language: en-us,en;q=0.5";
    $this -> headers[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $this -> headers[] = "Keep-Alive: 115";
    $this -> headers[] = "Connection: Keep-Alive";
    $this -> headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
    $this->ch = curl_init();
	$this->agent = $this->set_agent(1);
    curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($this->ch, CURLOPT_USERAGENT, $this->agent);
    curl_setopt($this->ch, CURLOPT_HEADER, 0);
    curl_setopt($this->ch, CURLOPT_REFERER, "");
    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
  }
    function header($header) {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
    }

    function ipout($outgoing_ip) {
        curl_setopt($this->ch, CURLOPT_INTERFACE, $outgoing_ip);
    }

    function data($url, $data, $hasHeader = false, $hasBody = true) {
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return $this->getPage($url, $hasHeader, $hasBody);
    }

	function customrequest($url, $request='GET',$data=false) {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $request);
		if($data) curl_setopt($this->ch, CURLOPT_POSTFIELDS,$data);
		return $this->getPage($url);
    }

	function post($url, $data, $hasHeader = false) {
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        return $this->getPage($url, $hasHeader);
    }
    function get($url, $hasHeader = false, $hasBody = true) {
        curl_setopt($this->ch, CURLOPT_POST, 0);
        return $this->getPage($url, $hasHeader, $hasBody);
    }
    function getinfo($url, $hasHeader = true, $hasBody = true) {
        curl_setopt($this->ch, CURLOPT_POST, 0);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, false);
        return $this->getPage($url, $hasHeader, $hasBody);
    }

    function getPage($url, $hasHeader = false, $hasBody = true, $hasInfo = true) {
		$url = preg_replace('/\\0/', "", $url);
		$url = preg_replace('/\s/', '%20', $url);
        curl_setopt($this->ch, CURLOPT_HEADER, $hasHeader ? 1 : 0);
        curl_setopt($this->ch, CURLOPT_NOBODY, $hasBody ? 0 : 1);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $data = curl_exec($this->ch);
        if ($data === FALSE) {
          return curl_error($this->ch);
        }
        $this->error = curl_error($this->ch);
        $this->info = curl_getinfo($this->ch); //$curl -> info['http_code']
        return $data;
    }
    function close() {
        curl_close($this->ch);
    }

	function set_agent($z) {
		$agent = array();
		//$agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)"; // loginYoutube
        $agent[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36";
        $agent[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.19 (KHTML, like Gecko) Chrome/0.2.153.1 Safari/525.19 ";
        $agent[] = "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9b5) Gecko/2008032620 Firefox/3.0b5 ";

		if(is_numeric($z)) {
			$z = $agent[$z];
		}  elseif($z == 'random') {
			$rand_keys = array_rand($agent,1);
			$z = $agent[$rand_keys];
		} elseif(!$z || $z == '' || $z == null) {
			$z = $agent[0];
		} elseif($z!='') {
			$z = $z;
		} elseif(isset($_SERVER['HTTP_USER_AGENT']))
			$z = $_SERVER['HTTP_USER_AGENT'];
		curl_setopt($this->ch, CURLOPT_USERAGENT, $z);
		return $z;
	}
}
function get_redirect($url,$hidesource=false,$showhtml=false,$cookie=false) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	if($cookie) {
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	$html = curl_exec($ch);
	$info = curl_getinfo($ch);
	$redirectURL = isset($info['redirect_url']) ? $info['redirect_url'] : false;
	curl_close($ch);
	if($redirectURL) $result = $redirectURL;
	elseif($showhtml) $result = $html;
	elseif(!$hidesource) $result = $url;
	else $result = null;
	return $result;
	//return $redirectURL ? trim($redirectURL) : (!$hidesource ? $url : null);
}
?>