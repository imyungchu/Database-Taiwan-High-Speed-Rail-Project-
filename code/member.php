<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<html>
<head>
<title>會員</title>
<link rel="stylesheet" href="member_style.css"/>
</head>
<body>
	<img src="hsr.jpg" width="1255px"><br/>
    <center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>
	<center><div action="" class="list">
	<?php
	include("mysql_connect.inc.php");
	
	
	if($_SESSION['username'] != null)
	{
		echo '<form name="form" method="post" action="logout.php">';
		echo '<input type="submit" name="button" value="登出" /></form>';
		echo '<form name="form" method="post" action="booking.php">';
        echo '<input type="submit" name="button" value="線上訂票" /></form>';
		echo '<form name="form" method="post" action="search.php">';
        echo '<input type="submit" name="button" value="查詢車次" /></form>';
		echo '<form name="form" method="post" action="cancel.php">';
        echo '<input type="submit" name="button" value="查詢或取消訂單" /></form>';
		echo '<form name="form" method="post" action="member_modify.php">';
        echo '<input type="submit" name="button" value="修改會員資料" /></form>';
	}
	else{
		echo '您沒有權限瀏覽此頁面！請登入或註冊';
		echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
	}
	?>
	
        </form>
		</div></center> 
</body>
</html>