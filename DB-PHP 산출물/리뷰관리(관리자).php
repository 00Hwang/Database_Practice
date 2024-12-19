<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
	$page_num = $_POST["page_num"];
	if (is_null($page_num)){
		$page_num = 1;
	}
	
	$sql = " select * from
	(select rownum r_num, B.* from
	(select * from 
	(select PRV.* ,NICKNAME from HB_PRODUCT_REVIEW PRV inner join HB_USER US
	on PRV.USER_ID = US.ID) A inner join HB_PRODUCT PR
	on A.PRODUCT_NUMBER = PR.PRODUCT_NUMBER order by write_date DESC) B )
	where r_num > (($page_num-1)*10) and r_num <=(($page_num)*10)";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>리뷰목록</title>
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
      width: 1500px;
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
      <h1>리뷰목록</h1>
      <table>
        <tr>
			<th> 상품 </th>
			<th> 닉네임 </th>
			<th> 내용 </th>
			<th> 작성날짜 </th>
			<th> 별점 </th>
			<th> 조회 </th>
			<th> 삭제 </th>
		</tr>
		<?php
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$REVIEW_NUMBER = $row['REVIEW_NUMBER'];
			
			$PRODUCT_NUMBER = $row['PRODUCT_NUMBER'];
			$NAME = $row['NAME'];
			$NICKNAME = $row['NICKNAME'];
			$CONTENT = $row['CONTENT'];
			$WRITE_DATE = $row['WRITE_DATE'];
			$WRITE_DATE = date("Y-n-j", strtotime("$WRITE_DATE"));
			$RATING = $row['RATING'];
			
			
			echo("<tr><td width=150px>$NAME</td>");
			echo("<td width=150px>$NICKNAME</td>");
			echo("<td>$CONTENT</td>");
			echo("<td width=80px>$WRITE_DATE</td>");
			echo("<td width=50px>$RATING 점</td>");
			echo("<td width=50px>
				<form method=\"POST\" action=\"리뷰.php\">
					<input type=\"hidden\" name=\"PRODUCT_NUMBER\" value=\"$PRODUCT_NUMBER\">
					<button type=\"submit\"> 조회 </button>
				</form>
				</td>");
			echo("<td width=50px>
				<form method=\"POST\" action=\"리뷰삭제.php\">
					<input type=\"hidden\" name=\"REVIEW_NUMBER\" value=\"$REVIEW_NUMBER\">
					<button type=\"submit\"> 삭제 </button>
				</form>
				</td></tr>");
		}
		?>
      </table>
	  <div class="page">
		<ul>
		<?php
			$sql = "select count(*) count from HB_PRODUCT_REVIEW";
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
						<form id=\"pagelist\" action=\"리뷰관리(관리자).php\" method=\"POST\">
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
