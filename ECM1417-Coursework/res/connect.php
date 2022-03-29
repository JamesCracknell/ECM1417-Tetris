<?php
// Log in details set as constants - temporary
define('SERVER_NAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'testpassword');
define('DBNAME', 'tetris');

// Attempt to create connection
$connection = new mysqli(SERVER_NAME, USERNAME, PASSWORD, DBNAME);

// Check connection
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}
echo('Connected successfully to ' . $servername);

?>