<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 10/12/2017
 * Time: 7:40 PM
 */
if (!isset($_SESSION)) {
    session_start();
}
include 'connection.php';
error_reporting(0);
$email= $_POST['email'];
$password= $_POST['password'];
if(isset($_POST['submit']));{
    $query=mysql_query("SELECT * FROM users WHERE email='$email' && BINARY password='$password'");
    $result=mysql_num_rows($query);
    if($result>0){

        $_SESSION['Username']=$email;
        $_SESSION['Password']=$password;
        header("location:index.php");
    }
    else
    {
        $loginecho=("<span style='color:red;'>Invalid login attempt</span>");
        //echo '<META http-equiv="refresh" content="3; URL="signin.php">';
		
    }

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup page</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main >
    <section class="panel"><br /><span style='color:red;'><?php if (isset($_GET['error'])) {
  echo $_GET['error']; } ?></span>
			        <form action="<?php $_SERVER['PHP_SELF']?>" name="login" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <button type="submit" value="signin">Sign In</button>
                <a href="signup.php">no account? <b>sign up</b></a><br>

            </div><br />
            <?php if(isset($loginecho)){echo $loginecho;} ?>
        </form>
    </section>
</main>
</body>
</html>
