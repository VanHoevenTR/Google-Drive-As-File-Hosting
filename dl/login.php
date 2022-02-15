<?php @session_start();
include_once('inc/KZ_Crypt.php');
include_once('inc/config.php');
//include_once '../megavn.net/inc/_functions.php';
include_once 'inc/functions.php';
include_once 'inc/user.php';
$user = new User();
$type = isset($_REQUEST['type']) ? urldecode($_REQUEST['type']) : null;
$ip = get_ip();
if(strtolower(@$_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if(isset($_REQUEST['oauth'])) {
		$oauth = json_decode($_REQUEST['oauth'], true);
		$access_token = $oauth['access_token'];
		$gpUserProfile = getInfoToken($access_token);
		if(isset($gpUserProfile['email'])) {
			//$output['debug1'] = 'check token ok';
			$gpUserData = array(
				'user_oauth_provider'=> 'google',
				'user_oauth_uid'     => $gpUserProfile['id'],
				'user_first_name'    => @$gpUserProfile['given_name'],
				'user_last_name'     => @$gpUserProfile['family_name'],
				'user_email'         => $gpUserProfile['email'],
				'user_gender'        => @$gpUserProfile['gender'],
				'user_locale'        => @$gpUserProfile['locale'],
				'user_picture'       => @$gpUserProfile['picture'],
				'user_link'          => @$gpUserProfile['link'],
				//'user_nickname'      => $userData['user_first_name'].' '.$userData['user_last_name'],
				//'user_created'       => date("Y-m-d H:i:s"),
				//'user_modified'      => date("Y-m-d H:i:s"),
			);
			//$user = new newUser();
			//$userData = $user->checkUser($gpUserData,false);
			//$user = new User();
			$userData = $user->checkUser($gpUserData);
			if(!$userData) {
				$userData = $user->insertUser($gpUserData);
			}
			if(!empty($userData)) {
				$userData['ip'] = $ip;
				$output['status'] = 1;
				$output['msg'] = $site_config['homepage'].'/dashboard/upload/';              
				$kz_crypt = new KZ_Crypt;
				$kz_crypt->_text = json_encode($userData);
				if($kz_crypt->_encrypt() != false) {
					$data = trim($kz_crypt->_result);
					$_SESSION['userData'] = $data;
					//setcookie('userData', $data, time()+(3600*24*7),'/');
				}
			}
		}
	}
	if(!isset($output['status']) || !$output['status']) $output['msg'] = 'Đăng nhập thất bại!';
	header('Content-Type: application/json');
	echo json_encode($output,JSON_PRETTY_PRINT);
	exit();
} else {
	if(!isset($_REQUEST['code'])) {
		header("Location: https://accounts.google.com/o/oauth2/auth?access_type=online&approval_prompt=force&response_type=code&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fplus.login+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&client_id=".$site_config['clientId']."&redirect_uri=".$site_config['redirectURL']."");
	} else {
		$curl = new cURL();
		$post_string = 'code='.$_REQUEST['code'].'&client_id='.$site_config['clientId'].'&client_secret='.$site_config['clientSecret'].'&redirect_uri='.$site_config['redirectURL'].'&grant_type=authorization_code';
		$curl->header(array('Content-Type: application/x-www-form-urlencoded'));
		$html = $curl->post('https://accounts.google.com/o/oauth2/token',$post_string);
		//exit($html);
		$data = json_decode($html,true);
		//var_dump($data);
		//file_put_contents('user_token.json', $html);
		if(isset($data['access_token'])) {
			$gpUserProfile = getInfoToken($data['access_token']);
			if(isset($gpUserProfile['email'])) {
				//$output['debug1'] = 'check token ok';
				$gpUserData = array(
					'user_oauth_provider'=> 'google',
					'user_oauth_uid'     => $gpUserProfile['id'],
					'user_first_name'    => @$gpUserProfile['given_name'],
					'user_last_name'     => @$gpUserProfile['family_name'],
					'user_email'         => $gpUserProfile['email'],
					'user_gender'        => @$gpUserProfile['gender'],
					'user_locale'        => @$gpUserProfile['locale'],
					'user_picture'       => @$gpUserProfile['picture'],
					'user_link'          => @$gpUserProfile['link'],
					//'user_nickname'      => $userData['user_first_name'].' '.$userData['user_last_name'],
					//'user_created'       => date("Y-m-d H:i:s"),
					//'user_modified'      => date("Y-m-d H:i:s"),
				);
				if(isset($data['refresh_token'])) $gpUserData['refresh_token'] = $data['refresh_token'];
				$userData = $user->checkUser($gpUserData);
				if(!$userData) {
					$userData = $user->insertUser($gpUserData);
				}
				if(!empty($userData)) {
					$userData['ip'] = $ip;
					$output['status'] = 1;
					$output['msg'] = $site_config['homepage'].'/dashboard/upload/';
					$kz_crypt = new KZ_Crypt;
					$kz_crypt->_text = json_encode($userData);
					if($kz_crypt->_encrypt() != false) {
						$data = trim($kz_crypt->_result);
						$_SESSION['userData'] = $data;
						//setcookie('userData', $data, time()+(3600*24*7),'/');
						header("Location: ".$site_config['homepage']."");exit();
					}
				}
			}
		}
	}
	exit('Có lỗi xảy ra!');
}
?>