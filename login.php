<?php
ob_start();
session_start();
session_destroy();
session_start();
?>
<?php include_once('db.php');?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Room Finder</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <style>
          body {font-family: Arial, Helvetica, sans-serif;}

/* Full-width input fields */
          input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
          }

          /* Set a style for all buttons */
          button {
            background-color: #333333;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
          }

          button:hover {
            opacity: 0.8;
          }

          /* Extra styles for the cancel button */
          .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
          }

          /* Center the image and position the close button */
          .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
            position: relative;
          }

          img.avatar {
            width: 40%;
            border-radius: 50%;
            width: 90px;
            height: 95px;
          }

          .container {
            padding: 16px;
          }

          span.psw {
            float: right;
            padding-top: 16px;
          }

          /* The Modal (background) */
          .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
          }

          /* Modal Content/Box */
          .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
          }

          /* The Close Button (x) */
          .close {
            position: absolute;
            right: 25px;
            top: 0;
            color: #000;
            font-size: 35px;
            font-weight: bold;
          }

          .close:hover,
          .close:focus {
            color: red;
            cursor: pointer;
          }

          /* Add Zoom Animation */
          .animate {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
          }

          @-webkit-keyframes animatezoom {
            from {-webkit-transform: scale(0)}
            to {-webkit-transform: scale(1)}
          }

          @keyframes animatezoom {
            from {transform: scale(0)}
            to {transform: scale(1)}
          }

          /* Change styles for span and cancel button on extra small screens */
          @media screen and (max-width: 300px) {
            span.psw {
              display: block;
              float: none;
            }
            .cancelbtn {
              width: 100%;
            }
          }

        </style>
    </head>
    <body>
        <?php require 'navbar.php' ?>

        <form class="modal-content" action="" method="post">

        <div class="imgcontainer">
          <img src="login.png" alt="Avatar" class="avatar">
        </div>

    <div class="container col-md-4">
      <label for="uname"><b>User mobile no.</b></label>
      <input type="text" placeholder="User mobile no." name="user_mobile" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="user_password" required>
       <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
      <br>
     <!--  <button type="submit" >Login</button> -->
     <div class="row">
     &nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Login" class="btn btn-warning col-md-6">&nbsp;&nbsp;
     <input type="cancel" onclick="history.back()" value="Cancel" class="btn btn-secondary col-md-5">
     </div>

    </div>
    <div style="text-align:center">
      Don't have any account
      <a href="register.php">click here</a>
    </div>
    <div class="container" style="background-color:#f1f1f1">

    </div>
  </form>
        <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        </nav> -->

        <?php require 'footer.php' ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<style type="text/css">
  .modal-content {
  margin: 5% auto 3% auto;
}
</style>
<?php

if (isset($_POST['submit'])) {

  $user_mobile = $_POST['user_mobile'];
  $user_password = $_POST['user_password'];

  $query="select *from tbl_user where user_mobile='".$user_mobile."' and user_password='". md5($user_password) ."' and isDeleted='0'";
  $run=mysqli_query($con,$query);
  /*echo $query;
  exit;*/
  $row = mysqli_fetch_assoc($run);

  if (mysqli_num_rows($run)>0) {
    //$_SESSION['user_id'] = $row['user_id'];
    foreach ($run as $v) {
        $isAdmin = $v['isAdmin'];
        $_SESSION['user_id'] = $v['user_id'];
        $_SESSION['user_name'] = $v['user_name'];
        $_SESSION['user_mobile'] = $v['user_mobile'];
        $_SESSION['user_address'] = $v['user_address'];
        $_SESSION['user_aadhaar'] = $v['user_aadhaar'];
        $_SESSION['login']=1;
    }
   /* echo "<pre>";
    print_r($v);
    print_r($isAdmin);
    exit;*/
    if($isAdmin==0) {

        if (isset($_GET['rid'])) {
          // echo "<pre>";
   //echo "string1";

            $url = base64_decode($_GET['rid']);
           /* echo $url;
            exit;*/

            header('Location: '.$url);
        }else{
          header('Location: index.php');
        }
    }else{
      $_SESSION['isAdmin']=1;
      $url = "kadmin/html/index.php";
   /* echo $url;
    exit;*/

      header('Location: '.$url);
    }
  }else{
    echo "<script>alert('Wrong Mobile No. or Password')</script>";
  }
}
?>
