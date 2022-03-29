<?php
// Log in details
$servername = "localhost";
$username = "root";
$password = "testpassword";
$dbname = "tetris";

// Create connection
$connection = new mysqli($servername, $username, $password);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
echo("Connected successfully to " . $servername);

?>