<?php @session_start();
include_once('inc/functions.php');
include_once('inc/ipVN.php');
include_once('inc/config.php');
include_once 'inc/lang.php';
include_once('inc/KZ_Crypt.php');
include_once('inc/db.php');
include_once 'inc/UUID.php';
include_once 'inc/user.php';
include_once 'inc/folder.php';
include_once 'inc/file.php';

require __DIR__ . '/phpfastcache/phpfastcache.php';
$phpFastCache = phpFastCache();

$prex_lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'vi';

$user = new User();
$userData = getUserLogin();

if(!empty($userData) && isset($userData['user_id'])) $userID = (int)$userData['user_id'];
else $userID = 0;

$type = isset($_REQUEST['type']) ? urldecode($_REQUEST['type']) : null;
$id = isset($_REQUEST['id']) ? (int)urldecode($_REQUEST['id']) : null;
$output = array(
	"status" 	=> 0,
	"msg" 		=> null
);
$output['debug']['IN_MANAGER'] = IN_MANAGER;
$ip = get_ip();

$checktoken = false;
$headers = array_change_key_case(apache_request_headers(),CASE_LOWER);
if(isset($headers['x-csrf-token'])) {
	$kz_crypt = new KZ_Crypt;
	$kz_crypt->_text = $headers['x-csrf-token'];
	if($kz_crypt->_decrypt() != false) {
		$result = json_decode(trim($kz_crypt->_result),true);
		if(isset($result['time'])) {
			if((time() - $result['time']) > (3600*3)) $output['msg'] = 'REQUEST_EXPIRED!';
			elseif($result['ip'] != $ip) $output['msg'] = 'REQUEST_INVALID_IP!';
			else $checktoken = true;
		} else $output['msg'] = 'TOKEN_INVALID!';
	}
} else {
	//$output['msg'] = 'TOKEN NOT FOUND!';
	//$output['debug'][] = $headers;
}
if(preg_match("/^(file_pass|pass|file_check|file_download|directLink|manager_info|manager_update|manager_search|manager_sort|manager_delete|manager_delete_all|folder_move|savefile)$/i",$type,$data)) {
	if(preg_match("/(?:file|embed)\/([^\/\?]+)/",$_SERVER['REQUEST_URI'],$data)) {
		$fileID = $data[1];
	} else {
		$fileID = $id;
	}
	$file = new File();
	if(IN_MANAGER)
		$fileData = $file->checkFile($fileID,$userID);
	else
		$fileData = $file->checkFile($fileID);
	$fileID = $fileData['file_id'];
	$fileUser = $fileData['file_user'];
} else $fileData = null;

if(preg_match("/^(folder_create|folder_info|folder_update|folder_delete|folder_load|folder_search|manager_search|manager_sort|folder_move|folder_pass)$/i",$type,$data)) {
	if(preg_match("/(manager|folder)\/([^\/\?]+)/",$_SERVER['REQUEST_URI'],$data)) {
		$folderID = $data[2];
	} else {
		$folderID = $id;
	}
	$folder = new Folder();
	if(IN_MANAGER)
		$folderData = $folder->checkFolder($folderID,$userID);
	else
		$folderData = $folder->checkFolder($folderID);
	$folderID = $folderData['folder_id'];
	$folderUser = $folderData['folder_user'];
} else $folderData = null;

if(preg_match("/^(group_create|group_status)$/i",$type,$data)) {
	include_once 'inc/group.php';
	$group = new Group();
} else $groupData = null;

