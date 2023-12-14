<?php

// List of allowed domains
$allowed_domains = [
    "*"
];

// Get the origin of the request
$request_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

// If the request's origin is in the list of allowed domains, set the appropriate headers
if (in_array($request_origin, $allowed_domains)) {
    header("Access-Control-Allow-Origin: $request_origin");
    header("Access-Control-Allow-Headers: Content-Type");
} else {
    // Optional: Handle disallowed origins here
}
?>
