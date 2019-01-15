<?php
	include_once("header.php");
	$user = $_SESSION['uid'];
	$sxc = 0;$stc="";
	if (isset($_POST['memform'])) {
		$title = mysqli_real_escape_string($connection,$_POST['title']);
		$message = mysqli_real_escape_string($connection,$_POST['message']);
		$receipt = mysqli_real_escape_string($connection,$_POST['receipt']);
		if($receipt==-1){
			$f='fz1';$cor="Please select the message receipent";
		}

	if (empty($f)){
		$dat = time();
		mysqli_query($connection,"insert into messages (mtype,sender,receipt,date,title,message) values ($receipt,$user,$receipt,$dat,'$title','$message')");
		echo "<script>alert('Message was successfully sent.');</script>";
	}
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
                    <h2>List of Better Life Messages<small>Details</small></h2>
					&nbsp;&nbsp;<?php if(isset($cor)){ ?><center>
				  <div style="text-align:center;width:30%;background-color:#ccc;border:2px #f00 solid; color:#a0a; font-family:times new roman; text-size:25px">
					<?php echo $cor; ?>
				  </div></center>
			  <?php } ?>
                    <ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success btn-xs" data-toggle="modal" data-target=".meeting-sm"><i class="fa fa-plus-circle"><b> Compose New Message</b></i></button>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

<div class="modal fade meeting-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">Send New Message</h4>
			</div>
			<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="modal-body">
					<h5>Fill all the fields</h5>
					<select name="receipt" class="form-control"><option value="-1">Receipent: </option>
						<?php
						$qns = mysqli_query($connection,"SELECT * FROM users where id!=$user");
						while($dns = mysqli_fetch_array($qns)){ ?>
						<option value="<?php echo $dns['id']; ?>" title="<?php echo $dns['regno']; ?>"><?php echo $dns['name']." (".$dns['regno'].")"; ?></option>
						<?php } ?>
						<option value="0" title="Information to all members"><b class='fa fa-users'> Information to Everyone </b></option>
					</select>
					<input type="text" name="title" placeholder="Type Subject" class="form-control" required=""><br/>
					<textarea name="message" rows="10" placeholder="Write your message here" class="form-control" required=""><?php if(isset($message)){echo $message;} ?></textarea>
					<div class="ln_solid"></div>
					<input type="hidden" name="memform" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit fa fa-send" onclick=""> SEND</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


<?php
@$idx = $_GET['link'];
@$idd = $_GET['deli'];
if(isset($idx)){
	mysqli_query($connection,"update messages set readr=1 where id=$idx and receipt=".$_SESSION['uid']);
	$msgr = mysqli_fetch_array(mysqli_query($connection,"select * from messages where mtype!=0 and receipt=".$_SESSION['uid']." and id=$idx"));
}
if(isset($idd)){
	mysqli_query($connection,"delete from messages where receipt=".$_SESSION['uid']." and id=$idd");
}
?>
<div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Message Inbox <small></small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-sm-3 mail_list_column">
                        <button id="compose" class="btn btn-sm btn-success btn-block" type="button">INBOX</button>
				<?php
				$req1 = mysqli_query($connection,"select * from messages where mtype!=0 and receipt=".$_SESSION['uid']." order by id desc");
				$i=0;
				while($dx = mysqli_fetch_array($req1)){
					$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dx['sender']));
					if(!isset($msgr)){if($i == 0){ $msgr = $dx; }}
					$i++;
				?>
                        <a href="?link=<?php echo $dx['id']; ?>#mss" id="link<?php echo $dx['id']; ?>">
                          <div class="mail_list">
                            <div class="left">
                              <?php echo($dx['readr']==0?'<i class="fa fa-circle"></i>':'<i class="fa fa-circle-o"></i>'); ?> <i class="fa fa-edit"></i>
                            </div>
                            <div class="right">
                              <?php echo ($dx['readr']==0?'<h3>':'<h5>'); ?><?php echo $dx['title']; ?> &nbsp;&nbsp;<small><?php echo date('D, d.m.Y',$dx['date']); ?></small></h3>
                              <p><?php echo ($dx['readr']==0?'<b>':'').$fdp['name'].' ('.$fdp['regno'].')'; ?></b></p>
                            </div>
                          </div>
                        </a>
                <?php } ?>
                      </div>
                      <!-- /MAIL LIST -->

                      <!-- CONTENT MAIL --><a name="mss">
                      <div class="col-sm-9 mail_view">
                        <div class="inbox-body">
						<?php if(isset($msgr)){
							$fdp = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$msgr['sender']));
							$sxc = $msgr['sender']; $stc = "Re: ".$msgr['title'];
						?>
                          <div class="mail_heading row">
                            <div class="col-md-8">
                              <div class="btn-group">
								&nbsp;
							  </div>
							</div>
                            <div class="col-md-4 text-right">
                              <p class="date"> <?php echo date('D, h:i A d M, Y',$msgr['date']-3600); ?></p>
                            </div>
                            <div class="col-md-12">
                              <h4> <?php echo $msgr['title']; ?></h4>
                            </div>
                          </div>
                          <div class="sender-info">
                            <div class="row">
                              <div class="col-md-12">
                                <strong><?php echo $fdp['name'].' ('.$fdp['regno'].')'; ?></strong>
                                <span>(Better Life)</span> to
                                <strong>me</strong>
                              </div>
                            </div>
                          </div>
                          <div class="view-mail">
                            <p><?php echo $msgr['message']; ?></p>
                          </div>

                          <div class="btn-group">
						  <a class="btn btn-sm btn-primary" type="button" data-original-title="Reply" data-toggle="modal" data-target=".meeting1-sm"><i class="fa fa-reply"></i> Reply</a> &nbsp;&nbsp;&nbsp;
                             <a href="?deli=<?php echo $msgr['id']; ?>" id="deli<?php echo $msgr['id']; ?>" class="btn btn-sm btn-danger" type="button" data-original-title="Trash"><i class="fa fa-trash-o"></i> Delete</a>

                          </div>
						<?php }else{
							echo "<b class='blue fa fa-envelope '>  You have no Message</b>";
						} ?>
                        </div>

                      </div></a>
                      <!-- /CONTENT MAIL -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

		  </div>
                </div>
              </div>
            </div>
          </div>
<div class="modal fade meeting1-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">Send New Message</h4>
			</div>
			<form class="form-horizontal form-label-left" name="mosque" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="modal-body">
					<h5>Fill all the fields</h5>
					<select name="receipt" class="form-control"><option value="-1">Receipent: </option>
						<?php
						$qns = mysqli_query($connection,"SELECT * FROM users where id!=$user");
						while($dns = mysqli_fetch_array($qns)){ ?>
						<option value="<?php echo $dns['id']; ?>" title="<?php echo $dns['regno']; ?>" <?php echo $sxc==$dns['id']?'selected':''; ?>><?php echo $dns['name']." (".$dns['regno'].")"; ?></option>
						<?php } ?>
						<option value="0" title="Information to all members"><b class='fa fa-users'> Information to Everyone </b></option>
					</select>
					<input type="text" name="title" value="<?php echo $stc; ?>" class="form-control" required=""><br/>
					<textarea name="message" rows="10" placeholder="Write your message here" class="form-control" required=""><?php if(isset($message)){echo $message;} ?></textarea>
					<div class="ln_solid"></div>
					<input type="hidden" name="memform" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit fa fa-send" onclick=""> SEND</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>


        </div>
        <!-- /page content -->

        <?php include_once("footer.php"); ?>

  </body>
</html>
