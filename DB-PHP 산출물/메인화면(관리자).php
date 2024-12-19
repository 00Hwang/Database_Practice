<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>관리자메뉴</title>
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
      <h1>관리자메뉴</h1>
      <a href="상품관리(관리자).php" class="edit-link">상품관리</a>
	  <a href="리뷰관리(관리자).php" class="edit-link">리뷰관리</a>
	  <a href="주문목록(관리자).php" class="edit-link">주문관리</a>
	  <a href="회원관리(관리자).php" class="edit-link">회원관리</a>
	  <a href="로그아웃.php" class="edit-link">관리종료</a>
    </div>
  </div>
</body>
</html>
