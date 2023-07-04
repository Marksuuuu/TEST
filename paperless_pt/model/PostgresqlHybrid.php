<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);

class PostgresqlHybrid
{

   private $conn;
   private $query;
   private $limit;
   private $sql;
   private $result = false;
 



   function __construct()
   {
      $this->conn  = $conn = pg_connect("host = 192.168.1.6 port = 5432 dbname = PAPERLESS_PT user = postgres password=postgres") or die();
   }


   function query($sql)
   {

      try {
         $this->query = pg_query($this->conn, $sql) or die('Error message: ' . pg_last_error());
         return $this;
      } catch (Exception $e) {
         return $e;
      }
   }


   
	function limit($limit){
		$this->limit = $limit;
		return $this;
	}
	
   function fetchAll($sql)
   {
      $counter=0;
      $this->result = false;
      $this->query = pg_query($this->conn, $sql) or die('Error message: ' . pg_last_error());
      while ($result = pg_fetch_assoc($this->query)) {
         $counter++;
         $this->result[] = $result;
         if(isset($this->limit)){
				if($this->limit == $counter){
					break;		
				}
			}
      }
      if (!empty($this->result)) {
         return $this->result;
      }
   }
   function fetchRow($sql)
   {

      $this->result = false;
      $this->query = pg_query($this->conn, $sql) or die('Error message: ' . pg_last_error());
      while ($result = pg_fetch_array($this->query)) {
         $this->result = $result;
      }
      if (!empty($this->result)) {
         return $this->result;
      }
   }
}