<?php

?>

<h3 style="font-family:Andalus;font-size:25px;color:red">Cash Details</h3>
<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
	<tr>
	  <th>Branch</th>
	  <th>Money Added</th>
	  <th>Money Deducted</th>
	  <th>Details</th>
	</tr>
  </thead>
  <tbody>
  <?php
	$qnx = mysqli_query($connection,"select * from school");
	while($dn = mysqli_fetch_array($qnx)){
		$tr1 = mysqli_fetch_array(mysqli_query($connection,"select sum(amount) as amt1 from transaction where ttype=3 and school=".$dn['id']));
		$tr2 = mysqli_fetch_array(mysqli_query($connection,"select sum(amount) as amt2 from transaction where ttype=4 and school=".$dn['id']));
  ?>
	<tr>
	  <td><?php echo $dn['name']; ?></td>
	  <td><?php echo "&#8358; ".number_format($tr1['amt1'],2); ?></td>
	  <td><?php echo "&#8358; ".number_format($tr2['amt2'],2); ?></td>
	  <td>
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target=".det-cem-sm-<?php echo $dn['id']; ?>">Details</button>
	  </td>
	</tr>
	<div class="modal fade det-cem-sm-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:16px;">
				<div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					  </button>
					  <h3 class="modal-title" id="myModalLabel2"><?php echo $dn['name']; ?> Details </h3>
					</div>
					<div class="modal-body">
					<h5></h5>
						<div style="overflow-y:auto;width:98%;height:280px;padding:10px;border: 2px solid #777;">
						<?php echo nl2br($dn['details']); ?></div>
						Money Given: <?php echo "&#8358; ".number_format($tr1['amt1'],2); ?><br/>Money Deducted: <?php echo "&#8358; ".number_format($tr2['amt2'],2); ?>
						<div class="ln_solid"></div>
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
