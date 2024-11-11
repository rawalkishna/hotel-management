<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']!=1)) {
        header('Location: ../../login.php');
    }
    require('db.php');
// When form submitted, insert values into the database.
// if (isset($_REQUEST['username'])) {
    // removes backslashes
    $title = stripslashes($_REQUEST['title']);
  //  $title    = mysqli_real_escape_string($con, $title);
    $type  = stripslashes($_REQUEST['type']);
    //$type    = mysqli_real_escape_string($con, $type);
    $price    = stripslashes($_REQUEST['price']);
  //  $price    = mysqli_real_escape_string($con, $price);
    $location    = stripslashes($_REQUEST['location']);
  //  $location    = mysqli_real_escape_string($con, $location);
    $keywords = stripslashes($_REQUEST['keywords']);
  //  $keywords = mysqli_real_escape_string($con, $keywords);
    $v=$_SESSION['user_id'];
    $query    = "INSERT into `tbl_room` (room_title, room_type , room_price , room_location, room_srch_key_words,room_owner_user_id)
                 VALUES ('$title', '$type','$price','$location','$keywords','$v')";
    $result   = mysqli_query($con, $query);
    // echo "$query";
    if ($result) {
        echo "<div class='form'>
              <h3>Room added successfully.</h3><br/>
              </div>";
        header('Location: roomlist.php');
    }
    else {
        echo "<h3>Required fields are missing.</h3><br/>";
              header('Location: add_room.php');
    }
  //}
  ?>
