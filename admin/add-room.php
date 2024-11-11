<?php
session_start();
include('db.php'); // Include your database connection file

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    // Gather form data
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
                    // Insert data into the database
                    $stmt = $con->prepare("INSERT INTO tbl_room (room_title, room_type, room_price, room_location, room_srch_key_words, room_img, isBooked, room_owner_user_id, isDeleted) 
                                          VALUES (?, ?, ?, ?, ?, ?, 0, ?, 0)");
                    $stmt->bind_param("sissssi", $room_title, $room_type, $room_price, $room_location, $room_srch_key_words, basename($_FILES["room_img"]["name"]), $_SESSION['user_id']);
                    if ($stmt->execute()) {
                        $success = "Room added successfully.";
                    } else {
                        $error = "Error: " . $stmt->error;
                    }
                } else {
                    $error = "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
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
    <h2>Add Room</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="room_title" class="form-label">Room Title</label>
            <input type="text" class="form-control" name="room_title" id="room_title" required>
        </div>
        <div class="mb-3">
            <label for="room_type" class="form-label">Room Type</label>
            <select class="form-select" name="room_type" id="room_type" required>
                <option value="1">Single Room</option>
                <option value="2">Double Room</option>
                <option value="3">Family Room</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="room_price" class="form-label">Room Price</label>
            <input type="number" class="form-control" name="room_price" id="room_price" required>
        </div>
        <div class="mb-3">
            <label for="room_location" class="form-label">Room Location</label>
            <input type="text" class="form-control" name="room_location" id="room_location" required>
        </div>
        <div class="mb-3">
            <label for="room_srch_key_words" class="form-label">Search Keywords</label>
            <input type="text" class="form-control" name="room_srch_key_words" id="room_srch_key_words" required>
        </div>
        <div class="mb-3">
            <label for="room_img" class="form-label">Room Image</label>
            <input type="file" class="form-control" name="room_img" id="room_img" accept="image/*" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Room</button>
    </form>
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