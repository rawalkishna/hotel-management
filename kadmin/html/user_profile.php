<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['isAdmin']) || ($_SESSION['isAdmin']!=1)) {
        header('Location: ../../login.php');
    }
    require('db.php');
    ?>
<div class="navbar-nav align-items-center">
  <div class="nav-item d-flex align-items-center">
    <i class="bx bx-search fs-4 lh-0"></i>
    <input
      type="text"
      class="form-control border-0 shadow-none"
      placeholder="Search..."
      aria-label="Search..."
    />
  </div>
</div>

<li class="nav-item navbar-dropdown dropdown-user dropdown">
  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
    <div class="avatar avatar-online">
      <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
    </div>
  </a>
  <ul class="dropdown-menu dropdown-menu-end">
    <li>
      <a class="dropdown-item" href="#">
        <div class="d-flex">
          <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-online">
              <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
            </div>
          </div>
          <div class="flex-grow-1">
            <span class="fw-semibold d-block">John Doe</span>
            <small class="text-muted">Admin</small>
          </div>
        </div>
      </a>
    </li>
    <li>
      <div class="dropdown-divider"></div>
    </li>
    <!-- <li>
      <a class="dropdown-item" href="dash_account.php">
        <i class="bx bx-cog me-2"></i>
        <span class="align-middle">Settings</span>
      </a>
    </li> -->
    <li>
      <div class="dropdown-divider"></div>
    </li>
    <li>
      <a class="dropdown-item" href="../../login.php">
        <i class="bx bx-power-off me-2"></i>
        <span class="align-middle">Log Out</span>
      </a>
    </li>
  </ul>
</li>