if($type=='checkfileupload') {
	if(!empty($userData)) {
		if($access_token_upload = getAccessToken($site_config['refresh_token'])) {
			$time_cookie = time() + 30;
			setcookie('access', $access_token_upload, $time_cookie,'/');

			$output['status'] = 1;
			$output['msg'] = 'OK';
		} else $output['msg'] = '{{server_offline}}';//'Máy chủ đang bảo trì!';
	} else {}
} elseif($type=='savefile') {
	if(isset($_REQUEST['fileId']) && isset($_REQUEST['fileSize'])) {
		$fileId = $_REQUEST['fileId'];
		$output['debug']['fileId'] = $fileId;
		$file_name = preg_replace('/(\^|"|:|\*|\?|\||<|>|\/|\\\)/','-',urldecode($_REQUEST['fileName']));
		$file_url = 'https://drive.google.com/open?id='.$fileId;
		$file_mime 	= urldecode($_REQUEST['fileType']);
		$file_size 	= $_REQUEST['fileSize'];
		$file_slug = createSlug(md5($fileId.microtime()));
		$file_status = preg_match('/(video)/i',$file_mime) ? 0 : 1;
		$file_thumb = null;
		if(($access_token_upload = getAccessToken($site_config['refresh_token']))) {
			$curl = new cURL();
			$curl->header(array('Authorization: Bearer '.$access_token_upload,'Content-Type: application/json'));
			$html = $curl->post('https://content.googleapis.com/drive/v2/files/'.$fileId.'/permissions','{"type":"anyone","role":"reader","withLink":"true"}');
			
			/***************************************** MULTI FILE ***************************************/
			if(count($site_config['server'])>1) {
				$file_urls = array();
				//$file_urls[] = $file_url;
				$site_config['server_tmp'] = $site_config['server'];
				unset($site_config['server_tmp'][0]);
				$rand_keys = array_rand($site_config['server_tmp'], $site_config['num_server_copy']);
				//shuffle($site_config['server_tmp']);
				//for ($i=0;$i<count($site_config['server_tmp']);$i++) {
				foreach($rand_keys as $i) {
					$output['debug']['server'][] = 'Copy to account: '.$site_config['server_tmp'][$i]['email'];
					$refresh_token = $site_config['server_tmp'][$i]['refresh_token'];
					if(($access_token = getAccessToken($refresh_token))) {
						$curl->header(array('Authorization: Bearer '.$access_token,'Content-Type: application/json'));
						$html = $curl->post('https://www.googleapis.com/drive/v2/files/'.$fileId.'/copy',''); // need share permissions folder
						$data = json_decode($html,true);
						if(isset($data['id'])) {
							$output['debug']['server'][] = 'Success copy to account '.$site_config['server_tmp'][$i]['email'].': '.$data['id'];
							$file_urls[] = 'https://drive.google.com/open?id='.$data['id'];
							$curl->header(array('Authorization: Bearer '.$access_token,'Content-Type: application/json'));
							$html = $curl->post('https://content.googleapis.com/drive/v2/files/'.$data['id'].'/permissions','{"type":"anyone","role":"reader","withLink":"true"}');
						} else {
							$output['debug']['server'][] = 'Fail copy to account '.$site_config['server_tmp'][$i]['email'];
							$output['debug']['server'][] = $html;
						}
					}
					//if($i==($site_config['num_server_copy']-1)) break;
				}
				if(!empty($file_urls)) {
					$file_url = $file_urls[0];
					$curl->header(array('Authorization: Bearer '.$access_token_upload,'Content-Type: application/json'));
					$html = $curl->customrequest('https://www.googleapis.com/drive/v2/files/'.$fileId,"DELETE");
				}
			}
			/********************************************************************************/
		}
		
		$fileData = array(
			'file_slug' 	=> $file_slug,
			'file_user' 	=> $userID,
			'file_name' 	=> $file_name,
			'file_url' 		=> $file_url,
			'file_urls' 	=> !empty($file_urls) ? implode(';',$file_urls) : null,
			'file_size' 	=> $file_size,
			'file_mime' 	=> $file_mime,
			'file_thumb' 	=> $file_thumb,
			'file_checksum' => null,
			'file_created' 	=> date("Y-m-d H:i:s"),
			'file_modified' => date("Y-m-d H:i:s"),
			'file_type' 	=> 'upload',
			'file_status' 	=> $file_status,
		);

		$file = new File();
		$fileData = $file->insertFile($fileData);
		if(!empty($fileData)) {
			$output['status'] = 1;
			$output['msg'] = $site_config['homepage'].'/file/'.$file_slug;
			$key = 'dashboard_'.$userData['user_id'];
			//$InstanceCache->deleteItem($key);
			$phpFastCache->delete($key);
		}
	} else $output['msg'] = 'File empty! (contact to admin.)';
	if(!$output['msg']) $output['msg'] = '{{unable_upload_file}}';
} elseif($type=='remote') {
	$fileDriveID = $fileId = isset($_REQUEST['fileId']) ? $_REQUEST['fileId'] : null;
	if($fileId) {
		$mimeType = isset($_REQUEST['mimeType']) ? $_REQUEST['mimeType'] : null;
		$fileName = isset($_REQUEST['fileName']) ? $_REQUEST['fileName'] : null;
		$filenameNew = preg_replace('/(\^|"|:|\*|\?|\||<|>|\/|\\\)/','-',urldecode($fileName));
		$fileSize = isset($_REQUEST['fileSize']) ? $_REQUEST['fileSize'] : null;
		$md5Checksum = isset($_REQUEST['md5Checksum']) ? $_REQUEST['md5Checksum'] : null;
		$file_url = null;
		$file_thumb = null;
		$file_subscene = null;
		$file_source = 'https://drive.google.com/open?id='.$fileId;
		if(($access_token_upload = getAccessToken($site_config['refresh_token']))) {
			$curl = new cURL();
			$curl->header(array('Authorization: Bearer '.$access_token_upload,'Content-Type: application/json'));
			$html = $curl->post('https://content.googleapis.com/drive/v2/files/'.$fileId.'/copy?alt=json','');
			$output['debug'][] = $html;
			$data = json_decode($html,true);
			if(isset($data['id'])) {
				$fileId = $data['id'];
				$file_url = 'https://drive.google.com/open?id='.$data['id'];
				$curl->header(array('Authorization: Bearer '.$access_token_upload,'Content-Type: application/json'));
				$html = $curl->post('https://content.googleapis.com/drive/v2/files/'.$data['id'].'/permissions','{"type":"anyone","role":"reader","withLink":"true"}');
				/***************************************** MULTI FILE ***************************************/
			if(count($site_config['server'])>1) {
				$file_urls = array();
				//$file_urls[] = $file_url;
				$site_config['server_tmp'] = $site_config['server'];
				unset($site_config['server_tmp'][0]);
				shuffle($site_config['server_tmp']);
				$output['debug']['server'][] = $site_config['server_tmp'];
				for ($i=0;$i<count($site_config['server_tmp']);$i++) {
					$output['debug']['server'][] = 'Copy to account: '.$site_config['server_tmp'][$i]['email'];
					$refresh_token = $site_config['server_tmp'][$i]['refresh_token'];
					if(($access_token = getAccessToken($refresh_token))) {
						$curl->header(array('Authorization: Bearer '.$access_token,'Content-Type: application/json'));
						$html = $curl->post('https://www.googleapis.com/drive/v2/files/'.$fileId.'/copy',''); // need share permissions folder
						$data = json_decode($html,true);
						if(isset($data['id'])) {
							$output['debug']['server'][] = 'Success copy to account '.$site_config['server_tmp'][$i]['email'].': '.$data['id'];
							$file_urls[] = 'https://drive.google.com/open?id='.$data['id'];
							$curl->header(array('Authorization: Bearer '.$access_token,'Content-Type: application/json'));
							$html = $curl->post('https://content.googleapis.com/drive/v2/files/'.$data['id'].'/permissions','{"type":"anyone","role":"reader","withLink":"true"}');
						} else {
							$output['debug']['server'][] = 'Fail copy to account '.$site_config['server_tmp'][$i]['email'];
							$output['debug']['server'][] = $html;
						}
					}
					if($i==($site_config['num_server_copy']-1)) break;
				}
				if(!empty($file_urls)) {
					$file_url = $file_urls[0];
					$curl->header(array('Authorization: Bearer '.$access_token_upload,'Content-Type: application/json'));
					$html = $curl->customrequest('https://www.googleapis.com/drive/v2/files/'.$fileId,"DELETE");
				}
			}
			/********************************************************************************/
			}
		}
		if($file_url) {
			$file_slug = createSlug(md5($fileId.microtime()));
			$file_status = preg_match('/(video)/i',$mimeType) ? 0 : 1;
			$fileData = array(
				'file_slug' 	=> $file_slug,
				'file_user' 	=> $userID,
				'file_name' 	=> $fileName,
				'file_url' 		=> $file_url,
				'file_urls' 	=> !empty($file_urls) ? implode(';',$file_urls) : null,
				'file_source' 	=> $file_source,
				'file_thumb' 	=> $file_thumb,
				'file_size' 	=> $fileSize,
				'file_mime' 	=> $mimeType,
				'file_checksum' => $md5Checksum,
				'file_folder' 	=> 0,
				'file_status' 	=> $file_status,
				'file_type' 	=> 'remote',
				'file_created' 	=> date("Y-m-d H:i:s"),
				'file_modified' => date("Y-m-d H:i:s"),
			);

			$file = new File();
			$fileData = $file->insertFile($fileData);
			if(!empty($fileData) && $file_url) {
				$output['status'] = 1;
				$output['msg'] = $site_config['homepage'].'/file/'.$file_slug;
				$key = 'dashboard_'.$userData['user_id'];
				//$InstanceCache->deleteItem($key);
				$phpFastCache->delete($key);
				if(preg_match('/(video)/i',$mimeType)) $output['info'] = '{{file_copy_processing}}';
				else $output['info'] = '{{file_copy_success}}';
			} else $output['info'] = '{{file_copy_fail}}: '.$fileId;
		} else $output['info'] = '{{file_copy_fail}}: '.$fileId;
	} else $output['info'] = '{{file_copy_fail}}: No File ID.';
} elseif(($type=='file_pass' || $type=='pass')) {
	if(!empty($fileData)) {
		if(isset($_REQUEST['pass']) && ($_REQUEST['pass'] == $fileData['file_password'])) {
			$output['status'] = 1;
			$output['msg'] = $fileData['file_name'];
			setcookie(md5($fileData['file_id']).'/pass', md5($_REQUEST['pass']), time()+(3600),'/');
		} else $output['msg'] = '{{wrong_password}}';
	}
} elseif($type=='file_check') {
	if(!empty($fileData)) {
		$file_lock = $fileData['file_password'] != '' ? true : false;
		$output['status'] = 1;
		if(!$file_lock) {
			$output['info'] = array(
				"file_lock" => $file_lock,
				"file_name" => $fileData['file_name'],
				"file_size" => (int)$fileData['file_size'],
				"file_thumb" => $fileData['file_thumb'],
				"file_mime" => $fileData['file_mime'],
				"file_date" => $fileData['file_created'],
				"file_url" => $site_config['homepage'].'/file/'.$fileData['file_slug'],
				"file_embed" => $site_config['homepage'].'/embed/'.$fileData['file_slug'],
			);
		}
		unset($output['info']);
	}
} elseif($type=='file_download') {
	if(!empty($fileData)) {
		//$file_url = $fileData['file_url'] != '' ? $fileData['file_url'] : $fileData['file_source'];
		if(!empty($fileData['file_urls'])) {
			$file_urls = explode(';',$fileData['file_urls']);
			$file_url = $file_urls[mt_rand(0, count($file_urls) - 1)];
			$output['debug']['download']['file_urls'] = $file_urls;
			$output['debug']['download'][] = 'Random file: '.$file_url;
		} else $file_url = $fileData['file_url'];
		$file_lock = $fileData['file_password'] != '' ? true : false;
		if(isset($_COOKIE[md5($fileData['file_id']).'/pass']) && ($_COOKIE[md5($fileData['file_id']).'/pass'] == md5($fileData['file_password']))) $file_lock = false;
		if(isset($userData['user_id']) && $userData['user_id'] == $fileData['file_user']) $file_lock = 0;
		if(!$file_lock && ($fileDriveID = getDriveId($file_url)) && ($access_token_upload = getAccessToken($site_config['refresh_token']))) {
			$url_download = null;
			$key = $fileDriveID;
			$CachedString = $phpFastCache->get($key);
			if (is_null($CachedString)) {
				if($fileData['file_status'] != 0 && $fileData['file_status'] != 1) {
					$url_download = $file_url;
				} else {
					$curl = new cURL();
					$curl->header(array('Authorization: Bearer '.$access_token_upload,'Content-Type: application/json'));
					$html = $curl->get('https://www.googleapis.com/drive/v2/files/'.$fileDriveID);
					$data = json_decode($html,true);
					if(isset($data['downloadUrl'])) {
						$url_download = $data['downloadUrl'];
					}
				}
				if($url_download && !preg_match('/(accounts.google.com|ServiceLogin)/i',$url_download)) {
					$phpFastCache->set($key, $url_download, 3600*24*7); // 12600
				}
			} else {
				$url_download = $CachedString;
			}
			if($url_download) {
				$url_download = $url_download.'&access_token='.$access_token_upload;
				$output['status'] = 1;
				$output['msg'] = $url_download;
			}
		} else $output['debug'][] = 'Not is drive';
	} else $output['debug'][] = 'No file to download';
	if(!$output['status']) $output['msg'] = '{{unable_download_file}}';
} elseif($type=='directLink') {
	if($checktoken) {
		if(!empty($fileData) && preg_match('/(video)/i',$fileData['file_mime'])) {
				if($fileData['file_status']) {
					$file_url = ($fileData['file_url'] != '' && $fileData['file_status']) ? $fileData['file_url'] : $fileData['file_source'];
					if(!empty($fileData['file_urls'])) {
						$file_urls = explode(';',$fileData['file_urls']);
						$file_url = $file_urls[mt_rand(0, count($file_urls) - 1)];
					}
					//$output['debug']['video'][] = $file_url;
					$output['title'] = $fileData['file_name'];
					$film_sub = null;
					$key = $file_url;
					$playlist = null;
					$CachedString = $phpFastCache->get($key);
					if (isset($_REQUEST['cache']) || is_null($CachedString)) {
							$curl = new cURL();
							/* ERROR 403
							$curl->select_type_ip('auto');
							$html = $curl->get('https://mail.google.com/e/get_video_info?authuser=&docid='.$fileDriveID.'&access_token='.getAccessToken($site_config['refresh_token']));
							parse_str($html, $info);
							if(@$info['status'] == 'ok' && isset($info['fmt_stream_map'])) {
								$playlist = null;
								$playlist['title'] = isset($info['title']) ? $info['title'] : null;
								$stream = explode(',', $info['fmt_stream_map']);
								include_once('inc/itag.php');
								$i=0;foreach($stream as $info) {
									if(preg_match('/^(\d*)\|(.*)/',$info,$data)) {
										$itag = $data[1];
										$height = $formats_itag[$itag]['height'];
										$width = $formats_itag[$itag]['width'];
										$ext = $formats_itag[$itag]['ext'];
										if($ext == 'mp4') {
											$url = $data[2].($playlist['title'] ? ('&title='.htmlspecialchars($playlist['title'])) : '');
											$url = preg_replace("/\/[^\/]+\.(google|googlevideo)\.com/","/redirector.googlevideo.com",$url);
											if($height<720) $label = $height.'p SD';
											else $label = $height.'p HD';
											$playlist['sources'][$i] = array("file"=>$url,"label"=>$label,"type"=>"video/mp4");
											if($height==720) $playlist['sources'][$i]['default'] = true;
											$i++;
										}
									}
								}
							}
							*/
						$html = $curl->get('http://megavn.net/player/ajax.php?referer=https://www.taptin.pro&token=taptin.pro&cache=delete&url='.$file_url);
						$find = array('megavn.net');
						$replace = array('4File.Us');
						$string = $html;
						$html = str_replace($find, $replace, $string);
						//$output['debug']['apihtml'] = $html;
						$playlist = json_decode($html,true);
						if(isset($playlist['sources'])) {
							$phpFastCache->set($key, $playlist, (3600*3)+(45*60)); // 12600
						} else {
							$output['debug'][] = 'No source';
							$output['debug']['playlist'] = $playlist;
						}
						$output['cache'] = 'FIRST LOAD';
					} else {
						$playlist = $CachedString;
					}

					if(!empty($playlist['sources'])) {
						$output['list'] = $playlist['sources'];
						if(isset($film_sub)) $output['sub'] = $film_sub;
						else if(isset($playlist['tracks'][0])) $output['sub'] = $playlist['tracks'][0]['file'];

						if(isset($playlist['image'])) $output['image'] = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&refresh=604800&url='.$playlist['image'];
						elseif(isset($fileData['file_slug'])) $output['image'] = $site_config['homepage'].'/thumb/'.$fileData['file_slug'];
						if(!isset($output['title']) && isset($playlist['title'])) $output['title'] = $playlist['title'];
						unset($output['status']);
						unset($output['msg']);
					} else {
						$output['msg'] = '{{video_error}}';
					}
				} else $output['msg'] = '{{video_processing}}';
		}
	} else $output['debug'][] = 'No token';
} elseif($type=='login') {
	if(isset($_REQUEST['oauth'])) {
		$oauth = json_decode($_REQUEST['oauth'], true);
		$access_token = $oauth['access_token'];
		$gpUserProfile = getInfoToken($access_token);
		if(isset($gpUserProfile['email'])) {
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
			);
			$userData = $user->checkUser($gpUserData);
			if(!$userData) {
				$userData = $user->insertUser($gpUserData);
			}
			if(!empty($userData)) {
				$userData['ip'] = $ip;
				$output['status'] = 1;
				$output['msg'] = $site_config['homepage'].'/dashboard';
				$kz_crypt = new KZ_Crypt;
				$kz_crypt->_text = json_encode($userData);
				if($kz_crypt->_encrypt() != false) {
					$data = trim($kz_crypt->_result);
					$_SESSION['userData'] = $data;
					setcookie('userData', $data, time()+(3600*24*7),'/');
				}
			}
		}
	}
	if(!$output['status']) $output['msg'] = '{{login_fail}}';
} elseif($type=='logout') {
	$output['status'] = 1;
	$output['msg'] = "./";
	unset($_SESSION['userData']);
	unset($_SESSION['G_AUTHUSER_H']);
	session_destroy();
	setcookie('userData', null, -1,'/');
	header("Location: ./");
} elseif($type=='manager_info') {
		if(!empty($fileData)) {
			$output['status'] = 1;
			$output['manager'][0] = array(
				'id' => (int)$fileData['file_id'],
				'name' => $fileData['file_name'],
				'track' => $fileData['file_subscene'],
				'pass' => $fileData['file_password'],
				'slug' => $fileData['file_slug'],
				'type' => preg_match("/video/i",$fileData['file_mime']) ? 1 : (preg_match("/image/i",$fileData['file_mime']) ? 2 : 0),
			);
			unset($output['msg']);
			$output['debug']['fileData'] = $fileData;
		} else $output['msg'] = '{{file_not_found}}';
} elseif($type=='manager_update') {
	if(!empty($fileData)) {
		$fileDriveID = getDriveId($fileData['file_url']);

		$file_url = $fileData['file_url'];
		$filenameOld = $fileData['file_name'];
		$filenameNew = preg_replace('/(\^|"|:|\*|\?|\||<|>|\/|\\\)/','-',urldecode($_REQUEST['name']));
		$fileDataNew = array(
			'file_id' => (int)$_REQUEST['id'],
			'file_name' => $filenameNew,
			'file_password' => urldecode($_REQUEST['password']),
			'file_subscene' => urldecode($_REQUEST['subscene']),
			'file_update' => date("Y-m-d H:i:s",time()),
		);
		if(!preg_match('/(video|image|photo)/i',$fileData['file_mime'])) {
			$curl = new cURL();
			$html = $curl->get($file_url);
			$html = unescapeUTF8EscapeSeq($html);
			$curl->close();
			if(preg_match('/meta property="og:image" content="([^\"]+)"/ms',$html,$data)) {
				$fileDataNew['file_thumb'] = $data[1];
			}
		}

		$fileData = $file->updateFile($fileDataNew,$userID);
		if(!empty($fileData)) {
			$access_token = getAccessToken($site_config['refresh_token']);
			if($fileDriveID && $access_token) {
				$curl = new cURL();
				$curl->header(array('Authorization: Bearer '.$access_token,'Content-Type: application/json'));
				$html = $curl->post('https://content.googleapis.com/drive/v2/files/'.$fileDriveID.'/permissions','{"type":"anyone","role":"reader","withLink":"true"}');
			}

			$output['status'] = 1;
			$output['msg'] = '{{file_update_success}}';
			$output['pass'] = $fileData['file_password'];
		} else $output['msg'] = '{{file_update_fail}}';
	} else $output['msg'] = '{{file_not_found}}';
} elseif($type=='manager_delete') {
	$fileDriveID = getDriveId($fileData['file_url']);
	$fileData = $file->deleteFile($fileData['file_id'],$userID);
	if($fileData) {
		if($fileDriveID && ($access_token = getAccessToken($site_config['refresh_token']))) {
			$curl = new cURL();
			$curl->header(array('Authorization: Bearer '.$access_token,'Content-Type: application/json'));
			$html = $curl->customrequest('https://www.googleapis.com/drive/v2/files/'.$fileDriveID,"DELETE");
			$output['debug']['delete'] = $html;
		}

		$output['status'] = 1;
		$output['msg'] = '{{file_delete_success}}';
		$key = 'dashboard_'.$userData['user_id'];
		$phpFastCache->delete($key);
	} else $output['msg'] = '{{file_delete_fail}}';
} elseif($type=='folder_create') {
	$folderData = $folder->checkFolder($folderID,$userID);
	if($folderData['folder_parent'] == '0' || (int)$folderData['folder_parent'] == 0) {
		$folder_slug = createSlugfd(md5($_REQUEST['name'].microtime()));
		$folderData = array(
			'folder_name' 		=> urldecode($_REQUEST['name']),
			'folder_slug' 		=> $folder_slug,
			'folder_user' 		=> $userID,
			'folder_password' 	=> null,
			'folder_created' 	=> date("Y-m-d H:i:s"),
			'folder_modified' 	=> date("Y-m-d H:i:s"),
			'folder_parent' 	=> isset($folderData['folder_id']) ? (int)$folderData['folder_id'] : 0,
		);
		$folderData = $folder->insertFolder($folderData);
		if(isset($folderData['folder_id'])) {
			$output['status'] = 1;
			$output['msg'] = '{{folder_create_success}}';
		} else $output['msg'] = '{{folder_exist}}';
	} else $output['msg'] = '{{folder_create_fail_subfolder}}';
} elseif($type=='folder_info') {
	if(isset($_REQUEST['id'])) $folderID = (int)$_REQUEST['id'];
	$folderData = $folder->checkFolder($folderID,$userID);
	if(!empty($folderData)) {
		$output['status'] = 1;
		$output['folder'][0] = array(
			'id' 		=> (int)$folderData['folder_id'],
			'name' 		=> $folderData['folder_name'],
			'type' 		=> 1,
			'pass' 		=> $folderData['folder_password'],
			'slug' 		=> $folderData['folder_slug'],
			'status'	=> 1,
			'created_at'=> $folderData['folder_created'],
		);
		unset($output['msg']);
	} else $output['msg'] = '{{task_fail}}';
} elseif($type=='folder_update') {
	if(isset($_REQUEST['id'])) $folderID = (int)$_REQUEST['id'];
	$folderData = $folder->checkFolder($folderID,$userID);
	if($folderData['folder_user'] == $userID) {
		$folderData = array(
			'folder_id' 		=> (int)$_REQUEST['id'],
			'folder_name' 		=> urldecode($_REQUEST['name']),
			'folder_password' 	=> urldecode($_REQUEST['password']),
			'folder_modified' 	=> date("Y-m-d H:i:s"),
		);
		$folderData = $folder->updateFolder($folderData,$userID);
		if(!empty($folderData)) {
			$output['status'] = 1;
			$output['msg'] = '{{update_folder_success}}';
		} else $output['msg'] = '{{update_folder_fail}}';
	} else $output['msg'] = '{{update_folder_fail}}';
} elseif($type=='folder_delete') {
	if(isset($_REQUEST['id'])) $folderID = (int)$_REQUEST['id'];
	$folderData = $folder->checkFolder($folderID,$userID);
	if($folderData['folder_user'] == $userID) {
		$folderData = $folder->deleteFolder($folderID,$userID);
		if($folderData) {
			$output['status'] = 1;
			$output['msg'] = '{{folder_delete_success}}';
		} else $output['msg'] = '{{folder_delete_fail}}';
	} else $output['msg'] = '{{folder_delete_fail}}';
} elseif($type=='folder_pass') {
	if(!empty($folderData)) {
		if(isset($_REQUEST['pass']) && ($_REQUEST['pass'] == $folderData['folder_password'])) {
			$output['status'] = 1;
			$output['msg'] = $folderData['folder_name'];
			setcookie(md5($folderData['folder_id']).'/pass', md5($_REQUEST['pass']), time()+(3600),'/');
		} else $output['msg'] = '{{wrong_password}}';
	}
} elseif($type=='folder_move') {
	if(isset($_REQUEST['folderId']) && isset($_REQUEST['fileIds'])) {
		$folderID = (int)$_REQUEST['folderId'];
		$fileIds = array_filter(explode(',',$_REQUEST['fileIds']));
		$folderData = $folder->checkFolder($folderID,$userID);
			if(($folderID==0 || !empty($folderData)) && !empty($fileIds)) {
				for($i=0;$i<count($fileIds);$i++) {
					$fileId = $fileIds[$i];
						$fileData = array('file_id'=>$fileId,'file_folder'=>$folderID);
						$fileData = $file->updateFile($fileData,$userID);
				}
				if(isset($fileData) && !empty($fileData)) {
					$output['status'] = 1;
					$output['msg'] = '{{file_move_success}}';
				}
			}
	}
	if(!$output['status']) $output['msg'] = '{{file_move_fail}}';
}  elseif($type=='manager_delete_all') {
	if(isset($_REQUEST['fileIds'])) {
		$fileIds = array_filter(explode(',',$_REQUEST['fileIds']));
		if(!empty($fileIds)) {
			$numsuccess = array();
			foreach($fileIds as $fileID) {
				$fileData = $file->checkFile($fileID,$userID);
				if(!empty($fileData) && ($fileData['file_user'] == $userID)) {
					if($file->deleteFile($fileID,$userID)) $numsuccess['success'][] = $fileData['file_name'];
					else $numsuccess['fail'][] = $fileData['file_name'];
				}
			}
			if(isset($numsuccess['success']) && count($numsuccess['success']) > 0) {
				$output['status'] = 1;
				if(count($numsuccess['success']) == count($fileIds)) $output['msg'] = '{{files_delete_success}}';
				elseif(isset($numsuccess['fail'])) $output['msg'] = '{{files_delete_success_fail}}: '.implode(', '.$numsuccess['fail']);
				else $output['msg'] = '{{files_delete_success_fail}}';
			}
		}
	}
	if(!$output['status']) $output['msg'] = '{{files_delete_fail}}';
} elseif($type=='folder_load' || $type=='folder_search') { // -------------------------------
	$start = isset($_REQUEST['start']) ? ((int)$_REQUEST['start']) : 0;
	$keyword = isset($_REQUEST['keyword']) ? urldecode($_REQUEST['keyword']) : null;
	$folderData = $folder->loadFolder($start,$keyword,$userID);
	if($folderData) {
		$output['status'] = 1;
		$output['msg'] = $folderData;
	} else $output['msg'] = '{{no_data}}';
} elseif($type=='manager_search') {
	// in folder or in user
	$start = isset($_REQUEST['start']) ? ((int)$_REQUEST['start']) : 0;
	$keyword = urldecode($_REQUEST['keyword']);
	if(IN_MANAGER)
		$fileData = $file->loadFile($folderData['folder_id'],$start,$keyword,'asc',$userID);
	else
		$fileData = $file->loadFile($folderData['folder_id'],$start,$keyword,'asc');
	if($fileData) {
		$output['status'] = 1;
		$output['msg'] = $fileData;
	} else $output['msg'] = '{{not_found}}';
} elseif($type=='manager_sort') {
	$start = isset($_REQUEST['start']) ? ((int)$_REQUEST['start']) : 0;
	$sort = strtolower($_REQUEST['name']) == 'asc' ? 'asc' : 'desc'; // asc
	$keyword = urldecode($_REQUEST['keyword']);
	$fileData = $file->loadFile($folderData['folder_id'],$start,$keyword,$sort,$folderData['folder_user']); // <-----------------------------------------
	if($fileData) {
		$output['status'] = 1;
		$output['msg'] = $fileData;
	} else $output['msg'] = '{{not_found}}';
} elseif(preg_match("/profile/i",$_SERVER['REQUEST_URI']) && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
	if(isset($userID)) {
		$newUserData = array(
			'user_id'				=> $userID,
			'user_oauth_provider'	=> $userData['user_oauth_provider'],
			'user_oauth_uid'		=> $userData['user_oauth_uid'],
			'user_nickname'    		=> urldecode($_REQUEST['user']),
			'user_player_logo'     	=> urldecode($_REQUEST['logo']),
			'user_gender'         	=> $_REQUEST['gender'] == 'male' ? 'male' : 'female',
		);
		$userData = $user->updateUser($newUserData);
		if(!empty($userData)) {
			$kz_crypt = new KZ_Crypt;
			$kz_crypt->_text = json_encode($userData);
			if($kz_crypt->_encrypt() != false) {
				$data = trim($kz_crypt->_result);
				$_SESSION['userData'] = $data;
				setcookie('userData', $data, time()+(3600*24),'/');
			}
			$output['status'] = 1;
			$output['msg'] = 'Cập nhật hồ sơ thành công.';
		} else $output['msg'] = 'Cập nhật hồ sơ thất bại.';
	} else $output['msg'] = 'Cập nhật hồ sơ thất bại.';
	//$output['redirect'] = $_SERVER["REDIRECT_URL"];
} elseif($type=='group_create') {
	$groupData = $group->checkGroup($_REQUEST['group_sub']);
	if(!$groupData) {
		$groupData['group_name'] = urldecode($_REQUEST['group_name']);
		$groupData['group_sub'] = $_REQUEST['group_sub']; // url

		$groupData = array(
			'group_name' 		=> urldecode($_REQUEST['group_name']),
			'group_url' 		=> $_REQUEST['group_sub'],
			'group_user' 		=> $userID,
			'group_status' 		=> 1,
		);
		$groupData = $group->insertGroup($groupData);
		if(isset($groupData['group_id'])) {
			$output['status'] = 1;
			$output['msg'] = "Tạo group thành công.";
		} else $output['msg'] = "Tạo group thất bại";
	} else $output['msg'] = "Url Group đã có người tạo";
} elseif($type=='report' && isset($_REQUEST['data'])) {
	$content = date("Y-m-d H:i:s")." : ".$_REQUEST['error']." : \n".$_REQUEST['data']."\n\n";
	file_put_contents('log_upload_error.log',$content,FILE_APPEND);
	$output['status'] = 1;
	$output['msg'] = "error_log";
}

fail:

ob_end_clean();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: application/json");
$content = json_encode($output,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
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
exit($content);
?>
