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
	
	$product_number = $_POST['product_number'];
	$price = $_POST['price'];
	$stock2 = $_POST['stock2'];
	
	
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$address3 = $_POST['address3'];
	$recipient_name = $_POST['recipient_name'];
	$recipient_num = $_POST['recipient_num'];
	
	if ($stock2 != null) {
		$sql = "select stock, name from HB_PRODUCT where PRODUCT_NUMBER = $product_number";
		$stid = oci_parse($conn, $sql); 
		oci_execute($stid);
		$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
		$stock = $row['STOCK'];
		$PRODUCT_NAME = $row['NAME'];
		
		if ($stock < $stock2){
			echo ("<script> alert('$PRODUCT_NAME : 재고가 부족하여 주문에 실패했습니다.'); </script>");
		} else {
			$sql = "update HB_PRODUCT set stock = stock - $stock2 where PRODUCT_NUMBER = $product_number";
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
			
			$order_date = date("Y-m-d");
			$sql = "insert into HB_ORDER values
			(incre_order_seq.NEXTVAL, '$id', TO_DATE('$order_date', 'YYYY-MM-DD'), '$address1', '$address2', '$address3', '$recipient_name', '$recipient_num')";
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
			
			$sql = "select MAX(order_number) order_number from HB_ORDER where USER_ID = '$id' GROUP BY USER_ID";
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			$order_number = $row['ORDER_NUMBER'];
			
			$sql = "insert into HB_ORDER_DETAIL values
			(incre_order2_seq.NEXTVAL, '$order_number', '$product_number', '$stock2', '$price', '준비', 'O')";
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
		}
	} else {
		$order_date = date("Y-m-d");
		$sql = "insert into HB_ORDER values
		(incre_order_seq.NEXTVAL, '$id', TO_DATE('$order_date', 'YYYY-MM-DD'), '$address1', '$address2', '$address3', '$recipient_name', '$recipient_num')";
		$stid = oci_parse($conn, $sql); 
		oci_execute($stid);
		
		$sql = "select MAX(order_number) order_number from HB_ORDER where USER_ID = '$id' GROUP BY USER_ID";
		$stid = oci_parse($conn, $sql); 
		oci_execute($stid);
		$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
		$order_number = $row['ORDER_NUMBER'];
		
		echo ("<script>alert('$order_number');</script>");
		
		$sql = "select * from HB_CART where USER_ID = '$id'";
		$stid = oci_parse($conn, $sql); 
		oci_execute($stid);
		
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			
			$CART_NUMBER = $row['CART_NUMBER'];
			$stock2 = $row['COUNT'];
			$price = $row['PRICE'];
			$PRODUCT_NUMBER = $row['PRODUCT_NUMBER'];
			
			echo ("<script>alert('$stock2');</script>");
			echo ("<script>alert('$PRODUCT_NUMBER');</script>");
			
			
			$sql2 = "select stock, name from HB_PRODUCT where PRODUCT_NUMBER = $PRODUCT_NUMBER";
			$stid2 = oci_parse($conn, $sql2); 
			oci_execute($stid2);
			$row2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS);
			$stock = $row2['STOCK'];
			$PRODUCT_NAME = $row2['NAME'];
			
			echo ("<script>alert('$stock');</script>");
			
			if ($stock < $stock2){
				echo ("<script> alert('$PRODUCT_NAME : 재고가 부족하여 주문에 실패했습니다.'); </script>");
			} else {
				$sql2 = "update HB_PRODUCT set stock = stock - $stock2 where PRODUCT_NUMBER = $PRODUCT_NUMBER";
				$stid2 = oci_parse($conn, $sql2); 
				oci_execute($stid2);
				
				$sql2 = "insert into HB_ORDER_DETAIL values
				(incre_order2_seq.NEXTVAL, '$order_number', '$PRODUCT_NUMBER', '$stock2', '$price', '준비', 'O')";
				$stid2 = oci_parse($conn, $sql2); 
				oci_execute($stid2);
				
				$sql2 = "DELETE FROM HB_CART where cart_number = '$CART_NUMBER'";
				$stid2 = oci_parse($conn, $sql2); 
				oci_execute($stid2);
			}
		}
	}
	
	
	echo("
			<script> alert('주문이 완료되었습니다.'); </script>
			<script> location.replace('주문목록.php'); </script>
		");
		
	oci_commit($conn);
	oci_close($conn);
	
?>