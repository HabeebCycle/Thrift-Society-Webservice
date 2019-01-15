<?php
include_once("header.php");
ob_start();
if($_SESSION['utype']==3){
		header('Location: users.php');
	}else{
		$act = $_GET['act'];
		$id = $_GET['idx'];

		if (isset($_POST['editdetails'])) {
			$name = mysqli_real_escape_string($connection,$_POST['name']);
			$phone = mysqli_real_escape_string($connection,$_POST['phone']);
			$regno = mysqli_real_escape_string($connection,$_POST['regno']);
			$gender = mysqli_real_escape_string($connection,$_POST['gender']);
			$dob = mysqli_real_escape_string($connection,$_POST['dob']);
			$doj = mysqli_real_escape_string($connection,$_POST['doj']);
			$address = mysqli_real_escape_string($connection,$_POST['address']);
			$occ = mysqli_real_escape_string($connection,$_POST['occ']);
			$intro = mysqli_real_escape_string($connection,$_POST['intro']);

			$usename = $_POST['funidn'];
			$idd = $_POST['idd'];
			$cem = mysqli_num_rows(mysqli_query($connection,"select regno from users where regno='$regno' and regno!='$usename' and deleted=0"));
			if($cem>0){
				$cor = "Registration Number already exist, use another username.";
			}else{
				mysqli_query($connection,"update users set name='$name',regno='$regno',sex=$gender,dob='$dob',doj='$doj',intro=$intro,address='$address',phone='$phone',occ='$occ' where id=$idd");
				echo "<script>alert('Member details edited successfully');</script>";
			}
		}elseif(isset($_POST['memshares'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into shares (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from shares order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (1,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New shares credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into shares (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from shares order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (1,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New shares debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editshares'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update shares set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=1 and acid = $idd");
				echo "<script>alert('Shares credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal){
					mysqli_query($connection,"update shares set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=1 and acid = $idd");
					echo "<script>alert('Shares debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['meminvest'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into investment (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from investment order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (2,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New investment credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into investment (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from investment order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (2,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New investment debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editinvest'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update investment set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=2 and acid = $idd");
				echo "<script>alert('Investment credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update investment set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=2 and acid = $idd");
					echo "<script>alert('Investment debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['memsave'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into savings (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from savings order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (3,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New savings credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into savings (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from savings order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (3,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New savings debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editsave'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update savings set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=3 and acid = $idd");
				echo "<script>alert('Savings credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update savings set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=3 and acid = $idd");
					echo "<script>alert('Savings debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['memtarg'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into target (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from target order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (4,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New target credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into target (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from target order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (4,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New target debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['edittarg'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update target set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=4 and acid = $idd");
				echo "<script>alert('Target credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update target set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=4 and acid = $idd");
					echo "<script>alert('Target debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['mememer'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into emergency (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from emergency order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (5,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New emergency credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into emergency (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from emergency order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (5,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New emergency debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editemer'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update emergency set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=5 and acid = $idd");
				echo "<script>alert('Emergency credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update emergency set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=5 and acid = $idd");
					echo "<script>alert('Emergency debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['membusi'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into business (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from business order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (6,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New business credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into business (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from business order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (6,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New business debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editbusi'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update business set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=6 and acid = $idd");
				echo "<script>alert('Business credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update business set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=6 and acid = $idd");
					echo "<script>alert('Business debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['membuid'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into building (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from building order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (7,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New building credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into building (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from building order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (7,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New building debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editbuid'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update building set amountcr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=7 and acid = $idd");
				echo "<script>alert('Building credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update building set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=7 and acid = $idd");
					echo "<script>alert('Building debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['memagm'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into agm (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from agm order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (8,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New AGM credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into agm (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from agm order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (8,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New agm debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editagm'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update agm set amountcr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=8 and acid = $idd");
				echo "<script>alert('AGM credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update agm set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=8 and acid = $idd");
					echo "<script>alert('AGM debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['memsoci'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into social (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from social order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (9,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New social credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into social (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from social order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (9,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New social debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editsoci'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update social set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=9 and acid = $idd");
				echo "<script>alert('Social credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update social set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=9 and acid = $idd");
					echo "<script>alert('Social debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['memdeve'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into development (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from development order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (10,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New development credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into development (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from development order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (10,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New development debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editdeve'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update development set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=10 and acid = $idd");
				echo "<script>alert('Development credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update development set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=10 and acid = $idd");
					echo "<script>alert('Development debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['memothe'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0){
					mysqli_query($connection,"insert into others (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from others order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (11,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New misc. credit transaction initiated successfully');</script>";
				}
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"insert into others (user,date,amountdr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from others order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (11,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New misc. debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['editothe'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				mysqli_query($connection,"update others set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=11 and acid = $idd");
				echo "<script>alert('Misc. credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				if($amt<=$bal and $amt>0){
					mysqli_query($connection,"update others set amountdr=$amt,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=11 and acid = $idd");
					echo "<script>alert('Misc. debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\\n Amount debiting is more than the balance or negative value.');</script>";
				}
			}
		}elseif(isset($_POST['memloan'])){
			$acc = mysqli_real_escape_string($connection,$_POST['acc']);
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$inte = mysqli_real_escape_string($connection,$_POST['interest']);
			$details = mysqli_real_escape_string($connection,$_POST['details']);

			$admin = $_SESSION['uid'];
			$bal = $_POST['bal'];
			$samt = $_POST['samt'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit (Repayment)":"Debit (Loan give out)")."transaction created by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."  (".$info.")";
			if($acc==1){
				if($amt>0 && $bal<0){
					mysqli_query($connection,"insert into loan (user,date,amountcr,details,admin) values ($user,$dat,$amt,'$full',$admin)");
					mysqli_query($connection,"update loans set amount3=amount3+$amt where user=$user and complete=0");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from loan order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountcr,details,admin) values (12,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New loan credit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('Error!\\n Invalid value entered or no loan to pay.');</script>";
				}
			}elseif($acc==2){
				if($amt<=$samt and $bal>=0){
					$inty = ($inte*($amt/100))+$amt;
					mysqli_query($connection,"insert into loan (user,date,amountdr,amountpay,details,admin) values ($user,$dat,$amt,$inty,'$full',$admin)");
					$save = $samt/2;
					mysqli_query($connection,"insert into loans (user,savings,amount1,amount2,date1,details,admin) values ($user,$save,$amt,$inty,$dat,'$full',$admin)");
					$idz = mysqli_fetch_array(mysqli_query($connection,"select * from loan order by id desc limit 1"))['id'];
					mysqli_query($connection,"insert into payment (actype,acid,user,date,amountdr,details,admin) values (12,$idz,$user,$dat,$amt,'$full',$admin)");
					echo "<script>alert('New loan debit transaction initiated successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\n The member savings balance is not up to the debit transaction value or the formal loan has not been repaid.');</script>";
				}
			}
		}elseif(isset($_POST['editloan'])){
			$acc = $_POST['acc'];
			$amt = mysqli_real_escape_string($connection,$_POST['amt']);
			$details1 = mysqli_real_escape_string($connection,$_POST['details1']);
			$inte = mysqli_real_escape_string($connection,$_POST['interest']);
			$details = $_POST['details'];
			$idd = $_POST['idd'];
			$dat = time();
			$user = $id;
			$info = ($acc==1?"Credit ":"Debit ")."transaction edited by ".$_SESSION['name']." of &#8358;".$amt." on ".date('D d.m.Y h:i:s A',$dat);
			$full = $details."<br/>".$details1."  (".$info.")";
			if($acc==1){
				$fdr = mysqli_fetch_array(mysqli_query($connection,"select amountcr from loan where user=$user and id=$idd"))['amountcr'];
				mysqli_query($connection,"update loan set amountcr=$amt,details='$full' where user=$user and id = $idd");
				mysqli_query($connection,"update loans set amount3=amount3+$amt-$fdr where user=$user and complete=0");
				mysqli_query($connection,"update payment set amountcr=$amt,details='$full' where user=$user and actype=12 and acid = $idd");
				echo "<script>alert('Loan credit transaction edited successfully');</script>";
			}elseif($acc==2){
				$bal = $_POST['bal'];
				$samt = $_POST['samt'];
				if($amt<=$samt and $bal>=0){
					$inty = ($inte*($amt/100))+$amt;
					mysqli_query($connection,"update loan set amountdr=$amt,amountpay=$inty,details='$full' where user=$user and id = $idd");
					mysqli_query($connection,"update loans set amount1=$amt,amount2=$inty,details='$full' where user=$user and complete=0");
					mysqli_query($connection,"update payment set amountdr=$amt,details='$full' where user=$user and actype=12 and acid = $idd");
					echo "<script>alert('Loan debit transaction edited successfully');</script>";
				}else{
					echo "<script>alert('ERROR!\n The member savings balance is not up to the debit transaction value or the formal loan has not been repaid.');</script>";
				}
			}
		}

		if(isset($id) and (($_SESSION['utype']==2) or ($_SESSION['utype']==1))){
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
					&nbsp;&nbsp;<?php if(isset($cor)){ ?><center>
				  <div style="text-align:center;width:30%;background-color:#ccc;border:2px #f00 solid; color:#a0a; font-family:times new roman; text-size:25px">
					<?php echo $cor; ?>
				  </div></center>
			  <?php } ?><?php if($_SESSION['utype']!=3 and $act!='details' and $det['id'] != $_SESSION['uid']){ ?>
                    <ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success btn-xs" data-toggle="modal" data-target=".<?php echo $act; ?>-sm"><i class="fa fa-plus-circle"><b>Add/Edit <?php echo $act; ?> Account</b></i></button>
						</li>
                    </ul>
			  <?php } ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30" >
                      List of members' <?php echo $act; ?> under Better Life for Ummah.
                    </p>

	<?php		if($act=='details'){ ?>

					<table id="datatable-responsive" class="table table-striped jambo_table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Type</th>
						  <th>Gender</th>
                          <th>DOB</th>
                          <th>Join</th>
						  <th>Activate</th>
						  <th>Status</th>
						  <th>Details</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
						$qnx = mysqli_query($connection,"select * from users where id=$id");
						while($dn = mysqli_fetch_array($qnx)){
							$fdx = mysqli_fetch_array(mysqli_query($connection,"select name, regno from users where id=".$dn['intro']));
					  ?>
                        <tr style="color:#000;font-family:Andalus;font-size:16px;text-align:justify;">
						  <td><?php echo ($dn['utype']==3?'Member':'Admin'); ?></td>
						  <td><?php echo ($dn['sex']==1?'Male':'Female'); ?></td>
						  <td><?php echo $dn['dob']; ?></td>
						  <td><?php echo $dn['doj']; ?></td>
						  <td><?php echo ($dn['active']==1?'YES':'NO'); ?></td>
						  <td><?php echo ($dn['ban']==0?'Active':'Banned'); ?></td>
						  <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target=".det-add-<?php echo $dn['id']; ?>"><i class="fa fa-home"> Details </i></button></td>
						  <td><button class="btn btn-warning btn-xs" data-toggle="modal" data-target=".det-edt-<?php echo $dn['id']; ?>"><i class="fa fa-cog"> Edit </i></button></td>

						  <div class="modal fade det-add-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:18px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo $dn['name']; ?> Other Details </h3>
									</div>
									<div class="modal-body">
									<?php if($det['utype']==3 or $det['id'] == $_SESSION['uid']){ ?>
									Reg No.: &nbsp;&nbsp;<?php echo $dn['regno']; ?><br/>
									PIN: &nbsp;&nbsp;<?php echo $dn['pin']; ?><br/><br/>
									<?php } ?>
										Introduced By<br/><?php echo ($dn['intro']==0?"NONE":$fdx['name'].' '.$fdx['regno']); ?><br/>
										Phone Number<br/><?php echo $dn['phone']; ?><br/>
										Occupation<br/><?php echo $dn['occ']; ?><br/>
										Address<br/><?php echo $dn['address']; ?><br/><br/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
									</div>
								</div>
							</div>
						  </div>
						  <div class="modal fade det-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2"><?php echo $dn['name']; ?> Edit Details </h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="mosque" method="post" action="?act=details&idx=<?php echo $dn['id']; ?>">
				<div class="modal-body">
					Name<input type="text" name="name" value="<?php echo $dn['name']; ?>" class="form-control" required="">
					Reg No.<input type="text" name="regno" value="<?php echo $dn['regno']; ?>" class="form-control" required="">
					<?php if($det['utype']==3 or $det['id'] == $_SESSION['uid']){ ?>
					Pin <input type="text" name="pin" value="<?php echo $dn['pin']; ?>" readonly class="form-control" required=""><?php } ?>
					Gender: &nbsp;<input type="radio" name="gender" value="1" <?php echo $dn['sex']==1?'checked':''; ?> required="">&nbsp;Male&nbsp;&nbsp;<input type="radio" name="gender" value="2" <?php echo $dn['sex']==2?'checked':''; ?> required="">&nbsp;Female<br/>
					Date of Birth<input type="text" name="dob" value="<?php echo $dn['dob']; ?>" class="form-control" required="">
					Join Date<input type="text" name="doj" value="<?php echo $dn['doj']; ?>" class="form-control" required="">
					Details/Address<textarea name="address" class="form-control" required=""><?php echo $dn['address']; ?></textarea>
					Phone<input type="text" name="phone" value="<?php echo $dn['phone']; ?>" class="form-control" required="">
					Occupation<input type="text" name="occ" value="<?php echo $dn['occ']; ?>" class="form-control" required="">
					Introduced By<select name="intro" class="form-control">
						<?php
						$qns = mysqli_query($connection,"SELECT * FROM users");
						while($dns = mysqli_fetch_array($qns)){ ?>
						<option value="<?php echo $dns['id']; ?>" title="<?php echo $dns['regno']; ?>" <?php echo $dn['intro']==$dns['id']?'selected':''; ?>><?php echo $dns['name']; ?></option>
						<?php } ?>
						<option value="0" title="No one brought him/her" <?php echo $dn['intro']==0?'selected':''; ?>>None</option>
					</select>
					<div class="ln_solid"></div>
					<input type="hidden" name="editdetails" value="TRUE" />
												<input type="hidden" name="funidn" value="<?php echo $dn['regno']; ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>" />
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
								</div>
							</div>
						  </div>

						</tr>
						<?php } ?>
                      </tbody>
                    </table>

	<?php	}elseif($act=='shares'){

	$fcc = mysqli_fetch_array(mysqli_query($connection,"select sum(amountcr) as amt1, sum(amountdr) as amt2 from shares where user=$id"));
	$bal = $fcc['amt1'] - $fcc['amt2'];
	?>

<script type="text/javascript">
function isdeb(){
    var r=document.shares.acc.value;
	var d=document.shares.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.shares.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade shares-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Shares Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="shares" method="post" action="?act=shares&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Shares Account">Credit</option>
						<option value="2" title="Debit Shares Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="memshares" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtshares<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtshares<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtshares<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade sha-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Shares <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtshares<?php echo $dn['id']; ?>" method="post" action="?act=shares&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editshares" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>"/>
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.investment.acc.value;
	var d=document.investment.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.investment.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade investment-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Investment Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="investment" method="post" action="?act=investment&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Investment Account">Credit</option>
						<option value="2" title="Debit Investment Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="meminvest" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtinvest<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtinvest<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtinvest<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade inv-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Investment <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtinvest<?php echo $dn['id']; ?>" method="post" action="?act=investment&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editinvest" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.savings.acc.value;
	var d=document.savings.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.savings.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade savings-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Savings Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="savings" method="post" action="?act=savings&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Savings Account">Credit</option>
						<option value="2" title="Debit Savings Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="memsave" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtsave<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtsave<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtsave<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade sav-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Savings <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtsave<?php echo $dn['id']; ?>" method="post" action="?act=savings&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editsave" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.target.acc.value;
	var d=document.target.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.target.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade target-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Target Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="target" method="post" action="?act=target&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Target Account">Credit</option>
						<option value="2" title="Debit Target Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="memtarg" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edttarg<?php echo $dn['id']; ?>.acc.value;
							d1=document.edttarg<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edttarg<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade tag-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Target <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edttarg<?php echo $dn['id']; ?>" method="post" action="?act=target&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="edittarg" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.emergency.acc.value;
	var d=document.emergency.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.emergency.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade emergency-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Emergency Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="emergency" method="post" action="?act=emergency&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Emergency Account">Credit</option>
						<option value="2" title="Debit Emergency Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="mememer" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtemer<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtemer<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtemer<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade eme-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Emergency <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtemer<?php echo $dn['id']; ?>" method="post" action="?act=emergency&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editemer" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.business.acc.value;
	var d=document.business.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.business.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade business-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Business Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="business" method="post" action="?act=business&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Business Account">Credit</option>
						<option value="2" title="Debit Business Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="membusi" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtbusi<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtbusi<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtbusi<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade bus-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Business <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtbusi<?php echo $dn['id']; ?>" method="post" action="?act=business&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editbusi" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.loan.acc.value;
	var d=document.loan.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if((d><?php echo $samt; ?>) || (<?php echo $bal; ?><0)){
				alert("ERROR!\n The member savings balance is not up to the debit transaction value or the formal loan has not been repaid.");
				document.loan.amt.value = "0.00";
				return;
			}else{
				document.loan.payback.value = d;
			}
		}
	}
}
function calInt(){
	var r=document.loan.acc.value;
	var d=document.loan.amt.value;
	var i=document.loan.interest.value;
	if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			amm = ((i/100)*Number(d))+Number(d);
			document.loan.payback.value = amm;
		}
	}
}

