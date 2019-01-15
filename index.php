<?php
require_once ('config/config.php');
$ddd = date('m-Y',time());
$qnx = mysqli_query($connection,"select * from access");
while($dn = mysqli_fetch_array($qnx)){
	$pay = explode("#",$dn['paid']);
	$len = count($pay);
	$jk = false;
	for($i=1;$i<$len;$i++){
		if($pay[$i] == $ddd){
			$jk = true;
			break;
		}
	}
	if($jk){
		mysqli_query($connection,"update users set ban=0 where id=".$dn['user']);
	}else{
		mysqli_query($connection,"update users set ban=1 where id=".$dn['user']);
	}
}
mysqli_query($connection,"update loans set complete=1,date2=".time()." where amount2=amount3");
if(isset($_SESSION['islog'])){
	unset($_SESSION['islog'], $_SESSION['utype'], $_SESSION['uorg'], $_SESSION['ureg'], $_SESSION['uid'], $_SESSION['name']);
}else{

if (isset($_POST['logform'])) {
    // Initialize a session:

    if (empty($_POST['unum'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $unum = mysqli_real_escape_string($connection,$_POST['unum']);
    }


    if (empty($_POST['upin'])) {
        $f = 'fz1';
    } else {
        $upin = $_POST['upin'];
    }

    if (empty($f)){
		$req = mysqli_query($connection,"select * from users where regno='".$unum."'");
		$dn = mysqli_fetch_array($req);
		if(($dn['pin']==$upin) and mysqli_num_rows($req)>0){
			if($dn['ban']==0){
				$_SESSION['ureg'] = $unum;
				$_SESSION['uid'] = $dn['id'];
				$_SESSION['name'] = $dn['name'];
				$_SESSION['utype'] = $dn['utype'];
				$_SESSION['uorg'] = $dn['org'];
				$_SESSION['islog'] = true;
				mysqli_query($connection,"update users set active=1 where id=".$dn['id']);
				if($dn['utype']==2 or $dn['utype']==1){
					header('Location: main');
				}else{
					header('Location: main/users.php');
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
}else{
@$msg=$_GET['erz'];
if(isset($msg)){
	if($msg == 'fz0'){
		$msg_err = 'User number field is empty.';
	}elseif($msg == 'fz1'){
		$msg_err = 'User pin field is empty.';
	}elseif($msg == 'fz3'){
		$msg_err = 'You have been banned from log in. Pay your app due.';
	}elseif($msg == 'fz4'){
		$msg_err = 'Password not the same. Check and try again';
	}elseif($msg == 'fz5'){
		$msg_err = 'Your password must be more than 6 characters.';
	}elseif($msg == 'fz6'){
		$msg_err = 'Username already exists, use another username.';
	}elseif($msg == 'fz7'){
		$msg_suc = 'Registration was successful. You can now login.';
	}else{
		$msg_err = 'You have entered wrong user number or pin.';
	}
}
}}
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->
<head>
     <meta charset="UTF-8" />
    <title>Admin Dashboard | Login Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
     <!-- PAGE LEVEL STYLES -->
     <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/login.css" />
    <link rel="stylesheet" href="assets/plugins/magic/magic.css" />
     <!-- END PAGE LEVEL STYLES -->
   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body >

   <!-- PAGE CONTENT -->
    <div class="container">
    <div class="text-center">
        <img src="assets/img/logo.png" id="logoimg" alt=" Logo" />
    </div>

    <div class="tab-content">
        <div id="login" class="tab-pane active">
		<?php if(isset($msg_err)){ ?>
				  <p class="text-muted text-center btn-block btn btn-danger btn-rect">
					<?php echo $msg_err; ?>
				  </p>
			  <?php } ?><br/>
            <form action="" method="post" class="form-signin">
                <p class="text-muted text-center btn-block btn btn-primary btn-rect">
                    Enter your user number and pin
                </p>
                <input type="text" placeholder="User Number" name="unum"  class="form-control" />
                <input type="password" placeholder="User Pin" name="upin"class="form-control" />
				<input type="hidden" name="logform" value="TRUE" />
                <button class="btn text-muted text-center btn-danger" type="submit">Sign in</button>
            </form>
        </div>
        <div id="forgot" class="tab-pane">
            <form action="" method="post" class="form-signin">
                <p class="text-muted text-center btn-block btn btn-primary btn-rect">Enter your name and phone number</p>
                <input type="text"  required="required" name="name" placeholder="Your full name"  class="form-control" />
				<input type="text"  required="required" name="phone" placeholder="Your phone number"  class="form-control" />
                <br />
                <button class="btn text-muted text-center btn-success" type="submit">Recover sign in details</button>
            </form>
        </div>
    </div>
    <div class="text-center">
        <ul class="list-inline">
            <li><a class="text-muted" href="#login" data-toggle="tab">Login</a></li>
            <li><a class="text-muted" href="#forgot" data-toggle="tab">Forgot Number/Pin</a></li>
        </ul>
    </div>


</div>

	  <!--END PAGE CONTENT -->

      <!-- PAGE LEVEL SCRIPTS -->
      <script src="assets/plugins/jquery-2.0.3.min.js"></script>
      <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>
   <script src="assets/js/login.js"></script>
      <!--END PAGE LEVEL SCRIPTS -->

</body>
    <!-- END BODY -->
</html>
