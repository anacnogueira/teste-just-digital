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

		if (empty($id) || !is_int(intval($id))) {
			return false;
		}

		$query = "SELECT id, title, body, path from ".$this->table.
		" WHERE id=? LIMIT 0,1";

		$stmt = $this->conn->prepare($query);


		$stmt->bindParam(1, $id);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function readByPath($path)
	{
		if (empty($path) || preg_match('%^/(?!.*\/$)(?!.*[\/]{2,})(?!.*\?.*\?)(?!.*\.\/).*%im', $path) == 0) {
		 	return false;
		}

		$query = "SELECT id, title, body, path from ".$this->table.
		" WHERE path=? LIMIT 0,1";

		$stmt = $this->conn->prepare($query);


		$stmt->bindParam(1, $path);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
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


		//Prepare
		$stmt = $this->conn->prepare($query);
				
		//Sanitize
		$this->title = htmlspecialchars(strip_tags($data['title']));
		$this->body  = $data['body'];
		$this->path  = htmlspecialchars(strip_tags($data['path']));


		//Bind values
		$stmt->bindParam(":title", $this->title);
		$stmt->bindParam(":body", $this->body);
		$stmt->bindParam(":path", $this->path);

		//execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;

	}

	public function update($id, $data)
	{
		//Verify first if row exists;
		$row = $this->readById($id);

		if (!$row) {
			return false;
		} 


		$errors = new stdClass();

		$validation = $this->validate($data);

		if($validation) {
			$errors->errors = $validation;

			return $errors;
		}
		
		$query = "UPDATE ".$this->table.
		" SET 
			title=:title,
			body=:body,
			path=:path
		 WHERE id = :id";

		$stmt = $this->conn->prepare($query);

		//Sanitize
		$this->title = htmlspecialchars(strip_tags($data['title']));
		$this->body  = $data['body'];
		$this->path  = htmlspecialchars(strip_tags($data['path']));


		//Bind values
		$stmt->bindParam(":title", $this->title);
		$stmt->bindParam(":body", $this->body);
		$stmt->bindParam(":path", $this->path);
		$stmt->bindParam(":id", $id);

		//execute query
		if ($stmt->execute()) {
			return true;
		}

		return false;
	} 

	public function delete($id)
	{
		//Verify first if row exists;
		$row = $this->readById($id);

		if (!$row) {
			return false;
		} 

		$query = "DELETE FROM ".$this->table." WHERE id = ?";

		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(1, $id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
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
}