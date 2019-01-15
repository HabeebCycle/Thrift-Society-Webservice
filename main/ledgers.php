<?php
include_once("header.php");
ob_start();
		$act = $_GET['act'];
		$id = $_GET['idx'];
		if(isset($id)){
			$det = mysqli_fetch_array(mysqli_query($connection,"select * from users where id=$id"));
		?>

		<div class="right_col" role="main">
          <div class="">
		  <div class="clearfix"></div>

            <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $det['name'].' ('.$det['regno'].') '; ?><small><?php echo ucfirst($act); ?></small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      List of members' <?php echo $act; ?> under Better Life for Ummah.
                    </p>

	<?php	if($act=='shares'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from shares where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from shares where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from shares where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".sha-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						<td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".sha-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-bull-eye'></i>";} ?></td>

						  <div class="modal fade sha-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx. ($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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

	<?php		}elseif($act=='investment'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from investment where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from investment where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from investment where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".inv-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".inv-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade inv-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='savings'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from savings where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from savings where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from savings where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".sav-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".sav-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade sav-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='target'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from target where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from target where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from target where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".tag-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".tag-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade tag-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='emergency'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from emergency where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from emergency where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from emergency where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".eme-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".eme-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade eme-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='business'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from business where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from business where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from business where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".bus-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".bus-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade bus-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='loan'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountpay) as amt2 from loan where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	$sav = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from savings where user=$id"));
	$samt = 2*($sav['amt1'] - $sav['amt2']);
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"> Savings Bal: &#8358;<?php echo number_format($samt/2,2); ?></b> &nbsp;&nbsp; <b>Credit: &#8358;<?php echo number_format(($fcc['amt1']>0?$fcc['amt1']:"0.00"),2); ?></b> &nbsp;&nbsp; <b>Debt/Debit: &#8358;<?php echo number_format(($fcc['amt2']>0?$fcc['amt2']:"0.00"),2); ?></b> &nbsp;&nbsp; <b>Balance: &#8358; <?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (Repayment) (&#8358;)</th>
						  <th>Debit (Loan) (&#8358;)</th>
						  <th>Cumm Debt. (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from loan where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountpay from loan where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountpay'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format($dn['amountpay'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".loa-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".loa-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade loa-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='building'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from building where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from building where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from building where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".bud-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".bud-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade bud-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='agm'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from agm where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from agm where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from agm where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".agm-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".agm-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade agm-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='social'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from social where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from social where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from social where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".soc-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".soc-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade soc-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='development'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from development where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from development where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from development where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".dev-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".dev-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade dev-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}elseif($act=='others'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from others where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>


				<div align="center" class="col-md-12 col-sm-12 col-xs-12">
					<p style="text-align:center;font-family:Andalus;font-size:20px;"><b class="fa fa-money"></b> <b> Credit: &#8358;<?php echo ($fcc['amt1']>0?$fcc['amt1']:"0.00"); ?></b> &nbsp;&nbsp; <b>Debit: &#8358;<?php echo ($fcc['amt2']>0?$fcc['amt2']:"0.00"); ?></b> &nbsp;&nbsp; <b>Balance: &#8358;<?php echo number_format($bal,2); ?></b></p>
				</div>
				<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
						  <th>ID#</th>
                          <th>Date</th>
                          <th>Credit (&#8358;)</th>
						  <th>Debit (&#8358;)</th>
						  <th>Balance (&#8358;)</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $xx = 0;
						$qnx = mysqli_query($connection,"select * from others where user=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$xx=$xx+1;
							$fdx = mysqli_query($connection,"select amountcr, amountdr from others where user=$id order by id limit $xx");
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['admin']));
							$amt1=0; $amt2=0;
							while($fdxx = mysqli_fetch_array($fdx)){
								$amt1 = $amt1 + $fdxx['amountcr'];
								$amt2 = $amt2 + $fdxx['amountdr'];
							}
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo "#$xx".$dn['date']; ?></td>
						  <td><?php echo date('d.m.Y',$dn['date']); ?></td>
						  <td><?php echo number_format($dn['amountcr'],2); ?></td>
						  <td><?php echo number_format($dn['amountdr'],2); ?></td>
						  <td><?php echo number_format(($amt1 - $amt2),2); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".oth-det-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><?php if($id != $_SESSION['uid']){; ?><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".oth-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button><?php }else{echo "<i class='fa fa-code'></i>";} ?></td>

						  <div class="modal fade oth-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo "#$xx".$dn['date']; ?> Full Details </h3>
									</div>
									<div class="modal-body">
										Transaction Details #<?php echo $xx.($dn['date']); ?><br/>
										Date: &nbsp;&nbsp; <?php echo date('d.m.Y',$dn['date']); ?><br/>
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
	<?php		}
		}else{
			//header('Location: users.php');
		}

?>
</div>
                </div>

<div class="col-xs-12">
<a class="btn btn-primary btn-sm col-md-3 col-xs-4" href="?act=shares&idx=<?php echo $id; ?>">Shares</a><a class="btn btn-warning btn-sm col-md-3 col-xs-4" href="?act=investment&idx=<?php echo $id; ?>">Investment</a><a class="btn btn-info btn-sm col-md-3 col-xs-4" href="?act=savings&idx=<?php echo $id; ?>">Savings</a><a class="btn btn-danger btn-sm col-md-3 col-xs-4" href="?act=target&idx=<?php echo $id; ?>">Target</a><a class="btn btn-success btn-sm col-md-3 col-xs-4" href="?act=emergency&idx=<?php echo $id; ?>">Emergency</a><a class="btn btn-primary btn-sm col-md-3 col-xs-4" href="?act=business&idx=<?php echo $id; ?>">Business</a><a class="btn btn-danger btn-sm col-md-3 col-xs-4" href="?act=loan&idx=<?php echo $id; ?>">Loan</a><a class="btn btn-success btn-sm col-md-3 col-xs-4" href="?act=building&idx=<?php echo $id; ?>">Building</a><a class="btn btn-info btn-sm col-md-3 col-xs-4" href="?act=agm&idx=<?php echo $id; ?>">AGM</a><a class="btn btn-primary btn-sm col-md-3 col-xs-4" href="?act=social&idx=<?php echo $id; ?>">Social</a><a class="btn btn-success btn-sm col-md-3 col-xs-4" href="?act=development&idx=<?php echo $id; ?>">Development</a><a class="btn btn-warning btn-sm col-md-3 col-xs-4" href="?act=others&idx=<?php echo $id; ?>">Others</a>
</div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->
<?php include_once("footer.php"); ?>

  </body>
</html>
