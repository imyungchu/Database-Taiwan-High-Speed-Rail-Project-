<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
        <title>搜尋車次</title>
        <link rel="stylesheet" href="tra_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵管理系統</center></h2><br/>
        <center><div action="" class="traadd">
        <?php
        include("mysql_connect.inc.php");

        //本頁面用來判讀與新曾班次
        // 接收前一頁提交的車次、時間、啟站與到站編號
        $train_id=$_POST['train_id_add_seq'];
        $train_type=$_POST['train_type_add_seq'];
        $train_ser=$_POST['train_ser_add_seq'];

        $hr=$_POST['hr'];
        $min=$_POST['min'];
        $sec=$_POST['sec'];

        $time=$hr.$min.$sec;
        //echo $time;

        $dep = $_POST['dep'];  
        $arr = $_POST['arr']; 


        $sss = $_POST["sss"];  // 將前一admin_tra_add.php的 checkbox 資料傳過來 轉入$sss  
        $num = count($sss);   // 將值存入計數器
        $南港 = 0;
        $台北 = 0;
        $板橋 = 0;
        $桃園 = 0;
        $新竹 = 0;
        $苗栗 = 0;
        $台中 = 0;
        $彰化 = 0;
        $雲林 = 0;
        $嘉義 = 0;
        $台南 = 0;
        $左營 = 0;

        for ($i=0; $i<$num; $i=$i+1)
        {
            if ($sss[$i]=='1'){$南港 = 1;}
            if ($sss[$i]=='2'){$台北 = 1;}
            if ($sss[$i]=='3'){$板橋 = 1;}
            if ($sss[$i]=='4'){$桃園 = 1;}
            if ($sss[$i]=='5'){$新竹 = 1;}
            if ($sss[$i]=='6'){$苗栗 = 1;}
            if ($sss[$i]=='7'){$台中 = 1;}
            if ($sss[$i]=='8'){$彰化 = 1;}
            if ($sss[$i]=='9'){$雲林 = 1;}
            if ($sss[$i]=='10'){$嘉義 = 1;}
            if ($sss[$i]=='11'){$台南 = 1;}
            if ($sss[$i]=='12'){$左營 = 1;}
        }
        mysqli_fetch_row(mysqli_query($conn,"INSERT INTO 
        TRAIN (TRAIN_CODE, TRAIN_TYPE, TRAIN_SER, DEP_TIME, DEP, ARR, NANGANG, TAIPEI, BANQIAO, TAOYUAN, HSINCHU, MIAOLI, TAICHUNG, CHANGHUA, YUNLIN, CHIAYI, TAINAN, ZUOYING) 
        VALUES ($train_id, $train_type, $train_ser, $time, $dep, $arr, $南港, $台北, $板橋, $桃園, $新竹, $苗栗, $台中, $彰化, $雲林, $嘉義, $台南, $左營)")); 
        // echo "$train_id, $train_type, $train_ser, $time, $dep, $arr, $南港, $台北, $板橋, $桃園, $新竹, $苗栗, $台中, $彰化, $雲林, $嘉義, $台南, $左營";


        if($dep<$arr)//南下
        {
        mysqli_fetch_row(mysqli_query($conn,"INSERT INTO ticket_down SELECT  TRAIN_CODE, TRAIN_TYPE, TRAIN_SER, DEP_TIME, DEP, ARR, 
        NANGANG, TAIPEI, BANQIAO, TAOYUAN, HSINCHU, MIAOLI, TAICHUNG, CHANGHUA, YUNLIN, CHIAYI, TAINAN, ZUOYING,
        SEAT_CODE, TRAIN_CAR, SEAT_ID, SEAT_TYPE, SECT_ID, SECT_ROUTE, LOC_DEP, LOC_ARR, SECT_PRICE, AVALIABLE  
        FROM TRAIN JOIN SEAT JOIN SECTION JOIN AVA_DEFAULT WHERE section.LOC_DEP < section.LOC_ARR  AND TRAIN_CODE = $train_id;")); 
        }
        if($dep>$arr)//北上
        {
        mysqli_fetch_row(mysqli_query($conn,"INSERT INTO ticket_up SELECT  TRAIN_CODE, TRAIN_TYPE, TRAIN_SER, DEP_TIME, DEP, ARR, 
        NANGANG, TAIPEI, BANQIAO, TAOYUAN, HSINCHU, MIAOLI, TAICHUNG, CHANGHUA, YUNLIN, CHIAYI, TAINAN, ZUOYING,
        SEAT_CODE, TRAIN_CAR, SEAT_ID, SEAT_TYPE, SECT_ID, SECT_ROUTE, LOC_DEP, LOC_ARR, SECT_PRICE, AVALIABLE  
        FROM TRAIN JOIN SEAT JOIN SECTION JOIN AVA_DEFAULT WHERE section.LOC_DEP > section.LOC_ARR  AND TRAIN_CODE = $train_id;")); 
        }


        // $train_status = mysqli_fetch_row(mysqli_query($conn,"SELECT CANCELED FROM TRAIN WHERE TRAIN_CODE =$train_id_mod")); 
        // if($train_status[0]==0)
        // {  
        //     mysqli_fetch_row(mysqli_query($conn,"UPDATE TRAIN SET CANCELED = '1' WHERE TRAIN_CODE =$train_id_mod")); 
        //     mysqli_fetch_row(mysqli_query($conn,"UPDATE ORDER_TICKET SET CANCELED = '2' WHERE TRAIN_CODE =$train_id_mod")); 
        //     echo "<br><br><strong> 已將您設定的班次 {$train_id_mod} 調整行車狀態 </strong><br>";
        //     echo '<br><br><font size = "5"><strong> 且已將該班次的 訂單全數取消 </strong></font><br>';

        // }
        // if($train_status[0]==1)
        // {
        //     mysqli_fetch_row(mysqli_query($conn,"UPDATE TRAIN SET CANCELED = 0 WHERE TRAIN_CODE =$train_id_mod")); 
        //     mysqli_fetch_row(mysqli_query($conn,"UPDATE ORDER_TICKET SET CANCELED = '0' WHERE TRAIN_CODE =$train_id_mod AND CANCELED=2")); 
        //     echo "<br><br><strong> 已將您設定的班次 {$train_id_mod} 調整行車狀態 </strong><br>";
        // }

        echo "<br><br><strong> 已將您設定的班次 $train_id 新增至資料庫 </strong><br>";
        echo '<meta http-equiv=REFRESH CONTENT=2;url=admin_tra_add.php>';



        ?>
        </div></center>
	</body>
</html>


        <!-- $train_id=$_POST['train_id_add_seq'];
        $train_type=$_POST['train_type_add_seq'];
        $train_ser=$_POST['train_ser_add_seq'];
        $time= $_POST['train_time_add_seq'];

        $dep = $_POST['dep'];  
        $arr = $_POST['arr']; 


        $sss = $_POST["sss"];
        $num = count($sss);
        $南港 = 0;
        $台北 = 0;
        $板橋 = 0;
        $桃園 = 0;
        $新竹 = 0;
        $苗栗 = 0;
        $台中 = 0;
        $彰化 = 0;
        $雲林 = 0;
        $嘉義 = 0;
        $台南 = 0;
        $左營 = 0;

        for ($i=0; $i<$num; $i=$i+1)
        {
            if ($sss[$i]=='1'){$南港 = 1;}
            if ($sss[$i]=='2'){$台北 = 1;}
            if ($sss[$i]=='3'){$板橋 = 1;}
            if ($sss[$i]=='4'){$桃園 = 1;}
            if ($sss[$i]=='5'){$新竹 = 1;}
            if ($sss[$i]=='6'){$苗栗 = 1;}
            if ($sss[$i]=='7'){$台中 = 1;}
            if ($sss[$i]=='8'){$彰化 = 1;}
            if ($sss[$i]=='9'){$雲林 = 1;}
            if ($sss[$i]=='10'){$嘉義 = 1;}
            if ($sss[$i]=='11'){$台南 = 1;}
            if ($sss[$i]=='12'){$左營 = 1;}
        }
        mysqli_fetch_row(mysqli_query($conn,"INSERT INTO 
        TRAIN (TRAIN_CODE, TRAIN_TYPE, TRAIN_SER, DEP_TIME, DEP, ARR, NANGANG, TAIPEI, BANQIAO, TAOYUAN, HSINCHU, MIAOLI, TAICHUNG, CHANGHUA, YUNLIN, CHIAYI, TAINAN, ZUOYING) 
        VALUES ($train_id, $train_type, $train_ser, $time, $dep, $arr, $南港, $台北, $板橋, $桃園, $新竹, $苗栗, $台中, $彰化, $雲林, $嘉義, $台南, $左營)")); 
        echo "$train_id, $train_type, $train_ser, $time, $dep, $arr, $南港, $台北, $板橋, $桃園, $新竹, $苗栗, $台中, $彰化, $雲林, $嘉義, $台南, $左營"; -->

