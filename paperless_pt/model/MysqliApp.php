<?php 
set_time_limit(0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);

class MysqliApp{

private $sql;
private $query;
private $limit;
private $conn;
private $result = false;

	function __construct(){
		// $this->conn = $conn = mysql_connect("192.168.1.38","root","misteklock");
		$this->conn = $conn = mysqli_connect("localhost","root","","drf_new");
		// $this->db = mysql_select_db("drf_new");
	}
	
	function select($sql){
	 $this->sql = $sql;
	return $this;
	}
	function query($sql){
	try {
		$this->query = $query = mysqli_query($this->conn,$sql) or die (mysqli_error($this->conn));
		return $this;	
	} catch (Exception $e) {
 echo 'Caught exception: ',  $e->getMessage(), "\n";
} 
	}
	
	function result(){
	try {
		// $this->sql;
		 // echo $this->sql;
		mysql_free_result($this->result);
		$this->query = $query = mysqli_query($this->conn,$this->sql) or die (mysqli_error());
		return $this;	
} catch (Exception $e) {
 echo 'Caught exception: ',  $e->getMessage(), "\n";
} 

	}
	function limit($limit){
		$this->limit = $limit;
		return $this;
	}
	
	
	function fetchAll(){
		$counter=0;
		$this->result = false;
		while($result = mysqli_fetch_array($this->query)){
		$counter++;
			$this->result[] = $result;
			if(isset($this->limit)){
				if($this->limit == $counter){
					break;		
				}
			}
		}
		if(!empty($this->result)){
			return $this->result; 		
		}
		
	}
	function fetchRow(){
		$this->result = false;
		$result = mysqli_fetch_array($this->query);
		$this->result = $result;
		return $this->result;
	}
	
	
	

}

?>