<?php
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
	if($id == null){
		echo("
			<script> alert('로그인 후 이용가능합니다.'); </script>
			<script> location.replace('로그인.html'); </script>
		");
		exit;
	}
	
	$address_number = $_POST['address_number'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$address3 = $_POST['address3'];
	
	
	$sql = "update HB_ADDRESS
	set address1 = '$address1', address2 = '$address2', address3 = '$address3'
	where address_number = $address_number";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	echo("
			<script> alert('배송 정보가 수정되었습니다.'); </script>
			<script> location.replace('배송정보.php'); </script>
		");
?>