<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);

class OracleAppDw
{

	private $sql;
	private $query;
	private $limit;
	private $conn;
	private $result = false;

	function __construct()
	{
		$dns = "odbc_datawh";
		$this->conn = $conn = odbc_connect($dns, "RPT", "RPT") or die(odbc_error());
	}

	function getConn()
	{
		return $this->conn;
	}
	function select($sql)
	{
		$this->sql = $sql;
		return $this;
	}

	function query($sql)
	{
		try {
			unset($this->result);
			$this->query = $query = odbc_exec($this->conn, $sql) or die($sql);
			return $this;
		} catch (Exception $e) {
			return $exception;
		}
	}

	function result()
	{
		try {
			$this->query = $query = odbc_exec($this->conn, $this->sql) or die($sql);
			return $this;
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}

	}
	function limit($limit)
	{
		$this->limit = $limit;
		return $this;
	}


	function fetchAll()
	{
		$counter = 0;
		while ($result = odbc_fetch_array($this->query)) {
			$counter++;
			$this->result[] = $result;
			if (isset($this->limit)) {
				if ($this->limit == $counter) {
					break;
				}
			}
		}
		if (!empty($this->result)) {
			return $this->result;
		}

	}
	function fetchRow()
	{
		$result = odbc_fetch_array($this->query);
		$this->result = $result;
		return $this->result;
	}
	function getCols()
	{
		$result = odbc_fetch_array($this->query);
		foreach ($result as $key => $val) {
			$keys[] = $key;
		}
		return $keys;
	}

	function tableize($keys)
	{
		$zxc = "&#36zxc";
		foreach ($keys as $key) {
			$phpStart = "&lt;&#63;php ";
			$phpEnd = " &#63;&gt;";
			$tbody = "&lt;td&gt;$phpStart echo $zxc&#91;&#39;$key&#39;&#93;&#59; $phpEnd&lt;&#47;td&gt;";
			$result .= $tbody;
		}
		return $result;
	}





}

?>