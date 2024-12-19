<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
	
	$sql = "select * from HB_PRODUCT where PRODUCT_NUMBER = $PRODUCT_NUMBER";
	$stid = oci_parse($conn, $sql); oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>상품수정</title>
  <style>
    body {
      background-color: whitesmoke;
      font-family: Arial, sans-serif;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .plus_product {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      width: 800px;
      padding: 20px;
      border: 2px solid black;
      border-radius: 10px;
      background-color: white;
    }
    .input-group {
      margin-bottom: 15px;
    }
    label {
      display: inline-block;
      width: 120px;
      text-align: right;
      margin-right: 10px;
      font-weight: bold;
    }
    input {
	  width : 600px;
	  margin-right: 50px;
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
	textarea {
		width : 600px;
		max-width : 600px;
		height : 100px;
		margin-right: 50px;
		font-size: 16px;
		font-family: Arial, sans-serif;
	}
    button {
      padding: 8px 16px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #0069d9;
    }
    a.main-link {
      color: red;
      text-decoration: none;
    }
    hr {
      margin-top: 20px;
      margin-bottom: 20px;
      border: 0;
      border-top: 1px solid #ccc;
    }
    h3 {
      margin-top: 20px;
      margin-bottom: 10px;
    }
  </style>
  <script>
    function sendDataToPHP(scriptName) {
      var form = document.getElementById("update");
      form.action = scriptName;
      form.submit();
    }
  </script>
</head>
<body>
  <div class="container">
    <section class="plus_product">
      <a href="메인화면(로그인).php" class="main-link">Back To HB</a>
      <h2>상품수정</h2>
      <form id= "update" method="POST" enctype="multipart/form-data">
        <div class="input-group">
          <label for="name">상품명</label>
          <input type="text" id="name" name="name" value="<?php echo $row["NAME"]?>" required>
        </div>
        <div class="input-group">
          <label for="introduce">상품설명</label>
          <textarea id="introduce" name="introduce" maxlength="500" placeholder = "최대 500자"><?php echo $row["INTRODUCE"]?></textarea>
        </div>
        <div class="input-group">
          <label for="price">가격</label>
          <input type="number" id="price" name="price" value="<?php echo $row["PRICE"]?>" required>
        </div>
        <div class="input-group">
          <label for="stock">재고</label>
          <input type="number" id="stock" name="stock" value="<?php echo $row["STOCK"]?>">
        </div>
		<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER ?>">
        <button type="button" onclick="sendDataToPHP('상품수정(관리자).php')">상품수정</button>
		<a href="상품관리(관리자).php"><button type="button">수정취소</button></a>
      </form>
	  <hr>
	  <h2>대표 사진 변경</h2>
	  <form action="대표사진변경(관리자).php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER ?>">
		<div class="input-group">
          <label for="product_image">대표사진</label>
          <input type="file" id="product_image" name="product_image" required>
        </div>
	  <button type="submit">대표사진수정</button>
	  </form>
	  <hr>
	  <h2>설명 사진 추가</h2>
	  <form action="설명사진추가(관리자).php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER ?>">
		<div class="input-group">
          <label for="product_image">설명사진</label>
          <input type="file" id="product_image" name="product_image" required>
        </div>
	  <button type="submit">설명사진추가</button>
	  </form>
    </section>
  </div>
</body>
</html>
