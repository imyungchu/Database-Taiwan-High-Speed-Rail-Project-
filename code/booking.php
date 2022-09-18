<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<form name="form" method="post" action="booking_seq.php">
<html>
	<head> 
        <title>訂票</title>
        <link rel="stylesheet" href="booking_style.css"/>
    <head>
	<body>
	
		<img src="hsr.jpg" width="1255px"><br/>
		<center><h2 style="font-size:50px;">台灣高鐵訂票系統</center></h2><br/>

    <center><div action="" class="list"  style="white-space: nowrap">
    起站為：
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
    </select>    

    <br><br><br>迄站為：
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
    </select>  
    
    </div></center>

    <!-- font(改字體大小) <strong>粗體 -->
    <br><br><center><div action="" class="search" >
    <center><font size = "5"><strong> 請僅使用一種方式搜尋(車次或時間)</strong></font><center><br>

    車次代碼搜尋<input type="text" name="train_id" />&nbsp;&nbsp; <!--把輸入的車號取名叫train_id傳出 -->
    時間搜尋<input type="text" name="time" /> <!--把輸入的時間取名叫time傳出 -->
    
    <input type="submit" name="button" value="搜尋" />&nbsp;&nbsp;
    </form>

		<form action="member.php">
            <input type="submit" name="button" value="回會員首頁" >
        </form>
    </div></center>


	</body>
</html>






<!-- <input type="radio" name="車廂號碼" value="1car" >
            <label for="1car">1號車廂</label>
            <input type="radio" name="車廂號碼" value="2car" >
            <label for="2car">2號車廂</label>
            <input type="radio" name="車廂號碼" value="3car" >
            <label for="3car">3號車廂</label>
            <input type="radio" name="車廂號碼" value="4car" >
            <label for="4car">4號車廂</label>
            <input type="radio" name="車廂號碼" value="5car" >
            <label for="5car">5號車廂</label>
            <input type="radio" name="車廂號碼" value="6car" >
            <label for="5car">6號車廂(商務艙)</label>
            <input type="radio" name="車廂號碼" value="7car" >
            <label for="5car">7號車廂</label>
            <br>

        <input type="radio" name="座位號碼" value="1seat" >
        <label for="1seat">1號座位</label>
        <input type="radio" name="座位號碼" value="2seat" >
        <label for="2seat">2號座位</label>
        <input type="radio" name="座位號碼" value="3seat" >
        <label for="3seat">3號座位</label>
        <br>

    <input type="radio" name="座位列" value="A" >
    <label for="right">右側靠窗</label>
    <input type="radio" name="座位列" value="B" >
    <label for="left">左側靠窗</label> -->

