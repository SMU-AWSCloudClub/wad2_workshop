<?php
include 'cors.php';
include 'database.php';

// Get data
$post_id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

// Update post
$query = "UPDATE posts SET title='$title', content='$content' WHERE id=$post_id";

mysqli_query($db, $query);

echo $post_id;