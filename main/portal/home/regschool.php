<?php


?>

<h3 style="font-family:Andalus;font-size:25px;color:red">Transactions Waiting Approval</h3>
<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
	<tr>
	  <th>#REF</th>
	  <th>Date</th>
	  <th>Type</th>
	  <th align='right'>Amount &#8358;</th>
	  <th align='right'>Charges &#8358;</th>
	  <th>Details</th>
	</tr>
  </thead>
  <tbody>
  <?php
	$qnx = mysqli_query($connection,"select * from transaction where approval=0 order by date desc");
	while($dn = mysqli_fetch_array($qnx)){
  ?>
	<tr>
	  <td><b><?php echo $dn['ref']; ?></b></td>
	  <td><?php echo date('M d, Y h:i:s A',($dn['date']-3600)); ?></td>
	  <td><?php echo ($dn['ttype']==1?'Credit':'Debit'); ?></td>
	  <td><?php echo number_format($dn['amount'],2); ?></td>
	  <td><?php echo number_format($dn['charges'],2); ?></td>
	  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".det-cem-sm-<?php echo $dn['id']; ?>">Details</button></td>
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

	<?php } ?>
  </tbody>
</table>
