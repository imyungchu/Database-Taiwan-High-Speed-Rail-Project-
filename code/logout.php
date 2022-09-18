<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<html>
<head>
<title>登出</title>
<link rel="stylesheet" href="member_style.css"/>
</head>
<body>
	<img src="hsr.jpg" width="1255px"><br/>
    <center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>

    <center><div style="font-size:30px;">
    <?php
    //連接資料庫
    //只要此頁面上有用到連接 MySQL就要include它
    include("mysql_connect.inc.php");

    // 判斷帳號與密碼是否為空白，密碼是否吻合
    $_SESSION['username'] = null;
    echo '您已登出!';
    echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
    ?>
    </div></center>

</body>
</html>
