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
	
	$cart_number = $_POST['cart_number'];
	
	$sql = "DELETE FROM HB_CART where user_id = '$id' and cart_number = '$cart_number'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	echo("
			<script> alert('삭제되었습니다.'); </script>
			<script> location.replace('장바구니.php'); </script>
		");
?>