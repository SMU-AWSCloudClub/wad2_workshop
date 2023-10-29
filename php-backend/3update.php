<?php
require_once 'cors.php';
require_once 'database.php';
require_once 'vendor/autoload.php';
require_once 'aws-require-env.php';

// Get data
$post_id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

if (isset($_FILES['image'])) {
	echo 'image found updating';
    try {
        $result = $s3Client->putObject([
            'Bucket' => 'bchewy-images',
            'Key' => 'todos/' . time() . '-' . $_FILES['image']['name'],
            'SourceFile' => $_FILES['image']['tmp_name'],
            'ACL'    => 'public-read',
        ]);

        $imageURL = $result['ObjectURL']; // The URL of the uploaded image

        // Update post
		$query = "UPDATE posts SET title='$title', content='$content', imageURL='$imageURL' WHERE id=$post_id";
		mysqli_query($db, $query);

		echo $post_id;
    } catch (AwsException $e) {
        // output error message if fails
        echo $e->getMessage();
    }
}
else{
	$query = "UPDATE posts SET title='$title', content='$content' WHERE id=$post_id";

	mysqli_query($db, $query);

	echo $post_id;
}

