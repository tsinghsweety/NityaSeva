<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="lib/bootstrap/bootstrap-3.3.7-dist/fonts/">-->
<!--        <link rel="stylesheet" href="lib/bootstrap.min.css">-->
<!--        <script src="lib/jquery.min.js"></script>-->
<!--        <script src="lib/bootstrap.min.js"></script>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/main.css">
        <title>Dashboard</title>
    </head>
    <body>
        <?php
            session_start(); //starts the session
            if($_SESSION['user']){ //checks if user is logged in
            }
            else{
                header("location:login.php"); // redirects if user is not logged in
            }
            $user = $_SESSION['user']; //assigns user value
            
            $con=mysqli_connect("localhost","root","","Admin_db");

            // Check connection
            if (mysqli_connect_errno()) {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
//            mysqli_connect("localhost", "root","") or die(mysqli_error());
//            mysqli_select_db("Admin_db") or die("Cannot connect to database");
            $query = mysqli_query($con,"SELECT is_superAdmin FROM Admin WHERE username='$user';");
            $fetched_row = mysqli_fetch_row($query);
            $is_superAdmin = $fetched_row[0];
        ?>
        <div id="implinks">
            <a id="addadmin" href="addAdmin.php"> Add Admin</a>
            <a href="addMember.php"> Add member</a>
            <a href="searchUser.php"> Search User</a>
            <a href="getMemberList.php"> Get Member List</a>
<!--            <a href="logout.php">Click here to logout</a><br/><br/>    -->
        </div>
        <!-- Logout modal -->
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
        <script type="text/javascript">
            var logged_user='<?php echo $user;?>';
            var is_superAdmin='<?php echo $is_superAdmin;?>';
//            alert(logged_user);
//            alert(is_superAdmin);
            if(is_superAdmin === "N")
            {
//                document.getElementById("adminlogin").removeAttribute('href');
//                document.getElementById("adminlogin").style.display='none';
                document.getElementById("addadmin").removeAttribute('href');
                document.getElementById("addadmin").style.display='none';
            }
        </script>
    </body>
</html>
