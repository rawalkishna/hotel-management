<?php
session_start();
include('db.php'); // Include database connection

// Get the room_id from the URL
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

// Debugging: Check if room_id is being retrieved correctly
if ($room_id == 0) {
    echo "Room ID is required to view the chat. Room ID: " . $_GET['room_id'];  // Debugging output
    exit;
}

// Query to fetch chat messages along with user names
$query = "
    SELECT c.message, c.sent_at, u.user_name 
    FROM tbl_chat c
    JOIN tbl_users u ON c.user_id = u.user_id
    WHERE c.room_id = '$room_id'
    ORDER BY c.sent_at DESC
";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    // Output chat messages
    echo '<div class="chat-box">';
    while ($row = mysqli_fetch_assoc($result)) {
        $message = htmlspecialchars($row['message']);
        $user_name = htmlspecialchars($row['user_name']);
        $sent_at = $row['sent_at'];

        // Display each message with the sender's name and the timestamp
        echo '<div class="chat-message">';
        echo '<p><strong>' . $user_name . ':</strong> ' . $message . ' <span class="timestamp">[' . $sent_at . ']</span></p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No messages yet in this chat.";
}
?>

<!-- Form to send a new message -->
<form action="send_message.php" method="POST">
    <input type="hidden" name="room_id" value="<?php echo $room_id; ?>" />
    <textarea name="message" placeholder="Type your message here..." required></textarea>
    <button type="submit">Send Message</button>
</form>
