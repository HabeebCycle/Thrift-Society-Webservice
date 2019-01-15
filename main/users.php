<?php
	include_once("header.php");
	$user = $_SESSION['uid'];
		$tot = mysqli_fetch_array(mysqli_query($connection,"select * from loans where user=$user and complete=0"));
		$fcc1 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from shares where user=$user"));$bal1 = $fcc1['amt1'] - $fcc1['amt2'];
		$fcc2 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from investment where user=$user"));$bal2 = $fcc2['amt1'] - $fcc2['amt2'];
		$fcc3 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from savings where user=$user"));$bal3 = $fcc3['amt1'] - $fcc3['amt2'];
		$fcc4 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from target where user=$user"));$bal4 = $fcc4['amt1'] - $fcc1['amt2'];
		$fcc5 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from emergency where user=$user"));$bal5 = $fcc5['amt1'] - $fcc5['amt2'];
		$fcc6 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from business where user=$user"));$bal6 = $fcc6['amt1'] - $fcc6['amt2'];
		$fcc7 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from building where user=$user"));$bal7 = $fcc7['amt1'] - $fcc7['amt2'];
		$fcc8 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from agm where user=$user"));$bal8 = $fcc8['amt1'] - $fcc8['amt2'];
		$fcc9 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from social where user=$user"));$bal9 = $fcc9['amt1'] - $fcc9['amt2'];
		$fcc10 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from development where user=$user"));$bal10 = $fcc10['amt1'] - $fcc10['amt2'];
		$fcc11 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from others where user=$user"));$bal11 = $fcc11['amt1'] - $fcc11['amt2'];

		$interest = ($tot['amount1']>0?(($tot['amount2']-$tot['amount1'])*100/$tot['amount1'] )."%":"");
?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=loan&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Loan <?php echo $interest; ?></span>
              <div class="count red" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($tot['amount2']-$tot['amount3']>0?$tot['amount2']-$tot['amount3']:'0.00'); ?></div>
              <span class="count_bottom">R: <i class="blue"> <?php echo '&#8358; '.($tot['amount1']>0?$tot['amount1']:"0.00"); ?></i><br/>P: <i class="green"><?php echo '&#8358; '.($tot['amount3']>0?$tot['amount3']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=shares&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Shares </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal1>0?$bal1:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc1['amt1']>0?$fcc1['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc1['amt2']>0?$fcc1['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=investment&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Investment </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal2>0?$bal2:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc2['amt1']>0?$fcc2['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc2['amt2']>0?$fcc2['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=savings&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Savings </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal3>0?$bal3:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc3['amt1']>0?$fcc3['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc3['amt2']>0?$fcc3['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=target&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Target </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal4>0?$bal4:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc4['amt1']>0?$fcc4['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc4['amt2']>0?$fcc4['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=emergency&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Emergency </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal5>0?$bal5:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc5['amt1']>0?$fcc5['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc5['amt2']>0?$fcc5['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=business&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Business </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal6>0?$bal6:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc6['amt1']>0?$fcc6['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc6['amt2']>0?$fcc6['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=building&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Building </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal7>0?$bal7:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc7['amt1']>0?$fcc7['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc7['amt2']>0?$fcc7['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=agm&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> AGM </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal8>0?$bal8:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc8['amt1']>0?$fcc8['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc8['amt2']>0?$fcc8['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=social&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Social </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal9>0?$bal9:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc9['amt1']>0?$fcc9['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc9['amt2']>0?$fcc9['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=development&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Development </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal10>0?$bal10:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc10['amt1']>0?$fcc10['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc10['amt2']>0?$fcc10['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='ledgers.php?act=others&idx=<?php echo $user; ?>'>
              <center><span class="count_top"><i class="fa fa-money"></i> Misc. </span>
              <div class="count green" style="font-family:Andalus;font-size:22px;"><?php echo '&#8358; '.($bal11>0?$bal11:"0.00"); ?></div>
              <span class="count_bottom">Cr: <i class="blue"> <?php echo '&#8358; '.($fcc11['amt1']>0?$fcc11['amt1']:'0.00'); ?></i><br/>Dr: <i class="red"> <?php echo '&#8358; '.($fcc11['amt2']>0?$fcc11['amt2']:'0.00'); ?></i> </span></center></a>
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row" style="font-family:Andalus;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3> Better Life for Muslim Ummah </h3>
                  </div>

                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Recent Information</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
					<?php
						$intd = mysqli_query($connection,"select * from messages where mtype=0 order by id desc limit 10");
						while($dns = mysqli_fetch_array($intd)){
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dns['sender']));
					?>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a><?php echo $dns['title']; ?></a>
                                          </h2>
                            <div class="byline">
                              <span><?php echo date('D d.m.Y',$dns['date']); ?></span> by <a><?php echo $fdp['name']; ?></a>
                            </div>
                            <p class="excerpt"><?php if(strlen($dns['message'])>100){ echo substr($dns['message'],0,100).' ... '; ?>
							<a class="btn btn-xs btn-info" data-toggle="modal" data-target=".ann-modal-<?php echo $dns['id']; ?>">Read&nbsp;More</a> <?php }else{ echo $dns['message']; } ?>
							</p>
                          </div>
                        </div>
                      </li>
					  <div class="modal fade ann-modal-<?php echo $dns['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:16px;text-align:left;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo $dns['title']; ?> </h3>
									</div>
									<div class="modal-body">
									<h5><?php echo $fdp['name']; ?> on <?php echo date('D d.m.Y',$dns['date']); ?></h5>
										<p style="color:darkblue;"><?php echo $dns['message']; ?></p>

										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						</div>
					  <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-6 col-sm-6 col-xs-12">
              <!--<div class="x_panel tile fixed_height_320">-->
			  <div class="x_panel">
                <div class="x_title">
                  <h2>Your Loan Balances</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
				  <?php
					$cex = mysqli_query($connection,"select * from loans where user=$user order by date1 desc");
					while($dn = mysqli_fetch_array($cex)){
						$ddd = $dn['amount2']; $dde = $dn['amount3'];
						$t4 = ($ddd==0?0:(($dde/$ddd)*100));
				  ?> <?php echo "<b class='red'>&#8358;".$dn['amount2']."</b>"; ?>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span><?php echo "<b class='blue'>&#8358;".$dn['amount3']."</b>"; ?></span>
                    </div>
                    <div class="w_center w_55">
                      <div class="">
						<div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $t4; ?>"></div>
                        </div>
                      </div>
                    </div>
                    <div class="w_left w_20">
                      <span> &nbsp; <?php echo (int)($t4).'%'; ?></span>
                    </div>
                    <div class="clearfix"></div>
                  </div>
					<?php } ?>

                </div>
              </div>
            </div>


				</div>
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

          <div class="row">

          </div>



        </div>
        <!-- /page content -->

        <?php include_once("footer.php"); ?>

  </body>
</html>
