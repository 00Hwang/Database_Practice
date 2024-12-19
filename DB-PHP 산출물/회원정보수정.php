<?php
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
	
	
	$name = $_POST["name"];
	$phone_number = $_POST["phone_number"]; // 전화번호
	function validateNumberString($input) {
		$pattern = '/^[0-9]+$/'; // 정규식을 사용하여 숫자만 허용하는 패턴을 지정합니다
		if (preg_match($pattern, $input)) { // 입력값과 패턴을 비교하여 검증합니다
			return true;
		} else {
			return false;
		}
	}
	if (!validateNumberString($phone_number)) {
		echo("
			<script> alert('전화번호가 유효하지 않습니다.'); </script>;
			<script> history.back(); </script>;
		");
		exit;
	}
	$email = $_POST["email"];
	if (isset($_POST["email_check"])) $email_check = 'O';
	else $email_check = 'X';
	$nickname = $_POST["nickname"];
	
	
	
	$sql = "UPDATE HB_USER SET 
	name = '$name', phone_number = '$phone_number',
	email = '$email', email_check = '$email_check',
	nickname ='$nickname'
	where id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	echo("
			<script> alert('$nickname 님 회원정보가 수정되었습니다.'); </script>;
			<script> location.replace('회원정보.php'); </script>;
		");
	
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
?>