<?php 

use Dotenv\Dotenv;


class Database {
	protected $dotenv;
	protected $conn;

	public function __construct()
	{
		$this->dotenv = new Dotenv(__DIR__."/../..");
		$this->dotenv->load(); 
	}

	public function getConnection()
	{
		$this->dotenv->required([
			'DB_CONNECTION', 
			'DB_HOST', 
			'DB_DATABASE', 
			'DB_USERNAME',
			'DB_PASSWORD'
		]);

		$this->conn = null;

		try {
			$this->conn = new PDO(getenv('DB_CONNECTION').":host=".getenv('DB_HOST').";dbname=".getenv('DB_DATABASE'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'));
            $this->conn->exec("set names utf8");
		} catch (Exception $e) {
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->conn;
	}


	
}