<?php
	require('conn.php');
	
	$search = $_POST['search'];
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
	
	$sql = "update HB_PRODUCT set views = views+1 where PRODUCT_NUMBER = $PRODUCT_NUMBER";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid); // 조회수
	
	$sql = " select A.*, rating from 
	(select IM.LINK as link, PR.PRODUCT_NUMBER as NUM, PR.NAME as name, PR.PRICE as price, PR.stock as stock, PR.INTRODUCE introduce
	from HB_PRODUCT PR inner join HB_PRODUCT_IMAGE IM
	on PR.PRODUCT_NUMBER = IM.PRODUCT_NUMBER
	where PR.PRODUCT_NUMBER = $PRODUCT_NUMBER AND IM.NAME = '대표사진') A
	left outer join
	(select PRODUCT_NUMBER NUM, AVG(RATING) rating from HB_PRODUCT_REVIEW GROUP BY PRODUCT_NUMBER) B
	on A.NUM = B.NUM";
	$stid = oci_parse($conn, $sql); 
	oci_execute($stid);
	
	
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>상품</title>
  <link rel="stylesheet" href="style.css">
  <style>
    section.product_main {
      width: 800px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #000;
      text-align: center;
      background-color: #fff;
    }
    section.product_main h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .product {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
	  margin-left: 200px;
	  margin-right: 20px;
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ddd;
      width: 400px;
    }
    .product img {
      width: 390px;
	  height:390px;
	  margin-left : 10px;
      margin-bottom: 10px;
    }
    .introduce {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }
    .introduce h3 {
      font-size: 45px;
      margin: 0;
      font-weight: bold;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .introduce p {
      margin: 0;
	  font-size: 30px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      letter-spacing: 1px;
    }
    .choice {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
      margin-right: 10px;
    }
    .choice button {
	  display: flex;
      padding: 10px 20px;
      font-size: 25px;
      background-color: #007bff;
      color: #fff;
      border: 1px solid #007bff;
      cursor: pointer;
      text-decoration: none;
	  margin : 10px 10px 0px 10px;
    }
	.choice input {
	  margin-top : 10px;
	  margin-right : 10px;
	  font-size: 25px;
	  width : 80px;
	  height : 50px;
	}
	.content {
	  font-size: 25px;
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }
	.content img {
		max-width: 90%;
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
    function sendDataToPHP(scriptName) {
      var form = document.getElementById("order");
      form.action = scriptName;
      form.submit();
    }
  </script>
</head>
<body>
  <section class="product_main">
    <header>
      <a href="메인화면(로그인).php" class="main-link">Back To HB</a>
    </header>
    <h2>상품 정보</h2>
    <div class="product">
	<?php
		$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
		$num = $row["NUM"];
		$link = $row["LINK"];
		$PR_NAME = $row["NAME"];
		$PR_PRICE = $row["PRICE"];
		$stock = $row["STOCK"];
		$rating = $row["RATING"];
		if(is_null($rating)){
				$rating = 3;
			}
			$rating_check = round($rating,1);
			$rating_link = "starRating/".round($rating).".jpg";
		echo("
			<img src=\"$link\" alt=\"Product\">
		");
	?>
    </div>
	<form id="order" method="POST">
		<div class="introduce">
		<?php
			echo ("
				<h3>$PR_NAME</h3>
				<p> \\ $PR_PRICE 원</p><br>
				<img class=\"star average-rating\" src=\"$rating_link\" alt=\"rating\"> 평점 : $rating_check
			");
		?>
		</div>
		<div class="STOCK">
		<?php
			echo ("<p> 남은 재고 : $stock (개)</p>");
		?>
		</div>
		<div class="choice">
			<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER; ?>">
			<input type="number" max="<?php echo $stock ?>" id="numberInput" name="numberInput" value=1>
			<button type="button" onclick="sendDataToPHP('장바구니.php')">장바구니 담기</button>
			<button type="button" onclick="sendDataToPHP('리뷰.php')">리뷰 ></button>
			<button type="button" onclick="sendDataToPHP('주문화면.php')">주문하기 ></button>
		</div>
	</form>
	<br><hr><br>
	<div class = "content">
		<?php
			echo $row["INTRODUCE"];
			echo "<br><br>";
			$sql = "
			select PR.introduce introduce, IM.LINK link
			from HB_PRODUCT PR inner join HB_PRODUCT_IMAGE IM
			on PR.PRODUCT_NUMBER = IM.PRODUCT_NUMBER
			where PR.PRODUCT_NUMBER = $PRODUCT_NUMBER and IM.name != '대표사진'
			order by image_number ASC";
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
			
			while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
				$link = $row["LINK"];
				echo("<img src=\"$link\" alt=\"Product\">");
			}
		?>
	</div>
  </section>
</body>
</html>