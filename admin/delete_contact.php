<?php
include('db.php'); // Database connection

if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    // SQL query to delete the contact submission
    $query = "DELETE FROM tbl_contact WHERE contact_id = '$contact_id'";
    if (mysqli_query($con, $query)) {
        header("Location: manage_contact.php");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
