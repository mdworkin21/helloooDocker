<?php

class DB {
  private $host = 'rgi_mysql';
	private $user = 'dev';
	private $pw = 'dev';
	private $db = 'froppit1_rgi1';

  function __construct($open = null, $options = null){
		if($open){
			$this->open();
		}

		if($options && $options['content'] === true){
			$this->content = true;
		}
	}

  public function query($sql, $log = null, $unbuffered = null){
		$db_start = microtime(true);
		
		$this->query = $this->conn->query($sql, ($unbuffered ? MYSQLI_USE_RESULT : null));

		$db_time = microtime(true) - $db_start;

		return $this->query;
	}

  public function fetch(){
		return $this->query ? $this->query->fetch_assoc() : null;
	}

  public function fetchAll($cast = null){
		$rows = [];
		if($this->query){
			while($row = $this->fetch()){
				if($cast){
					foreach ($row as $key => &$value) {
						if(array_key_exists($key, $cast)){
							settype($value, $cast[$key]);
						}
					}
				}
				$rows[] = $row;
			}
		}

		return $rows;
	}



  public function open(){
		$this->conn = new mysqli($this->host, $this->user, $this->pw, $this->db);

		if( $this->conn->connect_errno ) {
			die(json_encode(array("status"=>500, "error"=>$this->conn->connect_error)));
		}

		return $this->conn;
	}

  public function close(){
		$this->conn->close();
		return $this;
	}
}
