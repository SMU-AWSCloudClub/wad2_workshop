<?php
// 2read.php

include 'cors.php';
include 'database.php';

// Get posts
$query = "SELECT * FROM posts";
$result = mysqli_query($db, $query);

$posts = [];
while($row = mysqli_fetch_assoc($result)) {
  $posts[] = $row; 
}

echo json_encode($posts);