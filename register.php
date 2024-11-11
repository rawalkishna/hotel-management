<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <!-- <link rel="stylesheet" href="style.css"/> -->
    <style>
      body {
          background: #fff;
      }
      .form {
          margin: 50px auto;
          width: 500px;
          padding: 30px 25px;
          background: white;
      }
      h1.login-title {
          color: #666;
          margin: 0px auto 25px;
          font-size: 40px;
          font-weight: 300;
          text-align: center;
      }
      .login-input {
          font-size: 15px;
          border: 1px solid #000;
          padding: 18px;
          margin-bottom: 25px;
          height: 25px;
          width: calc(100% - 2px);
      }
      .login-input:focus {
          border-color:#6e8095;
          outline: none;
      }
      .login-button {
          color: #fff;
          background: #333333;
          border: 0;
          outline: 0;
          width: 100%;
          height: 50px;
          font-size: 16px;
          text-align: center;
          cursor: pointer;
      }
      .link {
          color: #666;
          font-size: 15px;
          text-align: center;
          margin-bottom: 0px;
      }
      .link a {
          color: #666;
      }
      h3 {
          font-weight: normal;
          text-align: center;
      }
      span.psw {
            float: right;
            padding-top: 16px;
          }
      @media screen and (max-width: 300px) {
            span.psw {
              display: block;
              float: none;
            }
            .login-buttonn {
              width: 100%;
            }
          }
    </style>

</head>
<body>
    <?php require 'header.php' ?>
<?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        // escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $mobile    = stripslashes($_REQUEST['mobile']);
        $mobile    = mysqli_real_escape_string($con, $mobile);
        $address    = stripslashes($_REQUEST['address']);
        $address    = mysqli_real_escape_string($con, $address);
        $citizenship    = stripslashes($_REQUEST['citizenship']);
        $citizenship    = mysqli_real_escape_string($con, $citizenship);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $query    = "INSERT into `tbl_user` (user_name, user_mobile, user_address, user_citizenship, user_password)
                     VALUES ('$username', '$mobile', '$address', '$citizenship', '" . md5($password) . "')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  </div>";
                  header('Location: login.php');
        } else {
            echo "<h3>Required fields are missing.</h3><br/>";
                  // header('Location: register.php');
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registration</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="tel" class="login-input" name="mobile" placeholder="Phone Number">
        <input type="text" class="login-input" name="address" placeholder="Address">
        <input type="text" class="login-input" name="citizenship" placeholder="Citizenship Number">
        <input type="password" class="login-input" name="password" placeholder="Password">
        <input type="password" class="login-input" name="con_password" placeholder="Confirm Password">
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="login.php">Click to Login</a></p>
    </form>
<?php
    }
?>
  <?php require 'footer.php' ?>
</body>
</html>
