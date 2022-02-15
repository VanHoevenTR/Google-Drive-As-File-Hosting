<?php
//include_once(dirname(__FILE__).'/config.php');
class File {
	private $dbHost     = "localhost";
    private $dbUsername = "mgame_file";
    private $dbPassword = "kenviet1988@@";
    private $dbName     = "mgame_file";
    private $fileTbl    = 'files';
	
	function __construct() {
		global $site_config;
        if(!isset($this->db)) {
            // Connect to the database
            $conn = @new mysqli($site_config['dbHost'], $site_config['dbUsername'], $site_config['dbPassword'], $site_config['dbName']);
            if($conn->connect_error) {
                //die("Failed to connect with MySQL: " . $conn->connect_error);
                return false;
            } else {
                $this->db = $conn;
				$this->db->set_charset("utf8");
				$this->fileTbl = $site_config['fileTbl'];
            }
        }
    }
	
	function checkFile($fileID,$userID=false) {
		if(!isset($this->db)) return false;
        if(isset($fileID)) {
            $prevQuery = "SELECT * FROM ".$this->fileTbl." WHERE ". (is_numeric($fileID) ? 'file_id' : 'file_slug') ." = '".$fileID."'";
			if($userID) $prevQuery .= " AND file_user = '".$userID."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
				//Get file data from the database
				$result = $this->db->query($prevQuery);
				$fileData = $result->fetch_assoc();
				return $fileData;
			}
        }
		return false;
    }
	
	function deleteFile($fileID,$userID=false) {
        if(isset($fileID)) {
			//return false;
            $query = "DELETE FROM `files` WHERE file_id = '".$fileID."'";
			if($userID) $query .= " AND file_user = '".$userID."'";
            $result = $this->db->query($query);
            if($result) return true;
        }
		return false;
    }
	
	function updateFile($fileData = array(),$userID=false) {
        if(!empty($fileData) && isset($fileData['file_id'])) {
            //Check whether file data already exists in database
            $prevQuery = "SELECT * FROM ".$this->fileTbl." WHERE file_id = '".$fileData['file_id']."'";
			if($userID) $prevQuery .= " AND file_user = '".$userID."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
                //Update file data if already exists
				$query_param = array();
				foreach($fileData as $col => $value) {
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}
				$query_param = implode(', ', $query_param);
				$query = "UPDATE ".$this->fileTbl." SET ".$query_param." WHERE file_id = '".$fileData['file_id']."'";
				if($userID) $query .= " AND file_user = '".$userID."'";
               // $query = "UPDATE ".$this->fileTbl." SET file_name = '".$fileData['file_name']."', file_url = '".$fileData['file_url']."', file_folder = '".$fileData['file_folder']."', file_password = '".$fileData['file_password']."', file_subscene = '".$fileData['file_subscene']."', file_modified = '".date("Y-m-d H:i:s")."' WHERE file_id = '".$fileData['file_id']."'";
                $update = $this->db->query($query);
				$result = $this->db->query($prevQuery);
				$fileData = $result->fetch_assoc();
				return $fileData;
            }
		}
		return false;
	}
	
	function insertFile($fileData = array(),$userID=false) {
        if(!empty($fileData) && (isset($fileData['file_url']) || isset($fileData['file_source']))) {
			$query_param = array();
			foreach($fileData as $col => $value) {
				if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
			}
			$query_param = implode(', ', $query_param);
			$query = "INSERT INTO ".$this->fileTbl." SET ".$query_param."";
            $insert = $this->db->query($query);
            $last_id = $this->db->insert_id;
			$prevQuery = "SELECT * FROM ".$this->fileTbl." WHERE file_id = '".$last_id."'";
			$result = $this->db->query($prevQuery);
			$fileData = $result->fetch_assoc();
			return $fileData;
        }
		return false;
    }
	function loadFile($folderID,$start=0,$keyword=null,$sort='asc',$userID=false) {
		global $site_config;
		if($keyword)
			$prevQuery = "SELECT * FROM ".$this->fileTbl." ".($keyword ? "WHERE file_folder = '".$folderID."' AND file_name LIKE '%".$this->db->real_escape_string($keyword)."%'" : '')."";
		else
			$prevQuery = "SELECT * FROM ".$this->fileTbl." WHERE file_folder = '".$folderID."'";
		if($userID) $prevQuery .= " AND file_user = '".$userID."'";
		$prevQuery .= " ORDER BY file_name ".$sort." LIMIT $start, 10";
        $result = $this->db->query($prevQuery);
		if($result->num_rows > 0) {
			$html = "";
			while ($row = mysqli_fetch_assoc($result)) {
				$disabled = '';
				if($row['file_password'] != '') {
					$type_private_title = 'Đã khóa file';
					$type_private_class = 'glyphicon-lock';
					$type_private_style = '';
				} else {
					$type_private_title = 'Công khai';
					$type_private_class = 'glyphicon-ok-circle';
					$type_private_style = ' style="color:green"';
				}
				if(preg_match("/video/i",$row['file_mime'])) {
					$type_file_title = 'Xem Online';
					$type_file_url = $site_config['homepage'].'/embed/'.$row['file_slug'];
					$type_file_class = 'glyphicon-facetime-video';
					$type_file_btn = 'btn-primary';
				} elseif(preg_match("/images?/i",$row['file_mime'])) {
					$type_file_title = 'Xem ảnh';
					$type_file_url = $site_config['homepage'].'/image/'.$row['file_slug'];
					$type_file_class = 'glyphicon-eye-open';
					$type_file_btn = 'btn-success';
				} else {
					$type_file_title = 'Không thể xem';
					$type_file_url = $site_config['homepage'].'/file/'.$row['file_slug'];
					$type_file_class = 'glyphicon glyphicon-eye-close';
					$type_file_btn = 'btn-default';
					$disabled = ' disabled';
				}
				
				if($row['file_url'] != '' && !$row['file_status'] && preg_match('/(video)/i',$row['file_mime'])) {
					$type_private_class = 'glyphicon-time';
					$type_private_title = 'Đang xử lý (Cập nhập lúc '.$row['file_update'].')';
					$type_private_style = ' style="color:orange"';
					if($row['file_source'] == '') {
						$type_file_btn = 'btn-default';
						$disabled = ' disabled';
					}
				}
				$html .= '<tr id="manager-'.$row['file_id'].'">
					<td class="col-md-13 middle"><input type="checkbox" name="listItems" value="'.$row['file_id'].'"> </td>
					<td class="col-md-13 middle text-center">
					'.(preg_match('/(video|image|photo)/i',$row['file_mime']) ? '<img class="thumb lazy" data-toggle="modal" data-target="#myPreview" src="'.$site_config['homepage'].'/thumb/'.$row['file_slug'].'?s=480" width="50" style="max-height: 50px; max-width: 50px;">' : '<span class="fa fa-file-o fa-2x"></span>').'
					</td>
						<td class="col-md-5 middle manager-title-'.$row['file_id'].'"><a href="#" data-toggle="modal" data-target="#myModal" onclick="manager_info('.$row['file_id'].')">'.$row['file_name'].'</a></td>
						
						<td class="col-md-1 middle text-center">'.formatBytes($row['file_size']).'</td>
						<td class="col-md-2 middle text-center">'.$row['file_created'].'</td>
						
						<td class="col-md-13 text-center middle manager-status-'.$row['file_id'].'"><span data-toggle="tooltip" data-placement="top" title="'.$type_private_title.'" class="glyphicon '.$type_private_class.'"'.$type_private_style.'></span></td>
						
						<td class="col-md-13 middle text-center middle"><a href="'.$site_config['homepage'].'/file/'.$row['file_slug'].'" data-toggle="tooltip" data-placement="top" title="Tải về" target="_blank" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-save"></span></a></td>
						<td class="col-md-13 text-center middle"><a href="'.$type_file_url.'" data-toggle="tooltip" data-placement="top" title="'.$type_file_title.'" target="_blank" class="btn '.$type_file_btn.' btn-xs"'.$disabled.'><span class="glyphicon glyphicon-facetime-video"></span></a></td>';
						
						if($userID && $userID==$row['file_user']) $html .= '<td class="col-md-13 text-center middle"><button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Xóa File" onclick="manager_delete('.$row['file_id'].')"><span class="glyphicon glyphicon-trash"></span></button></td>';
						
				$html .= '</tr>';
				//$html .= '<!-- '.$userID.' -->';
			}
			$html .= '<script>
				$("img.thumb").click(function() {
					var thumb = $(this)[0].src;
					$(".preview").html("<img src=\'" + thumb + "\' width=\'100%\'>")
				});
				$(document).ready(function() {
					$(\'[data-toggle="tooltip"]\').tooltip()
				});
			</script>';
			return $html;
		}
		return false;
    }
}
?>