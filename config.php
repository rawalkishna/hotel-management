<?php
// db.php
// Database connection
$host = "localhost"; // Server name
$user = "root";      // Username for MySQL (default is "root" in XAMPP)
$pass = "";          // Password (default is empty in XAMPP)
$db = "rf";          // Database name
$port = 3306;        // Port (as indicated by your dump file, set to 3307)

// Create connection
$con = mysqli_connect($host, $user, $pass, $db, $port);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
