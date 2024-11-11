<?php
session_start();
include('db.php'); // Include your database connection file

$error = '';
$success = '';

// Initialize $room to avoid undefined variable issues
$room = null;

// Fetch room details if a room ID is provided
if (isset($_GET['room_id'])) {
    $room_id = (int) $_GET['room_id'];
    $stmt = $con->prepare("SELECT room_id, room_title, room_type, room_price, room_location, room_srch_key_words, room_img FROM tbl_room WHERE room_id = ? AND isDeleted = 0");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc(); // Fetch room details
}

// Handle edit and delete requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
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

        if ($_FILES["room_img"]["name"]) {
            $target_file = $target_dir . basename($_FILES["room_img"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate image
            if (getimagesize($_FILES["room_img"]["tmp_name"]) === false) {
                $error = "File is not an image.";
            } elseif ($_FILES["room_img"]["size"] > 2000000) {
                $error = "Sorry, your file is too large.";
            } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            } else {
                // Move uploaded file
                if (move_uploaded_file($_FILES["room_img"]["tmp_name"], $target_file)) {
                    // Update room details
                    $stmt = $con->prepare("UPDATE tbl_room SET room_title = ?, room_type = ?, room_price = ?, room_location = ?, room_srch_key_words = ?, room_img = ? WHERE room_id = ?");
                    $stmt->bind_param("sissssi", $room_title, $room_type, $room_price, $room_location, $room_srch_key_words, basename($_FILES["room_img"]["name"]), $room_id);
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
        $stmt = $con->prepare("UPDATE tbl_room SET isDeleted = 1 WHERE room_id = ?");
        $stmt->bind_param("i", $room_id);
        if ($stmt->execute()) {
            $success = "Room deleted successfully.";
            header("Location: manage_rooms.php"); // Redirect after delete
            exit;
        } else {
            $error = "Error: " . $stmt->error;
        }
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
    <!-- Additional CSS files -->
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <h2>Manage Room</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($room): ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                    <div class="mb-3">
                        <label for="room_title" class="form-label">Room Title</label>
                        <input type="text" class="form-control" name="room_title" value="<?php echo $room['room_title']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_type" class="form-label">Room Type</label>
                        <select class="form-select" name="room_type" required>
                            <option value="1" <?php echo $room['room_type'] == 1 ? 'selected' : ''; ?>>Single Room</option>
                            <option value="2" <?php echo $room['room_type'] == 2 ? 'selected' : ''; ?>>Double Room</option>
                            <option value="3" <?php echo $room['room_type'] == 3 ? 'selected' : ''; ?>>Family Room</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="room_price" class="form-label">Room Price</label>
                        <input type="number" class="form-control" name="room_price" value="<?php echo $room['room_price']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_location" class="form-label">Room Location</label>
                        <input type="text" class="form-control" name="room_location" value="<?php echo $room['room_location']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_srch_key_words" class="form-label">Search Keywords</label>
                        <input type="text" class="form-control" name="room_srch_key_words" value="<?php echo $room['room_srch_key_words']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_img" class="form-label">Room Image (Leave empty if you don't want to change)</label>
                        <input type="file" class="form-control" name="room_img" accept="image/*">
                    </div>
                    <button type="submit" name="edit" class="btn btn-primary">Update Room</button>
                    <button type="submit" name="delete" class="btn btn-danger">Delete Room</button>
                </form>
            <?php else: ?>
                <!-- <div class="alert alert-warning">Room not found.</div> -->
            <?php endif; ?>
        </div>
    </div>
</div>

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
