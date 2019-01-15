<?php
require_once ('../../config/config.php');
if(!isset($_SESSION['islog']) or !$_SESSION['islog'] or $_SESSION['utype']!=1){
	header('Location: ../');
}
$tr1 = mysqli_fetch_array(mysqli_query($connection,"select * from school where id=".$_SESSION['school']));
if(isset($_POST['mosedt'])){
	$name = mysqli_real_escape_string($connection,$_POST['name']);
	$phone = mysqli_real_escape_string($connection,$_POST['phone']);

	$id = $_POST['mosid'];
	mysqli_query($connection,"update users set name='$name',phone='$phone' where id=$id");
	echo "<script>alert('Profile updated successfully');</script>";
}elseif(isset($_POST['mosdel'])){
	$id = $_SESSION['uid'];
	$pass = mysqli_fetch_array(mysqli_query($connection,"select password from users where id=$id"))['password'];
	$pass1 = mysqli_real_escape_string($connection,$_POST['pass1']);
	$pass2 = mysqli_real_escape_string($connection,$_POST['pass2']);
	$pass3 = mysqli_real_escape_string($connection,$_POST['pass3']);

	if($pass == $pass1){
		if($pass2 == $pass3){
			mysqli_query($connection,"update users set password='$pass2' where id=$id");
			echo "<script>alert('Password updated successfully');</script>";
		}else{
			echo "<script>alert('ERROR!: New password not matched. Check and try again.');</script>";
		}
	}else{
		echo "<script>alert('ERROR!: Old password is not correct. Check and try again.');</script>";
	}

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo APP_NAME; ?> :: Portal </title>

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
	<!-- Full Calendar -->
    <link href="../vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="../vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="">
    <div class="container body">

	  <div class="x_panel col-sm-10">
		<div class="x_title" style="font-family:Andalus;color:purple">
		  <h3 align="center">Welcome to Accounting Management System</h3><h2 align="center"><?php echo $_SESSION['uname'].' - '.$tr1['name']; ?></h2><br/>

		  <div class="clearfix"></div>
		</div>
		<div class="x_content">

		<div class="x_panel">
			<div class="x_title">
			  <h2><i class='fa fa-home'></i> Home Page</h2>
			  <ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
			  </ul>
			  <div class="clearfix"></div>
			</div>
			<div class="x_content">

        <!-- page content -->
        <div class="right_col" role="main" style="font-family:Andalus;font-size:18px">

		  <div class="row" style="font-family:Andalus;">
			<div class="col-md-12">
				<div class="x_panel">
                  <div class="x_title">
                    <h3 class="blue">Navigation <a href="../" class="pull-right blue fa fa-sign-out"> Sign out</a></h3>
				  </div>

					<a href="home" style="font-size:18px; color:a0a;" >
						<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="" style="font-size:30px;text-align:center;"><i class="fa fa-tachometer "></i><br/>Manager Dashboard </div>
							</div>
						</div>
					</a><!--
					<a href="#" data-toggle="modal" data-target=".new-sm2" style="font-size:18px; color:00f;" >
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="blue" style="font-size:30px;text-align:center;"><i class="fa fa-info "></i><br/>Introducing MLP </div>
							</div>
						</div>
					</a>
					<a href="#" data-toggle="modal" data-target=".new-sm3" style="font-size:18px; color:0f0;" >
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="green" style="font-size:30px;text-align:center;"><i class="fa fa-file "></i><br/>Records</div>
							</div>
						</div>
					</a>
					<a href="#" data-toggle="modal" data-target=".new-sm4" style="font-size:18px; color:f00;" >
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="red" style="font-size:30px;text-align:center;"><i class="fa fa-file-text-o "></i><br/>Brief Notes</div>
							</div>
						</div>
					</a>
					<a href="#" data-toggle="modal" data-target=".new-sm5" style="font-size:18px; color:#afa;" >
						<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="purple" style="font-size:30px;text-align:center;"><i class="fa fa-list-ol "></i><br/>Tables of Specification</div>
							</div>
						</div>
					</a> -->
					<a href="#" data-toggle="modal" data-target=".new-sm6" style="font-size:18px; color:#aa0;" >
						<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="black" style="font-size:30px;text-align:center;"><i class="fa fa-cog "></i><br/>Profile Settings</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="clearfix"></div>
		  </div>

		<br/><br/><br/><br/>
        </div></div></div>


        <!-- /page content -->
		</div>
		</div>

		<div class="modal fade new-sm6" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Profile Settings</h4>
					</div>
						<div class="modal-body">
							<h5><b>Profile Information</b></h5>
							<?php
						$qnx = mysqli_query($connection,"select * from users where id=".$_SESSION['uid']);
						$dn = mysqli_fetch_array($qnx);
						//$super = mysqli_fetch_array(mysqli_query($connection,"select name from users where id=".$dn['super']))['name'];
					  ?>
                         Username:<input type="text" name="name" value="<?php echo $dn['username']; ?>" class="form-control" disabled>
						 Password:<input type="text" name="name" value="******" class="form-control" disabled>
						 Full Name:<input type="text" name="name" value="<?php echo $dn['name']; ?>" class="form-control" disabled>
						 Phone Number:<input type="text" name="name" value="<?php echo $dn['phone']; ?>" class="form-control" disabled>
							<div class="ln_solid"></div>

						</div>
						<div class="modal-footer">
						  <a href='#' class='btn btn-warning btn-sm fa fa-user' data-toggle='modal' data-target='.edt-info'> Edit Info</a>
						  <a href='#' class='btn btn-primary btn-sm fa fa-cogs' data-toggle='modal' data-target='.edt-pass'> Change Password</a>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
				</div>
			</div>
		</div>

		<div class="modal fade edt-pass" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Password</h4>
					  <form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					</div>
						<div class="modal-body">
							<h5><b>Change Password</b></h5>
							Old Password<input type="password" name="pass1" maxlength="10" placeholder="Enter your old password" class="form-control" required="">
							New Password<input type="password" name="pass2" maxlength="10" placeholder="Enter your new password" class="form-control" required="">
							Repeat New Password<input type="password" name="pass3" maxlength="10" placeholder="Repeat your new password"  class="form-control"  required="">
							<div class="ln_solid"></div>
							<input type="hidden" name="mosdel" value="TRUE" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Change</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					  </form>
				</div>
			</div>
		</div>

		<div class="modal fade edt-info" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Edit Information</h4>
					  <form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					</div>	<?php
						$qnx = mysqli_query($connection,"select * from users where id=".$_SESSION['uid']);
						$dn = mysqli_fetch_array($qnx);
						//$super = mysqli_fetch_array(mysqli_query($connection,"select name from users where id=".$dn['super']))['name'];
					  ?>
						<div class="modal-body">
							<h5><b>Personal Information</b></h5>
							Full Name:<input type="text" name="name" value="<?php echo $dn['name']; ?>" class="form-control" required="">
							Phone Number:<input type="text" name="phone" value="<?php echo $dn['phone']; ?>"  class="form-control"  required="">
							Username:<input type="text" name="uname" value="<?php echo $dn['username']; ?>" class="form-control" disabled>
							<div class="ln_solid"></div>
							<input type="hidden" name="mosedt" value="TRUE" />
							<input type="hidden" name="mosid" value="<?php echo $dn['id']; ?>" />
							<input type="hidden" name="unamer" value="<?php echo $dn['username']; ?>" />
							<div class="ln_solid"></div>
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					  </form>
				</div>
			</div>
		</div>

		<br/><br/>
        <!-- footer content -->
        <footer style="">
          <div class="pull-right">
            <a href="<?php echo WEBSITE_URL; ?>"><?php echo APP_NAME; ?> :: Accounting Management System</a> &copy; <?php echo APP_YEAR; ?>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../vendors/fullcalendar/dist/fullcalendar.min.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
   <script src="../build/js/custom.min.js"></script>

  </body>
</html>
