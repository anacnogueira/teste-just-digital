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

$path = isset($_GET['path']) ? $_GET['path'] : null;

$data = $post->readByPath($path);


if (!$data) {
	echo json_encode([
		'error' => 'No post found',
		'return' => 404
	]);
} else {
	echo json_encode([
		'data' => $data,
		'return' => 200
	]);
}