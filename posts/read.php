<?php 
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

require_once('../core.php');

$database = new Database;
$db = $database->getConnection();

$post = new Post($db);

$stmt = $post->read();
$num = $stmt->rowCount();

if ( $num > 0) {
	$posts = [];
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$posts = [
			'id' => $id,
			'title' => $title,
			'body' => $body,
			'path' => strtolower($path),
		];	
	}

	echo json_encode([
		'data' => $posts,
		'return' => 200
	]);
} else {
	echo json_encode([
		'error' => 'No posts found',
		'return' => 404
	]);
}
