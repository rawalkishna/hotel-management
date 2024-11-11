<?php
session_start();
include('db.php'); // Include database connection

// Query to fetch all chat messages along with user names and room details
$query = "
    SELECT c.chat_id, c.message, c.sent_at, u.user_name, r.room_title, c.room_id, c.user_id, c.is_admin
    FROM tbl_chat c
    JOIN tbl_user u ON c.user_id = u.user_id
    JOIN tbl_room r ON c.room_id = r.room_id
    ORDER BY c.user_id, c.room_id, c.sent_at DESC
";

// Execute the query
$result = mysqli_query($con, $query);

// Check for SQL query errors
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Group messages by user and room
$groupedMessages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['user_id'];
    $room_id = $row['room_id'];
    
    if (!isset($groupedMessages[$user_id])) {
        $groupedMessages[$user_id] = [];
    }
    
    if (!isset($groupedMessages[$user_id][$room_id])) {
        $groupedMessages[$user_id][$room_id] = [
            'user_name' => htmlspecialchars($row['user_name']),
            'room_title' => htmlspecialchars($row['room_title']),
            'messages' => []
        ];
    }
    
    $groupedMessages[$user_id][$room_id]['messages'][] = [
        'message' => htmlspecialchars($row['message']),
        'sent_at' => $row['sent_at'],
        'is_admin' => $row['is_admin']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Chat</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* Basic Styling for Body and Layout */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
    color: #333;
}

.container {
    margin-left: 220px; /* Offset for sidebar */
    padding: 30px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h3 {
    color: #333;
    text-align: center;
    margin-bottom: 30px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #4CAF50;
    color: white;
    text-transform: uppercase;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.3s ease-in-out;
}

/* Filter Form Styling */
.filter-form {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.filter-form label {
    font-weight: bold;
    font-size: 14px;
}

.filter-form select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.filter-form .filter-btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.filter-form .filter-btn:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

/* Reply Button Styling */
.reply-btn {
    padding: 10px 20px;
    background-color: #2196F3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.reply-btn:hover {
    background-color: #0b7dda;
    transform: scale(1.05);
}

/* Sidebar Styling */
.leftbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    height: 100%;
    background-color: #333;
    padding-top: 20px;
}

.leftbar ul {
    list-style-type: none;
    padding: 0;
}

.leftbar ul li {
    margin: 15px 0;
    text-align: center;
}

.leftbar ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    display: block;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.leftbar ul li a:hover {
    background-color: #575757;
    transform: scale(1.05);
}

/* Header Styling */
header {
    background-color: #333;
    padding: 20px;
    color: white;
    text-align: center;
}

    </style>
</head>
<body>


    <div class="container">
        <h3>All Chat Messages</h3>


<table>
            <tr>
                <th>User Name</th>
                <th>Room</th>
                <th>Messages</th>
                <th>Reply</th>
            </tr>
            
            <?php
            foreach ($groupedMessages as $userId => $rooms) {
                foreach ($rooms as $roomId => $roomData) {
                    echo '<tr>';
                    echo '<td>' . $roomData['user_name'] . '</td>';
                    echo '<td>' . $roomData['room_title'] . '</td>';
                    echo '<td>';
                    echo '<div style="max-height: 200px; overflow-y: auto; scrollbar-width: none;">';
                    
                    // Display all messages for this user and room
                    foreach ($roomData['messages'] as $message) {
                        echo '<div class="chat-message">';
                        echo '<p>' . ($message['is_admin'] ? 'Admin: ' : 'User: ') . $message['message'] . '</p>';
                        echo '<small>' . $message['sent_at'] . '</small>';
                        echo '</div><hr>';
                    }
                    echo '<div>';
                    
                    echo '</td>';
                    
                    // Reply form
                    echo '<td>
                        <form class="reply-form" method="POST" style="display:flex; flex-direction: column; gap: 10px; align-items: start;">
                            <input type="hidden" name="room_id" value="' . $roomId . '">
                            <input type="hidden" name="user_id" value="' . $userId . '">
                            <textarea name="reply_message" id="message" rows="6" placeholder="Type your reply" required style="width: 70%"></textarea>
                            <button type="submit" class="reply-btn">Send Reply</button>
                        </form>
                    </td>';
                    
                    echo '</tr>';
                }
            }
            ?>
        </table>

        <!-- Filter Form for Rooms -->
        <!-- <form action="manage-chat.php" method="GET" class="filter-form">
            <label for="room_id">Filter by Room:</label>
            <select name="room_id" id="room_id">
                <option value="">Select Room</option>
                <?php
                // Fetch available rooms for filtering
                $rooms_query = "SELECT room_id, room_title FROM tbl_room";
                $rooms_result = mysqli_query($con, $rooms_query);

                if (!$rooms_result) {
                    die("Failed to fetch rooms: " . mysqli_error($con));
                }

                while ($room = mysqli_fetch_assoc($rooms_result)) {
                    echo '<option value="' . $room['room_id'] . '">' . htmlspecialchars($room['room_title']) . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="filter-btn">Filter</button>
        </form> -->
    </div>

    <script>
    $(document).ready(function() {
        // Handle the reply form submission via AJAX
        $('.reply-form').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this); // Get form data

            fetch('http://localhost/rf/send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ room_id: formData.get("room_id"), user_id: formData.get("user_id"), message: formData.get("reply_message"), is_admin: true })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('message sent successfully')
                    document.getElementById('message').value = "";
                } else {
                    alert('Failed to send message.');
                }
            })
            .catch(error => console.error('Error:', error));

        });
    });
    </script>

</body>
</html>

