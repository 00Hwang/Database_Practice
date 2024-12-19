<?php
	date_default_timezone_set('Asia/Seoul');
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
	
	$write_date = date("Y-m-d");
	$content = $_POST['coment'];
	$rating = $_POST['rating'];
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
	
	$sql = "insert into HB_PRODUCT_REVIEW
	(REVIEW_NUMBER, PRODUCT_NUMBER, CONTENT, WRITE_DATE, RATING, USER_ID)
	values (incre_review_seq.NEXTVAL, '$PRODUCT_NUMBER', '$content', TO_DATE('$write_date', 'YYYY-MM-DD'), '$rating', '$id')";
	
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	$link = $PRODUCT_NUMBER."_상품.php";
	
	echo("
			<script> alert('작성이 완료되었습니다.'); </script>
			<script> location.replace('상품 정보.php'); </script>
		");
	exit();
?>