<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	$page_num = $_POST["page_num"];
	if (is_null($page_num)){
		$page_num = 1;
	}
	
	session_start();
	$id = $_SESSION['id'];
	
	$sql = " select * from
	(select rownum r_num, ORD.* from HB_ORDER ORD)
	where r_num > (($page_num-1)*10) and r_num <=(($page_num)*10)";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>주문목록</title>
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
	
	
	.page ul {
      list-style-type: none;
    }
    .page li {
		margin-right: 10px;
		display: inline-block;
    }
    .page li button {
      padding: 15px 20px;
      font-size: 20px;
	  font-color: black;
	  font-weight: 600;
      background-color: #d3d3d3;
      cursor: pointer;
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
			<th> 주문번호 </th>
			<th> 주문날짜 </th>
			<th> 우편번호 </th>
			<th> 주소, 상세주소 </th>
			<th> 수령인 </th>
			<th> 수령인번호 </th>
			<th> 조회 </th>
		</tr>
		<?php
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$order_number = $row['ORDER_NUMBER'];
			$order_date = $row['ORDER_DATE'];
			$order_date = date("Y-n-j", strtotime("$order_date"));
			$address1 = $row['ADDRESS1'];
			$address2 = $row['ADDRESS2'];
			$address3 = $row['ADDRESS3'];
			$recipient_name = $row['RECIPIENT_NAME'];
			$recipient_phone_number = $row['RECIPIENT_PHONE_NUMBER'];
			echo("<tr><td>$order_number</td>");
			echo("<td>$order_date</td>");
			echo("<td>$address1</td>");
			echo("<td>$address2 ($address3)</td>");
			echo("<td>$recipient_name</td>");
			echo("<td>$recipient_phone_number</td>");
			echo("<td>
				<form method=\"POST\" action=\"주문상세.php\">
					<input type=\"hidden\" name=\"order_number\" value=\"$order_number\">
					<button type=\"submit\"> 조회 </button>
				</form>
				</td></tr>");
		}
		?>
      </table>
	  <div class="page">
		<ul>
		<?php
			$sql = "select count(*) count from HB_ORDER";
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			$count = ceil($row["COUNT"]/10);
			
			$i = $page_num - 5;
			if($i<=0){
				$i = 1;
			}
			for ($pagecount = 0; $pagecount < 10; $pagecount++){
				$j = $i + $pagecount;
				echo ("
					<li>
						<form id=\"pagelist\" action=\"주문목록(관리자).php\" method=\"POST\">
							<input type=\"hidden\" id=\"page_num\" name=\"page_num\" value=\" $j \">
							<button type=\"submit\">$j</button>
						</form>
					</li>
				");
				if($j == $count){
					break;
				}
			}
			?>
			</ul>
		</div>
    </div>
  </div>
</body>
</html>
