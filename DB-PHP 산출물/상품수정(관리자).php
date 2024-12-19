<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
	$name = $_POST["name"];
	$introduce = $_POST["introduce"];
	$price = $_POST["price"];
	$stock = $_POST["stock"];
	if(is_null($stock)) $stock = 0;
	
	$sql = "update HB_PRODUCT set name = '$name', introduce = '$introduce', price = '$price', stock = '$stock'
		where PRODUCT_NUMBER = $PRODUCT_NUMBER ";
	$stid = oci_parse($conn, $sql); oci_execute($stid);
	
	echo("
			<script> alert('$name 상품수정을 완료하였습니다.'); </script>
			<script> location.replace('상품관리(관리자).php'); </script>
		");
	oci_commit($conn);
	
	oci_free_statement($stid);
	
	oci_close($conn);
?>