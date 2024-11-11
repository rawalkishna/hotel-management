<!-- Responsive Table -->
<!-- <div class="card">
  <h5 class="card-header">.</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr class="text-nowrap">
          <th>SL No.</th>
          <th>Table heading</th>
          <th>Table heading</th>
          <th>Table heading</th>
          <th>Table heading</th>
          <th>Table heading</th>
          <th>Table heading</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Table cell</td>
          <td>Table cell</td>
          <td>Table cell</td>
          <td>Table cell</td>
          <td>Table cell</td>
          <td>Table cell</td>
        </tr>
      </tbody>
    </table>
  </div>
</div> -->
<!--/ Responsive Table -->
<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']!=1)) {
        header('Location: ../../login.php');
    }
    require('db.php');
    ?>
<div class="container">
  <center><h3>Room Lists</h3></center>
  <?php
  if (isset($_SESSION['msg'])) {
      echo '<pre style="text-align:center;"><b>'.$_SESSION['msg'].'</b></pre>';
      unset($_SESSION['msg']);
  }

  ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Type</th>
        <th>Price</th>
        <th>Location</th>
        <th>Keywords</th>
        <th>isBooked</th>
        <th>Action</th>
        <!-- <th  style="width: 10px;">List</th> -->
      </tr>
    </thead>
    <tbody>
        <?php
          $query="select * from tbl_room where isDeleted=0";
          //$query="select * from tbl_room,tbl_booking where 1 ORDER BY tbl_booking.booking_id desc";
          $run=mysqli_query($con,$query);
          while($v=mysqli_fetch_array($run)){
        ?>
      <tr>
        <td><b><?php echo $v['room_title'];?></b></td>
        <!-- <b>Type: </b>
        <br>
        <b>Price: </b> -->
        <td><?php if($v['room_type']=='1')echo "Single Room";elseif($v['room_type']=='2')echo "Double Room";else echo"Family Room";?></td>
        <td><?php echo $v['room_price'];?></td>
        <td><?php echo $v['room_location'];?></td>
        <td><?php echo $v['room_srch_key_words'];?></td>
        <td><?php if($v['isBooked']=='1') echo "Yes"; else echo "No" ?></td>
        <td>
          <a href="roomdelete.php?id=<?php echo base64_encode($v['room_id']); ?>" class="btn btn-danger">Delete</a>
        </td>
      </tr>

        <?php
        }
        ?>

    </tbody>
  </table>
</div>
