<?php
// Log in details set as constants - temporary
define('SERVER_NAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'testpassword');
define('DBNAME', 'tetris');

// Attempt to create connection
$conn = new mysqli(SERVER_NAME, USERNAME, PASSWORD, DBNAME);

// Check connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
echo('Connected successfully to ' . $servername);

?>