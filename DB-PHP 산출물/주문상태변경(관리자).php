<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	$ORDER_DETAIL_NUMBER = $_POST['ORDER_DETAIL_NUMBER'];
	$order_number = $_POST['order_number'];
	$STATUS = $_POST['STATUS'];
	
	$sql = "UPDATE HB_ORDER_DETAIL SET PROCESSING_STATUS = '$STATUS' where ORDER_DETAIL_NUMBER = $ORDER_DETAIL_NUMBER";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	oci_commit($conn);
	oci_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
	<script>
		function sendDataToPHP(scriptName) {
		  var form = document.getElementById("order");
		  form.action = scriptName;
		  form.submit();
		}
	</script>
</head>
<body>
<form method="POST" id="order">
	<input type="hidden" name="order_number" value="<?php echo $order_number ?>">
</form>
</body>
</html>

<?php
	echo("
			<script> sendDataToPHP('주문상세(관리자).php'); </script>
		");
?>
