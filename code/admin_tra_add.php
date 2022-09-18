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



        echo "<font size = '5'><strong>所有車班資訊</strong></font><br><br>";
        $sql = "SELECT * FROM train";
        $result = mysqli_query($conn,$sql);


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

            $dep_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $row[4]")); // 起站轉中文 
            $arr_ch = mysqli_fetch_row(mysqli_query($conn,"SELECT LOC_NAME FROM LOCATION where LOC_ID = $row[5]")); // 

            //echo "車次代碼 $row[0] {$dir} 發車時間$row[3] 起站 {$dep_ch[0]} 迄站 $arr_ch[0]  &nbsp&nbsp&nbsp&nbsp&nbsp南港 $row[6] 台北$row[7] 板橋$row[8] 桃園$row[9] 新竹$row[10] 苗栗$row[11]台中$row[12]  彰化$row[13] 雲林$row[14] 嘉義$row[15] 台南$row[16] 左營$row[17] 運行狀態{$status}<br><br>";
            
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
        echo '<form name="form" method="post" action="admin_tra_add_seq.php">';
        echo '<br><br><br><strong>請輸入要新增的車次代碼：<input type="text" name="train_id_add_seq" /></strong><br> ';
        echo '<strong>TRAIN_TYPE：<input type="text" name="train_type_add_seq" /> ';
        echo '<br><strong>TRAIN_SER：<input type="text" name="train_ser_add_seq" /> <br>';
        echo '<strong>發車時間：</strong>';
        echo '<strong><input type="text" name="hr" />時</strong>';
        echo '<strong><input type="text" name="min" />分</strong>';
        echo '<strong><input type="text" name="sec" />秒</strong>';


        echo '<br><strong>
        起站為(單選)：
        <select name="dep">
            <option value=""selected>請選擇起站</option>
            <option value="1">南港</option>
            <option value="2">台北</option>
            <option value="3">板橋</option>
            <option value="4">桃園</option>
            <option value="5">新竹</option>
            <option value="6">苗栗</option>
            <option value="7">台中</option>
            <option value="8">彰化</option>
            <option value="9">雲林</option>
            <option value="10">嘉義</option>
            <option value="11">台南</option>
            <option value="12">左營</option>
        </select>';

        echo '<br><strong>
        迄站為(單選)：
        <select name="arr">
            <option value=""selected>請選擇迄站</option>
            <option value="1">南港</option>
            <option value="2">台北</option>
            <option value="3">板橋</option>
            <option value="4">桃園</option>
            <option value="5">新竹</option>
            <option value="6">苗栗</option>
            <option value="7">台中</option>
            <option value="8">彰化</option>
            <option value="9">雲林</option>
            <option value="10">嘉義</option>
            <option value="11">台南</option>
            <option value="12">左營</option>
        </select></strong>';  

        echo '<br><strong>沿途經過(複選)：
        <input type="checkbox" name="sss[]" value ="1" >
        <label for="NANGANG">南港</label>
        <input type="checkbox" name="sss[]" value ="2" >
        <label for="TAIPEI">台北</label>
        <input type="checkbox" name="sss[]"  value ="3" >
        <label for="BANQIAO">板橋</label>
        <input type="checkbox" name="sss[]" value="4" >
        <label for="TAOYUAN">桃園</label>
        <input type="checkbox" name="sss[]" value="5" >
        <label for="HSINCHU">新竹</label>
        <input type="checkbox" name="sss[]" value="6" >
        <label for="MIAOLI">苗栗</label>
        <input type="checkbox" name="sss[]" value="7" >
        <label for="TAICHUNG">台中</label>
        <input type="checkbox" name="sss[]" value="8" >
        <label for="CHANGHUA">彰化</label>
        <input type="checkbox" name="sss[]" value="9" >
        <label for="YUNLIN">雲林</label>
        <input type="checkbox" name="sss[]" value="10" >
        <label for="CHIAYI">嘉義</label>
        <input type="checkbox" name="sss[]" value="11" >
        <label for="TAINAN">台南</label>
        <input type="checkbox" name="sss[]" value="12" >
        <label for="ZUOYING">左營</label></strong>';
        echo '<br>';
        echo '<input type="submit" name="button" value="確定" />&nbsp;&nbsp<br></form>';







        echo '<form name="form" method="post" action="admin.php">';
        echo '<input type="submit" name="button" value="回上頁" />&nbsp;&nbsp<br></form>';

        ?>

        </div></center>
	</body>
</html>



