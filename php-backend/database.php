<?php

$db = mysqli_connect('127.0.0.1', 'username', 'password', 'dbname');

// Check connection
if (!$db) {
    die(json_encode(['error' => 'Failed connecting to the database']));
}
