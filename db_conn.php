<?php
// 1) Make sure PHP itself is using Manila time
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('Asia/Manila');
}
// Database connection settings
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "taskmatic";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

try {
    $conn = new mysqli($servername, $username, $password, $database);
    $conn->set_charset("utf8"); // Set charset after connection
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
// Set the time zone to Manila (UTC +08:00)
$conn->query("SET time_zone = '+08:00'");

// Optionally, set the charset to UTF-8
$conn->set_charset("utf8");

// You can now use $conn in your application.
?>
