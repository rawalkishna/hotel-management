<?php
include('config.php'); // Ensure your database connection is set here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form submission
    $room_id = $_POST['room_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    // Insert or update the rating and feedback
    $query = "INSERT INTO tbl_ratings (room_id, user_id, rating, feedback)
              VALUES (?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE rating = ?, feedback = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiisss', $room_id, $user_id, $rating, $feedback, $rating, $feedback);
    $stmt->execute();
    $stmt->close();
    
    // Optionally, you can also update the average rating of the room
    $avgRatingQuery = "SELECT AVG(rating) AS avg_rating FROM tbl_ratings WHERE room_id = ?";
    $avgRatingStmt = $conn->prepare($avgRatingQuery);
    $avgRatingStmt->bind_param('i', $room_id);
    $avgRatingStmt->execute();
    $avgRatingResult = $avgRatingStmt->get_result();
    $avgRating = $avgRatingResult->fetch_assoc()['avg_rating'];

    $updateRoomRating = "UPDATE tbl_room SET rating = ? WHERE room_id = ?";
    $updateStmt = $conn->prepare($updateRoomRating);
    $updateStmt->bind_param('di', $avgRating, $room_id);
    $updateStmt->execute();
    $updateStmt->close();

    echo 'Success';
} else {
    echo 'Error: Invalid request.';
}
?>
