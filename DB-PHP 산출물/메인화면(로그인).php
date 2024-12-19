<?php
	require('conn.php');
	
	session_start();
	$id = $_SESSION['id'];
	if($id == null){
		echo("
			<script> alert('로그인이 만료되었습니다.'); </script>
			<script> location.replace('메인화면.html'); </script>
		");
		exit;
	} else if ($id == "admin") {
		echo("
			<script> alert('관리자페이지로 이동합니다.'); </script>
			<script> location.replace('메인화면(관리자).php'); </script>
		");
	}
	
	$sql = "select nickname, NVL(profile, 'profileImage/기본사진.jpg') as profile from HB_USER where id = '$id'";
	$stid = oci_parse($conn, $sql); oci_execute($stid);
	$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>메인화면</title>
  <style>
    body {
      background-color: whitesmoke;
    }
    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
    }
    .nav-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-right: 60px;
    }
    .menu {
      display: flex;
      justify-content: flex-start;
      align-items: center;
    }
    .nav-container .menu a {
      margin: 5px;
      border: 2px solid black;
      text-decoration: none;
      text-decoration-color: darkred;
      background-color: floralwhite;
      padding: 10px;
      white-space: nowrap;
      transition: background-color 0.3s, color 0.3s;
    }
    .nav-container .menu a:hover {
      background-color: darkblue;
      color: floralwhite;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 500px;
    }
    .container div {
      width: 100%;
      padding: 50px;
      text-align: center;
    }
    footer {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    footer button {
      margin: 5px;
      padding: 5px 10px;
    }
    .banner {
      text-align: center;
    }
    .banner img {
      width: 1500px;
    }
    .banner-container {
      width: 100%;
      height: 100%;
      overflow: hidden;
      text-align: center;
    }
    .profile-container {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      padding: 10px;
      margin-left: 60px;
      white-space: nowrap;
    }
    .profile-image {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .profile-name {
      font-size: 18px;
      font-weight: bold;
      flex-direction: nowrap;
    }
    .search-container {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      padding: 10px;
      margin-left: 60px;
    }
    .search-container form {
      display: flex;
      align-items: center;
    }
    .search-container .search-input {
      width: 750px;
	  height: 30px;
      margin-right: 10px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    .search-container .search-button {
      padding: 8px 12px;
      background-color: #4CAF50;
	  height: 45px;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      white-space: nowrap;
    }
    .search-container .search-button:hover {
      background-color: #45a049;
    }
    @media only screen and (max-width: 600px) {
      .nav-container {
        flex-direction: column;
        align-items: center;
      }
      .menu {
        margin-top: 10px;
      }
      .profile-container {
        margin-top: 10px;
      }
      .search-container {
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
        margin-bottom: 10px;
      }
      .search-container .search-input {
        width: 100%;
        margin-bottom: 10px;
      }
    }
	
  </style>
</head>
<body>
  <h1>HB Shopping Mall</h1>
  <hr>
  <nav>
    <div class="nav-container">
      <div class="menu">
        <a href="장바구니.php">장바구니</a>
        <a href="회원정보.php">마이페이지</a>
        <a href="로그아웃.php">로그아웃</a>
      </div>
      <div class="profile-container">
        <img class="profile-image" src="<?php echo $row["PROFILE"]?>" alt="프사">
        <div class="profile-name"><?php echo $row["NICKNAME"]?></div>
      </div>
      <div class="search-container">
        <form id="search-form" action="상품 정보.php" method="POST">
          <input type="text" id="search" name="search" placeholder="검색어를 입력하세요" class="search-input">
          <button type="submit" class="search-button">검색</button>
        </form>
      </div>
    </div>
  </nav>
  <hr>
  <div class="container">
    <div class="banner-container">
      <div class="banner">
        <img id="banner-image" src="배너 이미지.jpg" style="width:1250px; height:520px;" alt="배너 이미지">
      </div>
    </div>
  </div>
  <script>
    const products = [
      { name: '상품 1', category: '1' },
      { name: '상품 2', category: '2' },
      { name: '상품 3', category: '1' },
      { name: '상품 4', category: '3' },
      { name: '상품 5', category: '2' },
      { name: '상품 6', category: '3' },
    ];
    const productListElement = document.createElement('ul');
    productListElement.id = 'product-list';
    const loadMoreButton = document.getElementById('load-more');
    const categorySelect = document.getElementById('category');
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search');
    let currentPage = 1;
    const itemsPerPage = 3;
    displayProductList(products);
    loadMoreButton.addEventListener('click', loadMore);
    categorySelect.addEventListener('change', filterProductList);
    searchForm.addEventListener('submit', function(e) {
      e.preventDefault();
      filterProductList();
    });
    const containerDiv = document.querySelector('.container div');
    containerDiv.appendChild(productListElement);
    function displayProductList(products) {
      productListElement.textContent = '';
      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const visibleProducts = products.slice(startIndex, endIndex);
      for (let i = 0; i < visibleProducts.length; i++) {
        const product = visibleProducts[i];
        const listItem = document.createElement('li');
        listItem.textContent = product.name;
        productListElement.appendChild(listItem);
      }
    }
    function loadMore() {
      currentPage++;
      displayProductList(products);
    }
    function filterProductList() {
      currentPage = 1;
      const category = categorySelect.value;
      const searchKeyword = searchInput.value.toLowerCase();
      const filteredProducts = products.filter((product) => {
        const matchCategory = category === '' || product.category === category;
        const matchSearch = product.name.toLowerCase().includes(searchKeyword);
        return matchCategory && matchSearch;
      });
      displayProductList(filteredProducts);
    }
    function changePage(page) {
      currentPage = page;
      displayProductList(products);
    }
    window.addEventListener('DOMContentLoaded', function() {
      var bannerImage = document.getElementById('banner-image');
      bannerImage.addEventListener('load', function() {
        resizeImage(bannerImage);
      });

      function resizeImage(image) {
        var containerWidth = image.parentElement.offsetWidth;
        var containerHeight = image.parentElement.offsetHeight;
        var imageWidth = image.naturalWidth;
        var imageHeight = image.naturalHeight;
        var containerAspectRatio = containerWidth / containerHeight;
        var imageAspectRatio = imageWidth / imageHeight;

        if (containerAspectRatio > imageAspectRatio) {
          image.style.width = 'auto';
          image.style.height = '100%';
        } else {
          image.style.width = '100%';
          image.style.height = 'auto';
        }
      }
    });
  </script>
</body>
</html>