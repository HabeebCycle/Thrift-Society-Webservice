<?php
require_once ('../config/config.php');
require_once ('../config/site_func.php');
if(isset($_SESSION['islog']) and $_SESSION['islog']){
	@$idx = $_GET['idx'];
	if(isset($idx)){
		if($idx==1){
			$value = $_GET['value'];
			$sfunc = new SiteFunction();
			echo $sfunc -> convertToWord($value);
		}elseif($idx==2){
			header('Location: SpecificationTables.pdf');
		}elseif($idx==3){
			$msg = $_GET['msg'];
			mysqli_query($connection,"update messages set status=1 where id=$msg");
			$nmsg = mysqli_num_rows(mysqli_query($connection,"SELECT id FROM messages where status=0 and receipt=(select receipt from messages where id=$msg)"));
			echo $nmsg;
		}
	}
}else{
	header('Location: ../');
}
?>
