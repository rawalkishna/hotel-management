<?php
session_start();
include('db.php'); // Include your database connection file

$error = '';
$success = '';
$rooms = [];

// Fetch rooms from the database
$stmt = $con->prepare("SELECT room_id, room_title, room_type, room_price, room_location, room_srch_key_words, room_img FROM tbl_room WHERE isDeleted = 0");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $rooms[] = $row; // Collect all rooms
}

// Handle edit and delete requests
if (isset($_POST['edit'])) {
    $room_id = (int) $_POST['room_id'];
    $room_title = $_POST['room_title'];
    $room_type = (int) $_POST['room_type'];
    $room_price = (int) $_POST['room_price'];
    $room_location = $_POST['room_location'];
    $room_srch_key_words = $_POST['room_srch_key_words'];

    // Handle the uploaded image
    $target_dir = "uploads/room/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Check if an image was uploaded
    if ($_FILES["room_img"]["name"]) {
        $target_file = $target_dir . basename($_FILES["room_img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["room_img"]["tmp_name"]);
        if ($check === false) {
            $error = "File is not an image.";
        } else {
            // Check file size (limit to 2MB for example)
            if ($_FILES["room_img"]["size"] > 2000000) {
                $error = "Sorry, your file is too large.";
            } else {
                // Allow only certain file formats
                $allowed_formats = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageFileType, $allowed_formats)) {
                    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($_FILES["room_img"]["tmp_name"], $target_file)) {
                        // Update room details in the database
                        $stmt = $con->prepare("UPDATE tbl_room SET room_title = ?, room_type = ?, room_price = ?, room_location = ?, room_srch_key_words = ?, room_img = ? WHERE room_id = ?");
                        $stmt->bind_param("sissssi", $room_title, $room_type, $room_price, $room_location, $room_srch_key_words, basename($_FILES["room_img"]["name"]), $room_id);
                    }
                }
            }
        }
    } else {
        // Update without changing the image
        $stmt = $con->prepare("UPDATE tbl_room SET room_title = ?, room_type = ?, room_price = ?, room_location = ?, room_srch_key_words = ? WHERE room_id = ?");
        $stmt->bind_param("sisssi", $room_title, $room_type, $room_price, $room_location, $room_srch_key_words, $room_id);
    }

    if ($stmt->execute()) {
        $success = "Room updated successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

// Handle delete request
if (isset($_POST['delete'])) {
    $room_id = (int) $_POST['room_id'];
    $stmt = $con->prepare("UPDATE tbl_room SET isDeleted = 1 WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);
    if ($stmt->execute()) {
        $success = "Room deleted successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include('includes/header.php');?>
<div class="ts-main-content">
<?php include('includes/leftbar.php');?>
<div class="content-wrapper">
<div class="container-fluid">
    <h2>Manage Rooms</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>Price</th>
                <th>Location</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo $room['room_id']; ?></td>
                    <td><?php echo $room['room_title']; ?></td>
                    <td><?php echo $room['room_type']; ?></td>
                    <td><?php echo $room['room_price']; ?></td>
                    <td><?php echo $room['room_location']; ?></td>
                    <td><img src="uploads/room/<?php echo $room['room_img']; ?>" alt="<?php echo $room['room_title']; ?>" width="50" height="50"></td>
                    <td>
                        <!-- Manage Button -->
                        <a href="manage_rooms.php?room_id=<?php echo $room['room_id']; ?>" class="btn btn-primary">Manage</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Loading Scripts -->
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
