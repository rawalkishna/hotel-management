<?php
require 'header.php';
require 'db.php';

// Get the room_id from the URL
if (isset($_GET['room_id'])) {
    $room_id = intval($_GET['room_id']);
} else {
    die("Room ID not provided.");
}

// Query to fetch room details
$query = "SELECT * FROM tbl_room WHERE room_id = '$room_id' AND isDeleted='0'";
$result = mysqli_query($con, $query);

// Check if the room exists
if (mysqli_num_rows($result) > 0) {
    $room = mysqli_fetch_assoc($result);
} else {
    die("Room not found.");
}

// Determine availability based on isBooked field
$availability = ($room['isBooked'] == 0) ? 'Available' : 'Not Available';
$availabilityClass = ($room['isBooked'] == 0) ? 'available' : 'not-available';

// Fetch similar rooms from the same location or category
$similar_rooms_query = "SELECT * FROM tbl_room WHERE room_location = '" . mysqli_real_escape_string($con, $room['room_location']) . "' AND room_id != '$room_id' AND isDeleted='0' AND isBooked='0' LIMIT 3";
$similar_rooms_result = mysqli_query($con, $similar_rooms_query);

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <style>
          /* Custom animation for room details */
          .room-details {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .room-details.show {
            opacity: 1;
        }

        .room-image {
            animation: fadeIn 2s ease-in-out;
        }

        /* Fade-in effect for room availability */
        .availability {
            animation: bounceInUp 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes bounceInUp {
            0% {
                transform: translateY(2000px);
                opacity: 0;
            }
            60% {
                transform: translateY(-30px);
                opacity: 1;
            }
            100% {
                transform: translateY(0);
            }
        }

        /* Availability Status Styling */
        .available {
            color: #28a745; /* Green for available */
            font-weight: bold;
        }

        .not-available {
            color: #dc3545; /* Red for not available */
            font-weight: bold;
        }

        .btn-book {
            animation: zoomIn 1s ease-in-out;
        }

        @keyframes zoomIn {
            0% {
                transform: scale(0.8);
            }
            100% {
                transform: scale(1);
            }
        }

        .similar-rooms-section {
            margin-top: 50px;
        }

        .similar-rooms {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .similar-room {
            width: 30%;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .similar-room:hover {
            transform: scale(1.05);
        }

        .similar-room img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .similar-room h4 {
            font-size: 18px;
            margin: 10px 0;
        }

        .similar-room p {
            font-size: 16px;
            margin: 10px 0;
        }

        .similar-room .btn-book {
            margin-top: 10px;
        }
        #chat-container {
        margin-top: 20px;
        border: 1px solid #ddd;
        padding: 10px;
        background-color: #f9f9f9;
    }

    .chat-box {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 10px;
    }

    .chat-message {
        margin-bottom: 10px;
    }

    .chat-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    .send-message-btn {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    .send-message-btn:hover {
        background-color: #0056b3;
    }
    #comment{
        height: 90px;
    }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Room Image -->
                <img src="uploads/room/<?php echo htmlspecialchars($room['room_img']); ?>" alt="Room Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($room['room_title']); ?></h2>
                <p><strong>Price:</strong> <?php echo htmlspecialchars($room['room_price']); ?> NRP</p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($room['room_location']); ?></p>
                <p><strong>Type:</strong> <?php echo (($room['room_type'] == '1') ? "Single Room" : (($room['room_type'] == '2') ? "Double Room" : "Family Room")); ?></p>
                
                <!-- Availability status -->
                <p class="availability <?php echo $availabilityClass; ?>"><strong>Availability:</strong> <?php echo $availability; ?></p>

                <!-- Book Room Button -->
                <a href="booking.php?room_id=<?php echo $room['room_id']; ?>" class="btn btn-success">Book this Room</a>

                <!-- Chat Button -->
                <button id="chat-with-admin" class="btn btn-info">Chat with Admin</button>  <br>

                <div id="chat">
                    <div class="chat-box" id="chat-messages"></div>
                    <input type="hidden" id="room_id" value="<?php echo $room_id; ?>">
                    <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <textarea id="chat-input" class="chat-input" placeholder="Type your message..."></textarea>
                    <button id="send-message" class="send-message-btn">Send</button>
                </div>

                <!-- Comment Submission Form -->
                <form action="addComment.php" method="POST">
                    <div class="comment"> 
                        <br>
                        <h3>Leave your comment here</h3>
                        <input id="comment" type="text" name="comment" required>
                        <br><br>
                        <!-- Hidden field to pass room_id -->
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">

                        <button type="submit" class="submit-comment" style="background-color: green; color: white;" onclick="alert('Your comment has been submitted!')">Submit Comment</button>


                    </div>
                </form>
                <br>
                <br>
                <br>
                                <p><strong>Comment :</strong> <?php echo htmlspecialchars($room['recommend']); ?> </p>

            </div>
        </div>

        <!-- Similar Rooms Section -->
        <div class="similar-rooms-section">
            <h3>Similar Rooms</h3>
            <div class="similar-rooms">
                <?php
                if (mysqli_num_rows($similar_rooms_result) > 0) {
                    while ($similar_room = mysqli_fetch_assoc($similar_rooms_result)) {
                        echo '<div class="similar-room">';
                        echo '<img src="uploads/room/' . htmlspecialchars($similar_room['room_img']) . '" alt="Similar Room">';
                        echo '<h4>' . htmlspecialchars($similar_room['room_title']) . '</h4>';
                        echo '<p><strong>' . htmlspecialchars($similar_room['room_price']) . ' NRP</strong></p>';
                        echo '<a href="view_room.php?room_id=' . $similar_room['room_id'] . '" class="btn btn-primary">View Details</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No similar rooms available at the moment.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <script>

        document.getElementById('chat').style.display = 'none';
        // Toggle chat container visibility
        document.getElementById('chat-with-admin').addEventListener('click', function () {
            var chatContainer = document.getElementById('chat');
            chatContainer.style.display = chatContainer.style.display === 'none' ? 'block' : 'none';
            loadChatMessages();
        });

        // Load chat messages
        async function loadChatMessages() {
    const roomId = document.getElementById('room_id').value;
    const response = await fetch(`fetch_messages.php?room_id=${roomId}`);
    const messages = await response.json();

    const chatBox = document.getElementById('chat-messages');
    chatBox.innerHTML = '';
    messages.forEach(message => {
        console.log(message)
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('chat-message');
        messageDiv.innerHTML = `<strong>${message.is_admin === '1' ? 'Admin' : 'You'}:</strong> ${message.message}`;
        chatBox.appendChild(messageDiv);
    });
}

        // Send message
        document.getElementById('send-message').addEventListener('click', function () {
            const roomId = document.getElementById('room_id').value;
            const userId = document.getElementById('user_id').value;
            const message = document.getElementById('chat-input').value;
            if (message.trim() === '') return;

            fetch('http://localhost/rf/send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ room_id: roomId, user_id: userId, message: message, is_admin: false })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadChatMessages()
                    document.getElementById('chat-input').value = "";
                    alert('message sent successfully')
                } else {
                    alert('Failed to send message.');
                }
            })
            .catch(error => console.error('Error:', error));
        });

    </script>
</body>
</html>
<?php require 'footer.php'; ?>
