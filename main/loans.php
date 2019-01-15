<?php
include_once("header.php");
if($_SESSION['utype']==3){
		header('Location: users.php');
	}else{
ob_start();

?>
<div class="right_col" role="main">
          <div class="">
		  <div class="clearfix"></div>

            <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Better Life Members <small>Loans</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      List of members' loans under Better Life for Ummah.
                    </p>

                    <table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Member name</th>
                          <th>Reg. No.</th>
                          <th>Savings (&#8358;)</th>
						  <th>Date</th>
						  <th>Status</th>
						  <th>Received (&#8358;)</th>
                          <th>Amount (&#8358;)</th>
						  <th>Payment (&#8358;)</th>
                          <th>Balance (&#8358;)</th>
						  <th>Details</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
						$qnx = mysqli_query($connection,"select * from loans order by complete");
						while($dn = mysqli_fetch_array($qnx)){
						$fdx = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['user']));
						$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
						$fds = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from savings where user=".$dn['user']));
						$bal = $fds['amt1'] - $fds['amt2'];
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
                          <td><?php echo $fdx['name']; ?></td>
                          <td><?php echo $fdx['regno']; ?></td>
						  <td class="green"><b><?php echo number_format($bal,2); ?></b></td>
                          <td><?php echo date('d.m.Y',$dn['date1']); ?></td>
						  <td><?php echo ($dn['complete']==0?"<i class='red fa fa-clock-o'> Pending</i>":"<i class='blue fa fa-check'> Completed"); ?></td>
						  <td><i><?php echo number_format($dn['amount1'],2); ?></i></td>
                          <td><b><?php echo number_format($dn['amount2'],2); ?></b></td>
						  <td><b><?php echo number_format($dn['amount3'],2); ?><b></td>
                          <td class="red"><b><?php echo number_format(($dn['amount2']-$dn['amount3']),2); ?></b></td>
                          <td><a class="btn btn-warning btn-xs" data-toggle="modal" data-target=".sav-det-<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Details</i></a> &nbsp;&nbsp; <a class="btn btn-primary btn-xs" href="mdetails.php?act=loan&idx=<?php echo $dn['user']; ?>"><i class="fa fa-book"> Ledger</i></a></td>

						  <div class="modal fade sav-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo $dn['date1']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo ($dn['date1']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date1']); ?><br/>
										Initiated: &nbsp;&nbsp; <?php echo $fdp['name'].' ('.$fdp['regno'].')'; ?><br/>
										Full Details<br/><?php echo $dn['details']; ?><br/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
									</div>
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
