<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	$order_number = $_POST['order_number'];
	
	$sql = "select *
	from HB_ORDER_DETAIL ORD inner join HB_PRODUCT PR
	on ORD.PRODUCT_NUMBER = PR.PRODUCT_NUMBER
	where ORD.ORDER_NUMBER = '$order_number'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>주문상세</title>
  <style>
    body {
      background-color: whitesmoke;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .info-box {
      width: 1300px;
      padding: 20px;
      border: 2px solid black;
      border-radius: 10px;
      text-align: center;
      background-color: white;
      font-family: Arial, sans-serif;
    }
    h1 {
      margin-top: 0;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    table td,
    th {
      padding: 10px;
      border: 1px solid black;
    }
    th {
      background-color: #333;
      color: white;
    }
    .edit-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    .edit-link:hover {
      background-color: #0069d9;
    }
	a.main-link {
      color: red;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="info-box">
	<a href="메인화면(로그인).php" class="main-link">Back To HB</a>
      <h1>주문목록</h1>
      <table>
        <tr>
			<th> 상품 </th>
			<th> 수량 </th>
			<th> 가격 </th>
			<th> 상태 </th>
			<th> 환불가능여부 </th>
			<th colspan="4"> 상태 </th>
		</tr>
		<?php
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$ORDER_DETAIL_NUMBER = $row['ORDER_DETAIL_NUMBER'];
			$name = $row['NAME'];
			$count = $row['COUNT'];
			$price = $row['PRICE'];
			$STATUS = $row['PROCESSING_STATUS'];
			$REFUN = $row['REFUNDABILITY'];
			echo("<tr><td>$name</td>");
			echo("<td>$count</td>");
			echo("<td>$price</td>");
			echo("<td>$STATUS</td>");
			echo("<td>$REFUN</td>");
			echo("<td width=50px>
				<form method=\"POST\" action=\"주문상태변경(관리자).php\">
					<input type=\"hidden\" name=\"ORDER_DETAIL_NUMBER\" value=\"$ORDER_DETAIL_NUMBER\">
					<input type=\"hidden\" name=\"order_number\" value=\"$order_number\">
					<input type=\"hidden\" name=\"STATUS\" value=\"준비\">
					<button type=\"submit\"> 준비 </button>
				</form>
				</td>");
			echo("<td width=50px>
				<form method=\"POST\" action=\"주문상태변경(관리자).php\">
					<input type=\"hidden\" name=\"ORDER_DETAIL_NUMBER\" value=\"$ORDER_DETAIL_NUMBER\">
					<input type=\"hidden\" name=\"order_number\" value=\"$order_number\">
					<input type=\"hidden\" name=\"STATUS\" value=\"배송\">
					<button type=\"submit\"> 배송 </button>
				</form>
				</td>");
			echo("<td width=50px>
				<form method=\"POST\" action=\"주문상태변경(관리자).php\">
					<input type=\"hidden\" name=\"ORDER_DETAIL_NUMBER\" value=\"$ORDER_DETAIL_NUMBER\">
					<input type=\"hidden\" name=\"order_number\" value=\"$order_number\">
					<input type=\"hidden\" name=\"STATUS\" value=\"환불\">
					<button type=\"submit\"> 환불 </button>
				</form>
				</td>");
			echo("<td width=50px>
				<form method=\"POST\" action=\"주문상태변경(관리자).php\">
					<input type=\"hidden\" name=\"ORDER_DETAIL_NUMBER\" value=\"$ORDER_DETAIL_NUMBER\">
					<input type=\"hidden\" name=\"order_number\" value=\"$order_number\">
					<input type=\"hidden\" name=\"STATUS\" value=\"완료\">
					<button type=\"submit\"> 완료 </button>
				</form>
				</td></tr>");
		}
		?>
      </table>
    </div>
  </div>
</body>
</html>
