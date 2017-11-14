<?php 
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-MAx-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../core.php');

$database = new Database;
$db = $database->getConnection();

$post = new Post($db);

$request = $_POST;

$create = $post->store($request);

if (isset($create->errors)) {
 	echo json_encode([
 		'message' => 'Unable to create post',
 		'errors' => $create->errors
 	]);
 } else {
 	echo json_encode([
 		'message' => 'Post was created',		 

 	]);
}
