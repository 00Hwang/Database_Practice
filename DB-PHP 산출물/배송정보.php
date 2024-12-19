<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
	$sql = "select * from HB_ADDRESS where USER_ID = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>회원정보</title>
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
      width: 500px;
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
      <h1>배송정보</h1>
      <table>
        <tr>
			<th> 우편번호 </th>
			<th> 주소 </th>
			<th> 상세주소 </th>
			<th> 수정 </th>
		</tr>
		<?php
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$address_number = $row['ADDRESS_NUMBER'];
			$address1 = $row['ADDRESS1'];
			$address2 = $row['ADDRESS2'];
			$address3 = $row['ADDRESS3'];
			echo("<tr><td>$address1</td>");
			echo("<td>$address2</td>");
			echo("<td>$address3</td>");
			echo("<td>
				<form method=\"POST\" action=\"배송정보수정화면.php\">
					<input type=\"hidden\" name=\"address_number\" value=\"$address_number\">
					<button type=\"submit\"> 수정 </button>
				</form>
				</td></tr>");
		}
		?>
      </table>
      <a href="배송정보입력화면.php" class="edit-link">배송지 추가하기</a>
	  <a href="회원정보.php" class="edit-link">돌아가기</a>
    </div>
  </div>
</body>
</html>
