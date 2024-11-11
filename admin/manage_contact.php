<?php
session_start();
include('db.php'); // Database connection

// Query to fetch all contact submissions
$query = "SELECT * FROM tbl_contact ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die("Error fetching data: " . mysqli_error($con));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contact Submissions</title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .message-column {
            max-width: 200px;
            word-wrap: break-word;
        }

        .action-buttons {
            text-align: center;
        }

        .btn-view {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-view:hover {
            background-color: #45a049;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #e53935;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-body {
            margin-top: 20px;
        }

        .modal-body p {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- <?php require 'header.php'; // Include the header ?> -->

    <div class="container">
        <h2>Manage Contact Submissions</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>';

            // Loop through each contact submission and display it
            while ($row = mysqli_fetch_assoc($result)) {
                $contact_id = $row['contact_id'];
                $name = htmlspecialchars($row['name']);
                $email = htmlspecialchars($row['email']);
                $phone = htmlspecialchars($row['phone']);
                $message = htmlspecialchars($row['message']);
                $created_at = $row['created_at'];

                echo "<tr>
                        <td>$name</td>
                        <td>$email</td>
                        <td>$phone</td>
                        <td class='message-column'>" . substr($message, 0, 100) . "...</td>
                        <td class='action-buttons'>
                            <button class='btn-view' onclick='viewMessage($contact_id)'>View</button>
                            <a href='delete_contact.php?id=$contact_id' class='btn-delete'>Delete</a>
                        </td>
                      </tr>";
            }

            echo '</table>';
        } else {
            echo '<p>No contact submissions found.</p>';
        }
        ?>

    </div>

    <!-- Modal for viewing message -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-body">
                <h3>Full Message</h3>
                <p id="fullMessage"></p>
            </div>
        </div>
    </div>

    <script>
        function viewMessage(contactId) {
            // Fetch the full message using AJAX (you can also fetch other details)
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_message.php?id=' + contactId, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('fullMessage').innerText = response.message;
                    document.getElementById('myModal').style.display = 'block';
                }
            };
            xhr.send();
        }

        // Close the modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

 
</body>
</html>
