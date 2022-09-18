<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
		<title>連接</title>
      	<link rel="stylesheet" href="login_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>

		<center><div style="font-size:30px;">
		<?php
		//連接資料庫
		//只要此頁面上有用到連接 MySQL就要include它
		include("mysql_connect.inc.php");
		$id = $_POST['id'];
		$pw = $_POST['pw'];
		//搜尋資料庫資料
		$sql = "SELECT * FROM ACCOUNT where ID = '$id' && user_pword ='$pw' ";
		$result = mysqli_query($conn,$sql);
		$row = @mysqli_fetch_row($result);

		
		if($id != null && $pw != null && $row[0] == $id && $row[1] == $pw)
		{
			if($row[6]=='admin')
			{
				$_SESSION['username'] = $id;
				echo '管理員登入成功!';
				echo '<meta http-equiv=REFRESH CONTENT=1;url=admin.php>';
			}
			else
			{
				$_SESSION['username'] = $id;
				echo '會員登入成功!';
				echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
				if($row[7]=='Yes') 	$_SESSION['is_student'] = 0.5;
				if($row[7]=='No') 	$_SESSION['is_student'] = 1;
			}
		}
		elseif ($id == null || $pw == null) 
		{
			echo '帳號或密碼不得為空!';
			echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
		}
		else 
		{
			echo '密碼錯誤，請重新輸入!';
			echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
		}
		 

		?>
		</div></center>
	</body>
</html>


