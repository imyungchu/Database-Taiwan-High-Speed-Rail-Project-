<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
        <title>取消訂票</title>
        <link rel="stylesheet" href="cancel_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>

        <center><div action="" class="class" style="font-size:30px;">
        <?php
        include("mysql_connect.inc.php");

        $coupon = '無大學生優惠';
        echo '<strong>所有訂購資訊</strong><br><br>';
        $name = $_SESSION['username'];
        $sql = "SELECT * FROM order_ticket WHERE USER_ID = '$name'and canceled = 0 ";
        $result = mysqli_query($conn,$sql);
        if($_SESSION['is_student'] == 0.5) $coupon = '大學生優惠價';

        //echo '<div class="table">';
        echo '<table>';
        echo '<div action="" class="table">';
        echo '<tr><th>訂單編號</th><th>車次</th><th>座位</th><th>起站</th><th>迄站</th><th>付款方式</th><th>原價</th><th>有無優惠</th><th>應付價格</th><tr>';
        while($row = mysqli_fetch_row($result))
        {
            if($row[9] == '0')
            echo '<tr>';
            echo "<td>$row[0]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>$row[3]</td>";
            echo "<td>$row[4]</td>";
            echo "<td>$row[5]</td>";
            echo "<td>$row[6]</td>";
            echo "<td>$row[7]</td>";
            echo "<td>$coupon</td>";
            echo "<td>$row[8]</td>";
            echo '</tr>';
        }
        echo '</table>';
        //echo '</div>';

        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '<form name="form" method="post" action="cancel_seq.php">';
        echo '<br><br><strong>請輸入訂單編號：<input type="text" name="id" /></strong>';
        echo '<input type="submit" name="button" value="確定" />&nbsp;&nbsp<br></form>';
        echo '<form name="form" method="post" action="member.php"><br><br>';
        echo '<input type="submit" name="button" value="回會員首頁" />&nbsp;&nbsp<br></form>';

        ?>
		</div></center>
	</body>
</html>

