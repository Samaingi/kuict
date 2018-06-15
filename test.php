<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>menu test</title>
<link rel="stylesheet" type="text/css" href="assets/css/st.css" />
</head>

<body>
<div class="header">  <button class="btn hide-large " onClick="nav_open();">MENU</button>
<nav class="sidenav collapse animate-left" id="mySidenav"><br>
  <a href="home.php" class="active">Home</a>
    <a href="referrals.php">Calendar</a>
    <a href="history.php">News</a>
    <a href="about.php">About</a>
    </nav>
</nav>
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