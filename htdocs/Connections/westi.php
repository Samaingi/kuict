<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_westi = "localhost";
$database_westi = "westend";
$username_westi = "root";
$password_westi = "";
$westi = mysql_pconnect($hostname_westi, $username_westi, $password_westi) or trigger_error(mysql_error(),E_USER_ERROR); 
?>