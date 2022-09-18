<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<head>
<title>會員資料修改</title>
<link rel="stylesheet" href="member_style.css"/>
</head>
<body>
	<img src="hsr.jpg" width="1255px"><br/>
    <center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>
	<center><div action="" class="list" >
        <?php
        include("mysql_connect.inc.php");

        if(isset($_POST['button'])){
            include("mysql_connect.inc.php");
            $id = $_SESSION['username'];
            $pw = $_POST['pw'];
            $pw2 = $_POST['pw2'];
            $fname = $_POST['f_name'];
            $lname = $_POST['l_name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            if($id != null && $pw != null && $pw2 != null && $pw == $pw2)
            {  
                $sql = "update account set USER_PWORD='$pw', USER_FNAME='$fname', USER_LNAME='$lname',USER_PHONE='$phone', USER_EMAIL='$email' where ID='$id'";
                    if(mysqli_query($conn, $sql))
                    {
                            echo "<font size='5'>修改成功! 等待跳轉回會員中心</font>";
                            echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
                    }
                    else
                    {
                            echo "<a><font size='5'>修改失敗!</font></a>";
                            echo '<meta http-equiv=REFRESH CONTENT=1;url=member_modify.php>';
                    }
            }
            else
            {
            echo "<a><font size='5'>修改失敗!</font></a>";
            echo '<meta http-equiv=REFRESH CONTENT=1;url=member_modify.php>';
            }
        }
 
 
        if($_SESSION['username'] != null)
        {
                $id = $_SESSION['username'];
                $sql = "SELECT * FROM account WHERE ID = $id";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_row($result);
        }
                echo "<br><br><br><font size = '6'><strong>修改會員個人資料</strong></font><br><br><br>";
                echo "<form name='form' method='post'>";
                echo "密碼：<input type='password' name='pw' value='$row[1]' />";
                echo "再一次輸入密碼：<input type='password' name='pw2' value='$row[1]' />";
                echo "姓：<input type='text' name='f_name' value='$row[2]' />";
                echo "名：<input type='text' name='l_name' value='$row[3]' />";
                echo "手機：<input type='text' name='phone' value='$row[4]' />";
                echo "電子信箱：<input type='text' name='email' value='$row[5]' />";        
                echo "<input type='submit' name='button' value='確認修改' /><br>";
                echo "</form>";

                
                
        
        ?>
        <form action="member.php">
            <input type="submit" name="button" value="回會員首頁" >
        </form>
        </div></center> 
</body>
</html> 