</script>
	<div class="modal fade loan-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Loan Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="loan" method="post" action="?act=loan&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Loan Account">Credit (Pay back loan)</option>
						<option value="2" title="Debit Loan Account">Debit (Give out loan)</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					Interest Rate (%) <i>*Leave 0 if no interest rate</i> <input type="text" name="interest" value="0.00" placeholder="0.00" required="" onblur="calInt();" /><br/>
					Pay Back (&#8358;)<input type="text" name="payback" placeholder="&#8358; 0.00" class="form-control" readonly onblur="">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="samt" value="<?php echo $samt; ?>" />
					<input type="hidden" name="memloan" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtloan<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtloan<?php echo $dn['id']; ?>.amt.value;
							i1=document.edtloan<?php echo $dn['id']; ?>.interest.value;
							if(r1==2){
								if((d1><?php echo $samt; ?>) || (<?php echo ($bal+$dn['amountpay']); ?><0)){
									alert("ERROR!\n The member savings balance is not up to the debit transaction value or the formal loan has not been repaid.");
									document.edtloan<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountdr']; ?>";
									return;
								}else{
									amm = ((i1/100)*Number(d1))+Number(d1);
									document.edtloan<?php echo $dn['id']; ?>.payback.value = amm;
								}
							}
						  }
						  function calInt2(){
							var r=document.edtloan<?php echo $dn['id']; ?>.acc.value;
							var d=document.edtloan<?php echo $dn['id']; ?>.amt.value;
							var i=document.edtloan<?php echo $dn['id']; ?>.interest.value;
							if(r==-1){
								alert("Select Transaction Type");
								return;
							}else{
								if(r==2){
									amm = ((i/100)*Number(d))+Number(d);
									document.edtloan<?php echo $dn['id']; ?>.payback.value = amm;
								}
							}
						}
						  </script>
						  <div class="modal fade loa-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-xs" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Loan <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtloan<?php echo $dn['id']; ?>" method="post" action="?act=loan&idx=<?php echo $id; ?>">
				<div class="modal-body">
				<?php
					$intr = 0;
					$amx = $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'];$payb = $dn['amountpay'];
					if($dn['amountpay']>0){$intr = number_format(100*($dn['amountpay'] - $dn['amountdr'])/$dn['amountdr'],2);}
				?>
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $amx; ?>" class="form-control" required=""  onblur="isdeb2();">
					Interest Rate (%) <i>*Leave 0 if no interest rate</i> <input type="text" name="interest" value="<?php echo $intr; ?>" placeholder="0.00" required="" onblur="calInt2();" /><br/>
					Pay Back (&#8358;)<input type="text" name="payback" value="<?php echo $dn['amountpay']; ?>" class="form-control" readonly onblur="">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editloan" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+$dn['amountpay']); ?>" />
												<input type="hidden" name="samt" value="<?php echo $samt; ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.building.acc.value;
	var d=document.building.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.building.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade building-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Building Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="building" method="post" action="?act=building&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Building Account">Credit</option>
						<option value="2" title="Debit Building Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="membuid" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtbuid<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtbuid<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtbudi<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade bud-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Building <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtbuid<?php echo $dn['id']; ?>" method="post" action="?act=building&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editbuid" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.agm.acc.value;
	var d=document.agm.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.agm.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade agm-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New AGM Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="agm" method="post" action="?act=agm&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit AGM Account">Credit</option>
						<option value="2" title="Debit AGM Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="memagm" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtagm<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtagm<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtagm<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade agm-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit AGM <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtagm<?php echo $dn['id']; ?>" method="post" action="?act=agm&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editagm" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.social.acc.value;
	var d=document.social.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.social.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade social-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Social Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="social" method="post" action="?act=social&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Social Account">Credit</option>
						<option value="2" title="Debit Social Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="memsoci" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtsoc<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtsoc<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtsoc<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade soc-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Social <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtsoc<?php echo $dn['id']; ?>" method="post" action="?act=social&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editsoci" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.development.acc.value;
	var d=document.development.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.development.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade development-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Development Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="development" method="post" action="?act=development&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Development Account">Credit</option>
						<option value="2" title="Debit Development Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="memdeve" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtdev<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtdev<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtdev<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade dev-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Development <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtdev<?php echo $dn['id']; ?>" method="post" action="?act=development&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editdeve" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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

<script type="text/javascript">
function isdeb(){
    var r=document.others.acc.value;
	var d=document.others.amt.value;
    if(r==-1){
        alert("Select Transaction Type");
		return;
    }else{
		if(r==2){
			if(d><?php echo $bal; ?>){
				alert("ERROR!\n The member balance is less than the debit transaction value");
				document.others.amt.value = "0.00";
				return;
			}
		}
	}
}

</script>
	<div class="modal fade others-sm" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;text-align:justify;">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel2">New Misc. Transaction</h4>
			</div>
			<form class="form-horizontal form-label-left" name="others" method="post" action="?act=others&idx=<?php echo $id; ?>">
				<div class="modal-body">
					<h4><?php echo $det['name'].' ('.$det['regno'].') '; ?></h4>
					<select name="acc" class="form-control"><option value="-1">Transaction: </option>
						<option value="1" title="Credit Misc. Account">Credit</option>
						<option value="2" title="Debit Misc. Account">Debit</option>
					</select>
					Amount (&#8358;)<input type="text" name="amt" placeholder="&#8358; 0.00" class="form-control" required="" onblur="isdeb();">
					<textarea name="details" placeholder="Transaction Details" class="form-control"></textarea>

					<div class="ln_solid"></div>
					<input type="hidden" name="bal" value="<?php echo $bal; ?>" />
					<input type="hidden" name="memothe" value="TRUE" />
				</div>
				<div class="modal-footer">
				  <button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Add Transaction</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
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
						  <script type="text/javascript">
						  function isdeb2(){
							r1=document.edtoth<?php echo $dn['id']; ?>.acc.value;
							d1=document.edtoth<?php echo $dn['id']; ?>.amt.value;
							if(r1==2){
								if(d1><?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>){
									alert("ERROR!\n The member balance is less than the debit transaction value");
									document.edtoth<?php echo $dn['id']; ?>.amt.value = "<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>";
									return;
								}
							}
						  }
						  </script>
						  <div class="modal fade oth-edt-<?php echo $dn['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm" style="color:#000;font-family:Andalus;font-size:15px;">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
									  </button>
									  <h3 class="modal-title" id="myModalLabel2">Edit Misc. <?php echo "#$xx".$dn['date']; ?></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal form-label-left" name="edtoth<?php echo $dn['id']; ?>" method="post" action="?act=others&idx=<?php echo $id; ?>">
				<div class="modal-body">
					Initiated<input type="text" name="name" value="<?php echo date('d.m.Y',$dn['date']); ?>" class="form-control" readonly>
					Edited<input type="text" name="date" value="<?php echo date('d.m.Y',time()); ?>" class="form-control" readonly>
					Amount  (&#8358;)<input type="text" name="amt" value="<?php echo $dn['amountcr']>0?$dn['amountcr']:$dn['amountdr']; ?>" class="form-control" required=""  onblur="isdeb2();">
					Details<textarea name="details1" class="form-control" ></textarea>
					<div class="ln_solid"></div>
												<input type="hidden" name="editothe" value="TRUE" />
												<input type="hidden" name="bal" value="<?php echo ($bal+($dn['amountcr']>0?$dn['amountcr']:$dn['amountdr'])); ?>" />
												<input type="hidden" name="idd" value="<?php echo $dn['id']; ?>"/>
												<input type="hidden" name="acc" value="<?php echo ($dn['amountcr']>0?1:2); ?>"/>
												<input type="hidden" name="details" value="<?php echo $dn['details']; ?>"/>
										<div class="ln_solid"></div>
									</div>
									<div class="modal-footer">
									<button type="submit" value="submit" name="submit" class="btn btn-primary submit" onclick="">Save</button>
									  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
									</div>
									</form>
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
