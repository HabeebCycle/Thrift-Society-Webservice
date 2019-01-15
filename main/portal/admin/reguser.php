<?php

if(isset($_POST['cemedt'])){
	// Initialize a session:

    $name = mysqli_real_escape_string($connection,$_POST['name']);
    $phone = mysqli_real_escape_string($connection,$_POST['phone']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);

	$id = $_POST['cemid'];
	mysqli_query($connection,"update users set name='$name',password='$password',phone='$phone' where id=$id");
	echo "<script>alert('User $name updated successfully');</script>";
}elseif(isset($_POST['cemdel'])){
	$id = $_POST['cemid'];
	$name = $_POST['cemidn'];
	$cem1 = mysqli_num_rows(mysqli_query($connection,"select * from plan where user=$id"));
	if($cem1 > 0){
		echo "<script>alert('User $name can not be deleted due to its records in the plan page. Please clear/update its record first.');</script>";
	}else{
		mysqli_query($connection,"delete from users where id=$id");
		echo "<script>alert('User $name deleted successfully');</script>";
	}
}elseif(isset($_POST['porapp'])){
	$id = $_POST['porid'];
	$whc = $_POST['whc'];
	mysqli_query($connection,"update users set ban=$whc where id=$id");
}

?>

<h3 style="font-family:Andalus;font-size:25px;color:red">Registered Staff</h3>
<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
	<tr>
	  <th>Name</th>
	  <th>Staff No.</th>
	  <th>Password</th>
	  <th>Phone</th>
	  <th>Branch</th>
	  <th>User</th>
	  <th>Status</th>
	  <th>Action</th>
	</tr>
  </thead>
  <tbody>
  <?php
	$qnx = mysqli_query($connection,"select * from users where utype!=0");
	while($dn = mysqli_fetch_array($qnx)){
		if($_SESSION['utype']==3 and $dn['utype']==3){
			continue;
		}
		$tr4 = mysqli_fetch_array(mysqli_query($connection,"select name from school where id = ".$dn['school']));

  ?>
	<tr>
	  <td><?php echo $dn['name']; ?></td>
	  <td><?php echo (($_SESSION['utype']==3 and $dn['utype']==3)?"******":$dn['username']); ?></td>
	  <td><?php echo (($_SESSION['utype']==3 and $dn['utype']==3)?"******":$dn['password']); ?></td>
	  <td><?php echo $dn['phone']; ?></td>
	  <td><?php echo ($dn['school']==0?($dn['utype']==1?"Manager (No Branch)":"Headquarter"):$tr4['name']); ?></td>
	  <td><?php echo $dn['utype']==1?'Manager':($dn['utype']==2?'Staff':'Administrator'); ?></td>
	  <td><?php echo $dn['ban']==1?"<b class='red'>Banned</b>":"<b class='green'>Active</b>"; ?></td>
	  <td>
		<a class="btn btn-default btn-xs" data-toggle="modal" data-target=".acc-<?php echo $dn['id']; ?>"><?php echo ($dn['ban']==1?"<i class='green fa fa-check-circle'> Access</i>":"<i class='red fa fa-exclamation'> Ban ....</i>"); ?></a>
		<?php if($_SESSION['utype']==0 or $_SESSION['utype']==-1){ ?>
		<button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".edt-cem-sm-<?php echo $dn['id']; ?>">Edit</button>
		<?php } ?>
		<?php if($_SESSION['utype']==-1){ ?>
		<button class="btn btn-danger btn-xs" data-toggle="modal" data-target=".del-cem-sm-<?php echo $dn['id']; ?>">Delete</button>
		<?php } ?>
	  </td>
	</tr>
	<div class="modal fade acc-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:18px;text-align:justify;">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				  </button>
				  <h4 class="modal-title" id="myModalLabel2">Portal Access for  <?php echo $dn['name']; ?></h4>
				</div>
				<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=2#tables">
					<div class="modal-body">
						<h5></h5>
						<p style="color:purple;">Are you sure to <?php echo $dn['ban']==0?'ban ':'lift ban on ' ?> <?php echo $dn['name']; ?></p>
						<div class="ln_solid"></div>
						<input type="hidden" name="porapp" value="TRUE" />
						<input type="hidden" name="porid" value="<?php echo $dn['id']; ?>" />
						<input type="hidden" name="whc" value="<?php echo $dn['ban']==0?1:0; ?>" />
					</div>
					<div class="modal-footer">
					  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick=""><?php echo $dn['ban']==0?'Ban ':'Give Access to '; ?> <?php echo $dn['name']; ?></button>
					  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
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
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="?cl=2#tables">
						<div class="modal-body">
							<h5>Fill all the fields</h5>
							Name:<input type="text" name="name" value="<?php echo $dn['name']; ?>" class="form-control" required="">
							Phone:<input type="text" name="phone" value="<?php echo $dn['phone']; ?>" class="form-control" required="">
							Username:<input type="text" name="username" value="<?php echo $dn['username']; ?>" class="form-control" disabled>
							Password:<input type="text" name="password" value="<?php echo $dn['password']; ?>" class="form-control" required="">
							<div class="ln_solid"></div>
							<input type="hidden" name="cemedt" value="TRUE" />
							<input type="hidden" name="cemid" value="<?php echo $dn['id']; ?>" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade del-cem-sm-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:18px;text-align:justify;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h4 class="modal-title" id="myModalLabel2">Delete <?php echo $dn['name']; ?></h4>
					</div>
					<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="modal-body">
							<h5></h5>
							<p style="color:purple;">Are you sure to delete <?php echo $dn['name']; ?></p>
							<div class="ln_solid"></div>
							<input type="hidden" name="cemdel" value="TRUE" />
							<input type="hidden" name="cemid" value="<?php echo $dn['id']; ?>" />
							<input type="hidden" name="cemidn" value="<?php echo $dn['name']; ?>" />
						</div>
						<div class="modal-footer">
						  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Delete</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php } ?>
  </tbody>
</table>
