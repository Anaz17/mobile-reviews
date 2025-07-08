<?php
$host = "localhost";
$user = "root";
$password = ""; // change if needed
$dbname = "mobile_review_apps";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>