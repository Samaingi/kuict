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
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck="."You must be logged in first!";
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO bookisue (bookId, studentId) VALUES (%s, %s)",
                       GetSQLValueString($_POST['bookId'], "int"),
                       GetSQLValueString($_POST['studentId'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
    $echo =("<span style='color:red;'>\nChanges Made successfully</span>");
    echo '<META http-equiv="refresh" content="1; URL="home.php">';

}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
mysql_select_db($database_conn, $conn);
$query_books = "SELECT * FROM book where status=0 ORDER BY book.bookId DESC ";
$books = mysql_query($query_books, $conn) or die(mysql_error());
$row_books = mysql_fetch_assoc($books);
$totalRows_books = mysql_num_rows($books);


mysql_select_db($database_conn, $conn);
$query_students = "SELECT * FROM student ORDER BY student.admNo DESC";
$students = mysql_query($query_students, $conn) or die(mysql_error());
$row_students = mysql_fetch_assoc($students);
$totalRows_students = mysql_num_rows($students);

$maxRows_bookissue = 10;
$pageNum_bookissue = 0;
if (isset($_GET['pageNum_bookissue'])) {
  $pageNum_bookissue = $_GET['pageNum_bookissue'];
}
$startRow_bookissue = $pageNum_bookissue * $maxRows_bookissue;

mysql_select_db($database_conn, $conn);
$query_bookissue = "SELECT * FROM bookisue, book, student WHERE bookisue.bookId=book.bookId and bookisue.studentId=student.studentId";
$query_limit_bookissue = sprintf("%s LIMIT %d, %d", $query_bookissue, $startRow_bookissue, $maxRows_bookissue);
$bookissue = mysql_query($query_limit_bookissue, $conn) or die(mysql_error());
$row_bookissue = mysql_fetch_assoc($bookissue);

if (isset($_GET['totalRows_bookissue'])) {
  $totalRows_bookissue = $_GET['totalRows_bookissue'];
} else {
  $all_bookissue = mysql_query($query_bookissue);
  $totalRows_bookissue = mysql_num_rows($all_bookissue);
}
$totalPages_bookissue = ceil($totalRows_bookissue/$maxRows_bookissue)-1;

$queryString_bookissue = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_bookissue") == false && 
        stristr($param, "totalRows_bookissue") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_bookissue = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_bookissue = sprintf("&totalRows_bookissue=%d%s", $totalRows_bookissue, $queryString_bookissue);

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"]="form2"))  {
  $deleteSQL = sprintf("DELETE FROM bookisue WHERE issueId=%s",
                       GetSQLValueString($_POST['issueId'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());

  	 $echo =("<span style='color:red;'>\nChanges Made successfully</span>");
    echo '<META http-equiv="refresh" content="1; URL="home.php">';
  
}

$editFormAction1 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction1 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

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
   <li><a href="Home.php" class="active" id="linkref">Home</a></li>
   <li><a href="borrowings.php" id="linkref">View Borrowed Books</a></li>
   <li><a href="books.php" id="linkref">View All Books</a></li>
   <li><a href="addbook.php" id="linkref">Add Book</a></li>
   <li><a href="addstudent.php" id="linkref">Add Student</a></li>
   <li><a href="deletebook.php" id="linkref">Delete Book</a></li>
   <li><a href="deletestudent.php" id="linkref">Delete Student</a></li>
   <ul><li><a href="<?php echo $logoutAction ?>" id="linkref">Logout</a></li>
   </ul>
  </div></center>
</div>
<main >
    <section class="panel">
    <h2>Issue Book</h2>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return proceed()">
         <div class="form-group">
                <label for="bookId">Book Name</label>
        	<select name="bookId">
              <?php 
do {  
?>
              <option value="<?php echo $row_books['bookId']?>" <?php if (!(strcmp($row_books['bookId'], $row_books['bookId']))) {echo "SELECTED";} ?>><?php echo $row_books['bookName']?></option>
              <?php
} while ($row_books = mysql_fetch_assoc($books));
?>
            </select>
            </div>
             <div class="form-group">
                <label for="studentId">Student's Admission Number</label>
            <select name="studentId">
              <?php 
do {  
?>
              <option value="<?php echo $row_students['studentId']?>" <?php if (!(strcmp($row_students['studentId'], $row_students['studentId']))) {echo "SELECTED";} ?>><?php echo $row_students['admNo']?></option>
              <?php
} while ($row_students = mysql_fetch_assoc($students));
?>
            </select>
            </div>
            <div class="form-group">
            <button type="submit" value="Issue" />Issue</button>
             
            </div>
        <input type="hidden" name="MM_insert" value="form1" /> <br /><br />
	 
      </form><br />
      <br />
      <h2>Return Book</h2>
      
       <form method="post" action="<?php echo $editFormAction1; ?>" name="form2" onsubmit="return proceed()" >
         
         <div class="form-group">
                <label for="issueId">Student's Admission Number</label>
            <select name="issueId">
              <?php 
do {  
?>
              <option value="<?php echo $row_bookissue['issueId']; ?>" <?php if (!(strcmp($row_bookissue['issueId'], $row_bookissue['issueId']))) {echo "SELECTED";} ?>><?php echo $row_bookissue['admNo']?></option>
              <?php
} while ($row_bookissue = mysql_fetch_assoc($bookissue));
?>
            </select>
            </div>
      <button type="submit" name="delete" id="delete" style="float:right" value="Return" />Return</button>
     <input type="hidden" name="MM_insert" value="form2" /> <br /><br />
	 <?php if(isset($echo)){echo $echo;} ?>
      </form>	
      
      </section>
        </main>
        <div class="footer"><h3 style="float:right">System Developed By <a href="mailto:denniskiprotich0@gmail.com">CustomTechs&copy; <?php ?></a> +254708058225</h3></div>
</body>
</html>
<?php
mysql_free_result($books);

mysql_free_result($students);

mysql_free_result($bookissue);
?>
<script type="text/javascript">
 function proceed() {
  return confirm('Sure to make changes?');
 }
 
 </script>