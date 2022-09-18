<?php session_start(); ?>
<html>
    <head> 
        <title>登入</title>
        <link rel="stylesheet" href="login_style.css"/>
    <head>  
    <body>
    <div>
    
        <img src="hsr.jpg" width="1255px"><br/>
        
        <center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>


        <center><div action="" class="login" > 
            <h3 style="font-size:30px;">登入 Login</h3>
            
            <form method="post" action="connect.php">
                <input type="text" name="id" placeholder="帳號" required><br>
                <input type="password" name="pw" placeholder="密碼" required><br>
                <input type="submit" name="button" value="登入" class="submit"/>
            </form>  

            <form action="register.php">
                <input type="submit" name="button" value="註冊" >
            </form>
        </div></center>  
        
    </div>
    </body>

</html>
