<?php
require 'db.php';

// Retrieve search and filter parameters
$search_location = $_POST['search_location'] ?? '';
$search_type = $_POST['search_type'] ?? '';
$sort_order = $_POST['sort_order'] ?? '';

// Build dynamic query
$condition = "";
if (!empty($search_location)) {
    $condition .= " AND room_srch_key_words LIKE '%" . mysqli_real_escape_string($con, $search_location) . "%' ";
}
if (!empty($search_type)) {
    $condition .= " AND room_type = '" . mysqli_real_escape_string($con, $search_type) . "' ";
}

$order = "";
if ($sort_order === "asc") {
    $order = " ORDER BY room_price ASC";
} elseif ($sort_order === "desc") {
    $order = " ORDER BY room_price DESC";
}

$query = "SELECT * FROM tbl_room WHERE isDeleted='0' AND isBooked='0' " . $condition . $order;
$run = mysqli_query($con, $query);

// Loop through the results and return the HTML
while ($v = mysqli_fetch_array($run)) {
    echo '
    <div class="col mb-5">
      <div class="card h-100">
        <img class="card-img-top" src="uploads/room/' . htmlspecialchars($v['room_img'] ?? 'default_image.jpg') . '" alt="' . htmlspecialchars($v['room_title']) . '" style="width: 100%; height: 250px; object-fit: cover;"  />
        <div class="card-body p-4">
          <div class="text-center">
            <h5 class="fw-bolder">' . htmlspecialchars($v['room_title']) . '</h5>
            <b>Price:</b> ' . htmlspecialchars($v['room_price']) . '<br>
            <b>Type:</b> ' . (($v['room_type'] == '1') ? "Single Room" : (($v['room_type'] == '2') ? "Double Room" : "Family Room")) . '<br>
            <a href="view_room.php?room_id=' . htmlspecialchars($v['room_id']) . '" class="btn btn-primary">View Room</a>
          </div>
        </div>
      </div>
    </div>';
}
?>
