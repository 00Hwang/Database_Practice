<?php
	require('conn.php');
	
	$id = $_POST["id"];
	$pw = $_POST["password"];
	
	$sql = "select ID, PW, NICKNAME from HB_USER where id = '$id' and pw = '$pw'";
	$stid = oci_parse($conn, $sql);
	oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	
	if (is_null($row["ID"])) {
		echo("
			<script> alert('Invalid username or password'); </script>;
			<script> location.replace('로그인.html'); </script>;
		");
		exit;
	} else {
		$nickname = $row["NICKNAME"];
		echo("
			<script> alert('$nickname 님 환영합니다.'); </script>;
			<script> location.replace('메인화면(로그인).php'); </script>;
		");
		session_start();
		$_SESSION['id'] = $row["ID"];
	}
	
	oci_free_statement($stid);
	
	oci_close($conn);
?>