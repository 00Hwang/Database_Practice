<?php
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
	if($id == null){
		echo("
			<script> alert('로그인 만료입니다'); </script>
			<script> location.replace('로그인.html'); </script>
		");
		exit;
	}
	
	$REVIEW_NUMBER = $_POST['REVIEW_NUMBER'];
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
	$link = $PRODUCT_NUMBER."_상품.php";
	
	$sql = "DELETE FROM HB_PRODUCT_REVIEW where user_id = '$id' and REVIEW_NUMBER = $REVIEW_NUMBER";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	echo("
			<script> alert('삭제되었습니다.'); </script>
			<script> location.replace('상품 정보.php'); </script>
		");
?>