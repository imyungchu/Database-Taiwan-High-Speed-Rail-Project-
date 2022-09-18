<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<form name="form" method="post" action="register_finish.php">

<html>
<head> 
        <title>註冊</title>
        <link rel="stylesheet" href="login_style.css"/>
<head>  
<body>
        
        <img src="hsr.jpg" width="1255px"><br/>
        <center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>
        <center><div action="" class="login" >
            會員帳號：<input type="text" name="id" /> <br>
            會員密碼：<input type="password" name="pw" /> <br>
            請再次輸入密碼：<input type="password" name="pw2" /> <br>
            姓：<input type="text" name="f_name" /> 
            名：<input type="text" name="l_name" /> <br>
            手機：<input type="text" name="phone" /> <br>
            電子信箱：<input type="text" name="email" /> <br>
            請再次輸入電子信箱：<input type="text" name="email2" /> <br>
            管理者金鑰(一般會員申請免填)：<input type="text" name="auth" /> <br>
            學生身分：
            </div></center>
            <center><div action="" class="student" style="white-space: nowrap">
            <label><input type="radio" id="is_student" name="IS_STUDENT" value="Yes" checked>是</label>
            <label><input type="radio" id="not_student" name="IS_STUDENT" value="No" >否</label>
            </div></center> 
            <center><div action="" class="login">
                <input type="submit" name="button" value="註冊" /></form>
                <form name="form" method="post" action="login.php">
                <input type="submit" name="button" value="回登入頁面" /></form>
            </div></center> 
            
            
</body>
</form>
</html>