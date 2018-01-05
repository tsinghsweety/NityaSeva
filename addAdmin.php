<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="lib/bootstrap.min.css">-->
<!--        <script src="lib/jquery.min.js"></script>-->
<!--        <script src="lib/bootstrap.min.js"></script>/script>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Bootstrap Date-Picker Plugin -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
        <link rel="stylesheet" href="css/addAdmin.css">
        <title>Admin</title>
    </head>
    <?php
//        session_start();
    ?>
    <body>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span></a><br/><br/>
        <h2>Add New Admin</h2>
        <form action="addAdmin.php" method="POST">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-2">Title:</div>
                  <div class="col-md-2"><input type="text" name="title" required="required" /></div>
                  <div class="col-md-2">First Name:</div>
                  <div class="col-md-2"><input type="text" name="first_name" required="required" /></div>
                  <div class="col-md-2">Last Name:</div>
                  <div class="col-md-2"><input type="text" name="last_name" required="required" /></div>
              </div>
              <div class="row">
                  <div class="col-md-2">Phone No.:</div>
                  <div class="col-md-2"><input type="integer" name="phone_no" required="required" /></div>
                  <div class="col-md-2">Email Id:</div>
                  <div class="col-md-2"><input type="email" name="email_id" required="required" /></div>
                  <div class="col-md-2"><label class="control-label" for="date">Start Date:</label></div>
                  <div class="col-md-2"><input id="date" name="date" required="required" placeholder="DD/MM/YYYY" type="text"/></div>
                  <script>
                    $(document).ready(function(){
                      var date_input=$('input[name="date"]'); //our date input has the name "date"
                      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                      var options={
                        format: 'dd/mm/yyyy',
                        container: container,
                        todayHighlight: true,
                        autoclose: true,
                        orientation: 'auto top'
                      };
                      date_input.datepicker(options);
                    })
                </script>
              </div>
              <div class="row">
                  <div class="col-md-2">Username:</div>
                  <div class="col-md-2"><input type="text" name="username" required="required" /></div>
                  <div class="col-md-2">Password:</div>
                  <div class="col-md-2"><input type="password" name="password" required="required" /></div>
              </div>
          </div>
           <input type="submit" id="addbtn" value="Save"/>
        </form>
    </body>
</html>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = mysql_real_escape_string($_POST['title']);
    $first_name = mysql_real_escape_string($_POST['first_name']);
    $last_name = mysql_real_escape_string($_POST['last_name']);
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $phone_no = mysql_real_escape_string($_POST['phone_no']);
    $email_id = mysql_real_escape_string($_POST['email_id']);
    $start_date = mysql_real_escape_string($_POST['date']);
    $is_superAdmin = "N";
    $bool = true;

    mysql_connect("localhost", "root","") or die(mysql_error());
    mysql_select_db("Admin_db") or die("Cannot connect to database");
    $query = mysql_query("Select * from Admin");

    while($row = mysql_fetch_array($query))
    {
        $table_admins = $row['username'];
        if($username == $table_admins)
        {
            $bool = false;
            Print '<script>alert("Username has been taken");</script>';
            Print '<<script>window.location.assign("addAdmin.php");</script>';
        }
    }
    if($bool)
    {
//        echo $start_date;
        $dateTime = date_create_from_format('d/m/Y',$start_date);
        $formatted_date = date_format($dateTime, 'Y-m-d');
        $insert_query = "INSERT INTO Admin(title,first_name,last_name,username,pwd,phone_no,email_id,start_date,is_superAdmin) VALUES('$title','$first_name','$last_name','$username','$password','$phone_no','$email_id','$formatted_date','$is_superAdmin');";
//        echo($insert_query);
//        mysql_query($insert_query);
        if(mysql_query($insert_query))
        {
            Print '<script>alert("Successfully Added!");</script>';
            Print '<script>window.location.assign("home.php");</script>';
        }else{
            Print '<script>alert("NOT ADDED YET");</script>';
        }

//        $_SESSION['$user_id'] = $user_id;
//        Print '<script>alert("Successfully Added!");</script>';
//        Print '<script>window.location.assign("login.php");</script>';

    }
}
?>
