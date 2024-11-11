<?php
include('db.php'); // Database connection

if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    // Fetch the full message based on contact_id
    $query = "SELECT message FROM tbl_contact WHERE contact_id = '$contact_id'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = ['message' => $row['message']];
        echo json_encode($response);
    } else {
        echo json_encode(['message' => 'No message found.']);
    }
}
?>
