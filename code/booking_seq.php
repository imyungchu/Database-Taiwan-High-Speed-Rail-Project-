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
        $_SESSION['dep'] = $dep;
        $_SESSION['arr'] = $arr;

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
            echo '<meta http-equiv=REFRESH CONTENT=2;url=booking.php>';
        }
        elseif($train_id == null && $time == null)
        {
            echo '請至少輸入一種方式進行搜尋';
            echo '<meta http-equiv=REFRESH CONTENT=2;url=booking.php>';
        }
        else
        {
            if ($time != null)//如果時間欄位不為空值
            {
                if($dep > $arr) // 代表是北上的車次
                {
                    $sql = "SELECT TRAIN_CODE FROM TRAIN where DEP_TIME > '$time' and TRAIN_SER = '02' and $dep_ch[0] = 1 and $arr_ch[0] = 1"; // 找出時間符合且為北上車且起站與到站有停的所有車次 (1)，TRAIN資料表站名都是英文
                    $result = mysqli_query($conn,$sql); // 與資料庫連線
                    while($row = mysqli_fetch_row($result)) // 若有找到，則會回傳找到的第一筆，取名叫row，row[0]即為第一筆車次代號
                    {  
                        $low_b = 10; // 先宣告每車次商務艙座位數 (商務座位 Business 僅 06 號車廂)
                        $low_sr = 80; // 一般座位數 (標準對號 Standard Reserved ，有 01,02,03,04,05,07,08,09 共八節車廂)
                        $low_sn = 30; // 自由座位數 (標準自由 Standard Non-Rserved ，有 10,11,12 共三節車廂)
                        $dep_i = $dep;  //設置initial最初選擇的起站depart 準備做迴圈
                        $arr_i = $arr;  //arrival_initial

                        while($dep_i != $arr_i) // 若起站不等於到站，則一直判斷下去，假如一開始輸入起站為10，到站為5，就先判斷10-9區間的票數，之後判斷9-8，以此類推，如果票夠，最後dep就會等於5，此時dep == arr，跳出迴圈
                        {   //下方在迴圈每一個"鄰近"站點(也就是section)的可用票數。而avaliable為0代表還沒有人買，因此count 所有為avaliable 為 0 的row 
                            $total = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0")); //找"全部票"夠不夠 
                            $bu = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0 and SEAT_TYPE = 'B'")); //找商務艙票數
                            $sr = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0 and SEAT_TYPE = 'SR'")); //找一般艙票數
                            $sn = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0 and SEAT_TYPE = 'SN'")); //找自由艙票數

                            if($bu[0] < $low_b) // 紀錄最低的可售票，當作顯示給訂票者看的資訊
                            {
                                $low_b = $bu[0];
                            }

                            if($sr[0] < $low_sr)
                            {
                                $low_sr = $sr[0];
                            }

                            if($sn[0] < $low_sn)
                            {
                                $low_sn = $sn[0];
                            }

                            if ($total[0] == 0) // 如果所有票都賣光了，就跳出這個迴圈，此時$dep就不會等於$arr
                            {
                                break;
                            }
                            $dep_i = $dep_i - 1; //此為，假如起站為10的找完了 ，就開始找起站為9 ，再來起站為8 的迴圈條件
                        }   

                        array_push($ticket_num, $low_b, $low_sr, $low_sn); // 把各車次中最小可售各艙等的票紀錄起來


                        if ($dep_i == $arr_i)//如果我找完了
                        {
                            echo "<font size = '6'><strong>車次&nbsp{$row[0]}&nbsp</srtong></font>&nbsp<br>"; //顯示 $row[0]= 車次代瑪 +"可訂票"文字
                            $dep_time = mysqli_fetch_row(mysqli_query($conn,"SELECT DEP_TIME FROM TRAIN where TRAIN_CODE = $row[0]")); // 將各車次的啟程時間抓出來給訂票者看
                            echo "<font size = '5'>發車時間&nbsp&nbsp&nbsp&nbsp商務艙剩餘座位數&nbsp&nbsp&nbsp&nbsp一般艙剩餘座位數&nbsp&nbsp&nbsp&nbsp自由座艙剩餘座位數</font><br>";
                            echo "<font size = '6'>{$dep_time[0]}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_b}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sr}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sn}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</font><br><br><br>";                 
                        }
                        else{
                            echo "<font size = '4'><strong>車次&nbsp{$row[0]}&nbsp已售完</srtong></font>&nbsp<br>";
                        }
                    }
            
                }
                elseif ($dep < $arr) // 南下 情形
                {
                    $sql = "SELECT TRAIN_CODE FROM TRAIN where DEP_TIME > '$time' and TRAIN_SER = '01' and $dep_ch[0] = 1 and $arr_ch[0] = 1"; // (1)
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_row($result))
                    { 
                        $low_b = 10;
                        $low_sr = 80;
                        $low_sn = 30;
                        $dep_i = $dep;
                        $arr_i = $arr;

                        while($dep_i != $arr_i) 
                        {   
                            $total = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0")); 
                            $bu = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0 and SEAT_TYPE = 'B'")); 
                            $sr = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0 and SEAT_TYPE = 'SR'")); 
                            $sn = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0 and SEAT_TYPE = 'SN'")); 

                            if($bu[0] < $low_b) 
                            {
                                $low_b = $bu[0];
                            }

                            if($sr[0] < $low_sr)
                            {
                                $low_sr = $sr[0];
                            }

                            if($sn[0] < $low_sn)
                            {
                                $low_sn = $sn[0];
                            }

                            if ($total[0] == 0) 
                            {
                                break;
                            }
                            $dep_i = $dep_i + 1;
                        }

                        array_push($ticket_num, $low_b, $low_sr, $low_sn); // 把各車次中最小可售各艙等的票紀錄起來

                        

                        if ($dep_i == $arr_i)
                        {
                            echo "<font size = '6'><strong>車次&nbsp{$row[0]}&nbsp</srtong></font>&nbsp<br>";
                            $dep_time = mysqli_fetch_row(mysqli_query($conn,"SELECT DEP_TIME FROM TRAIN where TRAIN_CODE = $row[0]")); 
                            echo "<font size = '5'>&nbsp&nbsp發車時間&nbsp&nbsp&nbsp&nbsp商務艙剩餘座位數&nbsp&nbsp&nbsp&nbsp一般艙剩餘座位數&nbsp&nbsp&nbsp&nbsp自由座艙剩餘座位數</font><br>";
                            echo "<font size = '6'>{$dep_time[0]}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_b}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sr}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sn}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</font><br><br><br>";                     
                        }
                        else
                        {
                            echo "<font size = '4'><strong>車次&nbsp{$row[0]}&nbsp已售完</srtong></font>&nbsp<br>";
                        }
                    }
            
                }
                else
                {
                    echo '您選的是同樣的起站與到站!!';
                    echo '<meta http-equiv=REFRESH CONTENT=2;url=booking.php>';
                }
            }
            elseif ($train_id != null)//如果車次欄位不為空值
            {  
                $train_exist = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TRAIN where TRAIN_CODE='$train_id'and $dep_ch[0] = 1 and $arr_ch[0] = 1"));//撈出你選的班次

                if ($train_exist[0]==1)
                
                {
                    if($dep > $arr) // 代表是北上的車次
                    {
                        $judge =mysqli_fetch_row(mysqli_query($conn, "SELECT count(*) FROM TRAIN where  TRAIN_SER=02 and $dep_ch[0]=1 and $arr_ch[0]=1 and train_code='$train_id"));
                        if($judge[0]==1)
                        {
                            $sql = "SELECT TRAIN_CODE FROM TRAIN where TRAIN_CODE='$train_id'"; // 找出時間符合且為北上車且起站與到站有停的所有車次 (1)，TRAIN資料表站名都是英文
                            $result = mysqli_query($conn,$sql); // 與資料庫連線
                            while($row = mysqli_fetch_row($result)) // 若有找到，則會回傳找到的第一筆，取名叫row，row[0]即為第一筆車次代號
                            {  
                                $low_b = 10; // 先宣告每車次商務艙座位數 (商務座位 Business 僅 06 號車廂)
                                $low_sr = 80; // 一般座位數 (標準對號 Standard Reserved ，有 01,02,03,04,05,07,08,09 共八節車廂)
                                $low_sn = 30; // 自由座位數 (標準自由 Standard Non-Rserved ，有 10,11,12 共三節車廂)
                                $dep_i = $dep;  //設置initial最初選擇的起站depart 準備做迴圈
                                $arr_i = $arr;  //arrival_initial

                                while($dep_i != $arr_i) // 若起站不等於到站，則一直判斷下去，假如一開始輸入起站為10，到站為5，就先判斷10-9區間的票數，之後判斷9-8，以此類推，如果票夠，最後dep就會等於5，此時dep == arr，跳出迴圈
                                {   //下方在迴圈每一個"鄰近"站點(也就是section)的可用票數。而avaliable為0代表還沒有人買，因此count 所有為avaliable 為 0 的row 
                                    $total = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0")); //找"全部票"夠不夠 
                                    $bu = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0 and SEAT_TYPE = 'B'")); //找商務艙票數
                                    $sr = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0 and SEAT_TYPE = 'SR'")); //找一般艙票數
                                    $sn = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_UP where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i-1 and avaliable = 0 and SEAT_TYPE = 'SN'")); //找自由艙票數

                                    if($bu[0] < $low_b)  {$low_b = $bu[0];}
                                    if($sr[0] < $low_sr)  {$low_sr = $sr[0];}
                                    if($sn[0] < $low_sn)  {$low_sn = $sn[0];}
                                    if ($total[0] == 0)   {break;}
                                    $dep_i = $dep_i - 1; //此為，假如起站為10的找完了 ，就開始找起站為9 ，再來起站為8 的迴圈條件
                                }   
                                array_push($ticket_num, $low_b, $low_sr, $low_sn); // 把各車次中最小可售各艙等的票紀錄起來
                                
                                if ($dep_i == $arr_i)//如果我找完了
                                {
                                    echo "<font size = '6'><strong>車次&nbsp{$row[0]}&nbsp</srtong></font>&nbsp<br>"; //顯示 $row[0]= 車次代瑪 +"可訂票"文字
                                    $dep_time = mysqli_fetch_row(mysqli_query($conn,"SELECT DEP_TIME FROM TRAIN where TRAIN_CODE = $row[0]")); // 將各車次的啟程時間抓出來給訂票者看
                                    echo "<font size = '5'>&nbsp&nbsp發車時間&nbsp&nbsp&nbsp&nbsp商務艙剩餘座位數&nbsp&nbsp&nbsp&nbsp一般艙剩餘座位數&nbsp&nbsp&nbsp&nbsp自由座艙剩餘座位數</font><br>";
                                    echo "<font size = '6'>{$dep_time[0]}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_b}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sr}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sn}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</font><br><br><br>";                   
                                }
                                else{
                                    echo "<font size = '4'><strong>車次&nbsp{$row[0]}&nbsp已售完</srtong></font>&nbsp<br>";
                                }
                            }
                        }
                        if($judge[0]==0)
                        {
                            echo '您的起迄站 與 車次方向相反';
                            echo '<meta http-equiv=REFRESH CONTENT=2;url=booking.php>';
                        }
                
                    }
                    elseif ($dep < $arr) // 南下 情形
                    {    
                        $judge =mysqli_fetch_row(mysqli_query($conn, "SELECT count(*) FROM TRAIN where  TRAIN_SER=02 and $dep_ch[0]=1 and $arr_ch[0]=1 and train_code='$train_id"));
                        if($judge[0]==1)
                        {
                            $sql = "SELECT TRAIN_CODE FROM TRAIN where TRAIN_CODE='$train_id'"; // (1)
                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_row($result))
                            { 
                                $low_b = 10;
                                $low_sr = 80;
                                $low_sn = 30;
                                $dep_i = $dep;
                                $arr_i = $arr;

                                while($dep_i != $arr_i) 
                                {   
                                    $total = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0")); 
                                    $bu = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0 and SEAT_TYPE = 'B'")); 
                                    $sr = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0 and SEAT_TYPE = 'SR'")); 
                                    $sn = mysqli_fetch_row(mysqli_query($conn,"SELECT count(*) FROM TICKET_DOWN where TRAIN_CODE = $row[0] and LOC_DEP = $dep_i and LOC_ARR = $dep_i+1 and avaliable = 0 and SEAT_TYPE = 'SN'")); 

                                    if($bu[0] < $low_b)  {$low_b = $bu[0];}
                                    if($sr[0] < $low_sr)  {$low_sr = $sr[0];}
                                    if($sn[0] < $low_sn)  {$low_sn = $sn[0];}
                                    if ($total[0] == 0)   {break;}
                                    $dep_i = $dep_i + 1;
                                }
                                array_push($ticket_num, $low_b, $low_sr, $low_sn); // 把各車次中最小可售各艙等的票紀錄起來
                                
                                if ($dep_i == $arr_i)
                                {
                                    echo "<font size = '6'><strong>車次&nbsp{$row[0]}&nbsp</srtong></font>&nbsp<br>";
                                    $dep_time = mysqli_fetch_row(mysqli_query($conn,"SELECT DEP_TIME FROM TRAIN where TRAIN_CODE = $row[0]")); 
                                    echo "<font size = '5'>&nbsp&nbsp發車時間&nbsp&nbsp&nbsp&nbsp商務艙剩餘座位數&nbsp&nbsp&nbsp&nbsp一般艙剩餘座位數&nbsp&nbsp&nbsp&nbsp自由座艙剩餘座位數</font><br>";
                                    echo "<font size = '6'>{$dep_time[0]}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_b}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sr}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{$low_sn}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</font><br><br><br>";               
                                }
                                else
                                {
                                    echo "<font size = '4'><strong>車次&nbsp{$row[0]}&nbsp已售完</srtong></font>&nbsp<br>";
                                }
                            }
                        }
                        if($judge[0]==0)
                        {
                            echo '您的起迄站與車次方向相反';
                            echo '<meta http-equiv=REFRESH CONTENT=2;url=booking.php>';
                        }
                    }
                    else
                    {
                        echo '您選的是同樣的起站與到站!!';
                        echo '<meta http-equiv=REFRESH CONTENT=2;url=booking.php>';
                    }
                }
                else
                {
                    echo '你選的車次沒有經過上面的站';
                    echo '<meta http-equiv=REFRESH CONTENT=2;url=booking.php>';
                }
            }
        }
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

        echo '<form name="form" method="post" action="booking.php">';
        echo '<input type="submit" name="button" value="回上頁重選" />&nbsp;&nbsp<br></form>';

        echo '<form name="form" method="post" action="booking_seq2.php">';


        echo '<br><br><font size = "4"><strong> 請輸入欲乘坐廂等代號</strong></font><br>
        (B:商務、SR:標準、SN:自由)&nbsp;&nbsp;<input type="text" name="type" /> <br>';
        echo "<input type='hidden' name='dep' value={$dep_next_page}>";
        echo "<input type='hidden' name='arr' value={$arr_next_page}>";
        echo "<input type='hidden' name='time' value={$time}>";
        echo "<input type='hidden' name='id_array' value={$ticket_num}>";
        echo "<input type='hidden' name='dir' value={$dir}>";
        echo '<font size = "4">請輸入欲乘坐車次：<input type="text" name="train_id" /></font> <br>';
        echo '<font size = "4">請輸入座位數量：<input type="text" name="seat_num" /></font> <br>';
        echo '<font size = "4">付款方式：
            <select name="payment" id="payment">
                <option value=""selected>請選擇付款方式</option>
                <option value="credit">信用卡</option>
                <option value="cash">現金</option>
            </select></font> ';
        echo '<form name="form" method="post" action="booking_seq2.php">';
        echo '<input type="submit" name="button" value="確定" />&nbsp;&nbsp<br></form>';




        ?>


