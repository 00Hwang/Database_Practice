<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	$id = $_POST["id"]; // ID
	
	$sql = "select ID from HB_USER where id = '$id'";
	$stid = oci_parse($conn, $sql); oci_execute($stid);
	oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	if ($row["ID"]) {
		echo("
			<script> alert('중복된 아이디입니다.'); </script>
			<script> history.back(); </script>
		");
		exit;
	}
	
	$pw = $_POST["password"];
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
			<script> alert('전화번호가 유효하지 않습니다.'); </script>
			<script> history.back(); </script>
		");
		exit;
	}
	
	$email = $_POST["email"];
	if (isset($_POST["email_check"])) $email_check = 'O';
	else $email_check = 'X';
	
	$nickname = $_POST["nickname"];
	$join_date = date("Y-m-d");
	$grade = "뉴비";
	
	// 프로필사진 업로드
	if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
		$tempFile = $_FILES['profile']['tmp_name'];
		$fileTypeExt = explode("/", $_FILES['profile']['type']);
		$fileType = $fileTypeExt[0]; // 파일 타입 
		$fileExt = $fileTypeExt[1]; // 파일 확장자
		$extStatus = false;
		
		switch($fileExt){
		case 'jpeg':
		case 'jpg':
		case 'gif':
		case 'bmp':
		case 'png':
			$extStatus = true;
			break;
		default:
			echo("
				<script> alert('이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다.'); </script>
				<script> history.back(); </script>
			");
			break;
		}
		if($fileType == 'image'){
			if($extStatus){
				$resFile = "profileImage/$id.{$_FILES['profile']['name']}"; // 임시 파일 옮길 디렉토리 및 파일명
				$profile = "profileImage/$id.{$_FILES['profile']['name']}";
				$imageUpload = move_uploaded_file($tempFile, $resFile);
				
				if($imageUpload == false){ // 업로드 성공 여부 확인
					echo("
						<script> alert('이미지 업로드 실패입니다.'); </script>
						<script> history.back(); </script>
					");
					exit;
				}
			} else {
				echo("
					<script> alert('이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다.'); </script>
					<script> history.back(); </script>
				");
				exit;
			}	
		} else {
			echo("
				<script> alert('이미지 파일이 아닙니다.'); </script>
				<script> history.back(); </script>
			");
			exit;
		}
	} else {
		echo("<script> alert('이미지를 선택하지 않았습니다.'); </script>");
		$profile = null;
	}
	
	
	$sql = "insert into HB_user (id, pw, name, phone_number, email, email_check, profile, nickname, join_date, grade)
	values ('$id', '$pw', '$name', '$phone_number', '$email', '$email_check', '$profile', '$nickname', TO_DATE('$join_date', 'YYYY-MM-DD'), '$grade')";
	$stid = oci_parse($conn, $sql); oci_execute($stid);
	
	echo("
			<script> alert('$nickname 님 회원가입을 축하드립니다!'); </script>
			<script> location.replace('로그인.html'); </script>
		");
	oci_commit($conn);
	
	oci_free_statement($stid);
	
	oci_close($conn);
?>