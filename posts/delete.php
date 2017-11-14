<?php 
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../core.php');

$database = new Database;
$db = $database->getConnection();

$post = new Post($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;

if($post->delete($id)) {
 	echo json_encode([
 		'message' => 'Post was deleted',
 	]);
} else {
	echo json_encode([
 		'message' => 'Unable to delete post', 		
 	]);
}
