<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<head>
    <title>財務管理</title>
    <head> 
      <link rel="stylesheet" href="cancel_style.css"/>
    <head>
	<body>

		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵管理系統</center></h2><br/>

        <center><div action="" class="class">
        <?php
        include("mysql_connect.inc.php");



        $r=0;
        $c=0;
        $u=0;
        $d=0;
        $i=0;


        echo '<font size = "5"><strong> 財務狀況表 </strong></font><br>';
        $revenue = "SELECT SUM(order_price) from ORDER_TICKET ";
        $result_r = mysqli_query($conn,$revenue);

        $person_canceled = "SELECT SUM(order_price) from ORDER_TICKET where CANCELED ='1' ";
        $result_person_canceled = mysqli_query($conn,$person_canceled);

        $train_unactive = "SELECT SUM(order_price) from ORDER_TICKET where CANCELED ='2' ";
        $result_train_unactive = mysqli_query($conn,$train_unactive);

        $train_delete = "SELECT SUM(order_price) from ORDER_TICKET where CANCELED ='3' ";
        $result_train_delete= mysqli_query($conn,$train_delete);

        $income = "SELECT SUM(order_price) from ORDER_TICKET where CANCELED ='0' ";
        $result_i = mysqli_query($conn,$income);




        while ($row_r = mysqli_fetch_row($result_r)) 
        {
            if($row_r[0]!=0)
            $r=$row_r[0]; 
        }

        while ($row_person_canceled = mysqli_fetch_row($result_person_canceled)) 
        {
            if($row_person_canceled[0]!=0)
            $c=$row_person_canceled[0];
        }

        while ($row_train_unactive = mysqli_fetch_row($result_train_unactive)) 
        {
            if($row_train_unactive[0]!=0)
            $u=$row_train_unactive[0]; 
        }

        while ($row_train_delete = mysqli_fetch_row($result_train_delete)) 
        {
            if($row_train_delete[0]!=0)
            $d=$row_train_delete元[0]; 
        }

        while ($row_i = mysqli_fetch_row($result_i)) 
        {
            if($row_i[0]!=0)
            $i=$row_i[0]; 
        }

        echo "<br><strong>總歷史收入為  $r 元 "; 
        echo "<br><strong>因客戶退票損失為  $c 元 "; 
        echo "<br><strong>因班次取消損失為  $u 元 "; 
        echo "<br><strong>因班次刪除損失為  $d 元 "; 
        echo "<br><strong>目前總淨利為  $i 元 "; 

        echo '<form name="form" method="post" action="admin.php"><br>';
        echo '<input type="submit" name="button" value="回管理員首頁" />&nbsp;&nbsp<br></form>';

        ?>



        <!-- while ($row_r = mysqli_fetch_row($result_r)) 
        {
            echo "<br>售票 總歷史收入為  $row_r[0] 元 "; 
        }

        while ($row_person_canceled = mysqli_fetch_row($result_person_canceled)) 
        {
            echo "<br>因客戶退票 損失為  $row_person_canceled[0] 元 "; 
        }

        while ($row_train_unactive = mysqli_fetch_row($result_train_unactive)) 
        {
            echo "<br>因班次取消 損失為  $row_train_unactive[0] 元 "; 
        }

        while ($row_train_delete = mysqli_fetch_row($result_train_delete)) 
        {
            echo "<br>因班次刪除 損失為  $row_train_delete[0] 元 "; 
        }

        while ($row_i = mysqli_fetch_row($result_i)) 
        {
            echo "<br>總獲利為  $row_i[0] 元 "; 
        } -->
        </div></center>
	</body>
</html>
