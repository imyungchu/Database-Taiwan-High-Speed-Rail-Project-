<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
        <title>訂票</title>
        <link rel="stylesheet" href="bookingseq_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>

        <center><div action="" class="class" style="font-size:30px;">
        <?php
        include("mysql_connect.inc.php");


        $train_id = $_POST['train_id'];
        $type= $_POST['type']; 
        $num = $_POST['seat_num'];
        $dep = $_POST['dep'];
        $arr = $_POST['arr'];
        $time = $_POST['time'];
        $ticket_num = $_POST['id_array'];
        $dir = $_POST['dir'];
        $payment = $_POST['payment'];
        $id_fail = 0;
        $dep_sec = $dep;  //SEC只是用來區分前一頁的$dep_i
        $arr_sec = $arr;
        $buy = 0;  //先宣告購買數尚且為0 等等會滿足它
        $pert = 1;  //percentage 百分比 等等用在 不同艙等的費用倍率，艙等不同倍率也不同  (商務艙1.5倍，標準艙原價，自由座0.8倍)
        $dep_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $dep")); // 起站轉中文 (1) 因為等等查找 某車次有無停某站時 是找中文站名其內容值 0 為沒停  1為有停
        $arr_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $arr")); // 到站轉中文 (1)


        $num_ava = 0; // 各種艙等預設可買的票數
        if ($type == 'B') { $num_ava = 10; $pert = 1.5;}   // 如果我到時候選商務艙 就是原本 SECTION_PRICE 各小路徑價格(固定) * 1.5倍
        if ($type == 'SR') $num_ava = 80;
        if ($type == 'SN') { $num_ava = 30; $pert = 0.8;} // 如果我到時候選自由座 就是原本 SECTION_PRICE 各小路徑價格(固定) * 0.8倍  變便宜

        if ($dir == '南下')
        {
            while($dep != $arr) // 如果南下車，找TICKET_DOWN 資料表中 車次符合、發車時間符合、艙等符合、且有停靠起站與停站的座位數
            {
                $id_type_min = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $train_id and DEP_TIME > '$time' and LOC_DEP = $dep and LOC_ARR = $dep+1 and avaliable = 0 and seat_type = '$type'"));
                if($id_type_min[0] < $num_ava) $num_ava = $id_type_min[0]; // 假設輸入商務艙，預設為10，若有5-6站只有9張，就取代預測值，最後9張會成為最多可買的數量，與booking_seq邏輯一樣
                $dep = $dep + 1;
                if($id_type_min[0] == null) $id_fail = 1; // 假如沒有搜尋到，代表車次輸入有誤
            }
        }
        elseif($dir == '北上')
        {
            while($dep != $arr)
            {
                $id_type_min = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $train_id and DEP_TIME > '$time' and LOC_DEP = $dep and LOC_ARR = $dep-1 and avaliable = 0 and seat_type = '$type'"));
                if($id_type_min[0] < $num_ava) $num_ava = $id_type_min[0];
                $dep = $dep - 1;
                if($id_type_min[0] == null) $id_fail = 1;
            }
        }

        $level = array('B','SR','SN');
        if (!in_array($type, $level)) // 先檢查艙等對不對
        {
            echo '艙等代號輸入錯誤';
            echo "<input type='hidden' name='time' value={$time}>";
            echo '<meta http-equiv=REFRESH CONTENT=1;url=booking_seq.php>';
        }
        elseif ($num > $num_ava) // 在檢查可賣票的數量有沒有超過
        {
            echo '超出可購買範圍';
            echo '<meta http-equiv=REFRESH CONTENT=1;url=booking_seq.php>';
        }
        elseif ($id_fail == 1) // 如果上面都可以但$id_fai=1，代表車次輸入有誤
        {
            echo '車次輸入錯誤';
            echo '<meta http-equiv=REFRESH CONTENT=1;url=booking_seq.php>';
        }
        elseif($dir == '南下')
        {
            $sql = "SELECT SEAT_CODE FROM TICKET_DOWN where TRAIN_CODE = $train_id and SEAT_TYPE = '$type' and LOC_DEP = $dep_sec and LOC_ARR = $dep_sec + 1"; //從南下車次表 TICKET_DOWN 拉出符合的SEAT_CODE 搭配該座為所有小路徑段SECTION
            $result = mysqli_query($conn,$sql); 
            echo "訂票成功！<br>";
            echo '<table>';
            echo '<div action="" class="table">';
            echo '<font size="5"><strong><tr><th>訂單編號</th><th>車次</th><th>艙等代號</th><th>起站</th><th>迄站</th><th>票價</th><th>座位</th><tr></strong></font>';
            while($row = mysqli_fetch_row($result))
            {
                $seat = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where SEAT_TYPE = '$type' and TRAIN_CODE = $train_id and SEAT_CODE = '$row[0]' and LOC_DEP < $arr_sec and LOC_ARR > $dep_sec and AVALIABLE = 1"));//COUNT出已選車次的已購買量
                if($seat[0] == 0) //如果已選車次、已選座位 無人購買
                {
                    $dep_use = $dep_sec;
                    $arr_use = $arr_sec;
                    while($dep_use != $arr_use) //就依序UPDATE 數據0 變成1  也就是說 我讓你買下該車次該座位 的所有小路徑段(依靠迴圈方式)
                    {
                        mysqli_query($conn,"UPDATE TICKET_DOWN SET avaliable = '1' WHERE TRAIN_CODE = $train_id and SEAT_TYPE = '$type' and SEAT_CODE = '$row[0]' and LOC_DEP = $dep_use and LOC_ARR = $dep_use+1");
                        $dep_use = $dep_use + 1;
                    }
                    $buy = $buy + 1; //處理完你完你第一張訂單後，依序處理第二張訂單，直到買夠你要的數量

                    $name = $_SESSION['username']; //將使用者名稱抓出來
                    $cost = mysqli_fetch_row(mysqli_query($conn,"SELECT SUM(SECT_PRICE) FROM TICKET_DOWN where SEAT_TYPE = '$type' and TRAIN_CODE = $train_id and SEAT_CODE = '$row[0]' and LOC_DEP < $arr_sec and LOC_ARR > $dep_sec and AVALIABLE = 1")); //SUM出你所有買的路徑總和價格
                    $total_pay = $cost[0] * $pert; //並依據你選的艙等給予倍率，之後存入票價欄位，注意此時的票價還沒選身分
                    $discount_pay = $total_pay * $_SESSION['is_student'];//給你學生折扣*0.5  如果你不是學生則*1
                    mysqli_query($conn,"INSERT INTO ORDER_TICKET ( USER_ID, TRAIN_CODE, SEAT_CODE, LOC_DEP, LOC_ARR, ORDER_PAYMENT, SUM_TICKET_PRICE, ORDER_PRICE) VALUES ('$name', '$train_id', '$row[0]', '$dep_ch[0]', '$arr_ch[0]', '$payment' , $total_pay, $discount_pay)");//把資料存入order_ticket
                    
                    $MAX_ORDER_ID = "SELECT MAX(ORDER_ID) FROM order_ticket";
                    $result_ordered = mysqli_query($conn,$MAX_ORDER_ID);
                    $row_ordered = mysqli_fetch_row($result_ordered);           
                    echo '<tr>';
                    echo "<td>{$row_ordered[0]}</td>";
                    echo "<td>{$train_id}{$dir}</td>";
                    echo "<td>{$type}</td>";
                    echo "<td>{$dep_ch[0]}</td>";
                    echo "<td>{$arr_ch[0]}</td>";
                    echo "<td>{$total_pay}</td>";
                    echo "<td>{$row[0]}</td>";
                    echo '</tr>';
                }
                
                if ($buy == $num)//如果我買量足夠了，就break
                {
                    break;
                }
            }
            echo '</table>';

            echo '<form name="form" method="post" action="member.php">';
            echo '<input type="submit" name="button" value="回會員首頁" />&nbsp;&nbsp<br></form>';
            // echo '<meta http-equiv=REFRESH CONTENT=2;url=booking_seq.php>';
        }
        elseif($dir == '北上')
        {
            $sql = "SELECT SEAT_CODE FROM TICKET_UP where TRAIN_CODE = $train_id and SEAT_TYPE = '$type' and LOC_DEP = $dep_sec and LOC_ARR = $dep_sec - 1"; 
            $result = mysqli_query($conn,$sql); 
            echo "訂票成功！<br>";
            echo '<table>';
            echo '<font size="5"><strong><tr><th>訂單編號</th><th>車次</th><th>艙等代號</th><th>起站</th><th>迄站</th><th>票價</th><th>座位</th><tr></strong></font>';
            while($row = mysqli_fetch_row($result))
            {
                $seat = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where SEAT_TYPE = '$type' and TRAIN_CODE = $train_id and SEAT_CODE = '$row[0]' and LOC_DEP > $arr_sec and LOC_ARR < $dep_sec and AVALIABLE = 1"));
                if($seat[0] == 0)
                {
                    $dep_use = $dep_sec;
                    $arr_use = $arr_sec;
                    while($dep_use != $arr_use)
                    {
                        mysqli_query($conn,"UPDATE TICKET_UP SET avaliable = '1' WHERE TRAIN_CODE = $train_id and SEAT_TYPE = '$type' and SEAT_CODE = '$row[0]' and LOC_DEP = $dep_use and LOC_ARR = $dep_use-1");
                        $dep_use = $dep_use - 1;
                    }
                    $buy = $buy + 1;

                    $name = $_SESSION['username'];
                    $cost = mysqli_fetch_row(mysqli_query($conn,"SELECT SUM(SECT_PRICE) FROM TICKET_UP where SEAT_TYPE = '$type' and TRAIN_CODE = $train_id and SEAT_CODE = '$row[0]' and LOC_DEP > $arr_sec and LOC_ARR < $dep_sec and AVALIABLE = 1"));
                    $total_pay = $cost[0] * $pert;
                    $discount_pay = $total_pay * $_SESSION['is_student']; 
                    mysqli_query($conn,"INSERT INTO ORDER_TICKET ( USER_ID, TRAIN_CODE, SEAT_CODE, LOC_DEP, LOC_ARR, ORDER_PAYMENT, SUM_TICKET_PRICE, ORDER_PRICE) VALUES ('$name', '$train_id', '$row[0]', '$dep_ch[0]', '$arr_ch[0]', '$payment' , $total_pay, $discount_pay)");
                    
                    $MAX_ORDER_ID = "SELECT MAX(ORDER_ID) FROM order_ticket";
                    $result_ordered = mysqli_query($conn,$MAX_ORDER_ID);
                    $row_ordered = mysqli_fetch_row($result_ordered);           
                    echo '<tr>';
                    echo "<td>{$row_ordered[0]}</td>";
                    echo "<td>{$train_id}{$dir}</td>";
                    echo "<td>{$type}</td>";
                    echo "<td>{$dep_ch[0]}</td>";
                    echo "<td>{$arr_ch[0]}</td>";
                    echo "<td>{$total_pay}</td>";
                    echo "<td>{$row[0]}</td>";
                    echo '</tr>';
                }
                
                if ($buy == $num)
                {
                    break;
                }
            }
            echo '</table>';
            echo '<form name="form" method="post" action="member.php">';
            echo '<input type="submit" name="button" value="回會員首頁" />&nbsp;&nbsp<br></form>';
            // echo '<meta http-equiv=REFRESH CONTENT=2;url=booking_seq.php>';
        }



        ?>
		</div></center>
	</body>
</html>