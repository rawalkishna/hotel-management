<?php
require 'db.php'; // Include your database connection file

// Check if room_id and comment are provided in the POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['room_id']) && isset($_POST['comment'])) {
        $comment = mysqli_real_escape_string($con, $_POST['comment']);
        $room_id = intval($_POST['room_id']);

        // Prepare the SQL query to update the room's comment field
        $stmt = $con->prepare("UPDATE tbl_room SET recommend = ? WHERE room_id = ? AND isDeleted = '0'");
        $stmt->bind_param("si", $comment, $room_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the room details page after successful submission
            header("Location: view_room.php?room_id=" . $room_id);
            exit();
        } else {
            echo "Error: " . $stmt->error; // Error message if the query fails
        }
    } else {
        echo "Please provide a comment and room ID."; // If no comment or room_id is provided
    }
} else {
    echo "Invalid request method."; // If not a POST request
}
?>
