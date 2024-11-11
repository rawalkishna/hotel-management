<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']!=1)) {
        header('Location: ../../login.php');
    }
    require('db.php');
    ?>
<div class="container">
  <center><h3>Booking Lists</h3></center>
  <?php
  if (isset($_SESSION['msg'])) {
      echo '<pre style="text-align:center;"><b>'.$_SESSION['msg'].'</b></pre>';
      unset($_SESSION['msg']);
  }
  ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Booking Date</th>
        <th>Title</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Room Users</th>
        <th>Action</th>
        <!-- <th  style="width: 10px;">List</th> -->
      </tr>
    </thead>
    <tbody>
        <?php
          //$query="select * from tbl_room where 1 ";
          $query="select * from tbl_booking,tbl_room,tbl_user where tbl_booking.user_id=tbl_user.user_id and tbl_booking.room_id = tbl_room.room_id and tbl_booking.isDeleted='0' ORDER BY tbl_booking.booking_id desc";
          $run=mysqli_query($con,$query);
          while($v=mysqli_fetch_array($run)){
        ?>
      <tr>
        <td><?php echo $v['booking_date'];?></td>
        <td><b><?php echo $v['room_title'];?></b></td>
        <!-- <b>Type: </b>
        <br>
        <b>Price: </b> -->
        <td><?php echo $v['user_name'];?></td>
        <td><?php echo $v['user_mobile'];?></td>
        <td>
          <a href="abcd.php?bid=<?php echo base64_encode($v['booking_id']); ?>" class="btn btn-info">View</a>
        </td>
        <td>
          <a href="bookingdelete.php?bid=<?php echo base64_encode($v['booking_id']).'&id='.base64_encode($v['room_id']); ?>" class="btn btn-danger">Delete</a>
        </td>

      </tr>

        <?php
        }
        ?>

    </tbody>
  </table>
</div>
