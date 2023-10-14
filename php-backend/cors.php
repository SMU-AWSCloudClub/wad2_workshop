<?php

// List of allowed domains (commented out for now since we want to allow all)
// $allowed_domains = [
//     "http://example.com",
//     "https://another-example.com"
// ];

// Always set the Access-Control-Allow-Origin header to "*"
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// If there's a pre-flight OPTIONS request, handle it and exit
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // Just exit after setting the above headers
}

// Commented out for now since we want to allow all origins
/*
// Get the origin of the request
$request_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

// If the request's origin is in the list of allowed domains, set the appropriate headers
if (in_array($request_origin, $allowed_domains)) {
    header("Access-Control-Allow-Origin: $request_origin");
} else {
    // Optional: Handle disallowed origins here
}
*/

?>
