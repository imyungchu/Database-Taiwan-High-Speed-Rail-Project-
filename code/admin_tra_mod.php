<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
        <title>修改車次</title>
        <link rel="stylesheet" href="tra_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵管理系統</center></h2><br/>
        <center><div action="" class="traadd">
        <?php
        include("mysql_connect.inc.php");

        $coupon = '111';
        echo '<strong>所有車班資訊</strong><br><br>';
        // $name = $_SESSION['username'];
        $sql = "SELECT * FROM train";
        $result = mysqli_query($conn,$sql);
        // if($_SESSION['is_student'] == 0.5) $coupon = '大學生優惠價';


        echo '<table>';
        echo '<font size="5"><strong><tr><th>車次代碼</th><th>發車時間</th><th>起站</th><th>迄站</th><th>南港</th><th>台北</th><th>板橋</th><th>桃園</th><th>新竹</th><th>苗栗</th><th>台中</th><th>彰化</th><th>雲林</th><th>嘉義</th><th>台南</th><th>左營</th><th>運行狀態</th><tr></strong></font>';
        while($row = mysqli_fetch_row($result))
        {
            if($row[18]=='1')
            {
                $status = ' 『此班次已被取消』';
            }
            else 
            {
                $status = ' 『正常通行』';
            }

            if($row[2]==1)
            {
                $dir = '南下';
            }
            else $dir = '北上';

            $dep_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $row[4]")); // 起站轉中文 (1) 因為等等查找 某車次有無停某站時 是找中文站名其內容值 0 為沒停  1為有停
            $arr_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $row[5]")); // 到站轉中文 (1)

            echo '<tr>';
            echo "<td>$row[0]{$dir}</td>";
            echo "<td>$row[3]</td>";
            echo "<td>{$dep_ch[0]}</td>";
            echo "<td>$arr_ch[0]</td>";
            echo "<td>$row[6]</td>";
            echo "<td>$row[7]</td>";
            echo "<td>$row[8]</td>";
            echo "<td>$row[9]</td>";
            echo "<td>$row[10]</td>";
            echo "<td>$row[11]</td>";
            echo "<td>$row[12]</td>";
            echo "<td>$row[13]</td>";
            echo "<td>$row[14]</td>";
            echo "<td>$row[15]</td>";
            echo "<td>$row[16]</td>";
            echo "<td>$row[17]</td>";
            echo "<td>{$status}</td>";
            echo '</tr>';
        }
        echo '</table>';
        

        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<form name="form" method="post" action="admin_tra_mod_seq.php">';
        echo '<strong>請輸入要改變的車次代碼：<input type="text" name="train_id_mod" /> ';
        echo '<input type="submit" name="button" value="確定" />&nbsp;&nbsp<br></form>';

        //以上是刪除班次的指令
        //以下是新增班次的指令

        echo '<form name="form" method="post" action="admin.php">';
        echo '<input type="submit" name="button" value="回上頁" />&nbsp;&nbsp<br></form>';

        ?>
        </div></center>
	</body>
</html>

