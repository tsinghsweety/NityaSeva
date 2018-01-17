<?php
    $con=mysqli_connect("localhost","root","","Admin_db");
//    $con=mysqli_connect("adminmysql.nityasevakol.net","adminnityasevako","nitaigaur","adminnityasevakol");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
?>
