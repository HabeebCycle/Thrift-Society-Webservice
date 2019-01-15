<?php
include_once("header.php");
if($_SESSION['utype']==3){
		header('Location: users.php');
	}else{
ob_start();

	if(isset($_POST['mempay'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);
			$user = mysqli_real_escape_string($connection,$_POST['res']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$info = ($acc==1?"Pay-in ":"Pay-out ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details." \n (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into payment (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New pay-in transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount must be more than zero.');</script>";
				}
			}elseif($acc==2){
				if($amt>0){
					mysqli_query($connection,"insert into payment (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New pay-out transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount must be more than zero.');</script>";
				}
			}
		}elseif(isset($_POST['editpay'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$info = ($acc==1?"Pay-in ":"Pay-out ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where id = $idd");
					echo "<script>alert('Pay-in transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount must be more than zero.');</script>";
				}
			}elseif($acc==2){
				if($amt>0){
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where id = $idd");
					echo "<script>alert('Pay-out transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount must be more than zero.');</script>";
				}
			}
		}

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from payment"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
?>
<div class="right_col" role="main">
          <div class="">
		  <div class="clearfix"></div>

            <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Better Life <small>Payment</small></h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success btn-xs" data-toggle="modal" data-target=".pay-sm"><i class="fa fa-plus-circle"><b> Add Payment </b></i></button>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      Summary of payment Better Life for Ummah.
                    </p>

		<div class="modal fade pay-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Payment Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="shares" method="post" action="">
				<div class="modal-body">
					<h4>New Payment</h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Income">Pay In</option>
						<option value="2" title="Expenditure">Pay Out</option>
					</select>
					Issue to:
					<select name="res" class="form-control"><option value="-1">Select member </option>
					<?php
						$qns = mysqli_query($connection,"SELECT * FROM users");
						while($dns = mysqli_fetch_array($qns)){ ?>
						<option value="<?php echo $dns['id']; ?>" title="<?php echo $dns['regno']; ?>"><?php echo $dns['name']; ?></option>
						<?php } ?>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control" required=""></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="mempay" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="isdeb();">Execute</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
function isdeb(){
    var r=document.shares.acc.value;
	var m=document.shares.res.value;
	var d=document.shares.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
	}else if(m==-1){
		alert("Select responsible member");
		return;
    }else{
		if(d<=0){
			alert("ERROR!\n The amount cannot be less or equal to zero.");
			document.shares.amt.value = "0.00";
			return;
		}
	}
}

</script>
<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Income: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Expenditure: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>

                    <table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>Date</th>
                          <th>Account</th>
						  <th>Member</th>
						  <th>Pay In (&#8358;)</th>
                          <th>Pay Out (&#8358;)</th>
						  <th>Details</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $mdx = ["In House","SHARES","INVESTMENT","SAVINGS","TARGET","EMERGENCY","BUILDING","BUSINESS","AGM","SOCIAL","DEVELOPMENT","OTHERS","LOAN"];
						$qnx = mysqli_query($connection,"select * from payment order by date desc");
						while($dn = mysqli_fetch_array($qnx)){
						$fdx = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['user']));
						$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
                          <td><?php echo date('d.m.Y',$dn['date']); ?></td>
                          <td><?php echo $mdx[$dn['actype']]; ?></td>
                          <td><?php echo $fdx['name'].' ('.$fdx['regno'].')'; ?></td>
						  <td class="green"><b><?php echo number_format($dn['amountcr'],2); ?></b></td>
						  <td class="red"><b><?php echo number_format($dn['amountdr'],2); ?></b></td>
                          <td><a class="btn btn-primary btn-xs" data-toggle="modal" data-target=".sav-det-<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Details</i></a> &nbsp;&nbsp; <?php if($dn['actype']==0){ ?><a class="btn btn-warning btn-xs" data-toggle="modal" data-target=".edit-det-<?php echo $dn['id']; ?>"><i class="fa fa-book"> Edit</i></a><?php } ?></td>

						  <div class="modal fade sav-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo $dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo ($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
										Initiated: &nbsp;&nbsp; <?php echo $fdp['name'].' ('.$fdp['regno'].')'; ?><br/>
										Responsible: &nbsp;&nbsp; <?php echo $fdx['name'].'('.$fdx['regno'].')'; ?><br/><br/>
										Full Details<br/><?php echo nl2br($dn['details']); ?><br/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						  </div>
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtpay<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtpay<?php echo $dn['id']; ?>.amt.value;

							if(d1<=0){
								alert("ERROR!\n Payment value cannot be less than or equal to zero");
								document.edtpay<?php echo $dn['id']; ?>.amt.value = "0.00";
								return;
							}
						  }
						  </script>
						  <div class="modal fade edit-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Payment <?php echo $dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtpay<?php echo $dn['id']; ?>" method="post" action="">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Responsible <input type="text" name="res" value="<?php echo $fdx['name'].'('.$fdx['regno'].')'; ?>" class="form-control" readonly>
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editpay" value="TRUE" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="isdeb2();">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
								</div>
							</div>
						  </div>
                        </tr>
						<?php } ?>
                      </tbody>
                    </table>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?php include_once("footer.php"); ?>

  </body>
</html>
	<?php } ?>
