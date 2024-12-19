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
	
	$sql = "select ID, name, phone_number, email,email_check, nickname, join_date, grade from HB_USER where id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
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
      <h1>회원정보</h1>
      <table>
        <tr>
          <th>ID</th>
          <td><?php echo $row["ID"]; ?></td>
        </tr>
        <tr>
          <th>이름</th>
          <td><?php echo $row["NAME"]; ?></td>
        </tr>
		<tr>
          <th>전화번호</th>
          <td><?php echo $row["PHONE_NUMBER"]; ?></td>
        </tr>
        <tr>
          <th>이메일</th>
          <td><?php echo $row["EMAIL"]; ?></td>
        </tr>
		<tr>
          <th>이메일수신여부</th>
          <td><?php echo $row["EMAIL_CHECK"]; ?></td>
        </tr>
		<tr>
          <th>닉네임</th>
          <td><?php echo $row["NICKNAME"]; ?></td>
        </tr>
		<tr>
          <th>가입날짜</th>
          <td><?php
		  $DATE = $row["JOIN_DATE"];
		  $DATE = date("Y-n-j", strtotime("$DATE"));
		  echo $DATE;
		  ?></td>
        </tr>
		<tr>
          <th>등급</th>
          <td><?php echo $row["GRADE"]; ?></td>
        </tr>
      </table>
      <a href="회원정보수정화면.php" class="edit-link">수정하기</a>
	  <a href="배송정보.php" class="edit-link">배송지관리</a>
	  <a href="주문목록.php" class="edit-link">주문목록</a>
    </div>
  </div>
</body>
</html>
