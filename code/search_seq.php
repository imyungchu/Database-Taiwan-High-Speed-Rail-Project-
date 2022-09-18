<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
        <title>查詢車次</title>
        <link rel="stylesheet" href="bookingseq_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>
        <center><div action="" class="class">
        <?php
        include("mysql_connect.inc.php");

        // 接收前一頁提交的車次、時間、啟站與到站編號
        $train_id = $_POST['train_id']; 
        $time = $_POST['time'];
        $dep = $_POST['dep'];  
        $arr = $_POST['arr']; 
        $dep_next_page = $dep;
        $arr_next_page = $arr; 

        // 用$dir紀錄列車方向，因為dep後面會被更動，無法用dep去做判斷
        if($dep>$arr)
        {
            $dir='北上';
        }
        else
        {
            $dir='南下';
        }
        $dep_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_ENG FROM LOCATION where LOC_ID = $dep")); // 起站轉英文 (1)
        $arr_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_ENG FROM LOCATION where LOC_ID = $arr")); // 到站轉英文 (1)

        $ticket_num = array();

        // 確定車次與時間欄位有被正確填入
        if($train_id != null && $time != null)
        {
            echo '請僅選擇其一方式進行搜尋';
            echo '<meta http-equiv=REFRESH CONTENT=2;url=search.php>';
        }
        elseif($train_id == null && $time == null)
        {
            echo '請至少輸入一種方式進行搜尋';
            echo '<meta http-equiv=REFRESH CONTENT=2;url=search.php>';
        }
        else
        {
            if ($time != null)
            {
                if($dep > $arr) // 代表是北上的車次
                {    
                    echo "<font size = '5'><strong>您所選擇的時間符合的車次有<br><br>";
                    $sql = "SELECT TRAIN_CODE FROM TRAIN where DEP_TIME > '$time' and TRAIN_SER = '02' and $dep_ch[0] = 1 and $arr_ch[0] = 1"; // 找出時間符合且為北上車且起站與到站有停的所有車次 (1)
                    $result = mysqli_query($conn,$sql); // 與資料庫連線
                    while($row = mysqli_fetch_row($result)) // 若有找到，則會回傳找到的第一筆，取名叫row，row[0]即為第一筆車次代號
                    {  
                        echo "<font size = '4'><strong>車次代碼：$row[0]&nbsp&nbsp&nbsp&nbsp";
                        $total = mysqli_fetch_row(mysqli_query($conn,"SELECT * FROM TRAIN where DEP_TIME > '$time' and TRAIN_SER = '02' and train_code=$row[0]")); 
                        $train_dep_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[4]")); // 起站轉英文 (1)
                        $train_arr_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[5]")); 
                        echo "<strong>從&nbsp&nbsp$train_dep_chinese[0]&nbsp&nbsp開往&nbsp&nbsp$train_arr_chinese[0]<br>";
                        echo "<strong>沿途停靠：";
                        if ($total[6] == 1){echo '<strong>南港&nbsp->';}
                        if ($total[7] == 1){echo '<strong>台北&nbsp->';}
                        if ($total[8] == 1){echo '<strong>板橋&nbsp->';}
                        if ($total[9] == 1){echo '<strong>桃園&nbsp->';}
                        if ($total[10] == 1){echo '<strong>新竹&nbsp->';}
                        if ($total[11] == 1){echo '<strong>苗栗&nbsp->';}
                        if ($total[12] == 1){echo '<strong>台中&nbsp->';}
                        if ($total[13] == 1){echo '<strong>彰化&nbsp->';}
                        if ($total[14] == 1){echo '<strong>雲林&nbsp->';}
                        if ($total[15] == 1){echo '<strong>嘉義&nbsp->';}
                        if ($total[16] == 1){echo '<strong>台南&nbsp->';}
                        if ($total[17] == 1){echo '<strong>左營&nbsp<br><br>';}
                        echo '<br>';
                    }
            
                }
                elseif ($dep < $arr)
                {   
                    echo "<font size = '5'><strong>您所選擇的時間符合的車次有<br><br>";
                    $sql = "SELECT TRAIN_CODE FROM TRAIN where DEP_TIME > '$time' and TRAIN_SER = '01' and $dep_ch[0] = 1 and $arr_ch[0] = 1"; // (1)
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_row($result))
                    { 
                        echo "<font size = '4'><strong>車次代碼：$row[0]&nbsp&nbsp&nbsp&nbsp";
                        $total = mysqli_fetch_row(mysqli_query($conn,"SELECT * FROM TRAIN where DEP_TIME > '$time' and TRAIN_SER = '01' and train_code=$row[0]")); 
                        $train_dep_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[4]")); // 起站轉英文 (1)
                        $train_arr_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[5]")); 
                        echo "<strong>從&nbsp&nbsp$train_dep_chinese[0]&nbsp&nbsp開往&nbsp&nbsp$train_arr_chinese[0]<br>";
                        echo "<strong>沿途停靠：";
                        if ($total[6] == 1){echo '<strong>南港&nbsp->';}
                        if ($total[7] == 1){echo '<strong>台北&nbsp->';}
                        if ($total[8] == 1){echo '<strong>板橋&nbsp->';}
                        if ($total[9] == 1){echo '<strong>桃園&nbsp->';}
                        if ($total[10] == 1){echo '<strong>新竹&nbsp->';}
                        if ($total[11] == 1){echo '<strong>苗栗&nbsp->';}
                        if ($total[12] == 1){echo '<strong>台中&nbsp->';}
                        if ($total[13] == 1){echo '<strong>彰化&nbsp->';}
                        if ($total[14] == 1){echo '<strong>雲林&nbsp->';}
                        if ($total[15] == 1){echo '<strong>嘉義&nbsp->';}
                        if ($total[16] == 1){echo '<strong>台南&nbsp->';}
                        if ($total[17] == 1){echo '<strong>左營&nbsp<br><br>';}
                        echo '<br>';
                    }
            
                }  
            }
            elseif ($train_id != null)//如果車次欄位不為空值
            {
                if($dep > $arr)//北上
                {
                    $judge =mysqli_fetch_row(mysqli_query($conn, "SELECT count(*) FROM TRAIN where  TRAIN_SER=02 and $dep_ch[0]=1 and $arr_ch[0]=1 and train_code='$train_id"));
                    if($judge[0]==1)
                    {
                        $train_exist = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TRAIN where TRAIN_CODE='$train_id'and $dep_ch[0] = 1 and $arr_ch[0] = 1 and CANCELED =0"));//撈出你選的班次
                        if ($train_exist[0]==1)
                        {
                            $total = mysqli_fetch_row(mysqli_query($conn,"SELECT * FROM TRAIN where TRAIN_CODE = $train_id")); 
                            echo "<font size = '4'><strong>車次代碼：$train_id&nbsp&nbsp&nbsp&nbsp";
                            $total = mysqli_fetch_row(mysqli_query($conn,"SELECT * FROM TRAIN where train_code= '$train_id'")); 
                            $train_dep_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[4]")); // 起站轉英文 (1)
                            $train_arr_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[5]"));  
                            echo "<strong>從&nbsp&nbsp$train_dep_chinese[0]&nbsp&nbsp開往&nbsp&nbsp$train_arr_chinese[0]<br>";
                            echo "<strong>沿途停靠：";
                            if ($total[6] == 1)
                            {
                                echo '南港&nbsp->';
                            }
                            if ($total[7] == 1)
                            {
                                echo '台北&nbsp->';
                            }
                            if ($total[8] == 1)
                            {
                                echo '板橋&nbsp->';
                            }
                            if ($total[9] == 1)
                            {
                                echo '桃園&nbsp->';
                            }
                            if ($total[10] == 1)
                            {
                                echo '新竹&nbsp->';
                            }
                            if ($total[11] == 1)
                            {
                                echo '苗栗&nbsp->';
                            }
                            if ($total[12] == 1)
                            {
                                echo '台中&nbsp->';
                            }
                            if ($total[13] == 1)
                            {
                                echo '彰化&nbsp->';
                            }
                            if ($total[14] == 1)
                            {
                                echo '雲林&nbsp->';
                            }
                            if ($total[15] == 1)
                            {
                                echo '嘉義&nbsp->';
                            }
                            if ($total[16] == 1)
                            {
                                echo '台南&nbsp->';
                            }
                            if ($total[17] == 1)
                            {
                                echo '左營&nbsp';
                            }
                        }
                        else
                        {
                            echo '無相符的起迄站與車次';
                            echo '<meta http-equiv=REFRESH CONTENT=2;url=search.php>';
                        }
                    }
                    if($judge[0]==0)
                    {
                        echo '您的起迄站與車次方向相反';
                        echo '<meta http-equiv=REFRESH CONTENT=2;url=search.php>';
                    }
                }
                if($dep < $arr)//南下
                {
                    $judge =mysqli_fetch_row(mysqli_query($conn, "SELECT count(*) FROM TRAIN where  TRAIN_SER=01 and $dep_ch[0]=1 and $arr_ch[0]=1 and train_code='$train_id" ));
                    if($judge[0]==1)
                    {
                        $train_exist = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TRAIN where TRAIN_CODE='$train_id'and $dep_ch[0] = 1 and $arr_ch[0] = 1 and CANCELED =0"));//撈出你選的班次
                        if ($train_exist[0]==1)
                        {
                            $total = mysqli_fetch_row(mysqli_query($conn,"SELECT * FROM TRAIN where TRAIN_CODE = $train_id"));
                            echo "<font size = '4'><strong>車次代碼：$train_id&nbsp&nbsp&nbsp&nbsp";
                            $total = mysqli_fetch_row(mysqli_query($conn,"SELECT * FROM TRAIN where train_code= '$train_id'")); 
                            $train_dep_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[4]")); // 起站轉英文 (1)
                            $train_arr_chinese = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $total[5]"));  
                            echo "<strong>從&nbsp&nbsp$train_dep_chinese[0]&nbsp&nbsp開往&nbsp&nbsp$train_arr_chinese[0]<br>";
                            echo "<strong>沿途停靠：";
                            if ($total[6] == 1)
                            {
                                echo '南港&nbsp->';
                            }
                            if ($total[7] == 1)
                            {
                                echo '台北&nbsp->';
                            }
                            if ($total[8] == 1)
                            {
                                echo '板橋&nbsp->';
                            }
                            if ($total[9] == 1)
                            {
                                echo '桃園&nbsp->';
                            }
                            if ($total[10] == 1)
                            {
                                echo '新竹&nbsp->';
                            }
                            if ($total[11] == 1)
                            {
                                echo '苗栗&nbsp->';
                            }
                            if ($total[12] == 1)
                            {
                                echo '台中&nbsp->';
                            }
                            if ($total[13] == 1)
                            {
                                echo '彰化&nbsp->';
                            }
                            if ($total[14] == 1)
                            {
                                echo '雲林&nbsp->';
                            }
                            if ($total[15] == 1)
                            {
                                echo '嘉義&nbsp->';
                            }
                            if ($total[16] == 1)
                            {
                                echo '台南&nbsp->';
                            }
                            if ($total[17] == 1)
                            {
                                echo '左營&nbsp';
                            }
                        }
                        else
                        {
                            echo '無相符的起迄站與車次';
                            echo '<meta http-equiv=REFRESH CONTENT=2;url=search.php>';
                        }
                    }
                    if($judge[0]==0)
                    {
                        echo '您的起迄站與車次方向相反';
                        echo '<meta http-equiv=REFRESH CONTENT=2;url=search.php>';
                    }
                }
            }
        }
        echo '<form name="form" method="post" action="search.php"><br>';
        echo '<input type="submit" name="button" value="回搜尋頁" />&nbsp;&nbsp<br></form>';


        ?>
        </div></center>
	</body>
</html>


