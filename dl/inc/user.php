<?php
//include_once(dirname(__FILE__).'/config.php');
class User {
	private $dbHost     = "localhost";
    private $dbUsername = "mgame_file";
    private $dbPassword = "kenviet1988@@";
    private $dbName     = "mgame_file";     
    private $userTbl    = 'users'; 
	
	function __construct() {
		global $site_config;
        if(!isset($this->db)) {
            // Connect to the database
            //$conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
			$conn = new mysqli($site_config['dbHost'], $site_config['dbUsername'], $site_config['dbPassword'], $site_config['dbName']);
            if($conn->connect_error){
                //die("Failed to connect with MySQL: " . $conn->connect_error);
				//return false;
				$this->db = null;
            }else{
                $this->db = $conn;
				$this->db->set_charset("utf8");
				$this->userTbl = $site_config['userTbl'];
            }
        }
    }
	
	function checkUser($userData = array()) {
        if(!empty($userData) && $this->db) {
			//var_dump($userData);
            $userData['oauth_provider'] = isset($userData['user_oauth_provider']) ? $userData['user_oauth_provider'] : 'google';
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE user_oauth_provider = '".$userData['user_oauth_provider']."' AND user_oauth_uid = '".$userData['user_oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
				//Get user data from the database
				$result = $this->db->query($prevQuery);
				$userData = $result->fetch_assoc();
				
				if(isset($userData['refresh_token']) && $userData['refresh_token'] != '') {
					$query = "UPDATE ".$this->userTbl." SET refresh_token='".$userData['refresh_token']."' WHERE user_oauth_provider = '".$userData['user_oauth_provider']."' AND user_oauth_uid = '".$userData['user_oauth_uid']."'";
					$this->db->query($query);
				}
				return $userData;
			}
        }
		return false;
    }
	function updateUser($userData = array()) {
        if(!empty($userData)){
            //Check whether user data already exists in database
			$userData['user_oauth_provider'] = isset($userData['user_oauth_provider']) ? $userData['user_oauth_provider'] : 'google';
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE user_oauth_provider = '".$userData['user_oauth_provider']."' AND user_oauth_uid = '".$userData['user_oauth_uid']."'";
			//return $prevQuery;
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
                //Update user data if already exists
				$query_param = array();
				foreach($userData as $col => $value) {
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}
				$query_param = implode(', ', $query_param);
				$query = "UPDATE ".$this->userTbl." SET ".$query_param." WHERE user_oauth_provider = '".$userData['user_oauth_provider']."' AND user_oauth_uid = '".$userData['user_oauth_uid']."'";
				//return $query;
                //$query = "UPDATE ".$this->userTbl." SET user_first_name = '".$userData['first_name']."', user_last_name = '".$userData['last_name']."', user_email = '".$userData['email']."', user_gender = '".$userData['gender']."', user_locale = '".$userData['locale']."', user_picture = '".$userData['picture']."', user_link = '".$userData['link']."', user_modified = '".date("Y-m-d H:i:s")."' WHERE user_oauth_provider = '".$userData['oauth_provider']."' AND user_oauth_uid = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);
				$result = $this->db->query($prevQuery);
				$userData = $result->fetch_assoc();
				return $userData;
            }
		}
		return false;
	}
	function insertUser($userData = array()) {
        if(!empty($userData)) {
            //Check whether user data already exists in database
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE user_oauth_provider = '".$userData['user_oauth_provider']."' AND user_oauth_uid = '".$userData['user_oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);
            if(!$prevResult->num_rows) {
                //Insert user data
				$query_param = array();
				foreach($userData as $col => $value) {
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}

				$query_param = implode(', ', $query_param).", user_nickname = '".trim($this->db->real_escape_string($userData['user_first_name']." ".$userData['user_last_name']))."', user_created = '".date("Y-m-d H:i:s")."', user_modified = '".date("Y-m-d H:i:s")."'";
				$query = "INSERT INTO ".$this->userTbl." SET ".$query_param."";

                $insert = $this->db->query($query);
				$result = $this->db->query($prevQuery);
				$userData = $result->fetch_assoc();
				return $userData;
            } else {
				$userData = $prevResult->fetch_assoc();
				return $userData;
			}
        }
		return false;
    }
}

