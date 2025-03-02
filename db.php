<?php
$host = "localhost";
$user = "root"; // Default XAMPP username
$pass = ""; // Default XAMPP password (leave blank)
$dbname = "qr-db";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select the database
if (!$conn->select_db($dbname)) {
    die("Database selection failed: " . $conn->error);
}

?>