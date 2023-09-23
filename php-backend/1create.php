<?php
include 'cors.php';
include 'database.php';

// Image check handling
$image = '';

if (isset($_POST['image'])) {
  $image = $_POST['image'];
}

// Handle create blog post
if (isset($_POST['title']) && isset($_POST['content'])) {
  
  $title = $_POST['title'];
  $content = $_POST['content'];
  // $image = $_POST['image'];


  $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
  // $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content', '$image')";

  if(!mysqli_query($db, $query)){
    echo "Error: " . mysqli_error($db);
  } else {
    // Return ID of new post
    $post_id = mysqli_insert_id($db);
    echo $post_id;
  }
}