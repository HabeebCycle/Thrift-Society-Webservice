<?php
require_once ('../config/config.php');
if(isset($_SESSION['islog'])){
	unset($_SESSION['islog'],$_SESSION['utype'],$_SESSION['school'],$_SESSION['uname'], $_SESSION['uid'], $_SESSION['name'], $_SESSION['phone']);
}else{

if (isset($_POST['logform'])) {
    // Initialize a session:

    if (empty($_POST['username'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $username = mysqli_real_escape_string($connection,$_POST['username']);
    }


    if (empty($_POST['password'])) {
        $f = 'fz1';
    } else {
        $password = $_POST['password'];
    }

    if (empty($f)){
		$req = mysqli_query($connection,"select * from users where username='$username'");
		$dn = mysqli_fetch_array($req);
		if(($dn['password']==$password) and mysqli_num_rows($req)>0){
			if($dn['ban']==0){
				$_SESSION['uname'] = $username;
				$_SESSION['uid'] = $dn['id'];
				$_SESSION['utype'] = $dn['utype'];
				$_SESSION['name'] = $dn['name'];
				$_SESSION['phone'] = $dn['phone'];
				$_SESSION['school'] = $dn['school'];
				$_SESSION['islog'] = true;
				if($dn['utype']==-1){
					header('Location: developer');
				}elseif($dn['utype']==0){
					header('Location: admin');
				}elseif($dn['utype']==1){
					header('Location: super');
				}elseif($dn['utype']==2){
					header('Location: home');
				}elseif($dn['utype']==3){
					header('Location: admin');
				}else{
					header('Location: ../');
				}
			}else{
				$f = 'fz3';
				header('Location: ?erz='.$f);
			}
		}else{
			$f = 'fz2';
			header('Location: ?erz='.$f);
		}
	}else{
		header('Location: ?erz='.$f);
	}

} // End of the main Submit conditional.
else{
@$msg=$_GET['erz'];
if(isset($msg)){
	if($msg == 'fz0'){
		$msg_err = 'ERROR! Username field is empty.';
	}elseif($msg == 'fz1'){
		$msg_err = 'ERROR! Password field is empty.';
	}elseif($msg == 'fz3'){
		$msg_err = 'ERROR! You have been banned from log in. Contact the administrator.';
	}elseif($msg == 'fz4'){
		$msg_err = 'ERROR! Your school has been archived and banned from log in. Contact your administrator.';
	}else{
		$msg_err = "ERROR! You have entered wrong username or password.";
	}
}
}}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="76x76" href="plan/assets/img/favicon.ico">
	<link rel="apple-touch-icon" sizes="76x76" href="plan/assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="plan/assets/img/favicon.png" />

    <title><?php echo APP_NAME; ?> :: Portal </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/animate.min.css" />

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
  <!-- Preloader -->
<div id="preloader">
<div id="loading-animation">&nbsp;</div>
</div>
<!-- /Preloader -->
    <div class="">
	  <h1 style='font-family:Andalus;text-align:center;' class=""><i class="fa fa-money"></i> <?php echo APP_NAME; ?>  <i class="fa fa-money"></i><br/><?php echo APP_ALIAS; ?></h1><h4 style='font-size:25px;color:purple;font-family:Andalus;text-align:center;'>Financial Details</h4>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form name="register" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <h1>Portal Login</h1>
			  <?php if(isset($msg_err)){ ?>
				  <div style="text-align:center;background-color:pink;border:2px #f00 solid; color:#f00; font-family:times new roman; text-size:25px">
					<?php echo $msg_err; ?>
				  </div>
			  <?php } ?>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
				<input type="hidden" name="logform" value="TRUE" />
                <button class="btn btn-default submit" name="submit" type="submit" value="Submit">Log in</button>
                <a class="reset_pass" href="#">Lost your password? contact your administrator</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  <a href="#" class=""> <b>About</b></a>| <a href="#" class=""> <b>New Registration</b></a>| <a href="#" class=""> <b>FAQs</b></a>| <a href="#" class=""> <b>Contact Us</b></a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <a href="<?php echo WEBSITE_URL; ?>">Accounting Management System</a> &copy; <?php echo APP_YEAR; ?>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>
