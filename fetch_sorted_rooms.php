<?php
require 'db.php';

$order_by = "";
if (isset($_POST['sort_order'])) {
    $sort_order = $_POST['sort_order'];
    if ($sort_order == 'asc') {
        $order_by = " ORDER BY room_price ASC";
    } elseif ($sort_order == 'desc') {
        $order_by = " ORDER BY room_price DESC";
    }
}

$query = "SELECT * FROM tbl_room WHERE isDeleted='0' AND isBooked='0'" . $order_by;
$run = mysqli_query($con, $query);

while ($v = mysqli_fetch_array($run)) {
    ?>
    <div class="col mb-5">
        <div class="card h-100">
            <!-- Product image-->
            <img class="card-img-top" 
                src="uploads/room/<?php echo htmlspecialchars($v['room_img'] ?? 'default_image.jpg'); ?>" 
                alt="<?php echo htmlspecialchars($v['room_title']); ?>" style="width: 100%; height: 250px; object-fit: cover;" />
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder"><?php echo htmlspecialchars($v['room_title']); ?></h5>
                    <!-- Product price-->
                    <b>Price:</b> <?php echo htmlspecialchars($v['room_price']); ?>
                    <br>
                    <b>Type:</b> <?php echo ($v['room_type'] == '1') ? "Single Room" : (($v['room_type'] == '2') ? "Double Room" : "Family Room"); ?>
                    <br>
                    <b>Location:</b> <?php echo htmlspecialchars($v['room_location']); ?>
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center">
                    <a class="btn btn-outline-dark mt-auto" 
                    href="view_room.php?room_id=<?php echo base64_encode($v['room_id']); ?>">View Now</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
