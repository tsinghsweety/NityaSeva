<?php
require 'dbConnect.php';
session_start(); //starts the session
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="lib/bootstrap.min.css">-->
<!--        <script src="lib/jquery.min.js"></script>-->
<!--        <script src="lib/bootstrap.min.js"></script>-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Bootstrap Date-Picker Plugin -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
        <link rel="stylesheet" href="css/giftPrasadam.css">
        <title>Gift/Prasadam Info Page</title>
    </head>
    <?php
        $user_id = $_SESSION['$user_id'];

        //FETCH FIRST NAME AND LAST NAME OF USER
        $fetch_user_info_query = mysqli_query($con,"SELECT title,first_name,last_name,user_lang FROM Users WHERE user_id='$user_id';");
        $fetched_row = mysqli_fetch_row($fetch_user_info_query);
        $title = $fetched_row[0];
        $first_name = $fetched_row[1];
        $last_name = $fetched_row[2];
        $user_lang = $fetched_row[3];
        $user_lang = $fetched_row[3];
     ?>
    <body>
<!--        <a href="searchUser.php">Click here to go back</a><br/><br/>-->
        <a href="searchUser.php"><span class="glyphicon glyphicon-home"></span></a><br/><br/>
        <h2>Gift/Prasadam Info Page</h2>
        <?php require 'logout_modal.php';
        ?>
        <form action="giftPrasadam.php" method="POST">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">Title:</div>
                    <div class="col-md-2"><input type="text" name="first_name" value="<?=$title?>" disabled/></div>
                    <div class="col-md-2">First Name:</div>
                    <div class="col-md-2"><input type="text" name="first_name" value="<?=$first_name?>" disabled/></div>
                    <div class="col-md-2">Last Name:</div>
                    <div class="col-md-2"><input type="text" name="last_name" value="<?=$last_name?>" disabled/></div>
                </div>
                <div class="row">
                    <div class="col-md-2">BTG Language:</div>
                    <div class="col-md-2"><input type="text" name="btg_lang" value="<?=$user_lang?>" disabled/></div>
                    <div class="col-md-2"><label for="sel1_pt">Type:</label></div>
                    <div class="col-md-2"><select class="form-control" id="sel1_pt"  name="type" width="10%">
                        <option>BTG</option>
                        <option>Gift</option>
                        <option>Prasadam</option>
                        </select>
                    </div>
                    <div class="col-md-2">Details:</div>
                    <div class="col-md-2"><textarea rows="4" cols="50" name="details" required="required"></textarea></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Dispatched:</div>
                    <div class="col-md-2">
                       <input type="radio" name="is_dispatched" required="required" value="Y"/> Yes
                       <input type="radio" name="is_dispatched" required="required" value="N"/> No
                    </div>
                    <div class="col-md-2"><label class="control-label" for="date">Date of Dispatch:</label></div>
                    <div class="col-md-2"><input id="date" name="dispatch_date" placeholder="DD/MM/YYYY" type="text"/></div>

                <script>
                    $(document).ready(function(){
                      var date_input=$('input[name="dispatch_date"]'); //our date input has the name "dispatch_date"
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
                    <div class="col-md-2">Remarks: </div>
                    <div class="col-md-2"><input type="text" name="gp_remarks" required="required" /></div>
                </div>
            </div>



            <input type="submit" id="gp" value="Add Entry"/>
        </form>
    </body>
</html>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
//    $btg_lang = mysql_real_escape_string($_POST['btg_lang']);
    $btg_lang = $user_lang;
    $type = mysqli_real_escape_string($con,$_POST['type']);
    $details = mysqli_real_escape_string($con,$_POST['details']);
    $is_dispatched = mysqli_real_escape_string($con,$_POST['is_dispatched']);
    $dispatch_date = mysqli_real_escape_string($con,$_POST['dispatch_date']);
    $gp_remarks = mysqli_real_escape_string($con,$_POST['gp_remarks']);
    $bool = true;
//    mysql_connect("localhost", "root","") or die(mysql_error());
//    mysql_select_db("Admin_db") or die("Cannot connect to database");
//    $query = mysql_query("Select * from User_Payment"); // CHECK TO BE ADDED

    if($bool)
    {
        if($dispatch_date!=NULL)
        {
            $dateTime = date_create_from_format('d/m/Y',$dispatch_date);
            $formatted_dispatch_date = date_format($dateTime, 'Y-m-d');
        }else
        {
            $formatted_dispatch_date = "0000-00-00";
        }
//        $dateTime = date_create_from_format('d/m/Y',$dispatch_date);
//        $formatted_dispatch_date = date_format($dateTime, 'Y-m-d');
        $insert_query = "INSERT INTO User_Gift_Prasadam(user_id,btg_lang,type,details,is_dispatched,dispatch_date,gp_remarks) VALUES('$user_id','$btg_lang','$type','$details','$is_dispatched','$formatted_dispatch_date','$gp_remarks');";
//        echo($insert_query);
        mysqli_query($con,$insert_query);

        Print '<script>alert("Gift/prasadam details entered successfully!");</script>';
//        session_destroy();
        mysqli_close($con);
        $_SESSION['$user_id'] = "";
        Print '<script>window.location.assign("searchUser.php");</script>';
    }
    mysqli_close($con);

}
?>
