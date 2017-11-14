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
$request = $_POST;

$update = $post->update($id, $request);

if (isset($update->errors)) {
 	echo json_encode([
 		'message' => 'There are errors to be corrected',
 		'errors' => $update->errors
 	]);
 } elseif($update) {
 	echo json_encode([
 		'message' => 'Post was updated',
 	]);
} else {
	echo json_encode([
 		'message' => 'Unable to update post', 		
 	]);
}
