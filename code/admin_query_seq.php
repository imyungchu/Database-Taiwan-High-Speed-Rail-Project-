<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head> 
      <link rel="stylesheet" href="admin_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>

        <center><div action="" class="search" style="font-size:30px;">
        <?php
        include("mysql_connect.inc.php");

        $name = $_POST['username']; 
        $train_id = $_POST['train_id']; 
        $seat = $_POST['seat_code'];
        $dep = $_SESSION['dep']; 
        $arr = $_SESSION['arr'];  


        echo '<font size = "6"><strong> 訂單一覽表 </strong></font><br>';
        echo '<font size = "3"><strong> (訂單狀態為1：顧客已退票或班次取消強制退票； 訂單狀態為0：訂單存在)</strong></font><br><br>';
        // 確定車次與時間欄位有被正確填入

        if($train_id == null && $name == null)
        {
            echo '請至少輸入一種方式進行搜尋';
            echo '<meta http-equiv=REFRESH CONTENT=2;url=admin_query.php>';
        }
        elseif ($train_id != null && $name != null)
        {
            $sql = "SELECT * FROM order_ticket WHERE TRAIN_CODE= '$train_id' and USER_ID='$name'";
            $result = mysqli_query($conn,$sql);
            echo "<font size = '5'>訂單編號&nbsp&nbsp&nbsp&nbsp購買人&nbsp&nbsp&nbsp&nbsp車次&nbsp&nbsp&nbsp&nbsp座位&nbsp&nbsp&nbsp&nbsp起站&nbsp&nbsp&nbsp&nbsp迄站&nbsp&nbsp&nbsp&nbsp付款方式&nbsp&nbsp&nbsp&nbsp實付金額&nbsp&nbsp&nbsp&nbsp訂單狀況&nbsp&nbsp&nbsp&nbsp<br>";
            while($row = mysqli_fetch_row($result))
            {
                echo "<font size = '4'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[0]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[1]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[2]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[3]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[4]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[5]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[6]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[8]元&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[9]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>";
            }
        }

        else
        {
            
            if ($name != null)
            {
                $sql = "SELECT * FROM order_ticket WHERE USER_ID = '$name'";
                $result = mysqli_query($conn,$sql);
                //echo "<font size = '5'>訂單編號&nbsp&nbsp&nbsp&nbsp購買人&nbsp&nbsp&nbsp&nbsp車次&nbsp&nbsp&nbsp&nbsp座位&nbsp&nbsp&nbsp&nbsp起站&nbsp&nbsp&nbsp&nbsp迄站&nbsp&nbsp&nbsp&nbsp付款方式&nbsp&nbsp&nbsp&nbsp實付金額&nbsp&nbsp&nbsp&nbsp訂單狀況&nbsp&nbsp&nbsp&nbsp<br>";
                echo '<table>';
                echo '<font size="5"><strong><tr><th>訂單編號</th><th>購買人</th><th>車次</th><th>座位</th><th>起站</th><th>迄站</th><th>付款方式</th><th>實付金額</th><th>訂單狀況</th><tr></strong></font>';
                while($row = mysqli_fetch_row($result))
                {
                    //echo "<font size = '4'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[0]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[1]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[2]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[3]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[4]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[5]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[6]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[8]元&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[9]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>";
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

            }

            elseif ($train_id != null)
            {
                $sql = "SELECT * FROM order_ticket WHERE TRAIN_CODE= '$train_id'";
                $result = mysqli_query($conn,$sql);
                echo "<font size = '5'>訂單編號&nbsp&nbsp&nbsp&nbsp購買人&nbsp&nbsp&nbsp&nbsp車次&nbsp&nbsp&nbsp&nbsp座位&nbsp&nbsp&nbsp&nbsp起站&nbsp&nbsp&nbsp&nbsp迄站&nbsp&nbsp&nbsp&nbsp付款方式&nbsp&nbsp&nbsp&nbsp實付金額&nbsp&nbsp&nbsp&nbsp訂單狀況&nbsp&nbsp&nbsp&nbsp<br>";
                while($row = mysqli_fetch_row($result))
                {
                    echo "<font size = '4'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[0]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[1]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[2]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[3]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[4]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[5]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[6]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[8]元&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$row[9]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br>";
                }
            }
            
            
        }
        echo '<br><br><form name="form" method="post" action="admin_query.php">';
        echo '<input type="submit" name="button" value="回上頁" />&nbsp;&nbsp<br></form>';





        // $sql = "SELECT * FROM order_ticket WHERE SEAT_CODE = '$seat'";
        // $result = mysqli_query($conn,$sql);
        // while($row = mysqli_fetch_row($result))
        // {
        //     echo "訂單號碼$row[0] 購買人$row[1] 車次$row[2] 座位$row[3] 起站$row[4] 迄站$row[5] 付款方式$row[6]/ 實付金額$row[8]元/ 訂單狀況為 $row[9]<br>";
        // }


                    // while($row = mysqli_fetch_row($result))
                    // {
                    //     echo "座位為{$row[0]}!<br>";

                    // }




        // echo '<br><br><font size = "5"><strong> 請僅使用一種方式進行搜尋(車次或時間)</strong></font><br>';
        // echo '車次代瑪搜尋&nbsp;&nbsp;<input type="text" name="train_id" />&nbsp;&nbsp; <!--把輸入的車號取名叫train_id傳出 -->';
        // echo '時間搜尋&nbsp;&nbsp;<input type="text" name="time" /> <!--把輸入的時間取名叫time傳出 -->';
        // echo '<br><input type="submit" name="button" value="搜尋" />&nbsp;&nbsp;';
        // echo '</form>';

        ?>
        </div></center>
	</body>
</html>
