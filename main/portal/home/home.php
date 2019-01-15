<?php
require_once ('../../config/config.php');
require("../../config/site_func.php");
if(!isset($_SESSION['islog']) or !$_SESSION['islog'] or $_SESSION['utype']!=2){
	header('Location: ../');
}
	$uid = $_SESSION['uid'];
	$sch = $_SESSION['school'];
	if(isset($_POST['cem3'])){
		$credits = mysqli_real_escape_string($connection,$_POST['credits']);
		$charges = mysqli_real_escape_string($connection,$_POST['charges']);
		$details = mysqli_real_escape_string($connection,$_POST['details']);
		$ttype = mysqli_real_escape_string($connection,$_POST['ttype']);
		$word = mysqli_real_escape_string($connection,$_POST['word']);
		$self = ($credits < LOW_MED)?$uid:0;
		$dreg = time();
		$per = mysqli_fetch_array(mysqli_query($connection,"select * from school where id=$sch"));
		$usr = mysqli_fetch_array(mysqli_query($connection,"select * from users where id=$uid")); $wc=$usr['name']; $wz=$usr['username'];
		$det = $details."\n".($ttype==2?"Deducted ":"Added ")."&#8358;$credits (charges: &#8358;$charges) by $wz - ($wc) on ".date('D, d.m.Y h:i:s A',($dreg-3600));
		$dex = $det."\n____________\n\r".$per['details'];
		$credx = $per['credit'] - $per['debit'];
		if($credits > 0){
			if(($credx < $credits) and ($ttype == 2)){
				echo "<script>alert('ERROR! Branch dont have upto &#8358; $credits');</script>";
			}else{
				if($ttype == 2){
					mysqli_query($connection,"insert into transaction (date,ref,user,school,ttype,amount,charges,details,approval) values ($dreg,'$sch$dreg',$uid,$sch,2,$credits,$charges,'$det',$self)");
					if($self!=0){
						mysqli_query($connection,"update school set debit=debit+$credits, credit=credit+$charges, details='$dex' where id=$sch");
						echo "<script>alert('#$credits ($word) debited successfully');</script>";
					}else{
						echo "<script>alert('#$credits ($word) is awaiting approval.\\nPlease inform your manager for approval');</script>";
					}
				}else{
					mysqli_query($connection,"insert into transaction (date,ref,user,school,ttype,amount,charges,details,approval) values ($dreg,'$sch$dreg',$uid,$sch,1,$credits,$charges,'$det',$self)");
					if($self!=0){
						mysqli_query($connection,"update school set credit=credit+$credits+$charges, details='$dex' where id=$sch");
						echo "<script>alert('#$credits ($word) credited successfully');</script>";
					}else{
						echo "<script>alert('#$credits ($word) is awaiting approval.\\nPlease inform your manager for approval');</script>";
					}
				}
			}
		}else{
			echo "<script>alert('ERROR! Cannot transact zero value');</script>";
		}
	}elseif(isset($_POST['cem4'])){
		$receipt = mysqli_real_escape_string($connection,$_POST['receipt']);
		$title = mysqli_real_escape_string($connection,$_POST['title']);
		$message = mysqli_real_escape_string($connection,$_POST['message']);
		$dreg = time();
		$sender = $_SESSION['uid'];
		if($receipt==-1){
			$adm = mysqli_query($connection, "select id from users where utype=1 and school=$sch");
			while($dc = mysqli_fetch_array($adm)){
				$rex = $dc['id'];
				mysqli_query($connection,"insert into messages (mtype,sender,receipt,date,title,message) values (1,$sender,$rex,$dreg,'$title','$message')");
			}
			$msgg = $message."\n\nSent to: Manager";
			mysqli_query($connection,"insert into messages (sender,receipt,date,title,message) values ($sender,-1,$dreg,'$title','$msgg')");
			echo "<script>alert('Message sent successfully');</script>";
		}elseif($receipt==-2){
			$adm = mysqli_query($connection, "select * from users where school=$sch and utype=2");
			while($dc = mysqli_fetch_array($adm)){
				$rex = $dc['id'];
				mysqli_query($connection,"insert into messages (mtype,sender,receipt,date,title,message) values (1,$sender,$rex,$dreg,'$title','$message')");
			}
			$msgg = $message."\n\nSent to: ALL Branch Staff";
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
	$brh = mysqli_fetch_array(mysqli_query($connection,"select * from school where id=$sch"));
	$nmsg = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM messages where receipt=$uid and status=0"));
	$cel = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM transaction where user=$uid and school=$sch and approval=0"));
	$cut = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM transaction where user=$uid and school=$sch and approval=$uid"));
	$cew = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM transaction where user=$uid and school=$sch and approval=-1"));
	$cen = mysqli_num_rows(mysqli_query($connection,"select * from transaction where user=$uid and school=$sch and date>$rdate"));
	$cep = mysqli_num_rows(mysqli_query($connection,"select * from transaction where user=$uid and school=$sch and (approval!=0 and
	approval!=-1)"));
	$cex = mysqli_fetch_array(mysqli_query($connection,"select sum(credit) as cex from school where id=$sch"))['cex'];
	$cet = mysqli_fetch_array(mysqli_query($connection,"select sum(debit) as cet from school where id=$sch"))['cet'];
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
		  <h3>Dashboard <small class="red">Staff Panel</small> - <?php echo ucwords($_SESSION['uname']).' - '.$brh['name']; ?><a href="index" class="pull-right blue fa fa-sign-out"> Home</a></h3>

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
            <div class="col-md-6 col-sm-6 col-xs-6 tile_stats_count"><a href='?cl=1#tables'>
              <center><span class="count_top"><i class="fa fa-money"></i> Awaiting Approvals </span><br/>
              <div class="count green btn btn-default"><?php echo $cel; ?></div><br/>
			  <span class="count_bottom">  Approved / Declined: <i class="red"> <?php echo $cut.' / '.$cew; ?> </i> </span>
			  </center></a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 tile_stats_count"><a href='?cl=3#tables'>
              <center><span class="count_top"><i class="fa fa-book"></i> Today Transactions </span><br/>
              <div class="count green btn btn-default"><?php echo $cen; ?></div><br/>
			  <span class="count_bottom"> Completed: <i class="red"> <?php echo $cep>0?$cep:0; ?> </i> </span>
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

					<a href="#" data-toggle="modal" data-target=".new-sm3" style="font-size:18px; color:0f0;" >
						<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="tile-stats alert-default">
							  <div class="green" style="font-size:30px;text-align:center;"><i class="fa fa-money "></i><br/>Add Transaction </div>
							</div>
						</div>
					</a>
					<a href="#" data-toggle="modal" data-target=".new-sm4" style="font-size:18px; color:f00;" onclick='showM(1);'>
						<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
			elseif($cl==3)
				include_once ('regplan.php');
			?>

			<div class="clearfix"></div>
        </div></div></div>
        <!-- /page content -->
		</div>
		</div>

		<div class="modal fade new-sm3" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Add/Deduct Money</h4>
					</div>
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=1#tables">
						<div class="modal-body">
							<h5>Fill all the fields</h5>
							Transaction Type:<select name="ttype" class="form-control" required=""><option value="">Select Type</option>
								<option value='1' title='Add money to branch account'>Credit Branch</option><option value='2' title='Take money out from branch account'>Debit Branch</option>
							</select>
							<br/>

							Amount (&#8358;): <small class='green'>(Max. amount &#8358; <?php echo $ava; ?>)</small><br/><small class='red'>(Don't put comma: 50,000 should be 50000)</small>
							<input type="text" name="credits" placeholder="Enter amount to credit/debit" class="form-control" required="" onblur="checkC(this.value,1);">
							<small id='word1' class='blue'><i>&#8358;</i></small><br/>
							Charges (&#8358;):<input type="text" id="charges" name="charges" value="0.00" class="form-control" required="" onblur="checkC(this.value,2);">
							<small id='wordc' class='green'><i>&#8358;</i></small><br/>
							Description:<textarea name="details" placeholder="Enter details about the transaction" class="form-control"></textarea>
							<div class="ln_solid"></div>
							<input type="hidden" id='word2' name="word" value="Zero" />
							<input type="hidden" name="cem3" value="TRUE" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Approve Transaction</button>
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
			function checkC(val,it){
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
					if(it==1){
						document.getElementById('word1').innerHTML = xmlhttp.responseText;
						document.getElementById('word2').value = xmlhttp.responseText;
					}else{
						document.getElementById('wordc').innerHTML = xmlhttp.responseText;
					}
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
									$tr = ($t1['school']==0?array('name'=>'To Headquarter'):($dns['receipt']==-1?'':mysqli_fetch_array(mysqli_query($connection,"select * from school where id = ".$t1['school']))));
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
			$tr2 = ($t2['school']==0?array('name'=>'To Headquarter'): mysqli_fetch_array(mysqli_query($connection,"select * from school where id = ".$t2['school']))); ?>
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
							To:<select name="receipt" class="form-control" required="" onchange=""><option value="">Select Staff</option>
								<?php
								$qns = mysqli_query($connection,"SELECT * FROM users where school=$sch and utype=2 where id!=$uid order by name asc");
								while($dns = mysqli_fetch_array($qns)){
								 $sch = $dns['name']; ?>
								<option value="<?php echo $dns['id']; ?>" title="<?php echo $sch; ?>"><?php echo $dns['username']; ?></option><?php } ?>
								<option value="-2" title="Send to your branch staff">*** All branch Staff</option>
								<option value="-1" title="Send to your Manager">*** Manager</option>
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
