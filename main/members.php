<?php
include_once("header.php");
if($_SESSION['utype']==3){
		header('Location: users.php');
	}else{
ob_start();
if (isset($_POST['memform'])) {
    // Initialize a session:

    if (empty($_POST['name'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $name = mysqli_real_escape_string($connection,$_POST['name']);
    }
	if (empty($_POST['phone'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $phone = mysqli_real_escape_string($connection,$_POST['phone']);
    }
	if (empty($_POST['regno'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $regno = mysqli_real_escape_string($connection,$_POST['regno']);
    }
	if (empty($_POST['gender'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $gender = mysqli_real_escape_string($connection,$_POST['gender']);
    }
	if (empty($_POST['dob'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $dob = mysqli_real_escape_string($connection,$_POST['dob']);
    }
	if (empty($_POST['doj'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $doj = mysqli_real_escape_string($connection,$_POST['doj']);
    }
	if (empty($_POST['address'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $address = mysqli_real_escape_string($connection,$_POST['address']);
    }
	if (empty($_POST['occ'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $occ = mysqli_real_escape_string($connection,$_POST['occ']);
    }
	if (empty($_POST['pin'])) {//if the email supplied is empty
        $f = 'fz0';
    } else {
        $pin = mysqli_real_escape_string($connection,$_POST['pin']);
		if(!is_numeric($pin)){
			$cor = "Please use four-digit pin"; $f = 'fz0';
		}
    }
	if ($_POST['intro'] == '-1') {//if the email supplied is empty
        $cor = "Please select the person that introduce him/her or 'None' if there is no one"; $f = 'fz0';
    } else {
        $intro = mysqli_real_escape_string($connection,$_POST['intro']);
    }
	if (empty($f)){
		mysqli_query($connection,"insert into users (name,regno,pin,sex,dob,doj,intro,address,phone,occ,ban) values ('$name','$regno',$pin,$gender,'$dob','$doj',$intro,'$address','$phone','$occ',1)");
		$idz = mysqli_fetch_array(mysqli_query($connection,"select * from users order by id desc limit 1"))['id'];
		mysqli_query($connection,"insert into access (user)  values ($idz)");
		echo "<script>alert('New member registered successfully');</script>";
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
                    <h2>List of Better Life Members<small>Details</small></h2>
					&nbsp;&nbsp;<?php if(isset($cor)){ ?><center>
				  <div style="text-align:center;width:30%;background-color:#ccc;border:2px #f00 solid; color:#a0a; font-family:times new roman; text-size:25px">
					<?php echo $cor; ?>
				  </div></center>
			  <?php } ?><?php if($_SESSION['utype']!=3){ ?>
                    <ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success btn-xs" data-toggle="modal" data-target=".new-cem-sm"><i class="fa fa-plus-circle"><b>Add New Member</b></i></button>
						</li>
                    </ul>
			  <?php } ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      List of members under Better Life for Ummah. Click 'Add New Member' button above to register a new member. Click on the 'Edit' button beside each member details to edit member's details.
                    </p>


<div class="modal fade new-cem-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">Register a new member</h4>
			</div>
			<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="modal-body">
					<h5>Fill all the fields</h5>
					<input type="text" name="name" placeholder="Member Name" class="form-control" required="">
					<input type="text" name="regno" placeholder="Registration No." class="form-control" required="">
					<input type="text" name="pin" placeholder="Default 4 digit pin" maxlength="4" class="form-control" required="">
					Gender: &nbsp;<input type="radio" name="gender" value="1" required="">&nbsp;Male&nbsp;&nbsp;
					<input type="radio" name="gender" value="2" required="">&nbsp;Female
					<input type="text" name="dob" placeholder="Birth Date(dd-mm-yyyy)" class="form-control" required="">
					<input type="text" name="doj" placeholder="Join Date(<?php echo date('d-m-Y',time()); ?>)" class="form-control" required="">
					<textarea name="address" placeholder="Member's address and other details" class="form-control" required=""></textarea>
					<input type="text" name="phone" placeholder="Phone No." class="form-control" required="">
					<input type="text" name="occ" placeholder="Occupation" class="form-control" required="">
					<select name="intro" class="form-control"><option value="-1">Introduced By: </option>
						<?php
						$qns = mysqli_query($connection,"SELECT * FROM users");
						while($dns = mysqli_fetch_array($qns)){ ?>
						<option value="<?php echo $dns['id']; ?>" title="<?php echo $dns['regno']; ?>"><?php echo $dns['name']; ?></option>
						<?php } ?>
						<option value="0" title="No one brought him/her">None</option>
					</select>
					<div class="ln_solid"></div>
					<input type="hidden" name="memform" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Member</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


                    <table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Member name</th>
                          <th>Reg. No.</th>
						  <th>Details</th>
                          <th>Shares</th>
						  <th>Investment</th>
                          <th>Savings</th>
                          <th>Target</th>
						  <th>Emergency</th>
						  <th>Business</th>
						  <th>Loan</th>
						  <th>Building</th>
						  <th>AGM</th>
						  <th>Social</th>
						  <th>Development</th>
						  <th>Others</th>
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
                          <td><a class="btn btn-warning btn-xs" href="mdetails.php?act=details&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Details</i></a></td>
                          <td><a class="btn btn-primary btn-xs" href="mdetails.php?act=shares&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Shares</i></a></td>
                          <td><a class="btn btn-success btn-xs" href="mdetails.php?act=investment&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Investment</i></a></td>
                          <td><a class="btn btn-info btn-xs" href="mdetails.php?act=savings&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Savings</i></a></td>
                          <td><a class="btn btn-danger btn-xs" href="mdetails.php?act=target&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Target</i></a></td>
                          <td><a class="btn btn-success btn-xs" href="mdetails.php?act=emergency&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Emergency</i></a></td>
                          <td><a class="btn btn-warning btn-xs" href="mdetails.php?act=business&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Business</i></a></td>
                          <td><a class="btn btn-info btn-xs" href="mdetails.php?act=loan&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Loan</i></a></td>
                          <td><a class="btn btn-primary btn-xs" href="mdetails.php?act=building&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Building</i></a></td>
                          <td><a class="btn btn-success btn-xs" href="mdetails.php?act=agm&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> AGM</i></a></td>
                          <td><a class="btn btn-danger btn-xs" href="mdetails.php?act=social&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Social</i></a></td>
                          <td><a class="btn btn-info btn-xs" href="mdetails.php?act=development&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Development</i></a></td>
                          <td><a class="btn btn-primary btn-xs" href="mdetails.php?act=others&idx=<?php echo $dn['id']; ?>"><i class="fa fa-check-circle"> Others</i></a></td>
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
