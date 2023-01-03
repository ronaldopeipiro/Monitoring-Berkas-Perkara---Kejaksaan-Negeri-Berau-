<?php

class createCon
{
	public $host = 'localhost';
	public $user = 'kejaribe_ronal';
	public $pass = 'password@sementara';
	public $db = 'kejaribe_monitoring_perkara';

	public $myconn;

	public function connect()
	{
		$con = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->user, $this->pass);
		if (!$con) {
			die('Could not connect to database!');
		} else {
			$this->myconn = $con;
		}

		return $this->myconn;
	}

	public function close()
	{
		$this->myconn = null;
	}
}
