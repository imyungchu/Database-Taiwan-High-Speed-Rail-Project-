<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
        <title>查看所有訂單</title>
        <link rel="stylesheet" href="admin_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵管理系統</center></h2><br/>

        <center><div action="" class="search" style="font-size:30px;">
        <?php
        include("mysql_connect.inc.php");


        echo '<font size = "6"><strong> 訂單一覽表 </strong></font><br>';
        echo '<font size = "3"><strong> (訂單狀態為1：顧客已退票或班次取消強制退票； 訂單狀態為0：訂單存在)</strong></font><br><br>';

        $sql = "SELECT * from ORDER_TICKET  ";
        $result = mysqli_query($conn,$sql);
        //echo "<font size = '5'>訂單編號&nbsp&nbsp&nbsp&nbsp購買人&nbsp&nbsp&nbsp&nbsp車次&nbsp&nbsp&nbsp&nbsp座位&nbsp&nbsp&nbsp&nbsp起站&nbsp&nbsp&nbsp&nbsp迄站&nbsp&nbsp&nbsp&nbsp付款方式&nbsp&nbsp&nbsp&nbsp實付金額&nbsp&nbsp&nbsp&nbsp訂單狀況&nbsp&nbsp&nbsp&nbsp<br>";
        echo '<table>';
        echo '<font size="5"><strong><tr><th>訂單編號</th><th>購買人</th><th>車次</th><th>座位</th><th>起站</th><th>迄站</th><th>付款方式</th><th>實付金額</th><th>訂單狀況</th><tr></strong></font>';
        while ($row = mysqli_fetch_row($result)) 
        {
            //echo "<font size = '4'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[0]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[1]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[2]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[3]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[4]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[5]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[6]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[8]元&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[9]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>";
            echo '<tr>';
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>$row[3]</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            echo "<td>$row[6]</td>";
            echo "<td>$row[8]</td>";
            echo "<td>$row[9]</td>";
            echo '</tr>';
        }
        echo '</table>';
                    // while($row = mysqli_fetch_row($result))
                    // {
                    //     echo "座位為{$row[0]}!<br>";

                    // }

        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<form name="form" method="post" action="admin_query_seq.php">';
        echo '<br><br><strong>請輸入購買人姓名：<input type="text" name="username" /><strong><br>';
        echo '<strong>請輸入車次代碼：<input type="text" name="train_id" /><strong>';
        // echo '請輸入座位代瑪：<input type="text" name="seat_code" /> <br><br><br>';
        echo '<input type="submit" name="button" value="確定" />&nbsp;&nbsp<br></form>';


        // echo '<br><br><font size = "5"><strong> 請僅使用一種方式進行搜尋(車次或時間)</strong></font><br>';
        // echo '車次代瑪搜尋&nbsp;&nbsp;<input type="text" name="train_id" />&nbsp;&nbsp; <!--把輸入的車號取名叫train_id傳出 -->';
        // echo '時間搜尋&nbsp;&nbsp;<input type="text" name="time" /> <!--把輸入的時間取名叫time傳出 -->';
        // echo '<br><input type="submit" name="button" value="搜尋" />&nbsp;&nbsp;';
        // echo '</form>';

        echo '<form name="form" method="post" action="admin.php">';
        echo '<input type="submit" name="button" value="回管理員首頁" />&nbsp;&nbsp<br></form>';

        ?>
		</div></center>
	</body>
</html>