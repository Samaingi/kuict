<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 10/12/2017
 * Time: 5:53 PM
 */
error_reporting(0);
$nameErr = $emailErr = $passwordEqqrr = "";
$name = $email = $password = "";

$hasError = false;

//include the connection script
require_once "connection.php";

//check to see if the http request method is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $hasError = true;
    } else {
        $name = clean($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ']*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $hasError = true;
        }
    }
    // validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $hasError = true;
    } else {
        $email = clean($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $hasError = true;
        }
    }
    // validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $hasError = true;
    } else {
        $password = $_POST["password"];
        if (!preg_match("/^[a-zA-Z0-9\w {8}]/", $password)) {
            $passwordErr = "Invalid password format";
            $hasError = true;
        }
    }


    // continue adding user to the database
    if (!$hasError) {


        global $pdo;

        $query = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";

        $insertStmt = $pdo->prepare($query);

        $insertStmt->execute([
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
        ]);
        if ($insertStmt->rowCount() > 0) {
            header("location: index.php");
        }
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
    <main>
        <section class="panel">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name">
                    <span class="helper"><?php echo $nameErr; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <span class="helper"><?php echo $emailErr; ?></span>

                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <span class="helper"><?php echo $passwordErr; ?></span>
                </div>
                <div class="form-group">
                    <button type="submit" name="signup">Sign Up</button>
                    <a href="signin.php">have an account? <b>sign in</b></a>
                </div>
            </form>
        </section>
    </main>
    </body>
    </html>

<?php


/**
 * sanitizes the user input by escaping html
 * characters then removing backslashes
 * and finally removing whitespaces.
 *
 * @param $input
 * entered by the user
 * @return string
 * sanitized input data
 */
function clean($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

?>