<?php
	date_default_timezone_set('Asia/Seoul');
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	
	$PRODUCT_NUMBER = $_POST['PRODUCT_NUMBER'];
	$selectedrating = $_POST['rating'];
	$ordering = $_POST['ordering'];
	
	$link = $PRODUCT_NUMBER."_상품.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>상품 리뷰</title>
	<style type="text/css">
		.review {
			text-align: center;
			background-color: #fff;
			border: 2px solid #000;
			border-radius: 4px;
			padding: 20px;
			margin: 0 auto;
			max-width: 700px;
		}
		.review .main-link {
			display: block;
			text-align: center;
			margin: 20px auto;
		}
		.review-list li {
			padding: 10px;
			border: 1px solid #ddd;
		}
		.sort-list {
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
		  display: flex;
		  padding: 10px 20px;
		  font-size: 15px;
		  background-color: #007bff;
		  color: #fff;
		  border: 1px solid #007bff;
		  cursor: pointer;
		  text-decoration: none;
		}
		.sort-list li button input {
			width : 10px;
		}
		.review-list {
			margin-top: 10px;
			text-align: left;
		}
		.review-list li .nickname {
			display: inline-block;
			font-weight: bold;
			margin-top: 0px;
			margin-right: 0px;
			margin-left: 2px;
			margin-bottom: 2px;
			margin: 0px;
			width : 100px;
		}
		.review-list li .w_date {
			display: inline-block;
			font-size: 12px;
			margin: 0px;
			width : 100px;
		}
		.review-list li .rating {
			display: block;
			
			margin: 0px;
			width : 100px;
		}
		.review-list li .content {
			display: flex;
			margin: 0px;
			margin-bottom: 5px;
		}
		@media only screen and (max-width: 500px) {
				.review .search input[type="text"] {
					width: 40%;
				}
				.sort select {
					width: 60%;
				}
		}
		.write select {
			width:120px;
			height: 45px;
			font-size: 14px;
			margin-left : 30px
		}
		.write .coment {
		  width: 450px;
		  height: 30px;
		  padding: 8px;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  font-size: 14px;
		}
		.write .coment-button {
		  padding: 8px 12px;
		  height: 45px;
		  background-color: #4CAF50;
		  color: white;
		  border: none;
		  border-radius: 4px;
		  font-size: 14px;
		  cursor: pointer;
		  white-space: nowrap;
		}
		.write .coment-button:hover {
		  background-color: #45a049;
		}
		a.main-link {
			color: red;
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
	function sendDataToPHP1(scriptName) {
      var form = document.getElementById("order1");
      form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP2(scriptName) {
      var form = document.getElementById("order2");
      form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP3(scriptName) {
      var form = document.getElementById("order3");
      form.action = scriptName;
      form.submit();
    }
	function sendDataToPHP4(scriptName) {
      var form = document.getElementById("order4");
      form.action = scriptName;
      form.submit();
    }
	</script>
</head>
<body>
	<section class="review">
	<a href="메인화면(로그인).php" class="main-link">Back To HB</a>
    <a href="상품 정보.php" class="main-link">상품 정보로</a>
    <h2>상품 리뷰</h2>
	<form id="coment-write" action="리뷰작성.php" method="POST">
	<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER; ?>">
		<div class="write">
			<select name="rating">
			  <option value = 5> 5점 ★★★★★ </option>
			  <option value = 4> 4점 ★★★★☆ </option>
			  <option value = 3> 3점 ★★★☆☆ </option>
			  <option value = 2> 2점 ★★☆☆☆ </option>
			  <option value = 1> 1점 ★☆☆☆☆ </option>
			</select></button></li>
			<input type="text" id="coment" name="coment" class="coment" placeholder="리뷰를 작성하세요">
			<button type="submit" class="coment-button">작성</button>
		</div>
	</form>
	<br><hr>
	<div class="sort-list">
	<form id="order" method="POST">
		<ul>
			<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER; ?>">
			<li><button type="button" onclick="sendDataToPHP1('리뷰.php')">평점순▼</button></li>
			<li><button type="button" onclick="sendDataToPHP2('리뷰.php')">평점순▲</button></li>
			<li><button type="button" onclick="sendDataToPHP3('리뷰.php')">날짜순▼</button></li>
			<li><button type="button" onclick="sendDataToPHP4('리뷰.php')">날짜순▲</button></li>
			<li><button type="button">
			<select name="rating" style="width:145px" onchange="sendDataToPHP('리뷰.php')">
			    <option value = 6 <?php if ($selectedrating == 6) echo "selected"; ?>> 모든평점보기 </option>
			    <option value = 5 <?php if ($selectedrating == 5) echo "selected"; ?>> 5점 ★★★★★ </option>
			    <option value = 4 <?php if ($selectedrating == 4) echo "selected"; ?>> 4점 ★★★★☆ </option>
			    <option value = 3 <?php if ($selectedrating == 3) echo "selected"; ?>> 3점 ★★★☆☆ </option>
			    <option value = 2 <?php if ($selectedrating == 2) echo "selected"; ?>> 2점 ★★☆☆☆ </option>
			    <option value = 1 <?php if ($selectedrating == 1) echo "selected"; ?>> 1점 ★☆☆☆☆ </option>
			</select></button></li>
		  </ul>
	</form>
	</div>
	
	<form id="order1" method="POST">
		<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER; ?>">
		<input type="hidden" name="rating" value="<?php echo $selectedrating; ?>">
		<input type="hidden" name="ordering" value="order by PRV.rating DESC">
	</form>
	<form id="order2" method="POST">
		<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER; ?>">
		<input type="hidden" name="rating" value="<?php echo $selectedrating; ?>">
		<input type="hidden" name="ordering" value="order by PRV.rating ASC">
	</form>
	<form id="order3" method="POST">
		<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER; ?>">
		<input type="hidden" name="rating" value="<?php echo $selectedrating; ?>">
		<input type="hidden" name="ordering" value="order by PRV.write_date DESC">
	</form>
	<form id="order4" method="POST">
		<input type="hidden" name="PRODUCT_NUMBER" value="<?php echo $PRODUCT_NUMBER; ?>">
		<input type="hidden" name="rating" value="<?php echo $selectedrating; ?>">
		<input type="hidden" name="ordering" value="order by PRV.write_date ASC">
	</form>
    <div class="review-list">
		<ul>
		<?php
			$sql = "select PRV.REVIEW_NUMBER review_number, PRV.CONTENT content, PRV.WRITE_DATE w_date, PRV.RATING rating, NVL(US.NICKNAME, '탈퇴한 회원') nickname, US.ID id 
			from HB_PRODUCT_REVIEW PRV left outer join HB_USER US
			on PRV.USER_ID = US.ID
			where PRV.PRODUCT_NUMBER = $PRODUCT_NUMBER";
			if (0 < $selectedrating and 6 > $selectedrating){
				$sql = $sql."and PRV.RATING = $selectedrating";
			}
			if (is_null($ordering) == 0){
				$sql = $sql."$ordering";
			}
			
			$stid = oci_parse($conn, $sql); 
			oci_execute($stid);
			while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
				$REVIEW_NUMBER = $row["REVIEW_NUMBER"];
				$CONTENT = $row["CONTENT"];
				$WRITE_DATE = $row["W_DATE"];
				$WRITE_DATE = date("Y-n-j", strtotime("$WRITE_DATE"));
				$RATING = "starRating/".$row["RATING"].".jpg";
				$NICKNAME = $row["NICKNAME"];
				$USER_ID = $row["ID"];
				
				echo ("
					<li>
						<p class=\"nickname\">$NICKNAME</p>
						<p class=\"w_date\">$WRITE_DATE</p>
						<p class=\"rating\"><img src=\"$RATING\" alt=\"Product\"> </p>
						<p class=\"content\">$CONTENT</p>
				");
				if ($id == $USER_ID or $id =='admin'){
					echo ("
						<form method=\"POST\" action=\"리뷰삭제.php\">
							<input type=\"hidden\" name=\"REVIEW_NUMBER\" value=\"$REVIEW_NUMBER\">
							<input type=\"hidden\" name=\"PRODUCT_NUMBER\" value=\"$PRODUCT_NUMBER\">
							<button type=\"submit\"> 리뷰삭제 </button>
						</form>
					");
				}
				echo ("</li>");
			}
		?>
      </ul>
    </div>
  </section>
</body>
</html>
