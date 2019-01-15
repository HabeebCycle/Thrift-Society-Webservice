<?php

if(isset($_POST['cemdel1'])){
	$id = $_POST['cemid'];
	$name = $_POST['cemidn'];
	$trx = mysqli_fetch_array(mysqli_query($connection,"select * from transaction where id=$id"));
	$per = mysqli_fetch_array(mysqli_query($connection,"select * from school where id=$sch"));
	$det = $trx['details'];
	$dex = $det."\n____________\n\r".$per['details'];
	$credx = $per['credit'] - $per['debit'];
	$credits = $trx['amount']; $charges = $trx['charges'];
	if($credits > 0){
		if(($credx < $credits) and ($trx['ttype'] == 2)){
			echo "<script>alert('ERROR! Branch dont have upto &#8358; $credits');</script>";
		}else{
			if($trx['ttype'] == 2){
				mysqli_query($connection,"update school set debit=debit+$credits, credit=credit+$charges, details='$dex' where id=$sch");
				mysqli_query($connection,"update transaction set approval=$uid where id=$id");
				echo "<script>alert('Transaction $name approved successfully');</script>";
			}else{
				mysqli_query($connection,"update school set credit=credit+$credits+$charges, details='$dex' where id=$sch");
				mysqli_query($connection,"update transaction set approval=$uid where id=$id");
				echo "<script>alert('Transaction $name approved successfully');</script>";
			}
		}
	}else{
		echo "<script>alert('ERROR! Cannot transact and approve zero value');</script>";
	}
}elseif(isset($_POST['cemdel2'])){
	$id = $_POST['cemid'];
	$name = $_POST['cemidn'];
	mysqli_query($connection,"update transaction set approval=-1 where id=$id");
	echo "<script>alert('Transaction $name declined successfully');</script>";
}

?>

<h3 style="font-family:Andalus;font-size:25px;color:red">Transactions Waiting Approval</h3>
<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
	<tr>
	  <th>#REF</th>
	  <th>Date</th>
	  <th>Initiated</th>
	  <th>Type</th>
	  <th align='right'>Amount &#8358;</th>
	  <th align='right'>Charges &#8358;</th>
	  <th>Details</th>
	  <th>Actions</th>
	</tr>
  </thead>
  <tbody>
  <?php
	$qnx = mysqli_query($connection,"select * from transaction where approval=0 order by date desc");
	while($dn = mysqli_fetch_array($qnx)){
		$tr2 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id = ".$dn['user']));
  ?>
	<tr>
	  <td><b><?php echo $dn['ref']; ?></b></td>
	  <td><?php echo date('M d, Y h:i:s A',($dn['date']-3600)); ?></td>
	  <td title='<?php echo $tr2['name']; ?>'><?php echo $tr2['username']; ?></td>
	  <td><?php echo ($dn['ttype']==1?'Credit':'Debit'); ?></td>
	  <td><?php echo number_format($dn['amount'],2); ?></td>
	  <td><?php echo number_format($dn['charges'],2); ?></td>
	  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".det-cem-sm-<?php echo $dn['id']; ?>">Details</button></td>
	  <td><button class="btn btn-success btn-xs fa fa-check-o" data-toggle="modal" data-target=".del-cem-sm1-<?php echo $dn['id']; ?>"> Approve</button> &nbsp; <button class="btn btn-danger btn-xs fa fa-times" data-toggle="modal" data-target=".del-cem-sm2-<?php echo $dn['id']; ?>"> Decline</button></td>
	</tr>
	<div class="modal fade det-cem-sm-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:16px;text-align:left;">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				  </button>
				  <h3 class="modal-title" id="myModalLabel2"> Transaction Details </h3>
				</div>
				<div class="modal-body">
				<h5></h5>
					<p style="color:darkblue;text-align:center;font-size:20px;"><?php echo $dn['ref']; ?></p><br/>
					<div style="overflow-y:auto;width:100%;height:280px;padding:10px;border: 2px solid #777;">
					<?php echo nl2br($dn['details']); ?></div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade del-cem-sm1-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:18px;text-align:justify;">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				  </button>
				  <h4 class="modal-title" id="myModalLabel2">Approve <?php echo $dn['ref']; ?></h4>
				</div>
				<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="modal-body">
						<h5></h5>
						<p style="color:purple;">Are you sure to approve <?php echo $dn['ref']; ?> transaction?</p>
						<div class="ln_solid"></div>
						<input type="hidden" name="cemdel1" value="TRUE" />
						<input type="hidden" name="cemid" value="<?php echo $dn['id']; ?>" />
						<input type="hidden" name="cemidn" value="<?php echo $dn['ref']; ?>" />
					</div>
					<div class="modal-footer">
					  <button type="submit" value="submit" name="submit" class="btn btn-primary fa fa-check-o submit" onclick=""> Approve</button>
					  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade del-cem-sm2-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:18px;text-align:justify;">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				  </button>
				  <h4 class="modal-title" id="myModalLabel2">Decline <?php echo $dn['ref']; ?></h4>
				</div>
				<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="modal-body">
						<h5></h5>
						<p style="color:purple;">Are you sure to decline <?php echo $dn['ref']; ?> transaction?</p>
						<div class="ln_solid"></div>
						<input type="hidden" name="cemdel2" value="TRUE" />
						<input type="hidden" name="cemid" value="<?php echo $dn['id']; ?>" />
						<input type="hidden" name="cemidn" value="<?php echo $dn['ref']; ?>" />
					</div>
					<div class="modal-footer">
					  <button type="submit" value="submit" name="submit" class="btn btn-danger fa fa-times submit" onclick=""> Decline</button>
					  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
  </tbody>
</table>
