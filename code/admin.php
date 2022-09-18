<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<html>
<head>
<title>管理員</title>
<link rel="stylesheet" href="member_style.css"/>
</head>
<body>
	<img src="hsr.jpg" width="1255px"><br/>
    <center><h2 style="font-size:50px;">台灣高鐵管理系統</center></h2><br/>
	<center><div action="" class="list">
	<?php
	include("mysql_connect.inc.php");
	if($_SESSION['username'] != null)
	{
		echo '<form name="form" method="post" action="logout.php">';
		echo '<input type="submit" name="button" value="登出" /></form>';
		echo '<form name="form" method="post" action="admin_tra_mod.php">';
        echo '<input type="submit" name="button" value="修改車次" /></form>';
		echo '<form name="form" method="post" action="finance.php">';
        echo '<input type="submit" name="button" value="財務管理" /></form>';
		echo '<form name="form" method="post" action="admin_tra_add.php">';
        echo '<input type="submit" name="button" value="新增車次" /></form>';
		echo '<form name="form" method="post" action="admin_tra_del.php">';
        echo '<input type="submit" name="button" value="刪除車次" /></form>';
		echo '<form name="form" method="post" action="admin_query.php">';
		echo '<input type="submit" name="button" value="查看所有訂單" /></form>';
		echo '<form name="form" method="post" action="admin_modify.php">';
        echo '<input type="submit" name="button" value="管理員個人資料修改" /></form>';
		echo '<form name="form" method="post" action="account_overview.php">';
        echo '<input type="submit" name="button" value="查看此系統所有成員資料" /></form>';
	}
	else{
		echo '您沒有權限瀏覽此頁面！請登入或註冊';
		echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
	}
	
	?>

	
		</div></center> 
</body>
</html>
