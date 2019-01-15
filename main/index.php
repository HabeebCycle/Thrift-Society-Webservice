<?php
	include_once("header.php");
	ob_start();ob_flush();
	if($_SESSION['utype']==3){
		header('Location: users.php');
	}else{
		$cel = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM users where deleted=0 order by id desc limit 1"));
		$cem = mysqli_query($connection,"SELECT * FROM users where deleted=0");
		$cen = mysqli_num_rows($cem);
		$tot = mysqli_fetch_array(mysqli_query($connection,"select * from loans where complete=0 order by id desc limit 1"));
		$inf = mysqli_num_rows(mysqli_query($connection,"select * from loans where complete=0"));
		$tos1 = mysqli_fetch_array(mysqli_query($connection,"select sum(amount2) as amt1, sum(amount3) as amt2 from loans where complete=0"));
		$tos2 = mysqli_fetch_array(mysqli_query($connection,"select sum(amount1) as amt1 from loans where complete=0"));

		$mos1 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt from payment"));
		$mos2 = mysqli_fetch_array(mysqli_query($connection,"select sum(amountdr) as amt from payment"));
		$mos3 = mysqli_fetch_array(mysqli_query($connection,"select * from payment where amountcr>0 order by id desc limit 1"));
		$mos4 = mysqli_fetch_array(mysqli_query($connection,"select * from payment where amountdr>0 order by id desc limit 1"));
		$inz1 = mysqli_num_rows(mysqli_query($connection,"select * from meetings"));
		$inz2 = mysqli_fetch_array(mysqli_query($connection,"select date from meetings order by date desc limit 1"));

		$incm = $mos1['amt']; $expd = $mos2['amt'];
		$lop = ($incm>0?(int)(100*$expd/$incm):0);
		$outp = $tos1['amt1']; $ipay = $tos1['amt2'];
		$xip = ($outp>0?(int)(100*$ipay/$outp):0);
		$mnum = $cen; $pnum = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM users where deleted=0 and ban=0"));
		$mjp = ($mnum>0?(int)(100*$pnum/$mnum):0);
		$mcum = $cen; $pcum = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM users where deleted=0 and active=1"));
		$mcp = ($mcum>0?(int)(100*$pcum/$mcum):0);

?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='members.php'>
              <center><span class="count_top"><i class="fa fa-users"></i> Number of Members </span>
              <div class="count green" style="font-family:Andalus;font-size:20px;"><?php echo $cen; ?></div>
              <span class="count_bottom">Latest <i class="green"> <?php echo ($cen>0?$cel['name']:'None'); ?> </i> </span></center></a>
            </div>
			<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='loans.php'>
              <center><span class="count_top"><i class="fa fa-money"></i> Loan Given </span>
              <div class="count green" style="font-family:Andalus;font-size:20px;"><?php echo $inf; ?></div>
              <span class="count_bottom">Latest <i class="green"> <?php echo '&#8358; '.($inf>0?$tot['amount1']:'0.00'); ?> </i> </span></center></a>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='loans.php'>
              <center><span class="count_top"><i class="fa fa-area-chart"></i> Loan Amount </span>
              <div class="count green" style="font-family:Andalus;font-size:20px;"><?php echo '&#8358; '.($tos2['amt1']>0?$tos2['amt1']:'0'); ?></div>
			  <span class="count_bottom">Balance <i class="green"> <?php echo '&#8358; '.($tos1['amt1']-$tos1['amt2']); ?> </i> </span>
              <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>$0.00 </i> Yesterday</span> --></center></a>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='payment.php'>
              <center><span class="count_top"><i class="fa fa-money"></i> Pay-In </span>
              <div class="count green" style="font-family:Andalus;font-size:20px;"><?php echo '&#8358; '.($mos1['amt']>0?$mos1['amt']:0); ?></div>
			  <span class="count_bottom">Last <i class="green"> <?php echo $mos3['date']>0?date('d.m.Y',$mos3['date']):'N/A'; ?> </i> </span>
              <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>$0.00 </i> Yesterday</span>--></center></a>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='payment.php'>
              <center><span class="count_top"><i class="fa fa-building"></i> Pay-Out </span>
              <div class="count green" style="font-family:Andalus;font-size:20px;"><?php echo '&#8358; '.($mos2['amt']>0?$mos2['amt']:0); ?></div>
			  <span class="count_bottom">Last <i class="green"> <?php echo $mos4['date']>0?date('d.m.Y',$mos4['date']):'N/A'; ?> </i> </span>
              <!--<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>$0.00 </i> Yesterday</span>--></center></a>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"><a href='meeting.php'>
              <center><span class="count_top"><i class="fa fa-users"></i> Meetings </span>
              <div class="count green" style="font-family:Andalus;font-size:20px;"><?php echo $inz1; ?></div></a><a href='worsta.php'>
			  <span class="count_bottom">Last <i class="green"> <?php echo $inz2['date']>0?date('d.m.Y',$inz2['date']):'N/A'; ?> </i> </span></center></a>
              <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>$0.00 </i> Yesterday</span>-->
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
              <!--<div class="x_panel tile fixed_height_320">-->
			  <div class="x_panel">
                <div class="x_title">
                  <h2>Loan Balances</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
				  <?php
					$cex = mysqli_query($connection,"select * from loans where complete=0 order by date1 desc");
					while($dn = mysqli_fetch_array($cex)){
						$reg = mysqli_fetch_array(mysqli_query($connection,"select regno from users where id=".$dn['user']));
						$ddd = $dn['amount2']; $dde = $dn['amount3'];
						$t4 = ($ddd==0?0:(($dde/$ddd)*100));
				  ?>
                  <div class="widget_summary">
                    <div class="w_left w_25">
                      <span><?php echo $reg['regno']; ?></span>
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

                <div class="col-md-6 col-sm-6 col-xs-12">
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Balance Sheet</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div>
                      <p> Payment Details (<?php  echo $expd.'/'.$incm; ?>)</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
						<?php if($incm-$expd<200){ ?>
						  <div class="progress-bar bg-red" role="progressbar" data-transitiongoal="<?php echo $lop; ?>"></div>
						<?php }else{ ?>
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $lop; ?>"></div>
						<?php } ?>
                        </div>
                      </div>
                    </div>
                    <div>
                      <p>Loan Details (<?php echo $ipay.'/'.$outp; ?>)</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $xip; ?>"></div>
                        </div>
                      </div>
                    </div>
					<div>
                      <p> Members' Activation (<?php echo $pcum.'/'.$mcum; ?>)</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $mcp; ?>"></div>
                        </div>
                      </div>
                    </div>
					<div>
                      <p> Members' Subsription (<?php echo $pnum.'/'.$mnum; ?>)</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 100%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $mjp; ?>"></div>
                        </div>
                      </div>
                    </div>
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
	<?php } ?>
