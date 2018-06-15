<?php
$conn =mysql_connect("localhost","root","") or die(mysql_error());
if($conn)
{
//echo "connection established";
}
else
{
echo "No connection";
}$db='rentalsmgt';
mysql_select_db($db) or die(mysql_error());
?>