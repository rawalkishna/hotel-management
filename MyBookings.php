<?php
session_start();
include('db.php'); // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: login.php');
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user bookings from the database
$query = "SELECT b.booking_id, b.room_id, b.booking_date, b.leave_date, b.status, r.room_title 
          FROM tbl_booking b 
          JOIN tbl_room r ON b.room_id = r.room_id 
          WHERE b.user_id = ? AND b.status != 'deleted' 
          ORDER BY b.booking_date DESC";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize messages
$error = '';
$success = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#232628">
    <div class="container px-5">
        <a class="navbar-brand" href="index.php">Room Finder</a>
        <!-- Add your navbar items here -->
    </div>
</nav>

<div class="container mt-4">
    <h2>My Bookings</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Room Title</th>
                <th>Booking Date</th>
                <th>Leave Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['room_title']); ?></td>
                    <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['leave_date']); ?></td>
                    <td>
                        <?php 
                        switch ($row['status']) {
                            case 'approved':
                                echo '<span class="text-success">Approved</span>';
                                break;
                            case 'rejected':
                                echo '<span class="text-danger">Rejected</span>';
                                break;
                            case 'pending':
                            default:
                                echo '<span class="text-warning">Pending</span>';
                                break;
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
