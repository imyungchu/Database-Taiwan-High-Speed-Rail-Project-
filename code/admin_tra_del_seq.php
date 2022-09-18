<?php session_start(); ?>
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


    //本頁面用來判讀刪減班次
    // 接收前一頁提交的車次編號
    $train_id_del=$_POST['train_id_del_seq'];



    // 確定車次與時間欄位有被正確填入
    if($train_id_del != null)
    {
        mysqli_fetch_row(mysqli_query($conn,"DELETE FROM train Where TRAIN_CODE=$train_id_del"));
        mysqli_fetch_row(mysqli_query($conn,"UPDATE order_ticket SET CANCELED=3 Where TRAIN_CODE=$train_id_del"));
        mysqli_fetch_row(mysqli_query($conn,"DELETE FROM ticket_down Where TRAIN_CODE=$train_id_del"));
        mysqli_fetch_row(mysqli_query($conn,"DELETE FROM ticket_up Where TRAIN_CODE=$train_id_del"));
        echo "已經成功將$train_id_del 車次刪除";
        echo '<meta http-equiv=REFRESH CONTENT=2;url=admin_tra_del.php>';
    }
    elseif($train_id_del == null )
    {
        echo '請輸入欲刪除之班次';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=admin_tra_del.php>';
    }
    ?>
        </div></center>
	</body>
</html>

