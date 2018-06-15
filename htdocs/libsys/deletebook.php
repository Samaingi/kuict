<?php require_once('Connections/conn.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

if ((isset($_POST['bookISBN'])) && ($_POST['bookISBN'] != "") && ($_POST["MM_insert"]="form1"))  {
  $deleteSQL = sprintf("DELETE FROM book WHERE bookISBN=%s",
                       GetSQLValueString($_POST['bookISBN'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
$echo=("<span style='color:red;'>Deleted successfully \n</span>");
echo '<META http-equiv="refresh" content="1; URL="deletestudent.php">';
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


 

mysql_select_db($database_conn, $conn);
$query_books = "SELECT * FROM book ORDER BY book.bookId DESC";
$books = mysql_query($query_books, $conn) or die(mysql_error());
$row_books = mysql_fetch_assoc($books);
$totalRows_books = mysql_num_rows($books);

mysql_select_db($database_conn, $conn);
$query_students = "SELECT * FROM student ORDER BY student.admNo DESC";
$students = mysql_query($query_students, $conn) or die(mysql_error());
$row_students = mysql_fetch_assoc($students);
$totalRows_students = mysql_num_rows($students);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Library Management System</title>
<link rel="stylesheet" type="text/css" href="assets/css/style.css" />

</head>

<body>
<div class="header">
 <center><div id="navbar">
   <ul>
   <li><a href="Home.php"  id="linkref">Home</a></li>
   <li><a href="borrowings.php" id="linkref">View Borrowed Books</a></li>
   <li><a href="books.php" id="linkref">View All Books</a></li>
   <li><a href="addbook.php" id="linkref">Add Book</a></li>
   <li><a href="addstudent.php" id="linkref">Add Student</a></li>
   <li><a href="deletebook.php" id="linkref"class="active">Delete Book</a></li>
   <li><a href="deletestudent.php" id="linkref">Delete Student</a></li>
   <ul><li><a href="<?php echo $logoutAction ?>" id="linkref">Logout</a></li>
   </ul>
  </div></center>
</div>
<main >
    <section class="panel">
      <form method="post" action="<?php echo $editFormAction; ?>" name="form1" onsubmit="return proceed()" >
     <div class="form-group">
      <label for="bookISBN">Book ISBN No:</label>
      <input type="text" name="bookISBN" id="bookISBN" required="required" placeholder="Enter ISBN No. to delete"/> 
      </div>
      <button type="submit" name="delete" id="delete" >Delete Book</button>
     <input type="hidden" name="MM_insert" value="form1" /><br /><br />
	 <?php if(isset($echo)){echo $echo;} ?>
      </form>	
      <p>&nbsp;</p>
    </section>
        </main>
         <div class="footer"><h3 style="float:right">System Developed By <a href="mailto:denniskiprotich0@gmail.com">CustomTechs&copy; <?php ?></a> +254708058225</h3></div>
</body>
</html>
<?php
mysql_free_result($books);

mysql_free_result($students);
?>
<script type="text/javascript">
 function proceed() {
  return confirm('Delete Book?');
 }
 
 </script>