<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();}
?>
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
  $_SESSION['Username'] = NULL;
  $_SESSION['password'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['Username']);
  unset($_SESSION['UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "signin.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: Dennoh V's
 * Date: 2/9/2018
 * Time: 11:53 PM
 */
 if (!isset($_SESSION)) {
    session_start();
}

    if (empty($_SESSION['Username'])){
		$restrictGoTo = "signin.php?error=You must login first";
		 header("Location:". $restrictGoTo); 
 		//echo '<META http-equiv="refresh" content="3; URL="signin.php">';
		}

?>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
<!-- Top container -->
<div class="container header large padding" style="z-index:4">
    <button class="btn hide-large " onClick="nav_open();">MENU</button>
    <l style="float: right; margin-right: 3px;">KUI</l>&ensp;<img name="logo" src="" width="32" height="30" alt="">
</div>
<!-- NavigationMenu -->
<nav class="sidenav collapse animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
    <div class="container row">
        <div class="col s1">
            <img src="assets/images/male.png" class="circle margin-right" style="width:46px;">
        </div>
       
        <div class="col s2">
            <div class="dropdown"><a href="#" class="dropbtn"><span>Welcome,<br> <strong><?php echo $_SESSION['Username'];?></strong></span><br> </a>
                <div class="dropdown-content">
                    <a href="myprofile.php">My Profile</a>
                    <a href="<?php echo $logoutAction ?>">Logout</a>
                </div></div>
              
        </div>
    </div> <p>&nbsp;</p>
    <hr>
    <!--PageLinks-->
   
    <a href="home.php" class="padding-16 active">Home</a>
    <div class="dropdown"><a href="#" class="dropbtn padding-16">Account </a>
        <div class="dropdown-content">
                <a href="balance.php" class="padding-16">Balance</a>
                <a href="deposit.php" class="padding-16">Deposit</a>
            </div></div>
    <a href="calendar.php" class="padding-16">Calendar</a>
    <a href="news.php" class="padding-16">News</a>
    <a href="about.php" class="padding-16">About</a>
    </nav>
    <!-- Overlay effect when opening sidenav on small screens -->
<div class="overlay hide-large animate-opacity" onClick="nav_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
<header>
	<div class="head" style="border:solid 1px #333;">&diams;&ensp;Dashboard</div>
</header><br>
<div class="content"><b>&Xi;My personal details</b><br>
<table border="1" cellspacing="0">
	<tr>
    	<th>First Name</th>
        <th>Last Name</th>
        <th>Reg No.</th>
     </tr>
        <?php
		include 'connection.php';
		$Username=$_SESSION['Username'];
	$sql = " SELECT * FROM users,studdets WHERE users.email='$Username' AND studdets.email='$Username'";
$result = mysql_query($sql) or die(mysql_error()); 
                   If(mysql_num_rows($result)>0)
                   {
                     while($row=mysql_fetch_array($result))
                     {  
						?>
                        <tr>
                        	<td><?php echo $row['fName']; ?></td>
                            <td><?php echo $row['lName']; ?></td>
                            <td><?php echo $row['regNo']; ?></td>
                          </tr>
                        <?php }} ?>
                        </table>
</div><br>
<div class="content"><b>&Xi;&ensp;Registration Status</b><br>
<table border="1" cellspacing="0">
	<tr><th></th><th></th></tr>
    <tr><td></td><td></td></tr>
</table>
</div>
</body>
</html>
<script>
    // Get the Sidenav
    var mySidenav = document.getElementById("mySidenav");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidenav, and add overlay effect
    function nav_open() {
        if (mySidenav.style.display === 'block') {
            mySidenav.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidenav.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    // Close the sidenav with the close button
    function nav_close() {
        mySidenav.style.display = "none";
        overlayBg.style.display = "none";
    }
</script>



