<?php 
require_once('config.php');
session_start();

if(!isset($_SESSION['admin_loggedin'])){
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php">
          <b><h3 style="color:purple;">PSMS Admin</h3></b>
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.php"> <h4 style="color:purple;">&nbsp PSMS</h4></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="images/faces/admin.jpg" alt="image">
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo $_SESSION['admin_loggedin'][0]['name']; ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-settings mr-2 text-success"></i>
                Settings
              </a>
              <a class="dropdown-item" href="change-password.php">
                <i class="mdi mdi-lock mr-2 text-success"></i>
                Change Password
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">
                <i class="mdi mdi-logout mr-2 text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          <!-- <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li> -->
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <i class="mdi mdi-email-outline"></i>
              <span class="count-symbol bg-warning"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <h6 class="p-3 mb-0">Messages</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                  <p class="text-gray mb-0">
                    1 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                  <p class="text-gray mb-0">
                    15 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                  <p class="text-gray mb-0">
                    18 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">4 new messages</h6>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count-symbol bg-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0">Notifications</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-calendar"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                  <p class="text-gray ellipsis mb-0">
                    Just a reminder that you have an event today
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-settings"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                  <p class="text-gray ellipsis mb-0">
                    Update dashboard
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-link-variant"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                  <p class="text-gray ellipsis mb-0">
                    New admin wow!
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">See all notifications</h6>
            </div>
          </li>
          <!-- <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-format-line-spacing"></i>
            </a>
          </li> -->
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-6" aria-expanded="false" aria-controls="ui-6">
              <span class="menu-title">Class Routine</span>
              <i class="menu-arrow"></i>
              <i class=" mdi mdi-kodi menu-icon"></i>
            </a>
            <div class="collapse" id="ui-6">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="routine-all.php">All Routine</a></li>
                <li class="nav-item"> <a class="nav-link" href="routine-add-new.php">Add New Routine</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-5" aria-expanded="false" aria-controls="ui-5">
              <span class="menu-title">Classes</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-library menu-icon"></i>
            </a>
            <div class="collapse" id="ui-5">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="class-all.php">All Class</a></li>
                <li class="nav-item"> <a class="nav-link" href="class-add-new.php">Add New Class</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-4" aria-expanded="false" aria-controls="ui-4">
              <span class="menu-title">Subject</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-book-multiple-variant menu-icon"></i>
            </a>
            <div class="collapse" id="ui-4">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="subject-all.php">All Subjects</a></li>
                <li class="nav-item"> <a class="nav-link" href="subject-add-new.php">Add New Subjects</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-title">Students</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="student-all.php">All Students</a></li>
                <li class="nav-item"> <a class="nav-link" href="attendance.php">Attendance</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Search</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Result</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-2" aria-expanded="false" aria-controls="ui-2">
              <span class="menu-title">Teachers</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-contacts menu-icon"></i>
            </a>
            <div class="collapse" id="ui-2">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="teacher-all.php">All Teachers</a></li>
                <li class="nav-item"> <a class="nav-link" href="teacher-add-new.php">Add New Teacher</a></li>
                <li class="nav-item"> <a class="nav-link" href="teacher-assign-subject.php">Assign Subject</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-7" aria-expanded="false" aria-controls="ui-7">
              <span class="menu-title">Student Marks</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-certificate menu-icon"></i>
            </a>
            <div class="collapse" id="ui-7">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="student-marks.php">Student Marks</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-3" aria-expanded="false" aria-controls="ui-3">
              <span class="menu-title">Payments</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-bank menu-icon"></i>
            </a>
            <div class="collapse" id="ui-3">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="">Teachers Payments</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Students Payments</a></li>
              </ul>
            </div>
          </li>
         
          <!-- <li class="nav-item">
            <a class="nav-link" href="pages/tables/basic-table.html">
              <span class="menu-title">Tables</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
          </li> -->
         
          
        </ul>
      </nav>