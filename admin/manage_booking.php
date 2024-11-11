<?php
session_start();
include('db.php'); // Include your database connection file

// Initialize messages
$error = '';
$success = '';

// Handle booking deletion (optional)
// If you want to keep deletion functionality, you can implement a soft delete logic
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    // Example of soft delete (you might want to implement this in a different way)
    $delete_query = "UPDATE tbl_booking SET status = 'deleted' WHERE booking_id = $delete_id"; 
    if (mysqli_query($con, $delete_query)) {
        $success = "Booking deleted successfully!";
    } else {
        $error = "Error deleting booking: " . mysqli_error($con);
    }
}

// Handle booking approval
if (isset($_GET['approve_id'])) {
    $approve_id = intval($_GET['approve_id']);
    $approve_query = "UPDATE tbl_booking SET status = 'approved' WHERE booking_id = $approve_id";
    if (mysqli_query($con, $approve_query)) {
        $success = "Booking approved successfully!";
    } else {
        $error = "Error approving booking: " . mysqli_error($con);
    }
}

// Handle booking rejection
if (isset($_GET['reject_id'])) {
    $reject_id = intval($_GET['reject_id']);
    $reject_query = "UPDATE tbl_booking SET status = 'rejected' WHERE booking_id = $reject_id";
    if (mysqli_query($con, $reject_query)) {
        $success = "Booking rejected successfully!";
    } else {
        $error = "Error rejecting booking: " . mysqli_error($con);
    }
}

// Fetch bookings from the database
$query = "SELECT b.booking_id, b.room_id, b.user_id, b.booking_date, b.leave_date, b.status, r.room_title, u.user_name 
          FROM tbl_booking b 
          JOIN tbl_room r ON b.room_id = r.room_id 
          JOIN tbl_user u ON b.user_id = u.user_id 
          WHERE b.status != 'deleted' 
          ORDER BY b.booking_date DESC";

$run = mysqli_query($con, $query);

// Check for query execution errors
if (!$run) {
    die("Query Failed: " . mysqli_error($con)); // Debugging output
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">

</head>
<body>
<?php include('includes/header.php'); ?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <h2>Manage Bookings</h2>
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
                        <th>Room Name</th>
                        <th>User Name</th>
                        <th>Booking Date</th>
                        <th>Leave Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($run)): ?>
                        <tr>
                            <td><?php echo $row['booking_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['room_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['leave_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="manage_booking.php?approve_id=<?php echo $row['booking_id']; ?>" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this booking?')">Approve</a>
                                <a href="manage_booking.php?reject_id=<?php echo $row['booking_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this booking?')">Reject</a>
                                <!-- Optional: Add delete button -->
                                <a href="manage_booking.php?delete_id=<?php echo $row['booking_id']; ?>" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
