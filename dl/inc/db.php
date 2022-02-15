<?php
//include_once(dirname(__FILE__).'/config.php');
class QueryDB {
	public $dbHost     = "localhost";
    public $dbUsername = "mgame_file";
    public $dbPassword = "kenviet1988@@";
    public $dbName     = "mgame_file";             
    public $Tbl    		= '';
	
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
            }
        }
    }
	// getDataDB('cf_web_name','config','cf_id',1);
	function get_data($f1,$table,$f2,$f2_value) {
		if ($f2 != '' || $f2_value != '')
			$where = " WHERE $f2='".$f2_value."'";
		else $where = '';
		$q = "SELECT $f1 FROM ".$table.$where;
		//return $q;
		$q = $this->db->query($q);
		$rs = $q->fetch_array(MYSQLI_BOTH);
		//$rs = $mysql->override_fetch_array($q);
		//$rs = $q->override_fetch_array(MYSQLI_BOTH);
		$f1_value = $rs[$f1];
		return $f1_value;
	}
	
	function update_data($f1,$table,$f2,$f2_value) {
		if ($f2 != '' || $f2_value != '')
			$where = " WHERE $f2='".$f2_value."'";
		else $where = '';
		$q = "UPDATE $table SET ".$table.$where;
		$q = '';
		$q = $this->db->query($q);
		$rs = $q->fetch_array(MYSQLI_BOTH);
		//$rs = $mysql->override_fetch_array($q);
		//$rs = $q->override_fetch_array(MYSQLI_BOTH);
		$f1_value = $rs[$f1];
		return $f1_value;
	}
	
}
?>