<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
      <link rel="stylesheet" href="login_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>

		<center><div style="font-size:30px;">
        <?php
        include("mysql_connect.inc.php");

        // 接收前一頁提交的車次、時間、啟站與到站編號
        $id = $_POST['id']; 
        $train_id = $_POST['train_id']; 
        $seat = $_POST['seat_code'];
        $dep = $_SESSION['dep']; 
        $arr = $_SESSION['arr'];  
        $name = $_SESSION['username'];

        $dep_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $dep")); // 起站轉中文
        $arr_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $arr")); // 到站轉中文 

        $outcome = mysqli_fetch_row(mysqli_query($conn,"SELECT TRAIN_CODE, SEAT_CODE, LOC_DEP, LOC_ARR  FROM ORDER_TICKET where ORDER_ID = $id")); // 抓出前一頁cancel剛輸入的訂單號碼


        $dep_math = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_ID FROM LOCATION where LOC_NAME = '$outcome[2]'")); // 起站轉數字代碼
        $arr_math = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_ID FROM LOCATION where LOC_NAME = '$outcome[3]'")); // 到站轉數字代碼


        mysqli_fetch_row(mysqli_query($conn,"UPDATE TICKET_UP SET AVALIABLE = '0' WHERE TRAIN_CODE = $outcome[0] and SEAT_CODE = '$outcome[1]' and LOC_DEP >= $dep_math[0] and LOC_ARR <= $arr_math[0]")); 
        mysqli_fetch_row(mysqli_query($conn,"UPDATE TICKET_DOWN SET AVALIABLE = '0' WHERE TRAIN_CODE = $outcome[0] and SEAT_CODE = '$outcome[1]' and LOC_DEP >= $dep_math[0] and LOC_ARR <= $arr_math[0]")); 
        mysqli_fetch_row(mysqli_query($conn,"UPDATE ORDER_TICKET SET CANCELED = '1' WHERE ORDER_ID = $id")); 

        echo "<br><br><strong> 已收到您的取消請求";
        echo "<br>已為您取消訂單$id 號</strong><br><br><br>";
        echo '<meta http-equiv=REFRESH CONTENT=2;url=cancel.php>';






        ?>

		</div></center>
	</body>
</html>

