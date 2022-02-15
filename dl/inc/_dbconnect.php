<?php
//if (!defined('IN_MEDIA')) exit("Hack");
//namespace name1 {
class mysql {
	var $link_id;
	var $log_file = 'logs.txt';
	var $log_error = 1;
	function connect($db_host, $db_username, $db_password, $db_name) {
		//$this->link_id = @mysql_connect($db_host, $db_username, $db_password);
		$this->link_id = new mysqli($db_host,$db_username,$db_password,$db_name);
		$this->link_id->set_charset("utf8");
	}
	function real_escape($data) {
		//return trim($this->link_id->real_escape_string($input));
		$data = trim($data);
		// apply stripslashes to pevent double escape if magic_quotes_gpc is enabled
		if(get_magic_quotes_gpc()) {
			$data = stripslashes($data);
		}
		// connection is required before using this function
		$data = mysqli_real_escape_string($this->link_id,$data);
		return $data;
	}

	function query($input){
		$q = $this->link_id->query($input);
		if (!$q) {
			$this->show_error("Lỗi MySQL Query : ".$this->link_id->connect_errno,$input);
			//throw new Exception('<b>Lỗi MySQL Query</b>');
		}
		return $q;
	}

	//override_function('fetch_array', '$query_id', 'return $query_id->fetch_array(MYSQLI_BOTH);');
	//override_function('fetch_array', '$query_id', 'return override_fetch_array($query_id);');
	function override_fetch_array($query_id){
		//$fa = @mysql_fetch_array($query_id,$type);
        $fa = $query_id->fetch_array(MYSQLI_BOTH);
		return $fa;
	}

	function fetch_assoc($query_id){
		//$fa = @mysql_fetch_assoc($query_id);
		$fa = $query_id->fetch_assoc();
		return $fa;
	}

	function num_rows($query_id) {
		//$nr = @mysql_num_rows($query_id);
		$nr = $query_id->num_rows;
		return $nr;
	}

	function result($query_id, $row=0, $field) {
		//$r = @mysql_result($query_id, $row, $field);
		//$r = mysql_result($r, 0, $field);
		$r = $query_id->fetch_assoc()[$field];  
		return $r;
	}

	function insert_id() {
		//return @mysql_insert_id($this->link_id);
		return $this->link_id->insert_id;
	}
	function show_error($input,$q){
		if ($this->log_error) {
			$file_name = $this->log_file;
			$fp = fopen($file_name,'a');
			flock($fp,2);
			fwrite($fp,"### ".date('H:i:s d-m-Y',time())." ###\n");
			fwrite($fp,$input."\n");
			fwrite($fp,"QUERY : ".$q."\n");
			flock($fp,1);
			fclose($fp);
		}
		return $input."\n";
	}
}

?>