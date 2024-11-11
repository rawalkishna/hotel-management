
<?php
// Database connection
$server = 'localhost';
$username = 'root';
$password = '';  // Change this to your MySQL password
$database = 'rf'; // Your database name

$con = mysqli_connect($server, $username, $password, $database);

// Check if the connection is successful
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
