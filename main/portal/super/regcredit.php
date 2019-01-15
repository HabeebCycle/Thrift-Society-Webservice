<?php

?>

<h3 style="font-family:Andalus;font-size:25px;color:red">Headquarter's Details</h3>
<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
	<tr>
	  <th>#REF</th>
	  <th>Date</th>
	  <th>Type</th>
	  <th align='right'>Amount &#8358;</th>
	  <th>Approval</th>
	  <th>Details</th>
	</tr>
  </thead>
  <tbody>
  <?php
	$qnx = mysqli_query($connection,"select * from transaction where school=$sch and ttype=3 or ttype=4");
	while($dn = mysqli_fetch_array($qnx)){
		$tr1 = mysqli_fetch_array(mysqli_query($connection,"select * from users where id=".$dn['approval']));
  ?>
	<tr>
	  <td><b><?php echo $dn['ref']; ?></b></td>
	  <td><?php echo date('M d, Y',$dn['date']); ?></td>
	  <td><?php echo ($dn['ttype']==3?"H.Added <b class='green fa fa-long-arrow-down'></b>":"H.Deduct <b class='red fa fa-long-arrow-up'></b>"); ?></td>
	  <td><?php echo number_format($dn['amount'],2); ?></td>
	  <td><?php echo $tr1['name']; ?></td>
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
					  <h3 class="modal-title" id="myModalLabel2"><?php echo $dn['ref']; ?> Details </h3>
					</div>
					<div class="modal-body">
					<h5></h5>
						<div style="overflow-y:auto;width:98%;height:280px;padding:10px;border: 2px solid #777;">
						<?php echo ($dn['ttype']==1?"Credit <b class='green fa fa-long-arrow-left'></b>":($dn['ttype']==2?"Debit <b class='red fa fa-long-arrow-right'></b>":($dn['ttype']==3?"Headquarter Added <b class='green fa fa-long-arrow-down'></b>":"Headquarter Deduct <b class='red fa fa-long-arrow-up'></b>"))); ?>
						<?php echo nl2br($dn['details']); ?></div>
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
