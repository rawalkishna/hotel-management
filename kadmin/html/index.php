<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']!=1)) {
        header('Location: ../../login.php');
    }
    require('db.php');
    ?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Room Finder Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php require 'menu.php' ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->

              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">


                <!-- User -->
                <?php require 'user_profile.php' ?>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                      <!-- Content -->

                      <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                          <div class="col-lg-8 mb-4 order-0">
                            <div class="card">
                              <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                  <div class="card-body">
                                    <h5 class="card-title text-primary">Room Finder</h5>
                                    <p class="mb-4">
                                      Welcome to <span class="fw-bold">Room Finder,</span> Next Generation Room Rent Booking System.
                                    </p>

                                              </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                  <div class="card-body pb-0 px-0 px-md-4">
                                    <img
                                      src="../assets/img/illustrations/man-with-laptop-light.png"
                                      height="140"
                                      alt="View Badge User"
                                      data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                      data-app-light-img="illustrations/man-with-laptop-light.png"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 order-1">
                            <div class="row">
                              <div class="col-lg-6 col-md-12 col-6 mb-4">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                      <div class="avatar flex-shrink-0">
                                        <img
                                          src="../assets/img/icons/unicons/chart-success.png"
                                          alt="chart success"
                                          class="rounded"
                                        />
                                      </div>
                                      <div class="dropdown">
                                        <button
                                          class="btn p-0"
                                          type="button"
                                          id="cardOpt3"
                                          data-bs-toggle="dropdown"
                                          aria-haspopup="true"
                                          aria-expanded="false"
                                        >
                                          </button>
                                        <!-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                          <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                          <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div> -->
                                      </div>
                                    </div>
                                    <span>Total Room</span>

                                    <h3 class="card-title text-nowrap mb-1">
                                      <?php
                                        require('db.php');
                                        //$result=mysql_query($con,"SELECT * from tble_room;");
                                        $sql = "SELECT * FROM tbl_room where isDeleted=0";
                                        $result = mysqli_query($con, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $r = mysqli_num_rows($result);
                                        echo $r;
                                      ?>
                                    </h3>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-6 col-md-12 col-6 mb-4">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                      <div class="avatar flex-shrink-0">
                                        <img
                                          src="../assets/img/icons/unicons/wallet-info.png"
                                          alt="Credit Card"
                                          class="rounded"
                                        />
                                      </div>
                                      <div class="dropdown">
                                        <button
                                          class="btn p-0"
                                          type="button"
                                          id="cardOpt6"
                                          data-bs-toggle="dropdown"
                                          aria-haspopup="true"
                                          aria-expanded="false"
                                        >
                                        </button>
                                        <!-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                          <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                          <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div> -->
                                      </div>
                                    </div>
                                    <span>Total Booking</span>
                                    <h3 class="card-title text-nowrap mb-1">
                                      <?php
                                        require('db.php');
                                        //$result=mysql_query($con,"SELECT * from tble_room;");
                                        $sql = "SELECT * FROM tbl_room where isBooked=1";
                                        $result = mysqli_query($con, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $r = mysqli_num_rows($result);
                                        echo $r;
                                      ?>
                                    </h3>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
            <!-- Content -->

            <!-- / Content -->

            <!-- Footer -->
            <?php require 'dash_footer.php' ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>

          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
