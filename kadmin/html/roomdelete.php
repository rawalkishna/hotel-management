<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']!=1)) {
        header('Location: ../../login.php');
    }
    require('db.php');
    $query="update tbl_room set isDeleted=1 where room_id=".base64_decode($_GET['id']);
    // echo $query;
    // exit;
    $run=mysqli_query($con,$query);
    header('Location: roomlist.php');
    ?>
