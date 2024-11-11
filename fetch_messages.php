<?php
session_start();
require 'db.php';

$room_id = intval($_GET['room_id']);
$user_id = intval($_SESSION['user_id']);

// Query to fetch all chat messages for this room and user
$query = "
    SELECT c.chat_id, c.message, c.sent_at, c.room_id, c.user_id, c.is_admin
    FROM tbl_chat c
    WHERE c.room_id = $room_id AND c.user_id = $user_id
    ORDER BY c.sent_at ASC
";

// Execute the query
$result = mysqli_query($con, $query);

// Check for SQL query errors
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Fetch and store messages in an array
$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = [
        'chat_id' => $row['chat_id'],
        'message' => htmlspecialchars($row['message']),
        'sent_at' => $row['sent_at'],
        'is_admin' => $row['is_admin']
    ];
}

// Output messages as JSON
echo json_encode($messages);
?>
