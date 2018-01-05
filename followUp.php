<?php
ob_start();
require_once("db_connect.php");
session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <link rel="stylesheet" href="lib/bootstrap.min.css">-->
<!--    <script src="lib/jquery.min.js"></script>-->
<!--    <script src="lib/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="css/followUp.css">
    <title>Payment Info Page</title>
</head>
<?php
//    session_start(); //starts the session

 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
//    mysqli_connect("localhost", "root","") or die(mysqli_error());
//    mysqli_select_db("Admin_db") or die("Cannot connect to database");
    $query_hsRun =false;
    if(isset($_POST['user_id']))
    {
//        echo $_POST['user_id'];
        $user_id = $_POST['user_id'];
        $_SESSION['$user_id'] = $user_id;
    }else if(isset($_SESSION['$user_id'])){
        $user_id = $_SESSION['$user_id'];
//        echo("user id:".$user_id);
    } else {
        echo("please enter user id!");
    }

 }


//    mysqli_connect("localhost", "root","") or die(mysqli_error());
//    mysqli_select_db("Admin_db") or die("Cannot connect to database");
 //FETCH FIRST NAME AND LAST NAME OF USER
//    $chk_query = "SELECT first_name,last_name FROM Users WHERE user_id='$user_id';";
//    echo($chk_query);
    if($query_hsRun)
    {
        $title = $_SESSION['$title'];
        $first_name = $_SESSION['$first_name'];
        $last_name = $_SESSION['$last_name'];
    }else{
        $fetch_user_info_query = mysqli_query($con, "SELECT title,first_name,last_name FROM Users WHERE user_id='$user_id';");
        $query_hsRun = true;
        $fetched_row = mysqli_fetch_row($fetch_user_info_query);
        $title = $fetched_row[0];
        $first_name = $fetched_row[1];
        $last_name = $fetched_row[2];
    }
//    $fetch_user_info_query = mysqli_query("SELECT title,first_name,last_name FROM Users WHERE user_id='$user_id';");
//    $fetched_row = mysqli_fetch_row($fetch_user_info_query);
//    $title = $_SESSION['$title'];
//    $first_name = $_SESSION['$first_name'];
//    $last_name = $_SESSION['$last_name'];
//FETCH FOLLOWUP DATE, REMARKS, NEXT DATE
//        $fetch_user_info_query = mysqli_query("SELECT followup_date,followup_remark,nxt_followup_date FROM Follow_Up WHERE user_id='$user_id';");
//        $fetched_row = mysqli_fetch_row($fetch_user_info_query);
//        $followup_date = $fetched_row[0];
//        $followup_remark = $fetched_row[1];
//        $nxt_followup_date = $fetched_row[2];
//    }

     // FETCH SCHEME_ID
        $fetch_schemeId_query = mysqli_query($con, "SELECT scheme_id FROM User_Donation WHERE user_id='$user_id';");
        $fetched_schemIdrow = mysqli_fetch_row($fetch_schemeId_query);
        $scheme_id = $fetched_schemIdrow[0];
    //FETCH SCHEME INFO
        $fetch_schemeInfo_query = mysqli_query($con, "SELECT scheme_name,scheme_value FROM Scheme WHERE scheme_id='$scheme_id';");
        $fetched_schemeRow = mysqli_fetch_row($fetch_schemeInfo_query);
        $scheme_name = $fetched_schemeRow[0];
        $scheme_value = $fetched_schemeRow[1];
     $net_amt_paid=0;
     $fetch_amtpaid_query = mysqli_query($con, "SELECT amt_paid FROM User_Payment WHERE user_id='$user_id';");
            while($fetched_amtRow = mysqli_fetch_array($fetch_amtpaid_query))
            {
                $net_amt_paid = $net_amt_paid + $fetched_amtRow[0];
            }
//            echo ($net_amt_paid);
        $due_amt = $scheme_value - $net_amt_paid;

