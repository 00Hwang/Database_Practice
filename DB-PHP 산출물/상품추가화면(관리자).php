<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>상품추가</title>
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
</head>
<body>
  <div class="container">
    <section class="plus_product">
      <a href="메인화면(로그인).php" class="main-link">Back To HB</a>
      <h2>상품추가</h2>
      <form action="상품추가(관리자).php" method="POST" enctype="multipart/form-data">
        <div class="input-group">
          <label for="name">상품명</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="input-group">
          <label for="introduce">상품설명</label>
          <textarea id="introduce" name="introduce" maxlength="500" placeholder = "최대 500자"></textarea>
        </div>
        <div class="input-group">
          <label for="price">가격</label>
          <input type="number" id="price" name="price" required>
        </div>
        <div class="input-group">
          <label for="stock">재고</label>
          <input type="number" id="stock" name="stock">
        </div>
        <hr>
        <h3>사진추가</h3>
        <div class="input-group">
          <label for="product_image">대표사진(필수)</label>
          <input type="file" id="product_image" name="product_image" required>
        </div>
        <button type="submit">상품추가</button>
      </form>
    </section>
  </div>
</body>
</html>
