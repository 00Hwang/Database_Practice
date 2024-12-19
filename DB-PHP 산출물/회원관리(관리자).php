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
	(select rownum r_num, US.* from HB_USER US where id != 'admin' and id !='0' order by JOIN_DATE DESC)
	where r_num > (($page_num-1)*10) and r_num <=(($page_num)*10)";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>회원목록</title>
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
      <h1>회원정보</h1>
      <table>
        <tr>
			<th> ID </th>
			<th> PW </th>
			<th> 이름 </th>
			<th> 번호 </th>
			<th> 이메일 </th>
			<th> 수신여부 </th>
			<th> 닉네임 </th>
			<th> 가입일시 </th>
			<th> 등급 </th>
			<th> 탈퇴 </th>
		</tr>
		<?php
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$id = $row['ID'];
			$pw = $row['PW'];
			$NAME = $row['NAME'];
			$PHONE_NUMBER = $row['PHONE_NUMBER'];
			$EMAIL = $row['EMAIL'];
			$EMAIL_CHECK = $row['EMAIL_CHECK'];
			$NICKNAME = $row['NICKNAME'];
			$DATE = $row["JOIN_DATE"];
			$DATE = date("Y-n-j", strtotime("$DATE"));
			$GRADE = $row['GRADE'];
			
			echo("<tr><td>$id</td>");
			echo("<td>$pw</td>");
			echo("<td>$NAME</td>");
			echo("<td>$PHONE_NUMBER</td>");
			echo("<td>$EMAIL</td>");
			echo("<td>$EMAIL_CHECK</td>");
			echo("<td>$NICKNAME</td>");
			echo("<td>$DATE</td>");
			echo("<td>$GRADE</td>");
			echo("<td>
				<form method=\"POST\" action=\"회원탈퇴.php\">
					<input type=\"hidden\" name=\"id\" value=\"$id\">
					<button type=\"submit\"> 탈퇴 </button>
				</form>
				</td></tr>");
		}
		?>
      </table>
	  <div class="page">
		<ul>
		<?php
			$sql = "select count(*) count from HB_USER";
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
						<form id=\"pagelist\" action=\"회원관리(관리자).php\" method=\"POST\">
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
