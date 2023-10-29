<?php
include 'cors.php';
include 'database.php';
require 'vendor/autoload.php';
require_once 'aws-require-env.php';

// Handle create blog post
if (isset($_POST['title']) && isset($_POST['content'])) {
  
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $content = mysqli_real_escape_string($db, $_POST['content']);

  if (isset($_FILES['image'])) {
    try {
      $result = $s3Client->putObject([
          'Bucket' => 'bchewy-images',
          'Key' => 'todos/' . time() . '-' . $_FILES['image']['name'],
          'SourceFile' => $_FILES['image']['tmp_name'],
          'ACL'    => 'public-read',
      ]);

      $imageURL = $result['ObjectURL']; // The URL of the uploaded image

    } catch (AwsException $e) {
      // output error message if fails
      echo $e->getMessage();
    }
  }

  $query = "INSERT INTO posts (title, content, imageURL) VALUES ('$title', '$content', '$imageURL')";

  if(!mysqli_query($db, $query)){
    echo "Error: " . mysqli_error($db);
  } else {
    // Return ID of new post
    $post_id = mysqli_insert_id($db);
    echo $post_id;
  }
}