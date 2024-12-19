<?php
  session_start();
  session_destroy();
  
  echo("
		<script> alert('로그아웃 되었습니다'); </script>
		<script> location.replace('메인화면.html'); </script>
  ");
?>