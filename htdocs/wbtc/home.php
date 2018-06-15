<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}?>
<?php require_once('Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "User,Admin";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php#account?error=Restricted page";
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_DetailRS1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn, $conn);
$query_DetailRS1 = sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_DetailRS1, "text"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $conn) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;

$maxRows_withdrawals = 10;
$pageNum_withdrawals = 0;
if (isset($_GET['pageNum_withdrawals'])) {
  $pageNum_withdrawals = $_GET['pageNum_withdrawals'];
}
$startRow_withdrawals = $pageNum_withdrawals * $maxRows_withdrawals;
if (isset($_SESSION['MM_Username'])) {
  $colname_withdrawals = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn, $conn);
$query_withdrawals = sprintf("SELECT * FROM withdrawals WHERE withdrawals.email=%s ORDER BY withdrawals.time DESC",GetSQLValueString($colname_DetailRS1, "text"));
$query_limit_withdrawals = sprintf("%s LIMIT %d, %d", $query_withdrawals, $startRow_withdrawals, $maxRows_withdrawals);
$withdrawals = mysql_query($query_limit_withdrawals, $conn) or die(mysql_error());
$row_withdrawals = mysql_fetch_assoc($withdrawals);

if (isset($_GET['totalRows_withdrawals'])) {
  $totalRows_withdrawals = $_GET['totalRows_withdrawals'];
} else {
  $all_withdrawals = mysql_query($query_withdrawals);
  $totalRows_withdrawals = mysql_num_rows($all_withdrawals);
}
$totalPages_withdrawals = ceil($totalRows_withdrawals/$maxRows_withdrawals)-1;

$queryString_withdrawals = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_withdrawals") == false && 
        stristr($param, "totalRows_withdrawals") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_withdrawals = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_withdrawals = sprintf("&totalRows_withdrawals=%d%s", $totalRows_withdrawals, $queryString_withdrawals);
?>
<!DOCTYPE html>
<html>
<title>World Crypto Currency Mining</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
    <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();">&#9776;</button>
    <l style="float: right; margin-right: 3px;">Logo</l>
</div>

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
    <div class="w3-container w3-row">
        <div class="w3-col s4">
            <img src="images/female.png" class="w3-circle w3-margin-right" style="width:46px">
        </div>
        <div class="w3-col s8">
            <div class="dropdown"><a href="#" class="dropbtn"><span>Welcome, <strong><?php echo $row_DetailRS1['fName']; ?></strong></span><br> </a>
                <div class="dropdown-content">
                    <a href="myprofile.php">My Profile</a>
                    <a href="logout.php">Logout</a>
                </div></div
            ><a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-envelope"></i></a>
            <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
            <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5>Dashboard</h5>
    </div>
    <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="home.php" class="w3-padding w3-blue">Home</a>
    <a href="deposit.php" class="w3-padding">Deposit</a>
    <div class="dropdown"><a href="#" class="dropbtn">Account </a>
        <div class="dropdown-content">
                <a href="balance.php">Balance</a>
                <a href="withdraw.php">Withdraw</a>
            </div></div>
    <a href="referrals.php" class="w3-padding">Referrals</a>
    <a href="upgrade.php" class="w3-padding">Upgrade</a>
    <a href="history.php" class="w3-padding">History</a>
    <a href="about.php" class="w3-padding">About</a>
    </nav>


<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>

    </header>


            <div class="w3-container w3-padding-16">
               <style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #333;
    color: white;
}
</style> <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="45%">User Details</th>
      </tr>
  <tr>
    <td><b>Full Name:</b>   <?php echo $row_DetailRS1['fName']; ?>  <?php echo $row_DetailRS1['lName']; ?><br>
    <b>Email address:</b>   <?php echo $row_DetailRS1['email']; ?>  <br> 
    <b>Phone Number:</b> <?php echo $row_DetailRS1['phone']; ?></td>
    
  </tr>
</table><br>
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                    	<tr>
        <th width="55%">Withdrawal history</th>
    </tr>
  <td>
      <?php do { ?> 
        <a href="withdawals.php?recordID=<?php echo $row_withdrawals['email']; ?>" ></a>You Withdrew $<?php echo $row_withdrawals['amount']; ?>&nbsp;
		on <?php echo $row_withdrawals['time']; ?>&nbsp;<br> 
		
        <?php } while ($row_withdrawals = mysql_fetch_assoc($withdrawals)); ?>
    
      <br>
      
        <?php if ($pageNum_withdrawals > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_withdrawals=%d%s", $currentPage, 0, $queryString_withdrawals); ?>">First</a>
              <?php } // Show if not first page ?> 
               <?php if ($pageNum_withdrawals > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_withdrawals=%d%s", $currentPage, max(0, $pageNum_withdrawals - 1), $queryString_withdrawals); ?>">Previous</a>
              <?php } // Show if not first page ?>
          <?php if ($pageNum_withdrawals < $totalPages_withdrawals) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_withdrawals=%d%s", $currentPage, min($totalPages_withdrawals, $pageNum_withdrawals + 1), $queryString_withdrawals); ?>">Next</a>
              <?php } // Show if not last page ?>
          <?php if ($pageNum_withdrawals < $totalPages_withdrawals) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_withdrawals=%d%s", $currentPage, $totalPages_withdrawals, $queryString_withdrawals); ?>">Last</a>
              <?php } // Show if not last page ?>
       
      
     Records <?php echo ($startRow_withdrawals + 1) ?> to <?php echo min($startRow_withdrawals + $maxRows_withdrawals, $totalRows_withdrawals) ?> of <?php echo $totalRows_withdrawals ?></td></tr></table><br>
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                    <tr>
  <tr>
    <th>Referral Link</th>
  </tr>
     <tr>
         <td><a href="index.php?inviter=<?php echo $_SESSION['MM_Username'];?>">www.wbtc.com/index.php?inviter=<?php echo $_SESSION['MM_Username'];?></a></td>
     </tr>
 </table><br>
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                    <tr>
  <tr>
      <th>Investment Plan</th>
  </tr>
     <tr>
    <td>Basic</td>
  </tr>
</table>
  </div>

    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
              <p>Powered by <a href="#" target="_blank">WCCM</a></p>
    </footer>

    <!-- End page content -->
</div>

<script>
    // Get the Sidenav
    var mySidenav = document.getElementById("mySidenav");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidenav, and add overlay effect
    function w3_open() {
        if (mySidenav.style.display === 'block') {
            mySidenav.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidenav.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    // Close the sidenav with the close button
    function w3_close() {
        mySidenav.style.display = "none";
        overlayBg.style.display = "none";
    }
</script>

</body>
</html>
<?php
mysql_free_result($DetailRS1);

mysql_free_result($withdrawals);
?>
