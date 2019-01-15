<?php

if(isset($_POST['cemedt'])){
    $name = mysqli_real_escape_string($connection,$_POST['name']);
    $super = mysqli_real_escape_string($connection,$_POST['super']);
    $phone = mysqli_real_escape_string($connection,$_POST['phone']);
    $address = mysqli_real_escape_string($connection,$_POST['address']);

	$id = $_POST['cemid'];
	$namer = $_POST['cemidn'];
	$nsuper = $_POST['cemsup'];

	mysqli_query($connection,"update school set name='$name',super=$super,phone='$phone',address='$address' where id=$id");
	if($nsuper != $super){
		mysqli_query($connection,"update users set school=0 where id=$nsuper");
	}
	echo "<script>alert('Branch $namer updated successfully');</script>";

}

?>

<h3 style="font-family:Andalus;font-size:25px;color:red">Registered Branch</h3>
<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
	<tr>
	  <th>Branch name</th>
	  <th>Staff</th>
	  <th>Manager</th>
	  <th>Phone</th>
	  <th>Address</th>
	  <th>Balance (&#8358;)</th>
	  <th>Action</th>
	</tr>
  </thead>
  <tbody>
  <?php
	$qnx = mysqli_query($connection,"select * from school");
	while($dn = mysqli_fetch_array($qnx)){
		$tr1 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id=".$dn['super']));
		$tr2 = mysqli_num_rows(mysqli_query($connection,"select * from users where utype!=2 and school = ".$dn['id']));
		//$tr3 = mysqli_num_rows(mysqli_query($connection,"select * from plan where school = ".$dn['id']));
  ?>
	<tr>
	  <td><?php echo $dn['name']; ?></td>
	  <td><?php echo $tr2+1; ?></td>
	  <td><?php echo $tr1['name']; ?></td>
	  <td><?php echo $dn['phone']; ?></td>
	  <td><?php echo wordwrap(substr($dn['address'],0,80).' ...',50,"<br>\n"); ?></td>
	  <td align='right'><?php echo number_format(($dn['credit']-$dn['debit']),2); ?></td>
	  <td>
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target=".det-cem-sm-<?php echo $dn['id']; ?>">Transactions</button>
		<?php if($_SESSION['utype']==0 or $_SESSION['utype']==3){ ?>
		<button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".edt-cem-sm-<?php echo $dn['id']; ?>">Edit</button>
		<?php } ?>
	  </td>
	</tr>
	<div class="modal fade det-cem-sm-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:16px;text-align:left;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h3 class="modal-title" id="myModalLabel2"><?php echo $dn['name']; ?> Transaction Details </h3>
					</div>
					<div class="modal-body">
					<h5></h5>
						<p style="color:darkblue;"><?php echo nl2br($dn['address']); ?><br/>
						<div style="overflow-y:auto;width:100%;height:320px;padding:10px;border: 2px solid #777;">
						<?php echo nl2br($dn['details']); ?></div>
						<u>CREDITS</u>: <?php echo "&#8358; ".number_format($dn['credit'],2); ?> &nbsp;&nbsp;&nbsp; <u>DEBITS</u>: <?php echo "&#8358; ".number_format($dn['debit'],2); ?></p>

					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade edt-cem-sm-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Edit <?php echo $dn['name']; ?></h4>
					</div>
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=1#tables">
						<div class="modal-body">
							<h5>Fill all the fields</h5>
							Name:<input type="text" name="name" value="<?php echo $dn['name']; ?>" class="form-control" required="">
							Phone:<input type="text" name="phone" value="<?php echo $dn['phone']; ?>" class="form-control" required="">
							Address of the branch<textarea name="address" class="form-control"><?php echo $dn['address']; ?></textarea>
							Branch Manager:<select name="super" class="form-control" onchange=''><option value="<?php echo $dn['super']; ?>" selected><?php echo $tr1['name']; ?> </option>
							<?php
								$qns = mysqli_query($connection,"SELECT * FROM users WHERE utype=1 and school=0");
								while($dns = mysqli_fetch_array($qns)){ ?>
								<option value="<?php echo $dns['id']; ?>"><?php echo $dns['name']; ?></option>
								<?php } ?>
							</select>
							<div class="ln_solid"></div>
							<input type="hidden" name="cemedt" value="TRUE" />
							<input type="hidden" name="cemid" value="<?php echo $dn['id']; ?>" />
							<input type="hidden" name="cemidn" value="<?php echo $dn['name']; ?>" />
							<input type="hidden" name="cemsup" value="<?php echo $dn['super']; ?>" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php } ?>
  </tbody>
</table>
