<?php
include 'cors.php';
include 'database.php';

// Handle create blog post
if (isset($_POST['title']) && isset($_POST['content'])) {
  
  $title = $_POST['title'];
  $content = $_POST['content'];


  $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";

  if(!mysqli_query($db, $query)){
    echo "Error: " . mysqli_error($db);
  } else {
    // Return ID of new post
    $post_id = mysqli_insert_id($db);
    echo $post_id;
  }
}