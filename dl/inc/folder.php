<?php
//include_once(dirname(__FILE__).'/config.php');
class Folder {
	private $dbHost     = "localhost";
    private $dbUsername = "mgame_file";
    private $dbPassword = "kenviet1988@@";
    private $dbName     = "mgame_file";
    private $folderTbl    = 'folders';
	
	function __construct() {
		global $site_config;
        //if(!isset($this->db)) {
            // Connect to the database
            $conn = new mysqli($site_config['dbHost'], $site_config['dbUsername'], $site_config['dbPassword'], $site_config['dbName']);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
				$this->db->set_charset("utf8");
				$this->folderTbl = $site_config['folderTbl'];
            }
        //}
    }
	
	function checkFolder($folderID,$userID=false) {
		global $userData;
        if(isset($folderID)) {
            $prevQuery = "SELECT * FROM ".$this->folderTbl." WHERE ". (is_numeric($folderID) ? 'folder_id' : 'folder_slug') ." = '".$folderID."'". ($userID ? (" AND folder_user = '".$userID."'") : '');
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
				//Get folder data from the database
				$result = $this->db->query($prevQuery);
				$folderData = $result->fetch_assoc();
				return $folderData;
			}
        }
		return false;
    }
	
	function loadFolder($start=0,$keyword=null,$userID=false) {
		global $userData,$site_config;
		if($keyword)
			$prevQuery = "SELECT * FROM ".$this->folderTbl." ".($keyword ? "WHERE folder_user = '".$userData['user_id']."' AND folder_name LIKE '%".$this->db->real_escape_string($keyword)."%'" : '')." ORDER BY folder_name ASC LIMIT $start, 5";
		else
			$prevQuery = "SELECT * FROM folders WHERE folder_user = '".$userData['user_id']."' ORDER BY CASE WHEN `folder_parent` = 0 THEN `folder_id` ELSE `folder_parent` END, `folder_parent`, `folder_id` LIMIT $start,5";
		//if($userID) $prevQuery .= " AND folder_user = '".$userID."'";
        $result = $this->db->query($prevQuery);
		if($result->num_rows > 0) {
			$i = $id_parent = $start;
			$html = "";
			while ($row = mysqli_fetch_assoc($result)) {
				if($row['folder_password'] != '') {
					$type_private_title = 'Đã khóa thư mục';
					$type_private_class = 'glyphicon-lock';
					$type_private_style = '';
				} else {
					$type_private_title = 'Công khai';
					$type_private_class = 'glyphicon-ok-circle';
					$type_private_style = ' style="color:green"';
				}

				if($row['folder_parent'] != 0 && $row['folder_parent'] == $id_parent) {
					//$class_parent = ' treegrid-parent-'.$row['folder_parent'];
					$class_parent = ' treegrid-parent-'.$id_parent;
				} else {
					$class_parent = '';
					if($row['folder_parent'] == $id_parent) $id_parent++;
				}
				$html .= '<tr id="folder-'.$row['folder_id'].'" class="treegrid-'.$i.$class_parent.'">
					<td class="col-md-5 middle folder-title-'.$row['folder_id'].'"><a href="'.$site_config['homepage'].'/dashboard/manager/'.$row['folder_slug'].'"> '.$row['folder_name'].'</a></td>
					<td class="col-md-1 text-center middle">--</td>
					<td class="col-md-1 text-center middle">'.$row['folder_created'].'</td>
					<td class="col-md-13 text-center middle folder-status-'.$row['folder_id'].'"><span data-toggle="tooltip" data-placement="top" title="'.$type_private_title.'" class="glyphicon '.$type_private_class.'"'.$type_private_style.'></span></td>
					<td class="col-md-1 text-center middle"><button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal" onclick="folder_info('.$row['folder_id'].')"><span class="glyphicon glyphicon-info-sign"></span></button><button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Xóa Folder" onclick="folder_delete('.$row['folder_id'].')"><span class="glyphicon glyphicon-trash"></span></button></td>
					<td class="col-md-13 middle"><input type="radio" name="folder" value="'.$row['folder_id'].'"></td>
				</tr>';
				$i++;
			}
			$html .= '<script>
				$.extend($.fn.treegrid.defaults, {
					expanderExpandedClass: "glyphicon glyphicon-chevron-down",
					expanderCollapsedClass: "glyphicon glyphicon-chevron-right"
				}), $(document).ready(function() {
					$(".tree").treegrid({
						initialState: "collapsed",
						saveState: !0
					})
				});
				$("[name=listItems]").click(function() {
					for (var e = $("[name=listItems]"), l = "", o = 0, t = e.length; t > o; o++) e[o].checked && (l += e[o].value);
					l.length > 0 ? ($(".folder_move").show(), $(".folder_create").hide()) : ($(".folder_move").hide(), $(".folder_create").show())
				});
				$(document).ready(function() {
					$(\'[data-toggle="tooltip"]\').tooltip()
				});
			</script>';
			return $html;
		}
		return false;
    }
	
	function deleteFolder($folderID,$userID=false) {
        if(isset($folderID)) {
            $query = "DELETE FROM ".$this->folderTbl." WHERE folder_id = '".$folderID."'";
			if($userID) $query .= " AND folder_user = '".$userID."'";
            $result = $this->db->query($query);
            if($result) return true;
        }
		return false;
    }
	
	function updateFolder($folderData = array(),$userID=false) {
        if(!empty($folderData) && isset($folderData['folder_id'])) {
            //Check whether folder data already exists in database
            $prevQuery = "SELECT * FROM ".$this->folderTbl." WHERE folder_id = '".$folderData['folder_id']."'";
			if($userID) $prevQuery .= " AND folder_user = '".$userID."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
                //Update folder data if already exists
				$query_param = array();
				foreach($folderData as $col => $value) {
					//$query_param[] = $col." = '".$value."'";
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}
				$query_param = implode(', ', $query_param);
				$query = "UPDATE ".$this->folderTbl." SET ".$query_param." WHERE folder_id = '".$folderData['folder_id']."'";
                $update = $this->db->query($query);
				$result = $this->db->query($prevQuery);
				$folderData = $result->fetch_assoc();
				return $folderData;
            }
		}
		return false;
	}
	
	function insertFolder($folderData = array(),$userID=false) {
		$debug = null;
        if(!empty($folderData)) {
            //Check whether folder data already exists in database
            $prevQuery = "SELECT * FROM ".$this->folderTbl." WHERE folder_user = '".$folderData['folder_user']."' AND folder_name = '".$folderData['folder_name']."' AND folder_parent = '".$folderData['folder_parent']."'";
			if($userID) $prevQuery .= " AND folder_user = '".$userID."'";
			$debug[] = $prevQuery;
            $prevResult = $this->db->query($prevQuery);
            if(!$prevResult->num_rows) {
                //Insert folder data
				$query_param = array();
				foreach($folderData as $col => $value) {
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}
				$query_param = implode(', ', $query_param);
				$query = "INSERT INTO ".$this->folderTbl." SET ".$query_param."";
				//return $query;
				$debug[] = $query;
                $insert = $this->db->query($query);
                $last_id = $this->db->insert_id;
				$prevQuery = "SELECT * FROM ".$this->folderTbl." WHERE folder_id = '".$last_id."'";
				$result = $this->db->query($prevQuery);
				$folderData = $result->fetch_assoc();
				if(!empty($folderData)) return $folderData;
            }
        }
		return false;
		//return $debug;
    }
}
?>