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
  <center><h3>Users Details</h3></center>
  <?php
  if (isset($_SESSION['msg'])) {
      echo '<pre style="text-align:center;"><b>'.$_SESSION['msg'].'</b></pre>';
      unset($_SESSION['msg']);
  }

  ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
      </tr>
    </thead>
    <tbody>
        <?php
          //$query="select * from tbl_room where 1 ";
          $query="select *from tbl_booking_user where booking_id = ".base64_decode($_GET['bid'])." and isDeleted='0' ORDER BY booking_id asc";
          // echo $query;
          // exit;
          $run=mysqli_query($con,$query);
          while($v=mysqli_fetch_array($run)){
        ?>
      <tr>
        <td><b style="color: brown;"><?php echo $v['user_name'];?></b></td>
        <td><?php echo $v['user_age'];?></td>
        <!-- <b>Type: </b>
        <br>
        <b>Price: </b> -->
        <td><?php echo $v['user_gender'];?></td>
      </tr>

        <?php
        }
        ?>

    </tbody>
  </table>
</div>
