<?php
/**
 * Created by PhpStorm.
 * User: Dennoh V's
 * Date: 2/10/2018
 * Time: 2:24 AM
 */
$conn =mysql_connect("localhost","root","") or die(mysql_error());
if($conn)
{
//echo "connection established";
}
else
{
    echo "No connection";
}$db='auth-o';
mysql_select_db($db) or die(mysql_error());
?>
