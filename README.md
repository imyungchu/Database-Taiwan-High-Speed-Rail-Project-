# Database Taiwan High Speed Rail project

###### tags:  `Database` `Database management system(DBMS)` `MySQL` `PHP` `CSS` `appserv` `PHPmyadmin` `visual studio` `ER diagram`

> This note record and share the final project of [DBMS course](https://timetable.nycu.edu.tw/?r=main/crsoutline&Acy=110&Sem=2&CrsNo=1482&lang=zh-tw) about constructing a integrated system for Taiwan High Speed Rail ticket booking system  :computer:
>  
 :male-teacher: Advicing Professor : Chien-Liang Liu 
 :man_and_woman_holding_hands: Team members : I-Lung Lu , Pei-Wen Li , Yu-Liang Li , Yu-Hsuan Chang and Yung-Chu Chiang(Me).
:bulb: Fun fact : our team member comes from different departments, including education, transportation, mathmatics, and industrial engineer.

## How to run the code

There are some tips for using our code :

1. Download SQL Database syntax first. There are two ways to build a database and the results are the same.
* Open in VSCode. Right-click all SQL cases and select RUNMQQy
* Direct operation on phpadmin
2. Please import the two csvs. into the table, each section is the most satisfying and the others are already in SQL.
3. Download all PHP files and put them in the WWW folder
4. Change the user account and password in mysql_connect.inc.php
5. Use Browse to type in the URL bar: localhost/login.php


## :memo: What have we done

### Step 1: Dicuss and build ER diagram according to the requiement.

#### Our plan 
![](https://i.imgur.com/ItoLQqV.png)

#### Requirements

In this course, the final project proposal is about developing a simple online Taiwan High Speed Rail ticket booking system integration. Suppose you are given the following basic functional requirements for a simple database for the online booking system:

- [x] User can:
● Login, logout, registration account
● Edit Customer information (ex: phone number, name, …)
● Booking ticket
1.The seats should include standard seats, business seats,    and non-reserved seats
2.The ticket price should include a discount (whether student or not) and which seats user books
● Search Train (number, date, Departure time, Arrival time, …)
● Seat viewing & selecting
● Bill (payment method)
● Ticket canceling
- [x] The station manager can:
● Login, logout, registration account
● Location (add, delete, edit)
● Train (add, cancel)
● View order detail, customers record
● Financial management
Construct a database using an ER diagram and business rules for online Taiwan High
Speed Rail ticket booking system integration. Your tables should include fields and
data types for attributes, as well as the relationships between entities.

#### Our ER diagram and business rule

![](https://i.imgur.com/kFnEGO3.png)
![](https://i.imgur.com/i65oAWv.png)

 

### Step 2: Backend - database table create and design

[Some initial notes](https://docs.google.com/document/d/1dYTJozoli40Ilzp4GrI7xForT8rODa2AaMaNsxTcKlA/edit?usp=sharing)

[Our working dairy](https://docs.google.com/document/d/1XuPKRCQofnrNRS-Z7Ok271g6cO7Oui6IVYDO4wmmw-A/edit?usp=sharing)

#### Codes to create table :

```
Use thsrc;
DROP TABLE IF EXISTS order_ticket; /*刪除原有的order_ticket TABLE*/

/*創建一個order_ticket 說明：Order_ticket的TABLE 裡面的欄位屬性，除了ORDER_ID 和兩個PRICE ，其他都是VARCHARS */
CREATE TABLE order_ticket (ORDER_ID INT AUTO_INCREMENT, USER_ID varchar(32),
                           TRAIN_CODE varchar(32),SEAT_CODE varchar(32),LOC_DEP varchar(32),LOC_ARR varchar(32),
                           ORDER_PAYMENT varchar(32), SUM_TICKET_PRICE decimal(8,0),
                           ORDER_PRICE decimal(8,0), CANCELED varchar(5) DEFAULT 0, PRIMARY KEY (ORDER_ID));





/*創建 所有車站 */
Use thsrc; 

DROP TABLE IF EXISTS location;
CREATE TABLE LOCATION ( LOC_ID int (32) NOT NULL, 
LOC_NAME varchar (64) NOT NULL, 
LOC_ENG varchar(64) NOT NULL, 
PRIMARY KEY (LOC_ID) );

INSERT INTO location VALUES('1','南港','NANGANG');
INSERT INTO location VALUES('2','台北','TAIPEI');
INSERT INTO location VALUES('3','板橋','BANQIAO');
INSERT INTO location VALUES('4','桃園','TAOYUAN');
INSERT INTO location VALUES('5','新竹','HSINCHU');
INSERT INTO location VALUES('6','苗栗','MIAOLI');
INSERT INTO location VALUES('7','台中','TAICHUNG');
INSERT INTO location VALUES('8','彰化','CHANGHUA');
INSERT INTO location VALUES('9','雲林','YUNLIN');
INSERT INTO location VALUES('10','嘉義','CHIAYI');
INSERT INTO location VALUES('11','台南','TAINAN');
INSERT INTO location VALUES('12','左營','ZUOYING');






/*創建 所有小路徑段 */

Use thsrc; 
DROP TABLE IF EXISTS section; 
CREATE TABLE section ( SECT_ID INT(32) NOT NULL,
SECT_ROUTE VARCHAR(10) NOT NULL,
LOC_DEP INT(32) NOT NULL,
LOC_ARR INT(32) NOT NULL, 
SECT_PRICE INT(32) NOT NULL, 
PRIMARY KEY (SECT_ID) ) ; 

INSERT INTO section VALUES('1','1 to 2','1','2','50');
INSERT INTO section VALUES('2','2 to 3','2','3','50');
INSERT INTO section VALUES('3','3 to 4','3','4','100');
INSERT INTO section VALUES('4','4 to 5','4','5','100');
INSERT INTO section VALUES('5','5 to 6','5','6','100');
INSERT INTO section VALUES('6','6 to 7','6','7','100');
INSERT INTO section VALUES('7','7 to 8','7','8','100');
INSERT INTO section VALUES('8','8 to 9','8','9','100');
INSERT INTO section VALUES('9','9 to 10','9','10','150');
INSERT INTO section VALUES('10','10 to 11','10','11','250');
INSERT INTO section VALUES('11','11 to 12','11','12','150');
INSERT INTO section VALUES('12','12 to 13','12','11','150');
INSERT INTO section VALUES('13','11 to 10','11','10','250');
INSERT INTO section VALUES('14','10 to 9','10','9','150');
INSERT INTO section VALUES('15','9 to 8','9','8','100');
INSERT INTO section VALUES('16','8 to 7','8','7','100');
INSERT INTO section VALUES('17','7 to 6','7','6','100');
INSERT INTO section VALUES('18','6 to 5','6','5','100');
INSERT INTO section VALUES('19','5 to 4','5','4','100');
INSERT INTO section VALUES('20','4 to 3','4','3','100');
INSERT INTO section VALUES('21','3 to 2','3','2','50');
INSERT INTO section VALUES('22','2 to 1','2','1','50');





/*創建 座位資料表 */
Use thsrc; 
DROP TABLE IF EXISTS seat; 
CREATE TABLE SEAT ( SEAT_CODE varchar (32) NOT NULL,
SEAT_TYPE varchar (32) NOT NULL,
PRIMARY KEY (SEAT_CODE) ) ; 
/*請用「座位SEAT_匯入資料用.csv」匯入座位資料表的內容 */
INSERT INTO seat VALUES('0101A','SR');
INSERT INTO seat VALUES('0101B','SR');
INSERT INTO seat VALUES('0102A','SR');
INSERT INTO seat VALUES('0102B','SR');
INSERT INTO seat VALUES('0103A','SR');
INSERT INTO seat VALUES('0103B','SR');
INSERT INTO seat VALUES('0104A','SR');
INSERT INTO seat VALUES('0104B','SR');
INSERT INTO seat VALUES('0105A','SR');
INSERT INTO seat VALUES('0105B','SR');
INSERT INTO seat VALUES('0201A','SR');
INSERT INTO seat VALUES('0201B','SR');
INSERT INTO seat VALUES('0202A','SR');
INSERT INTO seat VALUES('0202B','SR');
INSERT INTO seat VALUES('0203A','SR');
INSERT INTO seat VALUES('0203B','SR');
INSERT INTO seat VALUES('0204A','SR');
INSERT INTO seat VALUES('0204B','SR');
INSERT INTO seat VALUES('0205A','SR');
INSERT INTO seat VALUES('0205B','SR');
INSERT INTO seat VALUES('0301A','SR');
INSERT INTO seat VALUES('0301B','SR');
INSERT INTO seat VALUES('0302A','SR');
INSERT INTO seat VALUES('0302B','SR');
INSERT INTO seat VALUES('0303A','SR');
INSERT INTO seat VALUES('0303B','SR');
INSERT INTO seat VALUES('0304A','SR');
INSERT INTO seat VALUES('0304B','SR');
INSERT INTO seat VALUES('0305A','SR');
INSERT INTO seat VALUES('0305B','SR');
INSERT INTO seat VALUES('0401A','SR');
INSERT INTO seat VALUES('0401B','SR');
INSERT INTO seat VALUES('0402A','SR');
INSERT INTO seat VALUES('0402B','SR');
INSERT INTO seat VALUES('0403A','SR');
INSERT INTO seat VALUES('0403B','SR');
INSERT INTO seat VALUES('0404A','SR');
INSERT INTO seat VALUES('0404B','SR');
INSERT INTO seat VALUES('0405A','SR');
INSERT INTO seat VALUES('0405B','SR');
INSERT INTO seat VALUES('0501A','SR');
INSERT INTO seat VALUES('0501B','SR');
INSERT INTO seat VALUES('0502A','SR');
INSERT INTO seat VALUES('0502B','SR');
INSERT INTO seat VALUES('0503A','SR');
INSERT INTO seat VALUES('0503B','SR');
INSERT INTO seat VALUES('0504A','SR');
INSERT INTO seat VALUES('0504B','SR');
INSERT INTO seat VALUES('0505A','SR');
INSERT INTO seat VALUES('0505B','SR');
INSERT INTO seat VALUES('0601A','B');
INSERT INTO seat VALUES('0601B','B');
INSERT INTO seat VALUES('0602A','B');
INSERT INTO seat VALUES('0602B','B');
INSERT INTO seat VALUES('0603A','B');
INSERT INTO seat VALUES('0603B','B');
INSERT INTO seat VALUES('0604A','B');
INSERT INTO seat VALUES('0604B','B');
INSERT INTO seat VALUES('0605A','B');
INSERT INTO seat VALUES('0605B','B');
INSERT INTO seat VALUES('0701A','SR');
INSERT INTO seat VALUES('0701B','SR');
INSERT INTO seat VALUES('0702A','SR');
INSERT INTO seat VALUES('0702B','SR');
INSERT INTO seat VALUES('0703A','SR');
INSERT INTO seat VALUES('0703B','SR');
INSERT INTO seat VALUES('0704A','SR');
INSERT INTO seat VALUES('0704B','SR');
INSERT INTO seat VALUES('0705A','SR');
INSERT INTO seat VALUES('0705B','SR');
INSERT INTO seat VALUES('0801A','SR');
INSERT INTO seat VALUES('0801B','SR');
INSERT INTO seat VALUES('0802A','SR');
INSERT INTO seat VALUES('0802B','SR');
INSERT INTO seat VALUES('0803A','SR');
INSERT INTO seat VALUES('0803B','SR');
INSERT INTO seat VALUES('0804A','SR');
INSERT INTO seat VALUES('0804B','SR');
INSERT INTO seat VALUES('0805A','SR');
INSERT INTO seat VALUES('0805B','SR');
INSERT INTO seat VALUES('0901A','SR');
INSERT INTO seat VALUES('0901B','SR');
INSERT INTO seat VALUES('0902A','SR');
INSERT INTO seat VALUES('0902B','SR');
INSERT INTO seat VALUES('0903A','SR');
INSERT INTO seat VALUES('0903B','SR');
INSERT INTO seat VALUES('0904A','SR');
INSERT INTO seat VALUES('0904B','SR');
INSERT INTO seat VALUES('0905A','SR');
INSERT INTO seat VALUES('0905B','SR');
INSERT INTO seat VALUES('1001A','SN');
INSERT INTO seat VALUES('1001B','SN');
INSERT INTO seat VALUES('1002A','SN');
INSERT INTO seat VALUES('1002B','SN');
INSERT INTO seat VALUES('1003A','SN');
INSERT INTO seat VALUES('1003B','SN');
INSERT INTO seat VALUES('1004A','SN');
INSERT INTO seat VALUES('1004B','SN');
INSERT INTO seat VALUES('1005A','SN');
INSERT INTO seat VALUES('1005B','SN');
INSERT INTO seat VALUES('1101A','SN');
INSERT INTO seat VALUES('1101B','SN');
INSERT INTO seat VALUES('1102A','SN');
INSERT INTO seat VALUES('1102B','SN');
INSERT INTO seat VALUES('1103A','SN');
INSERT INTO seat VALUES('1103B','SN');
INSERT INTO seat VALUES('1104A','SN');
INSERT INTO seat VALUES('1104B','SN');
INSERT INTO seat VALUES('1105A','SN');
INSERT INTO seat VALUES('1105B','SN');
INSERT INTO seat VALUES('1201A','SN');
INSERT INTO seat VALUES('1201B','SN');
INSERT INTO seat VALUES('1202A','SN');
INSERT INTO seat VALUES('1202B','SN');
INSERT INTO seat VALUES('1203A','SN');
INSERT INTO seat VALUES('1203B','SN');
INSERT INTO seat VALUES('1204A','SN');
INSERT INTO seat VALUES('1204B','SN');
INSERT INTO seat VALUES('1205A','SN');
INSERT INTO seat VALUES('1205B','SN');







/*創建 火車 班次  */
Use thsrc; 
DROP TABLE IF EXISTS train; 
CREATE TABLE train ( TRAIN_CODE INT(32) NOT NULL,
TRAIN_TYPE INT(32) NOT NULL,
TRAIN_SER INT(32) NOT NULL, 
DEP_TIME TIME NOT NULL, 
DEP INT(32) NOT NULL,
ARR INT(32) NOT NULL,
NANGANG INT(32) NOT NULL,
TAIPEI INT(32) NOT NULL,  
BANQIAO INT(32) NOT NULL, 
TAOYUAN INT(32) NOT NULL,
HSINCHU INT(32) NOT NULL,
MIAOLI INT(32) NOT NULL,
TAICHUNG INT(32) NOT NULL,
CHANGHUA INT(32) NOT NULL,
YUNLIN INT(32) NOT NULL,
CHIAYI INT(32) NOT NULL,
TAINAN INT(32) NOT NULL,
ZUOYING INT(32) NOT NULL,
CANCELED INT(11)DEFAULT 0,
 
PRIMARY KEY (TRAIN_CODE) ) ; 

INSERT INTO TRAIN VALUES('402','4','02','09:01:00','7','1' ,'1','1','1','1','1','1','1','0','0','0','0','0','0');
INSERT INTO TRAIN VALUES('501','5','01','09:01:00','7','12','0','0','0','0','0','0','1','1','1','1','1','1','0');
INSERT INTO TRAIN VALUES('801','8','01','08:01:00','1','12' ,'1','1','1','1','1','1','1','1','1','1','1','1','0');
INSERT INTO TRAIN VALUES('802','8','02','08:01:00','12','1','1','1','1','1','1','1','1','1','1','1','1','1','0');






/*創建 帳號資料表 */
Use thsrc; 
DROP TABLE IF EXISTS account;
CREATE TABLE account ( ID varchar(32) NOT NULL, 
USER_PWORD varchar(64) NOT NULL, 
USER_FNAME varchar(64) NOT NULL, 
USER_LNAME varchar(64) NOT NULL, 
USER_PHONE varchar(64) NOT NULL, 
USER_EMAIL varchar(64) NOT NULL,
IS_ADMIN varchar(64) NOT NULL, 
IS_STUDENT varchar(64) NOT NULL,  
 
PRIMARY KEY (ID) ) ;  




CREATE TABLE ava_default(AVALIABLE int(11) DEFAULT 0);/*創建獨立的AVA 資料表*/


/*創建 下行車次資料表 */
Use thsrc; 
/* 以下出現報錯是正常，但還是可以跑，因為不是在PHPADMIN會抓不到表的屬性 */
/*先用假設兩個班次都是區間車的方式JOIN  共計 12節*2排*5列*2車次*11區段=2640*/
CREATE TABLE ticket_down SELECT  TRAIN_CODE, TRAIN_TYPE, TRAIN_SER, DEP_TIME, DEP, ARR, 
NANGANG, TAIPEI, BANQIAO, TAOYUAN, HSINCHU, MIAOLI, TAICHUNG, CHANGHUA, YUNLIN, CHIAYI, TAINAN, ZUOYING,
 SEAT_CODE, TRAIN_CAR, SEAT_ID, SEAT_TYPE, SECT_ID, SECT_ROUTE, LOC_DEP, LOC_ARR, SECT_PRICE, AVALIABLE 
 FROM `train` JOIN `seat` JOIN `section` JOIN `AVA_DEFAULT` WHERE section.LOC_DEP < section.LOC_ARR  AND TRAIN_CODE IN('801','501'); 
/*再，刪除501車次不啟動的車站  -720 */
DELETE FROM ticket_down WHERE TRAIN_CODE = '501' AND LOC_DEP IN('1','2','3','4','5','6');
/*共計 「12節*2排*5列*1班車[801]*11區段」+「12節*2排*5列*1班車[501]*6區段(台中到台北)  =1920*/
/* 新增AVALIABLE欄位  ※這邊雖然英文單字拼錯，不過先將就著用*/
ALTER TABLE ticket_down ADD AVALIABLE int(32) DEFAULT 0;



/*創建 上行車次資料表 */
Use thsrc; 
/* 以下出現報錯是正常，但還是可以跑，因為不是在PHPADMIN會抓不到表的屬性*/
/*先用假設兩個班次都是區間車的方式JOIN  共計 12節*2排*5列*2車次*11區段=2640*/
CREATE TABLE ticket_up SELECT  TRAIN_CODE, TRAIN_TYPE, TRAIN_SER, DEP_TIME, DEP, ARR, 
NANGANG, TAIPEI, BANQIAO, TAOYUAN, HSINCHU, MIAOLI, TAICHUNG, CHANGHUA, YUNLIN, CHIAYI, TAINAN, ZUOYING,
 SEAT_CODE, TRAIN_CAR, SEAT_ID, SEAT_TYPE, SECT_ID, SECT_ROUTE, LOC_DEP, LOC_ARR, SECT_PRICE, AVALIABLE 
 FROM `train` JOIN `seat` JOIN `section` JOIN `AVA_DEFAULT` WHERE section.LOC_DEP > section.LOC_ARR  AND TRAIN_CODE IN('802','402'); 
/*再，刪除402車次(從7號站起站往北，沿途皆停靠，所以應該有6個 "LOC_DEP" +6個section)不啟動的車站  -600=120(一班列車的座位)x5(五段section) */
DELETE FROM ticket_up WHERE TRAIN_CODE = '402' AND LOC_DEP IN('12','11','10','9','8');
/* 共計 「12節*2排*5列*1班車[802]*11區段」+「12節*2排*5列*1班車[402]*5區段(左營到台中)  =2040 */
/* 新增AVAILABLE欄位 ※這邊雖然英文單字拼錯，不過先將就著用*/
ALTER TABLE ticket_up ADD AVALIABLE int(32) DEFAULT 0;
```


### Step 3: Frontend - add some HTML and CSS to beautified the web page

#### Seeing is believing ! Watch our demo video below

<iframe src="https://player.vimeo.com/video/749046077?h=115ab3a54c" width="640" height="564" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>



- Watch MORE of my projects ➜ [My GitHub repositories](https://github.com/imyungchu?tab=repositories)

