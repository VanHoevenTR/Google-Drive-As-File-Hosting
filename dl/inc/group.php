<?php
//include_once(dirname(__FILE__).'/config.php');
class Group {
	private $dbHost     = "localhost";
    private $dbUsername = "mgame_file";
    private $dbPassword = "";
    private $dbName     = "mgame_file";
    private $groupTbl    = 'groups';
	
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
				$this->groupTbl = $site_config['groupTbl'];
            }
        //}
    }
	
	function checkGroup($groupID,$userID=false) {
		global $userData;
        if(isset($groupID)) {
            $prevQuery = "SELECT * FROM ".$this->groupTbl." WHERE ". (is_numeric($groupID) ? 'group_id' : 'group_url') ." = '".$groupID."'". ($userID ? (" AND group_user = '".$userID."'") : '');
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
				//Get group data from the database
				$result = $this->db->query($prevQuery);
				$groupData = $result->fetch_assoc();
				return $groupData;
			}
        }
		return false;
    }
	
	function loadGroup($start=0,$keyword=null,$userID=false) {
		global $userData,$site_config;
		if($keyword)
			$prevQuery = "SELECT * FROM ".$this->groupTbl." ".($keyword ? "WHERE group_user = '".$userData['user_id']."' AND group_name LIKE '%".$this->db->real_escape_string($keyword)."%'" : '')." ORDER BY group_name ASC LIMIT $start, 5";
		else
			$prevQuery = "SELECT * FROM groups WHERE group_user = '".$userData['user_id']."' ORDER BY CASE WHEN `group_parent` = 0 THEN `group_id` ELSE `group_parent` END, `group_parent`, `group_id` LIMIT $start,5";
		//if($userID) $prevQuery .= " AND group_user = '".$userID."'";
        $result = $this->db->query($prevQuery);
		if($result->num_rows > 0) {
			$i = $id_parent = $start;
			$html = "";
			while ($row = mysqli_fetch_assoc($result)) {
				if($row['group_password'] != '') {
					$type_private_title = 'Đã khóa thư mục';
					$type_private_class = 'glyphicon-lock';
					$type_private_style = '';
				} else {
					$type_private_title = 'Công khai';
					$type_private_class = 'glyphicon-ok-circle';
					$type_private_style = ' style="color:green"';
				}

				if($row['group_parent'] != 0 && $row['group_parent'] == $id_parent) {
					//$class_parent = ' treegrid-parent-'.$row['group_parent'];
					$class_parent = ' treegrid-parent-'.$id_parent;
				} else {
					$class_parent = '';
					if($row['group_parent'] == $id_parent) $id_parent++;
				}
				$html .= '<tr id="group-'.$row['group_id'].'" class="treegrid-'.$i.$class_parent.'">
					<td class="col-md-5 middle group-title-'.$row['group_id'].'"><a href="'.$site_config['homepage'].'/dashboard/manager/'.$row['group_slug'].'"> '.$row['group_name'].'</a></td>
					<td class="col-md-1 text-center middle">--</td>
					<td class="col-md-1 text-center middle">'.$row['group_created'].'</td>
					<td class="col-md-13 text-center middle group-status-'.$row['group_id'].'"><span data-toggle="tooltip" data-placement="top" title="'.$type_private_title.'" class="glyphicon '.$type_private_class.'"'.$type_private_style.'></span></td>
					<td class="col-md-1 text-center middle"><button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal" onclick="group_info('.$row['group_id'].')"><span class="glyphicon glyphicon-info-sign"></span></button><button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Xóa Group" onclick="group_delete('.$row['group_id'].')"><span class="glyphicon glyphicon-trash"></span></button></td>
					<td class="col-md-13 middle"><input type="radio" name="group" value="'.$row['group_id'].'"></td>
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
					l.length > 0 ? ($(".group_move").show(), $(".group_create").hide()) : ($(".group_move").hide(), $(".group_create").show())
				});
				$(document).ready(function() {
					$(\'[data-toggle="tooltip"]\').tooltip()
				});
			</script>';
			return $html;
		}
		return false;
    }
	
	function deleteGroup($groupID,$userID=false) {
        if(isset($groupID)) {
            $query = "DELETE FROM ".$this->groupTbl." WHERE group_id = '".$groupID."'";
			if($userID) $query .= " AND group_user = '".$userID."'";
            $result = $this->db->query($query);
            if($result) return true;
        }
		return false;
    }
	
	function updateGroup($groupData = array(),$userID=false) {
        if(!empty($groupData) && isset($groupData['group_id'])) {
            //Check whether group data already exists in database
            $prevQuery = "SELECT * FROM ".$this->groupTbl." WHERE group_id = '".$groupData['group_id']."'";
			if($userID) $prevQuery .= " AND group_user = '".$userID."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
                //Update group data if already exists
				$query_param = array();
				foreach($groupData as $col => $value) {
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}
				$query_param = implode(', ', $query_param);
				$query = "UPDATE ".$this->groupTbl." SET ".$query_param." WHERE group_id = '".$groupData['group_id']."'";
                $update = $this->db->query($query);
				$result = $this->db->query($prevQuery);
				$groupData = $result->fetch_assoc();
				return $groupData;
            }
		}
		return false;
	}
	
	function insertGroup($groupData = array(),$userID=false) {
		$debug = null;
        if(!empty($groupData)) {
            //Check whether group data already exists in database
            $prevQuery = "SELECT * FROM ".$this->groupTbl." WHERE group_url = '".$groupData['group_url']."'";

			//return $prevQuery;
            $prevResult = $this->db->query($prevQuery);
            if(!$prevResult->num_rows) {
                //Insert group data
				$query_param = array();
				foreach($groupData as $col => $value) {
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}
				$query_param = implode(', ', $query_param);
				$query = "INSERT INTO ".$this->groupTbl." SET ".$query_param."";
				//return $query;
				//$debug[] = $query;
                $insert = $this->db->query($query);
                $last_id = $this->db->insert_id;
				$prevQuery = "SELECT * FROM ".$this->groupTbl." WHERE group_id = '".$last_id."'";
				$result = $this->db->query($prevQuery);
				$groupData = $result->fetch_assoc();
				if(!empty($groupData)) return $groupData;
            }
        }
		return false;
		//return $debug;
    }
}
?>