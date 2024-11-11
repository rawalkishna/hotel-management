
        <?php require 'header.php' ?>
        <?php
       /* $_SESSION['login'] = 1;
        $_SESSION['user_id'] = 1;*/


            if (isset($_GET['room_id'])) {
                $room_id = base64_decode($_GET['room_id']);
            }else{
                header('Location: index.php');
            }
            if (!isset($_SESSION['login']) || ($_SESSION['login']!=1)) {
                $url = "booking.php?room_id=".base64_encode($room_id);
                header('Location: login.php?rid='.base64_encode($url));
            }
             $user_id=$_SESSION['user_id'];
        ?>
        <!-- Header-->
       
        <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        </nav> -->

        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
              
                     <?php require 'book.php' ?>
                </div>
            </div>
        </section>
        <?php require 'footer.php' ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
