<?php
require 'db.php';

if (isset($_GET['room_id'])) {
    $room_id = intval($_GET['room_id']);
    
    // Fetch chat messages from the database for the room
    $query = "SELECT * FROM tbl_chat WHERE room_id = '$room_id' ORDER BY sent_at ASC";
    $result = mysqli_query($con, $query);
    
    $messages = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }

    echo json_encode(['success' => true, 'messages' => $messages]);
} else {
    echo json_encode(['success' => false, 'error' => 'Room ID not provided']);
}
?>
