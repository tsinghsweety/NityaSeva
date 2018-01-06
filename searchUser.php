<!DOCTYPE html>
<html>
    <head>
      <title>Search User</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
<!--      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<!--      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!--      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="css/searchUser.css">
    </head>
    <?php
        session_start();
    ?>
    <body>
      <a href="home.php"><span class="glyphicon glyphicon-home"></span></a><br/><br/>
<!--      <a href="home.php">Click here to go back</a><br/><br/>-->
        <h3>Search member by:</h3>
      <form action="searchUser.php" method="POST">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-1">Phone_no:</div>
                  <div class="col-md-1"><input type="text" name="phone_no" id ="phone_no" required="required"/> </div>
              </div>
              <div class="row" id="searchbtns">
                  <div class="col-md-1"><button type="submit" name="pmt_button" class="btn btn-primary">Payment Info</button></div>
                  <div class="col-md-1"><button type="submit" name="gp_button" class="btn btn-primary">Gift/Prasadam</button></div>
                  <div class="col-md-1"><button type="button" class="btn btn-primary">SMS</button></div>
              </div>
          </div>
      </form>
    </body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $con=mysqli_connect("localhost","root","","Admin_db");

        // Check connection
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $phone_no = mysqli_real_escape_string($con,$_POST['phone_no']);
        $result_query = mysqli_query($con,"SELECT user_id FROM Users WHERE phone_no = '$phone_no';");
        $result_row = mysqli_fetch_row($result_query);
        $result = $result_row[0];
        if (!$result_row) {
            echo 'Could not run query: ' . mysqli_error($con);
            exit;
        }else{
//                var_dump($result_row);
//                echo("END");
//                var_dump($result);
                $user_id = $result;
        }
        $_SESSION['$user_id'] = $user_id;
         $_SESSION['$first_time_payment'] = "N";
        if (isset($_POST['pmt_button'])) {
            Print '<script>window.location.assign("payment.php");</script>';
        } else {
            if (isset($_POST['gp_button'])) {
                Print '<script>window.location.assign("giftPrasadam.php");</script>';
            }
        }
//        Print '<script>window.location.assign("payment.php");</script>';
    }
?>
