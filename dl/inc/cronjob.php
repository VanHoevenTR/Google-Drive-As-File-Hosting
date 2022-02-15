<title>Cronjob</title><?php ob_flush();flush();

// 15 * * * * /usr/bin/php /var/www/onecloud.media/inc/cronjob.php
//include_once '_functions.php';
include_once('functions.php');
include_once('config.php');
include_once('db.php');
date_default_timezone_set("Asia/Bangkok");

$mysqli = new QueryDB();
$prevQuery = "SELECT * FROM files WHERE file_url <> '' AND file_status = 0 ORDER BY file_created ASC";
$prevQuery = "SELECT * FROM files WHERE file_status = 0 ORDER BY file_created ASC";
$prevQuery = "SELECT * FROM files WHERE file_status <> 1 ORDER BY file_created ASC";
$result = $mysqli->db->query($prevQuery);
$timecheck = 15*60;
$time = time();

if($result->num_rows > 0) {
	while ($fileData = mysqli_fetch_assoc($result)) {
		if(preg_match('/(video)/i',$fileData['file_mime'])) {
			$fileNewData=array();$fileNewData['file_status'] = 0;
			echo '<a href="'.$fileData['file_url'].'" target="_blank">'.$fileData['file_name'].'</a> ('.formatBytes($fileData['file_size']).' - '.$fileData['file_created'].")<br />\n";
			//if(!$fileData['file_update'] || (($time - strtotime($fileData['file_update'])) > $timecheck)) {
			if(true) {
				if($fileDriveID = getDriveId($fileData['file_url'])) {
					//if($toke_access = getAccessToken(null,'upload')) { // use token upload to check chính xác lỗi
					if($toke_access = getAccessToken($site_config['refresh_token'])) { // use token upload to check chính xác lỗi
						$curl = new cURL();
						$curl->header(array('Authorization: Bearer '.$toke_access,'Content-Type: application/json'));
						$html = $curl->get('https://www.googleapis.com/drive/v2/files/'.$fileDriveID);
						$data = json_decode($html,true);
						if(isset($data['error'])) { // owner can access
							$fileNewData['file_status'] = $data['error']['code'];
							echo $data['error']['message']."<br/>\n";
						} else {
							if(isset($data['thumbnailLink'])) $fileNewData['file_thumb'] = $data['thumbnailLink'];
							if(isset($data['videoMediaMetadata']) && isset($data['videoMediaMetadata']['height'])) {
								$fileNewData['file_status'] = 1;
								//$fileNewData['file_width']  = $data['videoMediaMetadata']['width'];
								//$fileNewData['file_height']  = $data['videoMediaMetadata']['height'];
								//if(isset($data['videoMediaMetadata']['durationMillis'])) $fileNewData['file_duration']  = $data['videoMediaMetadata']['durationMillis'];
								echo "File được xử lý qua API.<br/>\n";
							}
						}
					} else {
						$curl = new cURL();
						$html = $curl->get('https://docs.google.com/get_video_info?authuser=&docid='.$fileDriveID);
						$curl->close();
						parse_str($html, $info);
						if(@$info['status'] == 'ok') {
							$fileNewData['file_status'] = 1;
							echo "File được xử lý qua get_video_info.<br/>\n";
						}
					}
					if(isset($fileNewData['file_status']) && $fileNewData['file_status'] == 1) {
						echo "File đã xử lý xong.<br/>\n";
						//$fileNewData['file_thumb'] = 'https://drive.google.com/thumbnail?authuser=0&sz=w480&id='.$fileDriveID;
						//$mysqli->db->query("UPDATE files SET file_status=1, file_update='".date("Y-m-d H:i:s")."' ".$insertThumb." WHERE file_id='".$fileData['file_id']."'");
					} else {
						echo "File chưa xử lý xong.<br/>\n";
						//$mysqli->db->query("UPDATE files SET file_update='".date("Y-m-d H:i:s")."' WHERE file_id='".$fileData['file_id']."'");
					}
					
					$fileNewData['file_update'] = date("Y-m-d H:i:s",$time);
					$query_param = array();
					foreach($fileNewData as $col => $value) {
						$query_param[] = $col." = '".$mysqli->db->real_escape_string($value)."'";
					}
					$query_param = implode(', ', $query_param);
					$query = "UPDATE files SET ".$query_param." WHERE file_id = '".$fileData['file_id']."'";
					echo $query."<br/>\n";
					$update = $mysqli->db->query($query);
					if(isset($fileNewData['file_status']) && $fileNewData['file_status']) {
						$arrDone['done'][] = $fileData['file_name'];
					} else $arrDone['wait'][] = $fileData['file_name'];
				} else echo "Không phải url Drive.<br/>\n";
			} else {
				echo "File chưa xử lý xong. Hãy đợi thêm ". ($timecheck/60) ." phút nữa!<br/>\n";
				echo "Last checked: ".$fileData['file_update']."<br/>\n";
				$nextcheck = date("Y-m-d H:i:s",(($time+$timecheck)-($time-strtotime($fileData['file_update']))));
				$nextsecs = abs($time-strtotime($nextcheck));
				$arrSecs[] = $nextsecs;
				echo "Next checked: ". $nextcheck  ."<br/>\n";
				//echo "File time: ".strtotime($fileData['file_update'])."\n";
				$arrDone['wait'][] = $fileData['file_name'];
			}
			echo "<br/>\n";
		}
		ob_flush();flush();
	}
} else echo "Không còn file nào để xử lý.<br/>\n";

if(isset($arrSecs) && !empty($arrSecs)) {
	$secRefresh = min($arrSecs);
} else $secRefresh = $timecheck;

echo '<meta http-equiv="refresh" content="'. $secRefresh .'">'."\n";
echo 'Next refresh: <span id="time">'.$secRefresh."</span>s<br/>\n";
echo '<script>function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.textContent = minutes + ":" + seconds;
        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}
window.onload = function () {
    var fiveMinutes = '.$secRefresh.',
        display = document.querySelector("#time");
    startTimer(fiveMinutes, display);
};</script>';

echo "Now: ".date("Y-m-d H:i:s",$time)."<br/>\n";
$content = date("Y-m-d H:i:s",$time);
if(isset($arrDone) && !empty($arrDone)) {
	if(isset($arrDone['done'])) $content .= ' Done: '.implode(', ',$arrDone['done']).";";
	if(isset($arrDone['wait'])) $content .= ' Wait: '.implode(', ',$arrDone['wait']).";";
}
$content .= ' '.get_current_user();
file_write('cronjob.txt',$content."\n");