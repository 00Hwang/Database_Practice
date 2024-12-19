<?php
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
	
	$stock2 = $_POST['numberInput'];
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>주문하기</title>
  <style type="text/css">
    body {
      background-color: whitesmoke;
    }

    .cart {
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .cart h2 {
      margin-top: 0;
    }

    .box {
      border: 2px solid black;
      border-radius: 10px;
      background-color: white;
      width: 80%;
      max-width: 500px;
      margin-top: 20px;
      padding: 20px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
	  margin-bottom: 20px;
    }

    th, td {
      border: 1px solid black;
      padding: 10px;
    }

    th {
      background-color: #eee;
    }

    tfoot td {
      font-weight: bold;
    }

    a.main-link {
      color: red;
      text-decoration: none;
      margin-bottom: 20px;
    }

    a.main-link:hover {
      text-decoration: underline;
    }

    .cart-content {
      margin-top: 20px;
    }
	
	
	
	.address {
		width : 100%;
		font-size : 15px;
		margin-bottom : 10px;
	}
	.input-group {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			margin-bottom: 10px;
			width: 100%;
	}
	.input-group label {
			margin-bottom: 5px;
	}
	.input-group input,
		.input-group select {
			height: 30px;
			margin-bottom : 5px;
			width: 100%;
			padding: 5px;
			border: 1px solid #ccc;
			border-radius: 4px;
	}
	.button-group {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 20px;
	}
	button[type="submit"] {
			background-color: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
	}
  </style>
  <script>
    function sendDataToPHP1 (scriptName) {
      var form = document.getElementById("order");
      form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP2 (scriptName) {
      var form = document.getElementById("order");
      form.action = scriptName;
      form.submit();
    }
  </script>
</head>
<body>
  <section class="cart">
    <div class="box">
      <a href="메인화면(로그인).php" class="main-link">Back To HB</a>
      <h2>주문하기</h2>
      <table>
        <thead>
          <tr>
            <th>상품명</th>
            <th>수량</th>
            <th>가격</th>
          </tr>
        </thead>
        <tbody>
			<?php
				if($stock2 == null){
					$sql = "select PR.name name, CA.COUNT stock, CA.PRICE price, CA.CART_NUMBER cart_number
					from HB_CART CA inner join HB_PRODUCT PR
					on CA.PRODUCT_NUMBER = PR.PRODUCT_NUMBER
					where CA.USER_ID = '$id' order by CA.CART_NUMBER";
					$stid = oci_parse($conn, $sql); 
					oci_execute($stid);
					$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
					if (is_null($row["NAME"])){
						echo("
							<script> alert('주문 목록이 비었습니다.'); </script>
							<script> history.back(); </script>
						");
						exit;
					}
					$stid = oci_parse($conn, $sql); 
					oci_execute($stid);
					while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
						$name = $row["NAME"];
						$stock = $row["STOCK"];
						$price = $row["PRICE"];
						$cart_number = $row["CART_NUMBER"];
						echo ("
							<tr>
								<td>$name</td>
								<td>
									<span class=\"quantity\">$stock</span>
								</td>
								<td class=\"price\">$price X $stock 원</td>
							</tr>
						");
					}
				} else {
					$sql = "select PR.name name, PR.price price from HB_PRODUCT PR where PRODUCT_NUMBER = $PRODUCT_NUMBER";
					$stid = oci_parse($conn, $sql); 
					oci_execute($stid);
					$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
					$name = $row["NAME"];
					$price = $row["PRICE"];
					echo ("
						<tr>
							<td>$name</td>
							<td>
								<span class=\"quantity\">$stock2</span>
							</td>
							<td class=\"price\">$price X $stock2 원</td>
						</tr>
						");
				}
			?>
        <tfoot>
			<?php
				if($stock2 == null){
					$sql = "select SUM(price) price from
					(select SUM(PRICE*COUNT) price, MAX(USER_ID) USER_ID
					from HB_CART
					where USER_ID = '$id'
					GROUP BY CART_NUMBER)
					GROUP BY USER_ID";
					$stid = oci_parse($conn, $sql); 
					oci_execute($stid);
					$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
					$price = $row["PRICE"];
					echo ("
						<tr>
							<td colspan=\"2\">총합계</td>
							<td colspan=\"2\" class=\"total-price\">$price 원</td>
						</tr>
					");
				} else {
					$price = $price * $stock2;
					echo ("
						<tr>
							<td colspan=\"2\">총합계</td>
							<td colspan=\"2\" class=\"total-price\">$price 원</td>
						</tr>
					");
				}
			?>
			</tfoot>
		</table>
		<form action="주문하기.php" method="POST">
			<select class="address">
				<option> 배송지 선택 </option>
				<?php
					$sql = "select * from HB_ADDRESS where USER_ID = '$id'";
					$stid = oci_parse($conn, $sql); 
					oci_execute($stid);
					while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
						$ADDRESS_NUMBER = $row['ADDRESS_NUMBER'];
						$full_address = $row['ADDRESS1'] . " : " . $row['ADDRESS2'] . " (" . $row['ADDRESS3'] . ")";
						echo ("<option value=\"$ADDRESS_NUMBER\"> $full_address </option>");
					}
				?>
			</select>
			<input type="hidden" name="product_number" value="<?php echo $PRODUCT_NUMBER ?>">
			<input type="hidden" name="price" value="<?php echo $price ?>">
			<input type="hidden" name="stock2" value="<?php echo $stock2 ?>">
			<div class="input-group">
				<label for="zip-code">우편번호</label>
				<input type="text" id="address1"  name="address1" placeholder="우편번호를 입력해주세요" required>
			</div>
			<div class="input-group">
				<label for="address">주소</label>
				<input type="text" id="address2" name="address2" placeholder="도시, 동" required>
				<input type="text" id="address3" name="address3" placeholder="상세 주소" required>
			</div>
			<div class="input-group">
				<label for="address">수령인</label>
				<input type="text" id="recipient_name" name="recipient_name" placeholder="수령인" required>
				<label for="address">수령자 핸드폰 번호</label>
				<input type="text" id="recipient_num" name="recipient_num" placeholder="수령인 핸드폰 번호" required>
			</div>
			<div class="button-group">
				<button type="submit">주문하기</button>
			</div>
		</form>
    </div>
  </section>
</body>
</html>
