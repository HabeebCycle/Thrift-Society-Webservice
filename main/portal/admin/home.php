<?php
require_once ('../../config/config.php');
require("../../config/site_func.php");
if(!isset($_SESSION['islog']) or !$_SESSION['islog'] or ($_SESSION['utype']!=0 and $_SESSION['utype']!=3)){
	header('Location: ../');
}
	$uid = $_SESSION['uid'];
	$inv = mysqli_fetch_array(mysqli_query($connection,"select id from users order by id desc limit 1"))['id'] + 1;
	$s_funx = new SiteFunction();
	$codex = $s_funx -> get_staff_number($inv);

	if(isset($_POST['cem1'])){
		$name = mysqli_real_escape_string($connection,$_POST['name']);
		$phone = mysqli_real_escape_string($connection,$_POST['phone']);
		$address = mysqli_real_escape_string($connection,$_POST['address']);
		$super = $_POST['super'];

		$cem = mysqli_num_rows(mysqli_query($connection,"select * from school where name='$name' and super=$super and phone='$phone' and address='$address'"));
		if($cem>0){
			echo "<script>alert('Branch name already registered.');</script>";
		}else{
			mysqli_query($connection,"insert into school (name,phone,address,super) values ('$name','$phone','$address',$super)");
			$idy = mysqli_fetch_array(mysqli_query($connection, "select id from school where name='$name' and super=$super and phone='$phone' and address='$address'"))['id'];
			mysqli_query($connection,"update users set school=$idy where id=$super");
			echo "<script>alert('$name branch has been registered successfully');</script>";
		}
	}elseif(isset($_POST['cem2'])){
		$name = mysqli_real_escape_string($connection,$_POST['name']);
		$uname = mysqli_real_escape_string($connection,$_POST['uname']);
		$pass = mysqli_real_escape_string($connection,$_POST['pass']);
		$phone = mysqli_real_escape_string($connection,$_POST['phone']);
		$utype = $_POST['utype'];

		$cem = mysqli_num_rows(mysqli_query($connection,"select * from users where username='$uname'"));
		if($cem>0){
			echo "<script>alert('Username already exist. Try another username.');</script>";
		}else{
			mysqli_query($connection,"insert into users (name,username,password,utype,phone,super) values ('$name','$uname','$pass',$utype,'$phone',$uid)");
			echo "<script>alert('$uname has been registered successfully');</script>";
		}
	}elseif(isset($_POST['cem3'])){
		$credits = mysqli_real_escape_string($connection,$_POST['credits']);
		$details = mysqli_real_escape_string($connection,$_POST['details']);
		$school = mysqli_real_escape_string($connection,$_POST['school']);
		$word = mysqli_real_escape_string($connection,$_POST['word']);
		$dreg = time();
		$per = mysqli_fetch_array(mysqli_query($connection,"select * from school where id=$school"));
		$usr = mysqli_fetch_array(mysqli_query($connection,"select * from users where id=$uid")); $wc=$usr['name']; $wz=$usr['username'];
		$mcred = -1 * $credits;
		$det = $details."\n".($credits<0?"Deducted &#8358;$mcred":"Added &#8358;$credits")." by $wz - $wc (Headquarter) on ".date('D, d.m.Y h:i:s A',($dreg-3600));
		$dex = $det."\n____________\n\r".$per['details'];
		$credx = $per['credit'] - $per['debit'];
		if($credits != 0){
			if(($credits < 0) and ($mcred > $credx)){
				echo "<script>alert('ERROR! Branch dont have upto &#8358; $mcred');</script>";
			}else{
				if($credits < 0){
					mysqli_query($connection,"update school set debit=debit+$mcred, details='$dex' where id=$school");
					mysqli_query($connection,"insert into transaction (date,ref,user,school,ttype,amount,details,approval) values ($dreg,'$school$dreg',$uid,$school,4,$mcred,'$det',$uid)");
					echo "<script>alert('#$mcred ($word) debited successfully');</script>";
				}else{
					mysqli_query($connection,"update school set credit=credit+$credits, details='$dex' where id=$school");
					mysqli_query($connection,"insert into transaction (date,ref,user,school,ttype,amount,details,approval) values ($dreg,'$school$dreg',$uid,$school,3,$credits,'$det',$uid)");
					echo "<script>alert('#$credits ($word) credited successfully');</script>";
				}
			}
		}else{
			echo "<script>alert('ERROR! Cannot add/deduct zero value');</script>";
		}
	}elseif(isset($_POST['cem4'])){
		$receipt = mysqli_real_escape_string($connection,$_POST['receipt']);
		$title = mysqli_real_escape_string($connection,$_POST['title']);
		$message = mysqli_real_escape_string($connection,$_POST['message']);
		$dreg = time();
		$sender = $_SESSION['uid'];
		if($receipt==-1){
			$adm = mysqli_query($connection, "select * from school");
			while($dc = mysqli_fetch_array($adm)){
				$rex = $dc['super'];
				mysqli_query($connection,"insert into messages (mtype,sender,receipt,date,title,message) values (1,$sender,$rex,$dreg,'$title','$message')");
			}
			$msgg = $message."\n\nSent to: ALL Managers";
			mysqli_query($connection,"insert into messages (sender,receipt,date,title,message) values ($sender,-1,$dreg,'$title','$msgg')");
			echo "<script>alert('Message sent successfully');</script>";
		}elseif($receipt==-2){
			$adm = mysqli_query($connection, "select * from users where utype=3");
			while($dc = mysqli_fetch_array($adm)){
				$rex = $dc['id'];
				mysqli_query($connection,"insert into messages (mtype,sender,receipt,date,title,message) values (1,$sender,$rex,$dreg,'$title','$message')");
			}
			$msgg = $message."\n\nSent to: ALL Admins";
			mysqli_query($connection,"insert into messages (sender,receipt,date,title,message) values ($sender,-1,$dreg,'$title','$msgg')");
			echo "<script>alert('Message sent successfully');</script>";
		}else{
			mysqli_query($connection,"insert into messages (sender,receipt,date,title,message) values ($sender,$receipt,$dreg,'$title','$message')");
			echo "<script>alert('Message sent successfully');</script>";
		}
	}
	$date = date('d/m/Y', time());
	list($dd,$mm,$yy)=explode('/',$date);
	$rdate = mktime(0,0,0,$mm,$dd,$yy);
	$nmsg = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM messages where receipt=$uid and status=0"));
	$cel = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM school"));
	$cut = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM school where credit>debit"));
	$cem = mysqli_num_rows(mysqli_query($connection,"select * from users where utype=2"));
    $ces = mysqli_num_rows(mysqli_query($connection,"select * from users where utype=1"));
	$cev = mysqli_num_rows(mysqli_query($connection,"select * from users where utype=3"));
	$cen = mysqli_num_rows(mysqli_query($connection,"select * from transaction where date>$rdate"));
	$cep = mysqli_num_rows(mysqli_query($connection,"select * from transaction"));
	$cex = mysqli_fetch_array(mysqli_query($connection,"select sum(credit) as cex from school"))['cex'];
	$cet = mysqli_fetch_array(mysqli_query($connection,"select sum(debit) as cet from school"))['cet'];
	$ava = $cex - $cet;
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
		  <h3>Dashboard <small class="red">Admin Panel</small> - <?php echo ucwords($_SESSION['uname']); ?><a href="index" class="pull-right blue fa fa-sign-out"> Home</a></h3>

		  <div class="clearfix"></div>
		</div>
		<div class="x_content">

		<div class="x_panel">
			<div class="x_title">
			  <h2>Panel Information</h2>
			  <ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
			  </ul>
			  <div class="clearfix"></div>
			</div>
			<div class="x_content">

        <!-- page content -->
        <div class="right_col" role="main" style="font-family:Andalus;font-size:18px">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count"><a href='?cl=1#tables'>
              <center><span class="count_top"><i class="fa fa-users"></i> Branches </span><br/>
              <div class="count green btn btn-default"><?php echo $cel; ?></div><br/>
			  <span class="count_bottom">  Cash Available: <i class="red"> <?php echo $cut>0?$cut:0; ?> </i> </span>
			  </center></a>
            </div>
			<div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count"><a href='?cl=2#tables'>
              <center><span class="count_top"><i class="fa fa-user"></i> All Staff </span><br/>
              <div class="count green btn btn-default"><?php echo $cem+$ces; ?></div><br/>
			  <span class="count_bottom"> Admin/Supervisor: <i class="red"> <?php echo $cev.' / '.$ces; ?> </i> </span>
			  </center></a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count"><a href='?cl=3#tables'>
              <center><span class="count_top"><i class="fa fa-book"></i> Today Transactions </span><br/>
              <div class="count green btn btn-default"><?php echo $cen; ?></div><br/>
			  <span class="count_bottom"> Transactions: <i class="red"> <?php echo $cep>0?$cep:0; ?> </i> </span>
			  </center></a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 tile_stats_count"><a href='?cl=4#tables'>
              <center><span class="count_top"><i class="fa fa-money"></i> Available Balance &#8358; </span><br/>
              <div class="green btn btn-default btn-xs" style='font-size:12px;font-style:regular'><?php echo number_format($ava,2); ?></div></a><br/>
			  <span class="count_bottom"> Cr.: <i class="red"> <?php echo $cex>0?$cex:0; ?> </i> </span><br/>
			  <span class="count_bottom"> Dr.: <i class="red"> <?php echo $cet>0?$cet:0; ?> </i> </span>
			  </center></a>
            </div>
          </div>
          <!-- /top tiles -->

		  <div class="row" style="font-family:Andalus;">
			<div class="col-md-12">
				<div class="x_panel">
                  <div class="x_title">
                    <h3 class="blue">Navigation </h3>
				  </div>

					<a href="#" data-toggle="modal" data-target=".new-sm1" style="font-size:18px; color:a0a;" >
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="" style="font-size:30px;text-align:center;"><i class="fa fa-building "></i><br/>Add Branch </div>
							</div>
						</div>
					</a>
					<a href="#" data-toggle="modal" data-target=".new-sm2" style="font-size:18px; color:00f;" >
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="blue" style="font-size:30px;text-align:center;"><i class="fa fa-user "></i><br/>Add Admin/Super </div>
							</div>
						</div>
					</a>
					<a href="#" data-toggle="modal" data-target=".new-sm3" style="font-size:18px; color:0f0;" >
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="green" style="font-size:30px;text-align:center;"><i class="fa fa-money "></i><br/>Add Money </div>
							</div>
						</div>
					</a>
					<a href="#" data-toggle="modal" data-target=".new-sm4" style="font-size:18px; color:f00;" onclick='showM(1);'>
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="red" style="font-size:30px;text-align:center;"><i class="fa fa-envelope "></i><br/>Messages (<small id='tv1'><?php echo $nmsg; ?></small>)</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="clearfix"></div>
		  </div>

        </div></div></div>

		<div class="x_panel">
			<div class="x_title">
			  <h2>Details</h2>
			  <ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
			  </ul>
			  <div class="clearfix"></div>
			</div>
			<div class="x_content">
		<div class="row" id="tables">
			<?php
			@$cl = $_GET['cl'];
			if(!isset($cl)){
				$cl = 1;
			}
			if($cl==1)
				include_once ('regschool.php');
			elseif($cl==2)
				include_once ('reguser.php');
			elseif($cl==3)
				include_once ('regplan.php');
			elseif($cl==4)
				include_once ('regcredit.php');
			?>

			<div class="clearfix"></div>
        </div></div></div>
        <!-- /page content -->
		</div>
		</div>

		<div class="modal fade new-sm1" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Register a new branch</h4>
					</div>
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=1#tables">
						<div class="modal-body">
							<h5>Fill all the fields</h5>
							Name:<input type="text" name="name" placeholder="Enter the branch name" class="form-control" required="">
							Phone:<input type="text" name="phone" placeholder="Enter the branch phone number" class="form-control" required="">
							Address:<textarea name="address" class="form-control" placeholder="Supply address of the branch"></textarea>
							Branch Manager:<select name="super" class="form-control" required="" onchange=''><option value="" disabled>Select Branch Supervisor</option>
							<?php
								$qns = mysqli_query($connection,"SELECT * FROM users WHERE utype=1 and school=0");
								while($dns = mysqli_fetch_array($qns)){ ?>
								<option value="<?php echo $dns['id']; ?>"><?php echo $dns['name']; ?></option>
								<?php } ?>
							</select>
							<div class="ln_solid"></div>
							<input type="hidden" name="cem1" value="TRUE" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade new-sm2" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Register a new user</h4>
					</div>
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=2#tables">
						<div class="modal-body">
							<h5>Fill all the fields</h5>
							Staff No.:<input type="text" name="uname" value="<?php echo $codex; ?>" class="form-control" readonly>
							Password:<input type="text" name="pass" placeholder="Enter login password" class="form-control" required="">
							Full Name:<input type="text" name="name" placeholder="Enter full name" class="form-control" required="">
							Phone:<input type="text" name="phone" placeholder="Enter user's phone number" class="form-control" required="">
							<br/>
							User's Role:<select name="utype" class="form-control" required="" onchange=''><option value="" disabled>Select User Role</option><option value="1">Manager/Supervisor</option><?php if($_SESSION['utype']==0){ ?><option value="3">Administrator</option><?php } ?>
							<div class="ln_solid"></div>
							<input type="hidden" name="cem2" value="TRUE" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade new-sm3" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Add Money</h4>
					</div>
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=4#tables">
						<div class="modal-body">
							<h5>Fill all the fields</h5>
							Branch:<select name="school" class="form-control" required=""><option value="">Select Branch</option>
								<?php
								$qns = mysqli_query($connection,"SELECT * FROM school");
								while($dns = mysqli_fetch_array($qns)){ ?>
								<option value="<?php echo $dns['id']; ?>" title="Balance: &#8358; <?php echo number_format(($dns['credit']-$dns['debit']),2); ?>"><?php echo $dns['name']; ?></option>
								<?php } ?>
							</select>
							<br/>

							Amount (&#8358;): <small class='red'>(negative value to deduct)</small><input type="text" name="credits" placeholder="Enter amount to add" class="form-control" required="" onblur="checkC(this.value);">
							<small>(Add minus sign to subtract e.g. -5000)</small><br/><small id='word1' class='blue'><i>&#8358;</i></small><br/>
							Description:<textarea name="details" placeholder="Enter details about the money" class="form-control"></textarea>
							<div class="ln_solid"></div>
							<input type="hidden" id='word2' name="word" value="Zero" />
							<input type="hidden" name="cem3" value="TRUE" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Money</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<script type='text/javascript'>
			function showM(id){
				if(id==1){
					document.getElementById('sent1').style.display = "none";
					document.getElementById('inbox1').style.display = "inline";
				}else{
					document.getElementById('sent1').style.display = "inline";
					document.getElementById('inbox1').style.display = "none";
				}
			}
			function enterRex(id){
				if(id==-2){
					document.getElementById('rex1').required = true;
					document.getElementById('rex1').style.display="inline";
				}else{
					document.getElementById('rex1').required = false;
					document.getElementById('rex1').style.display="none";
				}
			}
			function checkC(val){
				if(val<0){
					val = -1.0 * val;
				}
				if(val>0){
					url = "../getnew.php?idx=1&value="+val;
					if(window.XMLHttpRequest){
						xmlhttp = new XMLHttpRequest();
						xmlhttp.open("GET",url,false);
						xmlhttp.send(null);
					}else{
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						xmlhttp.open("GET",url,false);
						xmlhttp.send();
					}
					document.getElementById('word1').innerHTML = xmlhttp.responseText
					document.getElementById('word2').value = xmlhttp.responseText
				}
			}
			function msgStat(msg){
				url = "../getnew.php?idx=3&msg="+msg;
				if(window.XMLHttpRequest){
					xmlhttp = new XMLHttpRequest();
					xmlhttp.open("GET",url,false);
					xmlhttp.send(null);
				}else{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					xmlhttp.open("GET",url,false);
					xmlhttp.send();
				}
				document.getElementById('tv1').innerHTML = xmlhttp.responseText
				document.getElementById('tv2').innerHTML = xmlhttp.responseText
			}
		</script>
		<div class="modal fade new-sm4" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-md" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Messages</h4>
					</div>
						<div class="modal-body">
							<h4><a class='btn btn-success btn-sm' href='#' onclick='showM(1);'>Message Inbox (<span id='tv2'><?php echo $nmsg; ?></span>)</a> &nbsp;&nbsp; <a class='btn btn-info btn-sm' href='#' onclick='showM(2);'>Sent Messages</a></h4>	<div class="ln_solid"></div>
							<div id='inbox1'>
							<h4>Inbox</h4>
								<?php
								$qns = mysqli_query($connection,"SELECT * FROM messages where receipt=$uid order by date desc");
								$num1 = mysqli_num_rows($qns);
								if($num1>0){ ?>
									<div style="overflow-y:auto;width:98%;height:350px;padding:10px;border: 2px solid #777;">
								<?php while($dns = mysqli_fetch_array($qns)){
									$t1 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id = ".$dns['sender']));
									$tr = ($t1['school']==0?array('name'=>'From Headquarter'): mysqli_fetch_array(mysqli_query($connection,"select * from school where id = ".$t1['school'])));
								?>
									<h2 style="font-size:13px;font-family:Andalus;"><span class="red fa fa-clock-o"> <?php echo date('D d.m.Y h:i A',$dns['date']); ?> </span> &nbsp; <span class="right fa fa-user"> <i><?php echo $tr['name']; ?></i></span></h2>
									<a href='#' class="" data-toggle="modal" data-target=".msg<?php echo $dns['id']; ?>" onclick="msgStat(<?php echo $dns['id']; ?>);"><p align='' style="font-size:13px;color:purple;"><?php echo ($dns['status']==0?"* <b>":"<i>").$dns['title'].($dns['status']==0?"</b>":"</i>"); ?></p><p style='color:#8b8b8b;font-size:13px;'><?php echo wordwrap(substr($dns['message'],0,100).' ...',100,"<br>\n"); ?></p></a><hr color="#888">
						        <?php } echo "</div>"; }else{ echo "<b class='blue fa fa-envelope'> You have no inbox message </b>"; } ?>
						    </div>
							<div id='sent1'>
							<h4>Sent Messages</h4>
								<?php
								$qns = mysqli_query($connection,"SELECT * FROM messages where sender=$uid and mtype=0 order by date desc");
								$num1 = mysqli_num_rows($qns);
								if($num1>0){ ?>
									<div style="overflow-y:auto;width:98%;height:350px;padding:10px;border: 2px solid #777;">
								<?php while($dns = mysqli_fetch_array($qns)){ //e 467
									$t1 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id = ".$dns['receipt']));
									$tr = ($dns['receipt']==-1?'':mysqli_fetch_array(mysqli_query($connection,"select * from school where id = ".$t1['school'])));
								?>
									<h2 style="font-size:13px;font-family:Andalus;"><span class="red fa fa-clock-o"> <?php echo date('D d.m.Y h:i A',$dns['date']); ?> </span> &nbsp; <span class="right fa fa-user"> <i><?php echo $dns['receipt']==-1?"ALL":$tr['name']; ?></i></span></h2>
									<a href='#' class="" data-toggle="modal" data-target=".msg<?php echo $dns['id']; ?>"><p align='' style="font-size:13px;color:black;"><b><?php echo $dns['title']; ?></b></p><p style='color:#8b8b8b;font-size:13px;'><?php echo wordwrap(substr($dns['message'],0,100).' ...',100,"<br>\n"); ?></p></a><hr color="#888">
								<?php } echo "</div>"; }else{ echo "<b class='blue fa fa-envelope'> You have no sent message </b>"; } ?>
							</div>
						</div>
						<div class="modal-footer">
						  <a href='#' class="btn btn-primary" data-toggle="modal" data-target=".new-msg" onclick='enterRex(0);'>Compose</a>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
				</div>
			</div>
		</div>

		<?php
		$qns = mysqli_query($connection,"SELECT * FROM messages where (sender=$uid and mtype=0) or receipt=$uid order by date desc");
		while($dns = mysqli_fetch_array($qns)){
			$t1 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id = ".$dns['sender']));
			$t2 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id = ".$dns['receipt']));
			$tr1 = ($t1['school']==0?array('name'=>'From Headquarter'): mysqli_fetch_array(mysqli_query($connection,"select * from school where id = ".$t1['school'])));
			$tr2 = ($t2['school']==0?array('name'=>'From Headquarter'): mysqli_fetch_array(mysqli_query($connection,"select * from school where id = ".$t2['school']))); ?>
		<div class="modal fade msg<?php echo $dns['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-md" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2"><?php $dns['receipt']==1?'Inbox Message':'Sent Message'; ?></h4>
					</div>
						<div class="modal-body">
							<h5><b><?php echo $dns['title']; ?></b></h5>
							<h2 style="font-size:12px;font-family:Andalus;"><span class="red fa fa-clock-o"> <?php echo $dns['sender']==1?'Sent on ':''; ?><?php echo date('D d.m.Y',$dns['date']); ?> </span> &nbsp; <span class="right fa fa-user"> <i><?php echo $dns['receipt']==1?'From: ':'To: '; ?><?php echo ($dns['receipt']==1?($t1['name']." (".$t1['username'].")<br/>".$tr1['name']):($t2['name']." (".$t2['username'].")<br/>".$tr2['name'])); ?></i></span></h2>
							<div style="overflow-y:auto;width:98%;height:280px;padding:10px;border: 2px solid #777;">
								<p style='font-size:15px;'><?php echo nl2br($dns['message']); ?></p>
							</div>
							<div class="ln_solid"></div>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
						</div>
		</div></div></div><?php } ?>

		<div class="modal fade new-msg" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Compose New Message</h4>
					</div>
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=1#tables">
						<div class="modal-body">
							<h5>Fill all the fields</h5>
							To:<select name="receipt" class="form-control" required="" onchange=""><option value="">Select Branch</option>
								<?php
								$qns = mysqli_query($connection,"SELECT * FROM school order by name asc");
								while($dns = mysqli_fetch_array($qns)){
								 $sch = $dns['name']; ?>
								<option value="<?php echo $dns['super']; ?>" title="<?php echo $sch; ?>"><?php echo $sch." Manager/Supervisor"; ?></option>
								<?php } ?>
								<option value="-1" title="Send to all manager/supervisor">** All Manager/Supervisor</option>
								<?php if($_SESSION['utype']==0){ ?>
								<option value="-2" title="Send to your Admins">*** Administrator</option><?php } ?>
							</select>
							<br/>

							Subject:<input type="text" name="title" placeholder="Enter the subject" class="form-control" required="">
							<br/>
							Message:<textarea name="message" placeholder="Type your message here" class="form-control" required=""></textarea>
							<div class="ln_solid"></div>
							<input type="hidden" name="cem4" value="TRUE" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit fa fa-paper-plane"> Send</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>

        <!-- footer content -->
        <footer>
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
