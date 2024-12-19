<?php
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
	$sql = "select ID, name, phone_number, email,email_check, nickname, join_date, grade from HB_USER where id = '$id'";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>회원정보 수정</title>
  <style>
    body {
      background-color: whitesmoke;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      width: 500px;
      padding: 20px;
      border: 2px solid black;
      border-radius: 10px;
      background-color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    h1 {
      text-align: center;
    }
    .form-group {
      display: flex;
      flex-direction: row;
      align-items: center;
    }
    .form-group label {
      width: 120px;
      margin-right: 10px;
      font-weight: bold;
    }
    .form-group input[type="text"],
	.form-group input[type="email"],
    .form-group input[type="password"],
    .form-group select {
      width: 250px;
      padding: 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    input[type="submit"],
	input[type="button"]{
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
      align-self: center;
    }
	input[type="submit"]:hover {
      background-color: #0069d9;
    }
	button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
      align-self: center;
    }
    button:hover {
      background-color: #0069d9;
    }
  </style>
</head>
<body>
  <form action="회원정보수정.php" method="POST">
  <h1>회원정보 수정</h1>
    <div class="form-group">
      <label for="name">이름:</label>
      <input type="text" id="name" name="name" value="<?php echo $row["NAME"]; ?>">
    </div>
	<div class="form-group">
      <label for="phone_number">전화번호:</label>
      <input type="text" id="phone_number" name="phone_number" value="<?php echo $row["PHONE_NUMBER"]; ?>">
    </div>
    <div class="form-group">
      <label for="email">이메일:</label>
      <input type="email" id="email" name="email" value="<?php echo $row["EMAIL"]; ?>">
    </div>
    <div class="form-group">
	<?php
		if ($row["EMAIL_CHECK"] == 'O') {
			$email_check = 'checked';
		}
	  ?>
      <label for="email_check">이메일수신여부:</label>
      <input type="checkbox" id="email_check" name="email_check" value=""<?php echo $email_check; ?>>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
	<div class="form-group">
      <label for="nickname">닉네임:</label>
      <input type="text" id="nickname" name="nickname" value="<?php echo $row["NICKNAME"]; ?>">
    </div>
	<table>
		<tr>
			<td>
				<input type="submit" value="수정하기">
			</td>
			<td>
				<a href="회원정보.php"><input type="button" value="수정취소"></a>
			</td>
			<td>
				<a href="프사변경.html"><input type="button" value="프사변경"></a>
			</td>
			<td>
				<a href="회원탈퇴.html"><input type="button" value="회원탈퇴"></a>
			</td>
		</tr>
	</table>
  </form>
</body>
</html>