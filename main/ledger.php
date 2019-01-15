<?php
include_once("header.php");
	$user = $_SESSION['uid'];
ob_start();

?>
<div class="right_col" role="main">
          <div class="">
		  <div class="clearfix"></div>

            <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Better Life Members <small>Ledger</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      List of members' ledger under Better Life for Ummah.
                    </p>

                    <table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Account (Details)</th>
                          <th>Credit (&#8358;)</th>
                          <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $mdx = ["shares","investment","savings","target","emergency","building","loan","business","agm","social","development","others"];
					  for($i=0;$i<12;$i++){
						$qnx = mysqli_query($connection,"select sum(amountcr) as amt1, ".($i==6?"sum(amountpay)":"sum(amountdr)")." as amt2 from ".$mdx[$i]." where user=$user");
						$dn = mysqli_fetch_array($qnx);
						$bal = $dn['amt1'] - $dn['amt2'];
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
                          <td><a class="btn btn-primary btn-xs" href="ledgers.php?act=<?php echo $mdx[$i]; ?>&idx=<?php echo $user; ?>"><i class="fa fa-book"> <?php echo " &nbsp;".($i==8?"AGM":ucwords($mdx[$i])); ?> Ledger</i></a></td>
                          <td><?php echo ($dn['amt1']>0?$dn['amt1']:'0.00'); ?></td>
                          <td><?php echo ($dn['amt2']>0?$dn['amt2']:'0.00'); ?></td>
                          <td><?php echo number_format($bal,2); ?></td>

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
