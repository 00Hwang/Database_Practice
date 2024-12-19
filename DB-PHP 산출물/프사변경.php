<?php
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
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
	
	$sql = "UPDATE HB_USER SET 
	profile = '$profile'
	where id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	echo("
			<script> alert('프로필 사진이 변경되었습니다.'); </script>
			<script> location.replace('회원정보.php'); </script>
		");
	oci_commit($conn);
	
	oci_free_statement($stid);
	
	oci_close($conn);
?>