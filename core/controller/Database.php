<?php
class Database
{
	public static $db;
	public static $con;
	function Database()
	{
		/* 
		 	$this->user="diegolo";$this->pass="&u57c49jJ";$this->host="localhost";$this->ddbb= "syscombl2"; 
			 */

		$this->user = "root";
		$this->pass = "0709";
		$this->host = "localhost";
		// $this->ddbb = "syscombl_conoflex";
		$this->ddbb = "syscombl_conoflex2";
	}

	function connect()
	{
		$con = new mysqli($this->host, $this->user, $this->pass, $this->ddbb, "3307");
		$con->set_charset("utf8");
		return $con;
	}

	public static function getCon()
	{
		if (self::$con == null && self::$db == null) {
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}
}
