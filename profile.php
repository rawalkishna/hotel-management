<?php require 'header.php'; ?>

<div class="container">
    <div class="span3 well">
        <center>
            <a href="#aboutModal" data-toggle="modal" data-target="#myModal">
                <img src="uploads/sss.jpg" name="aboutme" width="140" height="140" class="img-circle">
            </a>
            <h3>
                <?php
                if (isset($_SESSION['user_name'])) {
                    echo htmlspecialchars($_SESSION['user_name']);
                }
                ?>
            </h3>
            <em><b>Mobile number: </b><?php
                if (isset($_SESSION['user_mobile'])) {
                    echo htmlspecialchars($_SESSION['user_mobile']);
                }
                ?></em>,
            <em><b>Address: </b><?php
                if (isset($_SESSION['user_address'])) {
                    echo htmlspecialchars($_SESSION['user_address']);
                }
                ?></em><br>
            <em><b>Citizenship Number </b><?php
                if (isset($_SESSION['user_aadhaar'])) {
                    echo htmlspecialchars($_SESSION['user_aadhaar']);
                }
                ?></em><br>
            <br>
            <h5>
                <a href="logout.php" style="color:red;text-decoration:none">LogOut</a>
            </h5>
        </center>
    </div>

    <div class="container">
        <h3>Bookings</h3>
        <?php
        if (isset($_SESSION['msg'])) {
            echo '<pre style="text-align:center;"><b>' . htmlspecialchars($_SESSION['msg']) . '</b></pre>';
            unset($_SESSION['msg']);
        }
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room Details</th>
                    <th>Location</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT b.*, r.room_title, r.room_type, r.room_price, r.room_location 
                          FROM tbl_booking b 
                          JOIN tbl_room r ON b.room_id = r.room_id 
                          WHERE b.user_id = ? AND b.status != 'deleted' 
                          ORDER BY b.booking_id DESC";
                
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($v = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td>
                            <b style="color: brown;"><?php echo htmlspecialchars($v['room_title']); ?></b><br><br>
                            <b>Type: </b><?php echo ($v['room_type'] == '1') ? "Single Room" : (($v['room_type'] == '2') ? "Double Room" : "Family Room"); ?>
                            <br>
                            <b>Price: </b><?php echo htmlspecialchars($v['room_price']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($v['room_location']); ?></td>
                        <td><?php echo htmlspecialchars($v['booking_date']); ?></td>
                        <td>
                            <span class="badge 
                                <?php 
                                    if ($v['status'] == 'approved') echo 'bg-success';
                                    elseif ($v['status'] == 'rejected') echo 'bg-danger';
                                    else echo 'bg-warning'; // For pending
                                ?>">
                                <?php echo ucfirst($v['status']); ?>
                            </span>
                        </td>
                        <!-- <td style="width: 10px;">
                            <a href="book_user.php?bid=<?php echo $v['booking_id']; ?>" data-toggle="modal">
                                <img src="uploads/list.png" width="30" height="30" alt="List">
                            </a>
                        </td> -->
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'footer.php'; ?>
