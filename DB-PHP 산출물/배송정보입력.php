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
	
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$address3 = $_POST['address3'];
	
	
	$sql = "insert into HB_ADDRESS (ADDRESS_NUMBER, USER_ID, ADDRESS1, ADDRESS2, ADDRESS3)
	values (incre_address_seq.NEXTVAL, '$id', '$address1', '$address2', '$address3')";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	echo("
			<script> alert('배송 정보가 추가되었습니다.'); </script>
			<script> location.replace('배송정보.php'); </script>
		");
?>