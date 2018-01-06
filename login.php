<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/main.css">
        <title>Admin login Page</title>
    </head>
    <body>
        <h2>Admin login</h2>
        <form action="checklogin.php" method="POST">
           Username: <input type="text" name="username" required="required" /> <br/>
           Password: <input type="password" name="password" required="required" /> <br/>
           <input type="submit" id ="loginbtn" value="Login"/>
        </form>
    </body>
</html>

<?php
//if(isset($_SESSION['user'])) {
//     header("Location: /home.php"); // redirects them to homepage
//     exit;
//}
//prevent someone from using the back button by not adding additional entries to their browser history
    //if(!isset($_SESSION['username'])) {
    //   include_once("login.php");
    //   exit;
    //}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = mysqli_real_escape_string($_POST['username']);
    $password = mysqli_real_escape_string($_POST['password']);

    echo "Username entered is: ". $username . "<br/>";
    echo "Password entered is: ". $password;
}
?>
