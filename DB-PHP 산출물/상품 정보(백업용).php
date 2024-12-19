<?php
	require('conn.php');
	
	$search = $_POST['search'];
	
	$order = $_POST['order'];
	
	echo ("<script> alert($order); </script>");
	
	$sql = "select A.*, rating from
	(select IM.LINK as link, PR.PRODUCT_NUMBER as NUM, PR.NAME as name, PR.PRICE as price 
	from HB_PRODUCT PR left outer join HB_PRODUCT_IMAGE IM
	on PR.PRODUCT_NUMBER = IM.PRODUCT_NUMBER where PR.name LIKE '%$search%' AND IM.NAME = '대표사진') A
	left outer join
	(select PRODUCT_NUMBER NUM, AVG(RATING) rating from HB_PRODUCT_REVIEW GROUP BY PRODUCT_NUMBER) B
	on A.NUM = B.NUM "."$order";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>상품 정보</title>
  <link rel="stylesheet" href="style.css">
  <style>
    section.product {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #000;
      text-align: center;
      background-color: #fff;
    }
    section.product h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .search {
      display: block;
      margin-bottom: 20px;
    }
    .search input[type="text"] {
	  width : 700px;
      flex: 1;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-right: none;
    }
    .search button[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: #fff;
      border: 1px solid #007bff;
      border-left: none;
      cursor: pointer;
    }
    .product-list {
      display: flex;
      justify-content: space-between;
      overflow-x: auto;
    }
    .product-list ul {
      display: flex;
      flex-wrap: wrap;
      padding: 0;
      list-style-type: none;
    }
    .product-list li {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
	  margin-left: 20px;
	  margin-right: 20px;
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ddd;
      width: 200px;
    }
    .product-list li a {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-decoration: none;
      color: #333;
    }
    .product-list li a img {
      max-width: 150px;
      margin-bottom: 10px;
    }
    .product-list li a div {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }
    .product-list li a div h3 {
      font-size: 18px;
      margin: 0;
      font-weight: bold;
      margin-bottom: 10px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .product-list li a div p {
      margin: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      letter-spacing: 1px;
    }
    .product-list li a div img {
		display: flex;
		margin-top : 15px;
    }
    .product-list li a div .average-rating:after {
      content: "4.5";
      margin-left: 5px;
    }
    .sort-list {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .sort-list ul {
      display: flex;
      list-style-type: none;
    }
    .sort-list li {
      margin-right: 10px;
    }
    .sort-list li button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: #fff;
      border: 1px solid #007bff;
      cursor: pointer;
      text-decoration: none;
    }
    a.main-link {
      color: red;
      display: block;
      margin-bottom: 20px;
    }
    header {
      text-align: center;
    }
    body {
      background-color: whitesmoke;
    }
  </style>
  <script>
    function sendDataToPHP_name1(scriptName) {
	  var form = document.getElementById("order1");
	  form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP_name2(scriptName) {
	  var form = document.getElementById("order2");
	  form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP_price(scriptName) {
	  var form = document.getElementById("order3");
	  form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP_price2(scriptName) {
	  var form = document.getElementById("order4");
	  form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP_rating(scriptName) {
	  var form = document.getElementById("order5");
	  form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP_rating2(scriptName) {
	  var form = document.getElementById("order6");
	  form.action = scriptName;
      form.submit();
    }
  </script>
</head>
<body>
  <section class="product">
    <header>
      <a href="메인화면(로그인).php" class="main-link">Back To HB</a>
    </header>
    <h2>상품 정보</h2>
	<div class="search">
		<form id="search-form" action="상품 정보.php" method="POST">
			  <input type="text" id="search" name="search" value="<?php echo $search;?>" class="search-input">
			  <button type="submit" class="search-button">검색</button>
		</form>
	</div>
    <div class="sort-list">
      <ul>
		<li><button type="button" onclick="sendDataToPHP_name1('상품 정보.php')">이름순▲</button></li>
		<form id="order1" method="POST"><input type="hidden" name="order" value="order by name ASC"></form>
		<li><button type="button" onclick="sendDataToPHP_name2('상품 정보.php')">이름순▼</button></li>
		<form id="order2" method="POST"><input type="hidden" name="order" value="order by name DESC"></form>
		<li><button type="button" onclick="sendDataToPHP_price('상품 정보.php')">가격순▲</button></li>
		<form id="order3" method="POST"><input type="hidden" name="order" value="order by price ASC"></form>
		<li><button type="button" onclick="sendDataToPHP_price2('상품 정보.php')">가격순▼</button></li>
		<form id="order4" method="POST"><input type="hidden" name="order" value="order by price DESC"></form>
		<li><button type="button" onclick="sendDataToPHP_rating('상품 정보.php')">평점순▲</button></li>
		<form id="order5" method="POST"><input type="hidden" name="order" value="order by rating ASC"></form>
		<li><button type="button" onclick="sendDataToPHP_rating2('상품 정보.php')">평점순▼</button></li>
		<form id="order6" method="POST"><input type="hidden" name="order" value="order by rating DESC"></form>
      </ul>
    </div>
    <div class="product-list">
	<ul>
	<?php
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$num = $row["NUM"]."_상품.php";
			$PR_num =$row["NUM"];
			$link = $row["LINK"];
			$PR_NAME = $row["NAME"];
			$PR_PRICE = $row["PRICE"];
			$rating = $row["RATING"];
			if(is_null($rating)){
				$rating = 3;
			}
			$rating_check = round($rating,1);
			$rating_link = "starRating/".round($rating).".jpg";
			echo("
				<li>
				  <a href=\"$num\">
					<img src=\"$link\" alt=\"Product\">
					<div>
					  <h3>$PR_NAME</h3>
					  <p>상품 가격: $PR_PRICE 원</p>
					  <img src=\"$rating_link\" alt=\"rating\">
					  <p>평점 : $rating_check</p>
					</div>
				  </a>
				</li>
			");
		}
	  ?>
	</ul>
    </div>
  </section>
  <script>
    const productList = document.querySelector('.product-list ul');
    const sortButtons = document.querySelectorAll('.sort-list a');
    sortButtons.forEach(button => {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        const id = this.id;
        if (id === 'sortName') {
          sortByName();
        } else if (id === 'sortPrice') {
          sortByPrice();
        } else if (id === 'sortRating') {
          sortByRating();
        }
      });
    });
    function sortByName() {
      const products = Array.from(productList.children);
      products.sort((a, b) => {
        const nameA = a.querySelector('h3').textContent;
        const nameB = b.querySelector('h3').textContent;
        return nameA.localeCompare(nameB);
      });
      products.forEach(product => productList.appendChild(product));
    }
    function sortByPrice() {
      const products = Array.from(productList.children);
      products.sort((a, b) => {
        const priceA = getPrice(a);
        const priceB = getPrice(b);
        return priceA - priceB;
      });
      products.forEach(product=> productList.appendChild(product));
    }
    function getPrice(product) {
      const priceString = product.querySelector('p:nth-of-type(1)').textContent;
      return parseInt(priceString.replace(/[^0-9]/g, ''));
    }
    function sortByRating() {
      const products = Array.from(productList.children);
      products.sort((a, b) => {
        const ratingA = getRating(a);
        const ratingB = getRating(b);
        return ratingB - ratingA;
      });
      products.forEach(product => productList.appendChild(product));
    }
    function getRating(product) {
      const ratingString = product.querySelector('.average-rating').textContent;
      const rating = ratingString.split(' ')[1];
      return parseFloat(rating);
    }
  </script>
</body>
</html>