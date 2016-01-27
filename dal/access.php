<?php
class MysqlAccess
{
	private $config = null;	
	private $conn = null;

	function __construct()
	{
		$this->config = require_once("config/db.php");
		$this->conn = new mysqli($this->config['servername'], $this->config['username'], $this->config['password'], $this->config['database']);

		if ($this->conn->connect_error) 
		{
		    	 throw new Exception('Error connecting to database.');
		}
	}

	function insert($sql)
	{
		if(stripos($sql, 'insert into') === FALSE)
		{
			$this->conn->query("insert into log (description, log_time) values('Error (logic): $sql', now());");
	    		throw new Exception('Invalid query: '.$sql);
		}

		if ($this->conn->query($sql) === FALSE) 
		{
			$this->conn->query("insert into log (description, log_time) values('Error (runtime): $sql', now());");
    			throw new Exception('Error inserting record: '.$sql);
		}
	
		return $this->conn->insert_id;
	}

	function __destruct() 
	{
		$this->conn->close();
	}
}
?>
