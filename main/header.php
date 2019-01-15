<?php
require_once ('../config/config.php');
if(!isset($_SESSION['islog']) and !$_SESSION['islog']){
	header('Location: ../');
}
$intd = mysqli_query($connection,"select * from messages where readr=0 and mtype!=0 and receipt=".$_SESSION['uid']." order by id desc limit 5");
$msg = mysqli_num_rows($intd);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Better Life :: Portal </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col  menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><i class="fa fa-"><img src="../assets/img/logo.png" width="24px" height="24px"/></i> <span>Application</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../assets/img/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><b><?php echo $_SESSION['name']; ?></b></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>MENU</h3>
                <ul class="nav side-menu">
				<?php if($_SESSION['utype']!=3){ ?>
                  <li><a><i class="fa fa-home"></i> Admin Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php">Dashboard</a></li>
					  <li><a href="members.php">Members' Account</a></li>
					  <li><a href="loans.php">Loans</a></li>
                    </ul>
                  </li>
				<?php } ?>
				  <li><a><i class="fa fa-user"></i> Member Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="users.php">Dashboard</a></li>
					  <li><a href="ledger.php">Ledger</a></li>
                    </ul>
                  </li>
				  <li><a><i class="fa fa-users"></i> Meetings <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<li><a href="member.php">Members</a></li>
                      <li><a href="meeting.php">Agenda/Minutes</a></li>
                    </ul>
                  </li>
				  <?php if($_SESSION['utype']!=3){ ?>
				  <li><a><i class="fa fa-money"></i> Recent Payment <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="payment.php">Payment Details</a></li>
                    </ul>
                  </li>
				  <li><a><i class="fa fa-microphone"></i> Application Access <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="access.php">Access Payment</a></li>
                    </ul>
                  </li>
				  <?php } ?>
				  <li><a><i class="fa fa-dashboard"></i> Message Board <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="messages.php">Notice/Messages</a></li>
                    </ul>
                  </li>
				  <li><a><i class="fa fa-cog"></i> Settings <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="proset.php">Account Settings</a></li>
                    </ul>
                  </li>
				  <li><a href="../index.php"><i class="fa fa-power-off"></i> Sign Out </a>
                  </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings" href="proset.php">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="../">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../assets/img/user.png" alt=""><?php echo $_SESSION['name']; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
					<li>
                      <a href="proset.php">
                        <span class="badge bg-red pull-right">*</span>
                        <span>Profile</span>
                      </a>
                    </li>
                    <li><a href="../"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

				<li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?php echo $msg; ?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
				  <?php while($dnk = mysqli_fetch_array($intd)){
				  $fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dnk['sender']));
				  ?>
                    <li>
                      <a href='messages.php?link=<?php echo $dnk['id']; ?>'>
                        <span class="image fa fa-envelope"></span>
                        <span>
                          <span><?php echo $fdp['name']; ?></span>
                          <span class="time"><?php echo date('D, d.m.Y',$dnk['date']); ?></span>
                        </span>
                        <span class="message">
                          <?php echo $dnk['title']; ?>
                        </span>
                      </a>
                    </li>
				  <?php } ?>
                    <li>
                      <div class="text-center">
                        <a href='messages.php'>
                          <strong>See All Messages</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
