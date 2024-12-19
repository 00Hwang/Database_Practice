<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	$name = $_POST["name"];
	$introduce = $_POST["introduce"];
	$price = $_POST["price"];
	$stock = $_POST["stock"];
	if(is_null($stock)) $stock = 0;
	
	// 프로필사진 업로드
	if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
		$tempFile = $_FILES['product_image']['tmp_name'];
		$fileTypeExt = explode("/", $_FILES['product_image']['type']);
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
				$sql = "insert into HB_PRODUCT (PRODUCT_NUMBER, NAME, PRICE, STOCK, INTRODUCE, VIEWS) 
				values (incre_product_seq.NEXTVAL, '$name', '$price', '$stock', '$introduce', 0)";
				$stid = oci_parse($conn, $sql); oci_execute($stid);
				
				$sql = "select MAX(PRODUCT_NUMBER) product_number
				from HB_PRODUCT";
				$stid = oci_parse($conn, $sql); oci_execute($stid);
				$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
				$product_number = $row['PRODUCT_NUMBER'];
				
				$resFile = "productImage/$product_number.{$_FILES['product_image']['name']}"; // 임시 파일 옮길 디렉토리 및 파일명
				$link = "productImage/$product_number.{$_FILES['product_image']['name']}";
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
		echo("
			<script> alert('이미지를 선택하지 않았습니다.'); </script>
			<script> history.back(); </script>
		");
		exit;
	}
	$sql = "insert into HB_PRODUCT_IMAGE values (incre_product_image_seq.NEXTVAL, '$product_number','대표사진','$link')";
	$stid = oci_parse($conn, $sql); oci_execute($stid);
	
	echo("
			<script> alert('$name 상품등록을 완료하였습니다.'); </script>
			<script> location.replace('상품관리(관리자).php'); </script>
		");
	oci_commit($conn);
	
	oci_free_statement($stid);
	
	oci_close($conn);
?>