<?php
	include_once("header.php");
	$user = $_SESSION['uid'];
	if (isset($_POST['memform'])) {

	$agenda = $_POST['min'];
	//$ddte = "";
	if (empty($_POST['day'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $dater = mysqli_real_escape_string($connection,$_POST['day']);// dd/mm/yyyy
		if(strlen($dater)==10 and strpos($dater,'/')==2 and strrpos($dater,'/')==5){
			$d1 = explode("/",$dater)[0];$d2 = explode("/",$dater)[1];$d3 = explode("/",$dater)[2];
			if(strlen($d1)==2 and is_numeric($d1)){
				if(strlen($d2)==2 and is_numeric($d2)){
					if(strlen($d3)==4 and is_numeric($d1)){
						$date = $dater;
					}
				}
			}
		}
		if(empty($date)){
			$f = 'fz0';$cor = "Date format is wrong use dd/mm/yyyy format";
		}
    }

	if (empty($f)){
		//mktime(hour,minute,second,month,day,year);
		list($d,$m,$y)=explode('/',$date);
		$rdate = mktime(0,0,0,$m,$d,$y);
		mysqli_query($connection,"insert into meetings (date,minutes,admin) values ('$rdate','$agenda',$user)");
		echo "<script>alert('Minutes of the meeting successfully saved.');</script>";
	}
}elseif (isset($_POST['delform'])) {
	$idx = $_POST['idd'];
	mysqli_query($connection,"delete from meetings where id=$idx");
	echo "<script>alert('Minutes of the meeting successfully deleted.');</script>";
}
?>
        <!-- page content -->
        <div class="right_col" role="main">
				<div class="">
		  <div class="clearfix"></div>

            <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Better Life Meetings<small>Details</small></h2>
					&nbsp;&nbsp;<?php if(isset($cor)){ ?><center>
				  <div style="text-align:center;width:30%;background-color:#ccc;border:2px #f00 solid; color:#a0a; font-family:times new roman; text-size:25px">
					<?php echo $cor; ?>
				  </div></center>
			  <?php } ?>
				<?php if($_SESSION['utype']!=3){ ?>
                    <ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success btn-xs" data-toggle="modal" data-target=".meeting-sm"><i class="fa fa-plus-circle"><b>Add Minutes</b></i></button>
						</li>
                    </ul>
			  <?php } ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

					<div class="modal fade meeting-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">Add a new minutes</h4>
			</div>
			<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="modal-body">
					<h5>Fill all the fields</h5>
					<input type="text" name="day" placeholder="Meeting Date(<?php echo date('d/m/Y',time()); ?>)" class="form-control" required=""><br/>
					<textarea name="min" rows="10" placeholder="Meeting details/minutes and other area" class="form-control" required=""><?php if(isset($agenda)){echo $agenda;} ?></textarea>
					<div class="ln_solid"></div>
					<input type="hidden" name="memform" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save Meeting</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

          <div class="row" style="font-family:Andalus;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h4> Better Life for Muslim Ummah Meetings Summary</h4>
                  </div>

                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Minute of Meetings</h2>
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
						$intd = mysqli_query($connection,"select * from meetings order by date desc");
						while($dns = mysqli_fetch_array($intd)){
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dns['admin']));
					?>
                      <li>
                        <div class="block">
                          <div class="block_content">
                            <h2 class="title">
                                              <a class="blue">Meeting <?php echo $dns['date']; ?></a>
                                          </h2>
                            <div class="byline">
                              <span class="black"><?php echo date('D d.m.Y',$dns['date']); ?></span> &nbsp;&nbsp; written by <a class="red"><?php echo $fdp['name'].' ('.$fdp['regno'].')'; ?></a>
                            </div>
                            <p class="excerpt" style="color:#000;font-family:Andalus;font-size:16px;text-align:left;"><?php if(strlen($dns['minutes'])>100){ echo substr($dns['minutes'],0,400).' ... </p>'; ?>
							<a class="btn btn-xs btn-info" data-toggle="modal" data-target=".ann-modal-<?php echo $dns['id']; ?>">Read&nbsp;More</a> <?php }else{ echo $dns['minutes'].'</p>'; } ?> &nbsp; <?php if($_SESSION['utype']!=3 and $_SESSION['uid']==$dns['admin']){ ?><a class="btn btn-xs btn-danger" data-toggle="modal" data-target=".del-modal-<?php echo $dns['id']; ?>">Remove</a><?php } ?>

                          </div>
                        </div>
                      </li>
					  <div class="modal fade ann-modal-<?php echo $dns['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:16px;text-align:left;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Meeting <?php echo $dns['date']; ?> </h3>
									</div>
									<div class="modal-body">
									<h5><?php echo $fdp['name'].' ('.$fdp['regno'].')'; ?> on <?php echo date('D d.m.Y',$dns['date']); ?></h5>
										<p style="color:darkblue;"><?php echo $dns['minutes']; ?></p>

										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						</div>
						<div class="modal fade del-modal-<?php echo $dns['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:16px;text-align:left;">
								<div class="modal-content">
								<form class="form-horizontal form-label-left" name="mosque" method="post" action="">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Delete <?php echo $dns['date']; ?> </h3>
									</div>
									<div class="modal-body">
										<p style="color:darkblue;">Are you sure to delete minute <?php echo $dns['date']; ?></p>
										<input type="hidden" name="idd" value="<?php echo $dns['id']; ?>" />
										<input type="hidden" name="delform" value="TRUE" />
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
									  <button type="submit" value="submit" class="btn btn-primary submit">Delete</button>
									</div>
								</form>
								</div>
							</div>
						</div>
					  <?php } ?>
                    </ul>
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
                </div>
              </div>
            </div>
          </div>



        </div>
        <!-- /page content -->

        <?php include_once("footer.php"); ?>

  </body>
</html>