?>
<body>
    <a href="getMemberList.php"><span class="glyphicon glyphicon-home"></span></a><br/><br/>
    <h2>Follow Up Details</h2>
    <form action="followUp.php" method="POST">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">Title:</div>
                <div class="col-md-2"><input type="text" name="title" disabled value="<?=$title?>"/></div>
                <div class="col-md-2">First Name:</div>
                <div class="col-md-2"><input type="text" name="first_name" disabled value="<?=$first_name?>"/></div>
                <div class="col-md-2">Last Name:</div>
                <div class="col-md-2"><input type="text" name="last_name" disabled value="<?=$last_name?>"/> </div>
            </div>
            <div class="row">
                <div class="col-md-2"><label class="control-label" for="date">FollowUp Date: </label></div>
                <div class="col-md-2"><input id="date" name="followup_date" required="required" placeholder="DD/MM/YYYY" type="text"/></div>
                <div class="col-md-2">FollowUp Remarks:</div>
                <div class="col-md-2"><input type="text" name="followup_remark" required="required"/></div>
                <div class="col-md-2"><label class="control-label" for="date">Next FollowUp Date:</label></div>
                <div class="col-md-2"><input id="date" name="nxt_followup_date" required="required" placeholder="DD/MM/YYYY" type="text"/></div>
                <script>
                $(document).ready(function(){
                  var date_input=$('input[name="followup_date"]'); //our date input has the name "followup_date"
                  var nxtdate_input=$('input[name="nxt_followup_date"]'); //our date input has the name "nxt_followup_date"
                  var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                  var options={
                    format: 'dd/mm/yyyy',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                    orientation: 'auto top'
                  };
                  date_input.datepicker(options);
                  nxtdate_input.datepicker(options);
                })
            </script>
            </div>
            <div class="row">
                <div class="col-md-2">Due Amount:</div>
                <div class="col-md-2"><input type="text" name="due_amt" disabled value="<?=$due_amt?>"/></div>
            </div>
        </div>
        <input type="submit" id="followupbtn" value="Add Details"/>
    </form>
</body>
<?php
//session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
//    echo("FOR");
    $bool = false;
//    if($_SESSION['$user_id']!= NULL)
//    {
//        $user_id = $_SESSION['$user_id'];
//        echo($user_id);
//    }
    if(isset($_POST['followup_date']))
    {
        $followup_date = mysqli_real_escape_string($con, $_POST['followup_date']);
        $dateTime = date_create_from_format('d/m/Y',$followup_date);
        $formatted_followup_date = date_format($dateTime, 'Y-m-d');
    }
    if(isset($_POST['followup_remark']))
    {
//        echo("followup_remark");
        $followup_remark = mysqli_real_escape_string($con, $_POST['followup_remark']);
        $bool = true;
    }
    if(isset($_POST['nxt_followup_date']))
    {
        $nxt_followup_date = mysqli_real_escape_string($con, $_POST['nxt_followup_date']);
        $dateTime = date_create_from_format('d/m/Y',$nxt_followup_date);
        $formatted_nxt_followup_date = date_format($dateTime, 'Y-m-d');
    }

    if($bool)
    {
//        echo("CHECK");
//        echo($user_id);

        $insert_query = "INSERT INTO Follow_Up(user_id,followup_date,followup_remark,nxt_followup_date) VALUES('$user_id','$formatted_followup_date','$followup_remark','$formatted_nxt_followup_date');";
//        echo($insert_query);
        mysqli_query($con, $insert_query);

//        Print '<script>alert("Follow Up Remarks added");</script>';
//        $_SESSION['$user_id'] = $user_id;
        $_SESSION['$title'] = $title;
        $_SESSION['$first_name'] = $first_name;
        $_SESSION['$last_name'] = $last_name;
//        session_destroy();
        Print '<script>window.location.assign("getMemberist.php");</script>';
    }

}
?>
