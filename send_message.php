<?php
session_start();
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['room_id'], $data['user_id'], $data['message'])) {
    $room_id = intval($data['room_id']);
    $user_id = intval($data['user_id']);
    $is_admin = boolval($data['is_admin']);
    $message = mysqli_real_escape_string($con, $data['message']);
    
    // Insert message into the chat table
    $query = "INSERT INTO tbl_chat (room_id, user_id, message, sent_at, is_admin) VALUES ('$room_id', '$user_id', '$message', NOW(), '$is_admin')";
    
    if (mysqli_query($con, $query)) {
        echo json_encode(['success' => true]);
    } else {
        // Output error message for debugging
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>
