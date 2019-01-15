<?php
include_once("header.php");

?>
<div class="right_col" role="main">
          <div class="">
		  <div class="clearfix"></div>

            <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Better Life Members<small>Details</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      List of members under Better Life for Ummah. .
                    </p>





                    <table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Member name</th>
                          <th>Reg. No.</th>
						  <th>Type</th>
						  <th>Gender</th>
                          <th>Join</th>
						  <th>Activate</th>
						  <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
						$qnx = mysqli_query($connection,"select * from users where deleted=0");
						while($dn = mysqli_fetch_array($qnx)){
								//if($dn['id']==$_SESSION['uid'])
									//continue;
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo $dn['name']; ?></td>
                          <td><?php echo $dn['regno']; ?></td>
                          <td><?php echo ($dn['utype']==3?'Member':'Admin'); ?></td>
						  <td><?php echo ($dn['sex']==1?'Male':'Female'); ?></td>
						  <td><?php echo $dn['doj']; ?></td>
						  <td><?php echo ($dn['active']==1?'YES':'NO'); ?></td>
						  <td><?php echo ($dn['ban']==0?'Active':'Banned'); ?></td>
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
