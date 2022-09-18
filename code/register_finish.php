<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>
		<center><div style="font-size:30px;">
		<?php
		include("mysql_connect.inc.php");

		$id = $_POST['id'];
		$pw = $_POST['pw'];
		$pw2 = $_POST['pw2'];
		$fname = $_POST['f_name'];
		$lname = $_POST['l_name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$email2 = $_POST['email2'];
		$auth = $_POST['auth'];
		$student = $_POST['IS_STUDENT'];


		//判斷任一欄位是否為空值
		if($id != NULL && $pw != NULL && $pw2 != NULL && $fname != NULL 
			&& $lname != NULL && $phone != NULL && $email != NULL&& $email2 != NULL)
		{
			//密碼正確，未授權，身分為普通會員
			if($pw == $pw2 && $auth == null&& $email == $email2)
			{
				//新增資料進資料庫語法
				$auth = 'member' ;
				$sql = "INSERT INTO ACCOUNT (ID, USER_PWORD, USER_FNAME, USER_LNAME, USER_PHONE, USER_EMAIL, IS_ADMIN, IS_STUDENT) 
				VALUES ('$id', '$pw', '$fname', '$lname', '$phone', '$email', '$auth', '$student')";
				if(mysqli_query($conn, $sql))
				{
					echo '新增成功!';
					echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
				}
			}
			//密碼正確，有授權，身分為管理員
			else if($pw == $pw2 && $auth == 'ej03xu3m06')
			{
				$auth = 'admin';
				$student = 'No';
				$sql = "INSERT INTO ACCOUNT (ID, USER_PWORD, USER_FNAME, USER_LNAME, USER_PHONE, USER_EMAIL, IS_ADMIN, IS_STUDENT) 
				VALUES ('$id', '$pw', '$fname', '$lname', '$phone', '$email', '$auth', '$student')";
				if(mysqli_query($conn, $sql))
				{
					echo '新增成功!';
					echo '<meta http-equiv=REFRESH CONTENT=2;url=login.php>';
				}
			}
			else
			{
				echo '密碼輸入錯誤或使用錯誤的管理員金鑰!';
				echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
			}
		}
		else
		{
			echo '任一欄位請勿為空!';
			echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
		}
		?>
		</div></center>
	</body>
</html>