class newUser {
	private $dbHost     = "localhost";
    private $dbUsername = "mgame_file";
    private $dbPassword = "kenviet1988@@";
    private $dbName     = "mgame_file";
    private $userTbl    = 'users';
	
	function __construct() {
		global $site_config;
        if(!isset($this->db)){
            // Connect to the database
            //$conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
			$conn = new mysqli($site_config['dbHost'], $site_config['dbUsername'], $site_config['dbPassword'], $site_config['dbName']);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
				$this->db->set_charset("utf8");
				$this->userTbl = $site_config['userTbl'];
            }
        }
    }
	
	function checkUser($userData = array(),$update=false) {
        if(!empty($userData)) {
            //Check whether user data already exists in database
            //$prevQuery = "SELECT * FROM ".$this->userTbl." WHERE user_oauth_provider = '".$userData['oauth_provider']."' AND user_oauth_uid = '".$userData['oauth_uid']."'";
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE user_oauth_provider = '".$userData['user_oauth_provider']."' AND user_oauth_uid = '".$userData['user_oauth_uid']."'";
            $result = $prevResult = $this->db->query($prevQuery);
            if($prevResult->num_rows > 0) {
				if($update) {
					//Update user data if already exists
					$query_param = array();
					foreach($userData as $col => $value) {
						if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
					}
					$query_param = implode(', ', $query_param).", user_modified = '".date("Y-m-d H:i:s")."'";
					$query = "UPDATE ".$this->userTbl." SET ".$query_param." WHERE user_oauth_provider = '".$userData['user_oauth_provider']."' AND user_oauth_uid = '".$userData['user_oauth_uid']."'";
					//$query = "UPDATE ".$this->userTbl." user_SET first_name = '".$userData['first_name']."', user_last_name = '".$userData['last_name']."', user_email = '".$userData['email']."', user_gender = '".$userData['gender']."', user_locale = '".$userData['locale']."', user_picture = '".$userData['picture']."', user_link = '".$userData['link']."', user_modified = '".date("Y-m-d H:i:s")."' WHERE user_oauth_provider = '".$userData['oauth_provider']."' AND user_oauth_uid = '".$userData['oauth_uid']."'";
					$result = $this->db->query($query);
				}
            } else {
                //Insert user data
				$query_param = array();
				foreach($userData as $col => $value) {
					if(!empty($value)) $query_param[] = $col." = '".$this->db->real_escape_string($value)."'";
				}
				$query_param = implode(', ', $query_param).", user_nickname = '".trim($this->db->real_escape_string($userData['first_name']." ".$userData['last_name']))."', user_created = '".date("Y-m-d H:i:s")."', user_modified = '".date("Y-m-d H:i:s")."'";
				$query = "INSERT INTO ".$this->userTbl." SET ".$query_param."";
                //$query = "INSERT INTO ".$this->userTbl." SET user_oauth_provider = '".$userData['oauth_provider']."', user_oauth_uid = '".$userData['oauth_uid']."', user_first_name = '".$userData['first_name']."', user_last_name = '".$userData['last_name']."', user_email = '".$userData['email']."', user_gender = '".$userData['gender']."', user_locale = '".$userData['locale']."', user_picture = '".$userData['picture']."', user_link = '".$userData['link']."', user_created = '".date("Y-m-d H:i:s")."', user_modified = '".date("Y-m-d H:i:s")."'";
                $insert = $this->db->query($query);
				$result = $this->db->query($prevQuery);
            }
            
            //Get user data from the database
            //$result = $this->db->query($prevQuery);
            $userData = $result->fetch_assoc();
			return $userData;
        }
        return false;
        //Return user data
        
    }
}
?>