<?php
require_once 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// S3 Items
$s3Client = new Aws\S3\S3Client([
    'region' => 'ap-southeast-1',
    'version' => 'latest',
    'credentials' => [
        'key' => $_ENV['AWS_ACCESS_KEY_ID'],
        'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
    ]
]);

?>