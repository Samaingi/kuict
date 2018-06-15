<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>West End Home Page</title>
<style>

#header{ 
    width:80%;
	height:120px;
	background:#0099FF;
	color:#000000;
    }
#sidebar{ 
    width:270px;
	margin-left:133px;
	height:500px;
	background:#0099ff;
	float:left;
    }
#data{
width:80%;
height:500px;
background:#66CCFF;
	color:#000000;
	font-family:Georgia;
    }
	ul li{
	padding:20px;
	 border-bottom:2px solid #000066;
	 list-style:none;
		}
 ul li:hover{
	  background:#66CCFF;
	   color:#ffffff;
	  }
	   a{
	  color:#000000;
	  text-decoration:none;}
	  button{
	  background-color:#66CCFF;
	  width:40px;
	  height:50px;
	  }
	 
</style>
</head>
<body bgcolor="#333333" width="80%"><center>
<div id="header">
<center><h1>WEST END COURIER SERVICES</h1>
<h1>MANAGEMENT SYSTEM</h1></center>
</div>
<div id="sidebar">
<ul>
 <li><a href="send.php">SEND</a></li>
 <li><a href="sent.php">SENT</a></li>
 <li><a href="received.php">RECEIVED</a></li>
  <li><a href="delivered.php">DELIVERED</a></li>
 <li><a href="index.php">LOGOUT</a></li>
 </ul>

</div>

<div id="data">
<center>
<?php
error_reporting(0); 
$sql="select * from user where username='$loginUsername'";
if ($sql==true){
 echo $row['loginUusername'];
}?><!-- #BeginDate format:fcAm1a -->Tuesday, May 23, 2017 10:17 PM<!-- #EndDate -->
<H2>WELCOME</H2>
<h3>TO</h3>
<h2>WEST END COURIER MANGEMENT SYSTEM</h2>
</center>
</div>
 </center>
</body>
</html>
