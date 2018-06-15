
<?php require_once('../Connections/westi.php'); ?>

<?php //include "check_login.php";
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_head = 10;
$pageNum_head = 0;
if (isset($_GET['pageNum_head'])) {
  $pageNum_head = $_GET['pageNum_head'];
}
$startRow_head = $pageNum_head * $maxRows_head;

mysql_select_db($database_westi, $westi);
$query_head = "SELECT * FROM info";
$query_limit_head = sprintf("%s LIMIT %d, %d", $query_head, $startRow_head, $maxRows_head);
$head = mysql_query($query_limit_head, $westi) or die(mysql_error());
$row_head = mysql_fetch_assoc($head);

if (isset($_GET['totalRows_head'])) {
  $totalRows_head = $_GET['totalRows_head'];
} else {
  $all_head = mysql_query($query_head);
  $totalRows_head = mysql_num_rows($all_head);
}
$totalPages_head = ceil($totalRows_head/$maxRows_head)-1;

$queryString_head = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_head") == false && 
        stristr($param, "totalRows_head") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_head = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_head = sprintf("&totalRows_head=%d%s", $totalRows_head, $queryString_head);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_head['name']; ?></title>
<link rel="stylesheet" href="style.css" />
</script>

<script type="text/javascript">
 function proceed() {
  return confirm('Sure to update Company Info?');
 }
 
 </script>
</head>

<body bgcolor="#333333"><center>
<div id="header">


    <?php do { ?>
      
        <h2><?php echo $row_head['name']; ?> </h2>
        <img src="img/<?php echo $row_head['logo']; ?>" width="50" height="50"/>
        <h3><?php echo $row_head['motto']; ?></h3>
     
      <?php } while ($row_head = mysql_fetch_assoc($head)); ?>
</div>
<div id="menubar">
<hr size="5" noshade="noshade" color="#990000" style="outline-color:#FFFFFF" />
<table border="0"><tr><td bgcolor="#66CCFF"><a href="home.php">HOME</a></td><td><a href="send.php">SEND</a></td><td><a href="sent.php">SENT</a></td><td><a href="received.php">RECEIVED</a></td><TD><a href="delivered.php">DELIVERED</a></TD><TD><a href="index.php">LOG OUT</a></TD></tr></table>
</div>
<div id="data"><hr size="1" noshade="noshade" color="#990000" style="outline-color:#FFFFFF" />
    <style>
        .bg-transition {

            font-size: 14px;
            border-radius: 15px;
            text-align: justify;
            font-family: 'Yanone Kaffeesatz', sans-serif;
            background-color:#66CCFF;
            transition: all 2s;
            -webkit-transition: all 1.2s linear;}

        .bg-transition:hover {
            background-color:#0099FF;
        }
    </style>

    <?php require_once('../Connections/westi.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_head = 10;
$pageNum_head = 0;
if (isset($_GET['pageNum_head'])) {
  $pageNum_head = $_GET['pageNum_head'];
}
$startRow_head = $pageNum_head * $maxRows_head;

mysql_select_db($database_westi, $westi);
$query_head = "SELECT * FROM info";
$query_limit_head = sprintf("%s LIMIT %d, %d", $query_head, $startRow_head, $maxRows_head);
$head = mysql_query($query_limit_head, $westi) or die(mysql_error());
$row_head = mysql_fetch_assoc($head);

if (isset($_GET['totalRows_head'])) {
  $totalRows_head = $_GET['totalRows_head'];
} else {
  $all_head = mysql_query($query_head);
  $totalRows_head = mysql_num_rows($all_head);
}
$totalPages_head = ceil($totalRows_head/$maxRows_head)-1;

$queryString_head = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_head") == false && 
        stristr($param, "totalRows_head") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_head = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_head = sprintf("&totalRows_head=%d%s", $totalRows_head, $queryString_head);
?><?php
  echo date("F j, Y");
  
  ?>
  </form>

      <h2>Welcome</h2>
	  
	  <?php require_once('../Connections/westi.php'); ?>
<?php
error_reporting(0);//$logo = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE info SET name=%s, logo=%s, motto=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['logo'], "text"),
                       GetSQLValueString($_POST['motto'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_westi, $westi);
  $Result1 = mysql_query($updateSQL, $westi) or die(mysql_error());
  echo "Update succesful";
    echo '<META http-equiv="refresh" content="3; URL=home.php">';
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_head = 10;
$pageNum_head = 0;
if (isset($_GET['pageNum_head'])) {
  $pageNum_head = $_GET['pageNum_head'];
}
$startRow_head = $pageNum_head * $maxRows_head;

mysql_select_db($database_westi, $westi);
$query_head = "SELECT * FROM info";
$query_limit_head = sprintf("%s LIMIT %d, %d", $query_head, $startRow_head, $maxRows_head);
$head = mysql_query($query_limit_head, $westi) or die(mysql_error());
$row_head = mysql_fetch_assoc($head);

if (isset($_GET['totalRows_head'])) {
  $totalRows_head = $_GET['totalRows_head'];
} else {
  $all_head = mysql_query($query_head);
  $totalRows_head = mysql_num_rows($all_head);
}
$totalPages_head = ceil($totalRows_head/$maxRows_head)-1;

$queryString_head = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_head") == false &&
        stristr($param, "totalRows_head") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_head = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_head = sprintf("&totalRows_head=%d%s", $totalRows_head, $queryString_head);
//echo '<META http-equiv="refresh" content="3; URL=home.php">';
?>


    <form method="post"  name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return proceed()">
  <table align="center"class="bg-transition">

    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="name" value="<?php echo $row_head['name']; ?>" ></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Logo:</td>
      <td bordercolorlight="#CCCCCC"><input type="file" name="logo" accept="image/*" value="<?php echo $row_head['logo']; ?>" required /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Motto:</td>
      <td><input type="text" name="motto" value="<?php echo $row_head['motto']; ?>" ></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update Company Info." style="background-color:#0099FF"></td>
    </tr>

  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_head['id']; ?>">
</form>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr><td></td><td>
	<a href="transporter.php"><input name="transporters" type="button" value="Add Transporter" title="Click To Add New Transporter" style="background-color:#0099FF"/></a>
	</td></tr></table>
	<p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
<div id="footer">
&copy;<?php
  echo date("Y");
  ?>  Dee Designers                     <div class="help"> <a href="help.php" title="Click to get Help">Help</a></div>


</div>
</body>
</html>
<?php
mysql_free_result($head);
?>

