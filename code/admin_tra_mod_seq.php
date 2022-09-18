<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
        <title>搜尋班次</title>
        <link rel="stylesheet" href="tra_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵管理系統</center></h2><br/>
        <center><div action="" class="traadd">
        <?php
        include("mysql_connect.inc.php");

        // 接收前一頁提交的車次、時間、啟站與到站編號

        $train_id_mod = $_POST['train_id_mod']; 

        $dep = $_SESSION['dep']; 
        $arr = $_SESSION['arr'];  
        $sss = $_POST["sss"];
        // for($i = 0 ; $i<3 ;$i=$i+1)
        // {echo $sss[$i];}
        echo $sss[1];
        echo'<br>';
        echo $sss[2];
        //先判斷是上行 or 下行車票
        // $sql_judge = "SELECT TRAIN_SER FROM TRAIN where train_code=$train_id_mod"; // (1)
        // $result_judge= mysqli_query($conn,$sql_judge);
        // $row_judge = mysqli_fetch_row($result_judge);

        $train_status = mysqli_fetch_row(mysqli_query($conn,"SELECT CANCELED FROM TRAIN WHERE TRAIN_CODE =$train_id_mod")); 
        if($train_status[0]==0)
        {  
            mysqli_fetch_row(mysqli_query($conn,"UPDATE TRAIN SET CANCELED = '1' WHERE TRAIN_CODE =$train_id_mod")); 
            mysqli_fetch_row(mysqli_query($conn,"UPDATE ORDER_TICKET SET CANCELED = '2' WHERE TRAIN_CODE =$train_id_mod")); 
            echo "<br><br><strong> 已將您設定的班次 {$train_id_mod} 調整行車狀態 </strong><br>";
            echo '<br><br><font size = "5"><strong> 且已將該班次的訂單全數取消 </strong></font><br>';

        }
        if($train_status[0]==1)
        {
            mysqli_fetch_row(mysqli_query($conn,"UPDATE TRAIN SET CANCELED = 0 WHERE TRAIN_CODE =$train_id_mod")); 
            mysqli_fetch_row(mysqli_query($conn,"UPDATE ORDER_TICKET SET CANCELED = '0' WHERE TRAIN_CODE =$train_id_mod AND CANCELED=2")); 
            echo "<br><br><strong> 已將您設定的班次 {$train_id_mod} 調整行車狀態 </strong><br>";
        }


        echo '<meta http-equiv=REFRESH CONTENT=1;url=admin_tra_mod.php>';






        // $dep_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $dep")); // 起站轉中文
        // $arr_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $arr")); // 到站轉中文 

        // $outcome = mysqli_fetch_row(mysqli_query($conn,"SELECT TRAIN_CODE, SEAT_CODE, LOC_DEP, LOC_ARR  FROM ORDER_TICKET where ORDER_ID = $id")); // 抓出前一頁cancel剛輸入的訂單號碼


        // $dep_math = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_ID FROM LOCATION where LOC_NAME = '$outcome[2]'")); // 起站轉數字代碼
        // $arr_math = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_ID FROM LOCATION where LOC_NAME = '$outcome[3]'")); // 到站轉數字代碼


        // mysqli_fetch_row(mysqli_query($conn,"UPDATE TICKET_UP SET AVALIABLE = '0' WHERE TRAIN_CODE = $outcome[0] and SEAT_CODE = '$outcome[1]' and LOC_DEP >= $dep_math[0] and LOC_ARR <= $arr_math[0]")); 
        // mysqli_fetch_row(mysqli_query($conn,"UPDATE TICKET_DOWN SET AVALIABLE = '0' WHERE TRAIN_CODE = $outcome[0] and SEAT_CODE = '$outcome[1]' and LOC_DEP >= $dep_math[0] and LOC_ARR <= $arr_math[0]")); 
        // mysqli_fetch_row(mysqli_query($conn,"UPDATE ORDER_TICKET SET CANCELED = '1' WHERE ORDER_ID = $id")); 

        // echo '<br><br><font size = "5"><strong> 已收到您的取消請求 </strong></font><br>';
        // echo '<meta http-equiv=REFRESH CONTENT=2;url=cancel.php>';






        ?>

        </div></center>
	</body>
</html>

