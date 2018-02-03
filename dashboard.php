<?php
require 'dbConnect.php';
session_start(); //starts the session
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Lib CSS -->
        <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
        <!-- App CSS -->
        <link rel="stylesheet" href="css/main.css">
        <title>Dashboard</title>
    </head>
    <body>
        <?php
            if($_SESSION['user']){ //checks if user is logged in
            }
            else{
                mysqli_close($con);
                header("location:login.php"); // redirects if user is not logged in
            }
            $user = $_SESSION['user']; //assigns user value

            $query = mysqli_query($con,"SELECT is_superAdmin FROM Admin WHERE username='$user';");
            $fetched_row = mysqli_fetch_row($query);
            $is_superAdmin = $fetched_row[0];
            mysqli_close($con);
        ?>
        <div id="implinks">
            <a id="addadmin" href="admin.html" onclick="sessionStorage.clear();">Add Admin</a>
            <a id="showadmins" href="adminsList.html">Show Admin List</a>
            <a href="member.html" onclick="sessionStorage.clear();">Add member</a>
            <a href="search.html">Search Members</a>
<!--            <a href="logout.php">Click here to logout</a><br/><br/>    -->
        </div>
        <?php require 'logout_modal.php';
        ?>
        <!-- Logout modal -->
<!--
        <button type="button" class="btn btn-default btn-sm" id="logoutbtn" data-toggle="modal" data-target=".bs-example-modal-sm">
          <span class="glyphicon glyphicon-log-out"></span>
        </button>

        <div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
             <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Log Out</h4>
            </div>
              <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
              <div class="modal-footer"><a href="logout.php" class="btn btn-primary btn-block">Logout</a></div>
            </div>
          </div>
        </div>
-->
        <!-- Lib Scripts -->
        <script src="lib/jquery.min.js"></script>
        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <!-- App Scripts -->
        <script type="text/javascript">
            var logged_user='<?php echo $user;?>';
            var is_superAdmin='<?php echo $is_superAdmin;?>';
//            alert(logged_user);
//            alert(is_superAdmin);
            if(is_superAdmin === "N")
            {
                document.getElementById("addadmin").removeAttribute('href');
                document.getElementById("addadmin").style.display='none';
                document.getElementById("showadmins").removeAttribute('href');
                document.getElementById("showadmins").style.display='none';
            }
        </script>
    </body>
</html>
