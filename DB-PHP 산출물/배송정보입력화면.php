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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>배송 정보</title>
	<style>
		main {
			width: 100%;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.delivery {
			width: 80%;
			max-width: 500px;
			padding: 20px;
			border: 2px solid #000;
			border-radius: 10px;
			text-align: center;
			background-color: #fff;
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
		button[type="submit"]:hover {
			background-color: #45a049;
		}
		a.main-link{
			color: red;
		}
		body{
			background-color: whitesmoke;
		}
	</style>
</head>
<body>
<main>
  <section class="delivery">
  	<a href="메인화면(로그인).php" class="main-link">Back To HB</a>
    <h2>배송 정보 추가</h2>
    <form action="배송정보입력.php" method="POST">
      <div class="input-group">
      	<label for="zip-code">우편번호</label>
      	<input type="text" id="address1"  name="address1" placeholder="우편번호를 입력해주세요" required>
      </div>
      <div class="input-group">
      	<label for="address">주소</label>
      	<input type="text" id="address2" name="address2" placeholder="도시, 동" required>
      	<input type="text" id="address3" name="address3" placeholder="상세 주소" required>
      </div>
      <div class="button-group">
        <button type="submit">배송 정보 입력</button>
      </div>
    </form>
  </section>
</main>
<hr>
</body>
</html>
