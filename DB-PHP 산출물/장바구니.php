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
	
	$stock = $_POST['numberInput'];
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
	
	
	
	if ($stock != null){
		$sql = "select PR.PRICE from HB_PRODUCT PR where PR.PRODUCT_NUMBER = $PRODUCT_NUMBER";
		$stid = oci_parse($conn, $sql); 
		oci_execute($stid);
		$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	
		$price = $row['PRICE'];
		
		$sql = "insert into HB_CART (CART_NUMBER, USER_ID, COUNT, PRICE, PRODUCT_NUMBER)
		values (incre_seq.NEXTVAL, '$id', '$stock', '$price', '$PRODUCT_NUMBER')";
		$stid = oci_parse($conn, $sql); 
		oci_execute($stid);
	}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>장바구니</title>
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
  </style>
</head>
<body>
  <section class="cart">
    <div class="box">
      <a href="메인화면(로그인).php" class="main-link">Back To HB</a>
      <h2>장바구니</h2>
	  <?php
		$sql = "select NICKNAME from HB_USER where id = '$id'";
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			$nickname = $row["NICKNAME"];
			echo ("$nickname 님의 장바구니");
	  ?>
      <table>
        <thead>
          <tr>
            <th>상품명</th>
            <th>수량</th>
            <th>가격</th>
            <th>삭제</th>
          </tr>
        </thead>
        <tbody>
			<?php
				$sql = "select PR.name name, CA.COUNT stock, CA.PRICE price, CA.CART_NUMBER cart_number
				from HB_CART CA inner join HB_PRODUCT PR
				on CA.PRODUCT_NUMBER = PR.PRODUCT_NUMBER
				where CA.USER_ID = '$id' order by CA.CART_NUMBER";
				$stid = oci_parse($conn, $sql); 
				oci_execute($stid);
				while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
					$name = $row["NAME"];
					$stock = $row["STOCK"];
					$price = $row["PRICE"];
					$cart_number = $row["CART_NUMBER"];
					echo ("
						<tr>
							<form id=\"cart_delete\" method=\"POST\" action=\"장바구니삭제.php\">
								<td>$name</td>
								<td>
									<span class=\"quantity\">$stock</span>
								</td>
								<td class=\"price\">$price X $stock 원</td>
								<input type=\"hidden\" name=\"cart_number\" value=\" $cart_number \">
								<td><button type=\"submit\" class=\"remove-btn\">삭제</button></td>
							</form>
						</tr>
					");
				}
			?>
        <tfoot>
			<?php
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
			?>
        </tfoot>
      </table>
	  <a href="주문화면.php" class="edit-link">주문하기</a>
    </div>
  </section>
</body>
</html>
