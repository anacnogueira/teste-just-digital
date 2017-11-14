<?php 
/**
* 
*/
class Post 
{
	
	//Database Connection
	protected $conn;
	protected $table = 'posts';

	//Table fields
	protected $id;
	protected $title;
	protected $body;
	protected $path;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function read()
	{
		//Select all query
		$query = "SELECT id, title, body, path from ".$this->table;
		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	public function readById($id)
	{

	}

	public function readByPath($path)
	{

	}

	public function store($data)
	{
		$errors = new stdClass();

		$validation = $this->validate($data);

		if($validation) {
			$errors->errors = $validation;

			return $errors;
		}

		$query = "INSERT INTO ".$this->table." SET
			title=:title,body=:body,path=:path";

		//Sanitize
		$this->title = htmlspecialchars(strip_tags($data['title']));
		$this->body  = $data['body'];
		$this->path  = htmlspecialchars(strip_tags($data['path']));

		
		//Bind values
		//execute query
	}

	public function update()
	{

	} 

	public function delete()
	{

	}

	private function validate($request)
	{
		$errors = [];

		//title
		if (!isset($request['title']) || empty($request['title'])) {
			$errors[] = 'Title is required';
		}
		

		//body
		if (!isset($request['body']) || empty($request['body'])) {
			$errors[] = 'Body is required';
		}

		//body
		if (!isset($request['path']) || empty($request['path'])) {
			$errors[] = 'Path is required';
		}

		return $errors;

	}

	private function errors()
	{

	}
}