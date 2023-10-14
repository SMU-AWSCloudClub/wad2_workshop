<?php

include 'cors.php';
include 'database.php';

$post_id = $_POST['id'];
$stmt = $db->prepare("DELETE FROM posts WHERE id=?");
$stmt->bind_param("i", $post_id); //Bind as integer 'i'
if ($stmt->execute()) {
	echo json_encode(['success' => "Post with ID $post_id has been deleted."]);
} else {
	echo json_encode(['error' => 'Failed to delete the post.']);
}
$stmt->close();
$db->close();
