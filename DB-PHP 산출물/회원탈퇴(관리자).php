<?php
	require('conn.php');
	
	$id = $_POST['id'];
	
	$sql = "select profile from HB_USER where id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	
	$file_path = $row["PROFILE"]; // 삭제할 파일의 경로
	
	if (file_exists($file_path)) {
		if (unlink($file_path)) {
			echo "파일이 성공적으로 삭제되었습니다.";
		} else {
			echo "파일 삭제 중에 오류가 발생했습니다.";
		}
	} else {
		echo "삭제할 파일이 존재하지 않습니다.";
	}
	
	$sql = "DELETE FROM HB_CART where user_id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	$sql = "UPDATE HB_PRODUCT_REVIEW SET USER_ID = 0 where USER_id = '$id'";
	$stid = oci_parse($conn, $sql);
	oci_execute($stid);
	
	$sql = "DELETE FROM HB_ADDRESS where USER_id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	$sql = "DELETE FROM HB_USER where id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	echo("
			<script> alert('성공적으로 탈퇴 되었습니다.'); </script>
			<script> location.replace('회원관리(관리자).php'); </script>
		");
	oci_commit($conn);
	oci_close($conn);
?>