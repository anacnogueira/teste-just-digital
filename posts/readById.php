<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once('../core.php');

$database = new Database();
$db = $database->getConnection();

$post = new Post($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;

$data = $post->readById($id);


if (!$data) {
	echo json_encode([
		'error' => 'No post found'
	]);
} else {
	echo json_encode([
		'data' => $data
	]);
}