<?php
    require 'dbConnect.php';
    session_start(); //starts the session
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $bool = true;

//    mysqli_connect("localhost", "root", "") or die (mysqli_error()); //Connect to server
//    mysqli_select_db("Admin_db") or die ("Cannot connect to database"); //Connect to database
    $query = mysqli_query($con,"Select * from admin WHERE username='$username'"); // Query the Admin table
    $exists = mysqli_num_rows($query); //Checks if username exists
    $table_users = "";
    $table_password = "";
    if($exists > 0)
    {
       while($row = mysqli_fetch_assoc($query)) // display all rows from query
       {
          $table_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
          $table_password = $row['pwd']; // the first password row is passed on to $table_password, and so on until the query is finished
       }
       mysqli_close($con);
       if(($username == $table_users) && ($password == $table_password))// checks if there are any matching fields
       {
          if($password == $table_password)
          {
             $_SESSION['user'] = $username; //set the username in a session. This serves as a global variable
              $_SESSION['logged_in'] = true;
              $_SESSION['logged_in_user'] = $username;
             header("location: dashboard.php"); // redirects the user to the authenticated dashboard page
          }

       }
       else
       {
        Print '<script>alert("Incorrect Password!");</script>'; // Prompts the user
        Print '<script>window.location.assign("login.html");</script>'; // redirects to login.html
       }
    }
    else
    {
        Print '<script>alert("Incorrect username!");</script>'; // Prompts the user
        mysqli_close($con);
        Print '<script>window.location.assign("login.html");</script>'; // redirects to login.html
    }
?>
