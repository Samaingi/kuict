<?php
//error_reporting(0);
session_start();
  $current_userName = $_SESSION['userName'];
			
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
 $userName = $_SESSION['userName'];

require_once '/Connections/west.php';
$sql = "SELECT * FROM user where userName='$userName' and passWord='$passWord'";
$result = mysql_query($sql) or die;

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $current_userName = $row['userName'];
    }
} else {
       header("/?login_err=You must be Administrator");
}


} else {
    header("location:?login_err=You must login first");
}
?>