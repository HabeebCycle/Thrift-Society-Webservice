<?php
if(isset($_POST['cemdel'])){
	$id = $_POST['cemid'];
	$name = $_POST['cemidn'];
	mysqli_query($connection,"delete from transaction where id=$id");
	echo "<script>alert('Transaction $name deleted successfully');</script>";
}
$xr1 = mysqli_fetch_array(mysqli_query($connection,"select sum(amount) as amt1 from transaction where ttype=1"));
$xr2 = mysqli_fetch_array(mysqli_query($connection,"select sum(amount) as amt2 from transaction where ttype=2"));
$xr3 = mysqli_fetch_array(mysqli_query($connection,"select sum(charges) as amt1 from transaction where ttype=1"));
$xr4 = mysqli_fetch_array(mysqli_query($connection,"select sum(charges) as amt2 from transaction where ttype=2"));
?>

<h3 style="font-family:Andalus;font-size:25px;color:red">Transactions</h3>
<div align='center' style="border: 1px solid #5f6;font-family:Calibri;font-size:14px;color:#000;">
Amount Credited: <?php echo "&#8358; ".number_format($xr1['amt1'],2); ?> &nbsp;|&nbsp; Amount Debited: <?php echo "&#8358; ".number_format($xr2['amt2'],2); ?> &nbsp;|&nbsp; Credited Charges: <?php echo "&#8358; ".number_format($xr3['amt1'],2); ?> &nbsp;|&nbsp; Debited Charges: <?php echo "&#8358; ".number_format($xr4['amt2'],2); ?></div><br/>
<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
	<tr>
	  <th>#REF</th>
	  <th>Date</th>
	  <th>Branch</th>
	  <th>Initiated</th>
	  <th>Type</th>
	  <th align='right'>Amount &#8358;</th>
	  <th align='right'>Charges &#8358;</th>
	  <th>Approval</th>
	  <th>Details</th>
	</tr>
  </thead>
  <tbody>
  <?php
	$qnx = mysqli_query($connection,"select * from transaction order by date desc");
	while($dn = mysqli_fetch_array($qnx)){
		$tr1 = mysqli_fetch_array(mysqli_query($connection,"select * from school where id=".$dn['school']));
		$tr2 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id = ".$dn['user']));
		$tr3 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id = ".$dn['approval']));
  ?>
	<tr>
	  <td><b><?php echo $dn['ref']; ?></b></td>
	  <td><?php echo date('M d, Y',$dn['date']); ?></td>
	  <td><?php echo $tr1['name']; ?></td>
	  <td title='<?php echo $tr2['name']; ?>'><?php echo $tr2['username']; ?></td>
	  <td><?php echo ($dn['ttype']==1?'Credit':($dn['ttype']==2?'Debit':($dn['ttype']==3?'H.Added':'H.Deduct'))); ?></td>
	  <td><?php echo number_format($dn['amount'],2); ?></td>
	  <td><?php echo number_format($dn['charges'],2); ?></td>
	  <td title='<?php echo $dn['approval']==0?'Not Approved':($dn['approval']==-1?'Declined':$tr3['name']); ?>'><?php echo $dn['approval']==0?"Not Approved <i class='blue fa fa-clock-o'></i>":($dn['approval']==-1?"Declined <i class='red fa fa-remove'></i>":$tr3['username']); ?></td>
	  <td><?php if($dn['approval']!=0){ ?><button class="btn btn-success btn-xs" data-toggle="modal" data-target=".det-cem-sm-<?php echo $dn['id']; ?>">Details</button>
	  <?php } if($_SESSION['utype']==0 and $dn['approval']==-1){ ?>
		<button class="btn btn-danger btn-xs" data-toggle="modal" data-target=".del-cem-sm-<?php echo $dn['id']; ?>">Delete</button>
	  <?php } ?></td>
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
	<div class="modal fade del-cem-sm-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:18px;text-align:justify;">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
				  </button>
				  <h4 class="modal-title" id="myModalLabel2">Delete <?php echo $dn['ref']; ?></h4>
				</div>
				<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="modal-body">
						<h5></h5>
						<p style="color:purple;">Are you sure to delete unapproved <?php echo $dn['ref']; ?></p>
						<div class="ln_solid"></div>
						<input type="hidden" name="cemdel" value="TRUE" />
						<input type="hidden" name="cemid" value="<?php echo $dn['id']; ?>" />
						<input type="hidden" name="cemidn" value="<?php echo $dn['ref']; ?>" />
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

