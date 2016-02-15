<?php
class MysqlAccess
{
	private static $instance = null;

	private $config = null;	
	private $conn = null;

	function __construct()
	{
		$this->config = require_once("config/db.php");
		$this->conn = new mysqli($this->config['hostname'], $this->config['username'], $this->config['password'], $this->config['database']);

		if ($this->conn->connect_error) 
		{
		    	 throw new Exception('Error connecting to database.');
		}
	}

	public static function insert($sql)
	{
		if(stripos($sql, 'insert into') === FALSE)
		{
			log('Error (logic): '.$sql);
	    		throw new Exception('Invalid query: '.$sql);
		}

		if (MysqlAccess::getInstance()->conn->query($sql) === FALSE) 
		{
			log('Error (runtime): '.$sql);
    			throw new Exception('Error inserting record: '.$sql);
		}
	
		return MysqlAccess::getInstance()->conn->insert_id;
	}

	public static function log($description)
	{
		MysqlAccess::getInstance()->conn->query("insert into log (description, log_time) values('$description', now());");
	}

	function __destruct() 
	{
		$this->conn->close();
	}

	private static function getInstance()
	{
		if(static::$instance === null)
			static::$instance = new MysqlAccess();
	
		return static::$instance;
	}
}
?>
