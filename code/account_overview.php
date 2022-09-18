<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<head>
    <title>查看此系統所有成員資料</title>
    <link rel="stylesheet" href="cancel_style.css"/>
</head> 
	<body>

		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵管理系統</center></h2><br/>

        <center><div action="" class="class">
        <?php
        include("mysql_connect.inc.php");

        echo '<font size = "6"><strong>查看此系統所有成員資料</strong></font><br><br>';
        $sql = "SELECT * FROM account";
        $result = mysqli_query($conn,$sql);
        //echo "<font size = '5'><br> 帳號&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp姓名&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp手機&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspEmail&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp身分&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp是否為學生<br>";
        echo '<table>';
        echo '<font size="5"><strong><tr><th>帳號</th><th>姓名</th><th>手機</th><th>Email</th><th>身分</th><th>是否為學生</th><tr></strong></font>';
        while($row = mysqli_fetch_row($result))
        {
        //echo "<font size = '5'>$row[0]&nbsp&nbsp&nbsp&nbsp&nbsp$row[2] $row[3]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[4]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[5]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[6]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[7]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>" ;
        echo '<tr>';
        echo "<td>$row[0]</td>";
        echo "<td>$row[2]$row[3]</td>";
        echo "<td>$row[4]</td>";
        echo "<td>$row[5]</td>";
        echo "<td>$row[6]</td>";
        echo "<td>$row[7]</td>";
        echo '</tr>';
        }
        echo '</table>';

        echo '<form name="form" method="post" action="admin.php"><br>';
        echo '<input type="submit" name="button" value="回管理員首頁" />&nbsp;&nbsp<br></form>';
        ?>
    </body>