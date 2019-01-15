<?php
include_once("header.php");
if($_SESSION['utype']==3){
		header('Location: users.php');
	}else{
ob_start();
if (isset($_GET['act'])) {
    $act = $_GET['act'];
	$idd = $_GET['idx'];
	$qnx = mysqli_fetch_array(mysqli_query($connection,"select * from access where id=$idd"));
	$user = $qnx['user'];
	$ddd = date('m-Y',time());
	$pay4 = $qnx['paid'];
	if($act=='pay'){
		$npay = $pay4."#".$ddd;
		mysqli_query($connection,"update access set paid='$npay' where id=$idd");
		mysqli_query($connection,"update users set ban=0 where id=$user");
	}elseif($act=='unpay'){
		$pays = explode("#",$pay4);
		$len = count($pays);
		$num = 0;
		for($t=1;$t<$len;$t++){
			if($pays[$t] == $ddd){
				$num = $t;
				break;
			}
		}
		$npay = '';
		for($t=1;$t<$len;$t++){
			if($num != $t)
				$npay = $npay.'#'.$pays[$t];
		}
		mysqli_query($connection,"update users set ban=1 where id=$user");
		mysqli_query($connection,"update access set paid='$npay' where id=$idd");
	}
}

?>
<div class="right_col" role="main">
          <div class="">
		  <div class="clearfix"></div>

            <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Better Life Members<small>Application Access</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      List of members under Better Life for Ummah. Click pay to give access to each member.
                    </p>


                    <table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Member name</th>
                          <th>Reg. No.</th>
						  <th>Status</th>
						  <th>Current</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
					  $ddd = date('m-Y',time());
						$qnx = mysqli_query($connection,"select * from access");
						while($dn = mysqli_fetch_array($qnx)){
							$jk = 0;
							$pat = "<b class='red fa fa-remove'> </b>";
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno, ban from users where id=".$dn['user']));
							$pay = explode("#",$dn['paid']);
							$len = count($pay);
							for($i=1;$i<$len;$i++){
								if($pay[$i] == $ddd){
									$pat = "<b class='green fa fa-check'> </b>";
									$jk = 1;
									break;
								}
							}

					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
                          <td><?php echo $fdp['name']; ?></td>
                          <td><?php echo $fdp['regno']; ?></td>
						  <td><?php echo "<i class='fa fa-".($fdp['ban']==0?"unlock green'> Active":"lock red'> Locked")."</i>"; ?></td>
                          <td><?php echo date('M, Y',time())."  ".$pat; ?></td>
                          <td><?php if($_SESSION['utype']==1){ ?><a class="btn <?php echo $jk==1?'btn-warning':'btn-info'; ?> btn-xs" href="?act=<?php echo $jk==1?'unpay':'pay'; ?>&idx=<?php echo $dn['id']; ?>"><i class="fa fa-refresh"> <?php echo $jk==1?'  Unpay':' &nbsp;Pay'; ?></i></a> <?php } ?> &nbsp;&nbsp;&nbsp; <a class="btn btn-primary btn-xs" data-toggle="modal" data-target=".his-det-<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> History</i></a></td>

						  <div class="modal fade his-det-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"> Payment History </h3>
									</div>
									<div class="modal-body"><?php
										if($len <= 1){
											echo "No history payment";
										}
										$mon = ['Jan.','Feb.','Mar.','Apr.','May','Jun.','Jul.','Aug.','Sep.','Oct.','Nov.','Dec.'];
										for($i=1;$i<$len;$i++){
											$puk = explode("-",$pay[$i]);
											echo "<b class='green fa fa-check'> ".$mon[$puk[0]-1].", ".$puk[1]."</b>&nbsp;&nbsp;";
										} ?>
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
