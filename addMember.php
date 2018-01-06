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
        <link rel="stylesheet" href="css/addMember.css">
        <title>Member Add</title>
    </head>
    <?php
        session_start();
    ?>
    <body>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span></a><br/><br/>
        <h2>New Member</h2>
        <form action="addMember.php" method="POST">
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
               <div class="col-md-2">Address:</div>
               <div class="col-md-2"><textarea rows="4" cols="50" name="address" resizeable= "false" required="required"></textarea></div>
               <div class="col-md-2">Phone No.:</div>
               <div class="col-md-2"><input type="integer" name="phone_no" required="required" /></div>
               <div class="col-md-2">Whatsapp No.:</div>
               <div class="col-md-2"><input type="integer" name="whatsapp" required="required" /></div>
           </div>
           <div class="row" id="thirdrow">
               <div class="col-md-2">Email Id:</div>
               <div class="col-md-2"><input type="email" name="email_id" required="required" /></div>
               <div class="col-md-2"><label class="control-label" for="date">Start Date:</label></div>
               <div class="col-md-2"><input id="date" name="date" required="required" placeholder="DD/MM/YYYY" type="text"/></div>
               <div class="col-md-1"> Corresponder:</div>
               <div class="col-md-1">
                   <input type="radio" name="is_corresponder" id="cy" required="required" value="Y"/><label for="cy">Yes</label>
                   <input type="radio" name="is_corresponder" id="cn" required="required" value="N"/><label for="cn">No</label>
               </div>
               <div class="col-md-1">Active:</div>
               <div class="col-md-1">
                   <input type="radio" name="is_active" id="ay" required="required" value="Y"/><label for="ay">Yes</label>
                   <input type="radio" name="is_active" id="an" required="required" value="N"/><label for="an">No</label>
               </div>
           </div>
          </div>
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
          <div class="row form-group">
              <div class="col-md-2"><label for="sel1_bg">Bhakti Vriksha:</label></div>
              <div class="col-md-2"><select class="form-control" id="sel1_bg"  name="connected_to">
                <option>None</option>
                <option>BV1</option>
                <option>BV2</option>
                <option>BV3</option>
                <option>BV4</option>
                <option>BV5</option>
                <option>BV6</option>
                <option>BV7</option>
                <option>BV8</option>
                <option>Nitai</option>
                  </select>
              </div>
              <div class="col-md-2"><label for="sel1_bg">Scheme name:</label></div>
              <div class="col-md-2"><select class="form-control" id="sel1_sn"  name="scheme_name">
                <option>None</option>
                <option>Prabhupada Sevak</option>
                <option>Jagannath Sevak</option>
                <option>Govind Sevak</option>
              </select>
              </div>
              <div class="col-md-2"><label for="sel1_pt">Payment Type:</label></div>
              <div class="col-md-2"><select class="form-control" id="sel1_pt"  name="payment_type">
                <option>None</option>
                <option>Cash</option>
                <option>Cheque</option>
                <option>Card</option>
                <option>Online payment</option>
              </select>
              </div>
          </div>
          <div class="row form-group">
              <div class="col-md-2">Corresponder Name:</div>
              <div class="col-md-2"><input type="text" name="corresponder"/></div>
              <div class="col-md-2"><label for="sel1_ulang">Language Preferred:</label></div>
              <div class="col-md-2"><select class="form-control" id="sel1_ulang"  name="user_lang" width="10%">
                <option>English</option>
                <option>Hindi</option>
                <option>Bengali</option>
              </select>
              </div>
              <div class="col-md-2">Remarks: </div>
              <div class="col-md-2"><input type="text" name="remarks"/></div>
          </div>
           <input type="submit" id="memberadd" value="Add"/>
        </form>
    </body>
</html>

<?php
//session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = mysql_real_escape_string($_POST['title']);
    $first_name = mysql_real_escape_string($_POST['first_name']);
    $last_name = mysql_real_escape_string($_POST['last_name']);
    $address = mysql_real_escape_string($_POST['address']);
    $phone_no = mysql_real_escape_string($_POST['phone_no']);
    $whatsapp = mysql_real_escape_string($_POST['whatsapp']);
    $email_id = mysql_real_escape_string($_POST['email_id']);
    $start_date = mysql_real_escape_string($_POST['date']);
    $is_corresponder = mysql_real_escape_string($_POST['is_corresponder']);
    $is_active = mysql_real_escape_string($_POST['is_active']);
    $connected_to = mysql_real_escape_string($_POST['connected_to']);
    $scheme_name = mysql_real_escape_string($_POST['scheme_name']);
    $payment_type = mysql_real_escape_string($_POST['payment_type']);
    $corresponder = mysql_real_escape_string($_POST['corresponder']);
    $user_lang = mysql_real_escape_string($_POST['user_lang']);
    $remarks = mysql_real_escape_string($_POST['remarks']);
    $bool = true;
    $bool2 = true;

    mysql_connect("localhost", "root","") or die(mysql_error());
    mysql_select_db("Admin_db") or die("Cannot connect to database");
    $query = mysql_query("Select * from Users");
    $query2 = mysql_query("Select * from User_Donation");

    while($row = mysql_fetch_array($query))
    {
        $table_users = $row['phone_no'];
        if($phone_no == $table_users)
        {
            $bool = false;
            Print '<script>alert("Phone Number has been taken");</script>';
            Print '<<script>window.location.assign("addMember.php");</script>';
        }
    }

    if($bool)
    {
//        echo $title;
//        echo $phone_no;
//        echo $email_id;
//        echo $start_date;
        $dateTime = date_create_from_format('d/m/Y',$start_date);
        $formatted_date = date_format($dateTime, 'Y-m-d');
//        echo "FORMATTED DATE";
//        echo $formatted_date;
        $insert_query = "INSERT INTO Users(title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_corresponder,is_active,connected_to,user_lang) VALUES('$title','$first_name','$last_name','$address','$phone_no','$whatsapp','$email_id','$formatted_date','$is_corresponder','$is_active','$connected_to','$user_lang');";
        mysql_query($insert_query);

        $result_query = mysql_query("SELECT user_id FROM Users WHERE phone_no = '$phone_no';");
//        $check_query = "SELECT user_id FROM Users WHERE phone_no = '$phone_no';";
//        echo ($check_query);
//        echo ("above query");
        $result_row = mysql_fetch_row($result_query);
        $result = $result_row[0];
        if (!$result_row) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }else{
//                var_dump($result_row);
//                echo("END");
//                var_dump($result);
                $user_id = $result;
        }
        $searchSchemeId_query = mysql_query("SELECT scheme_id FROM Scheme WHERE scheme_name = '$scheme_name';");
//        $check_query = "SELECT scheme_id FROM Scheme WHERE scheme_name = '$scheme_name';";
//        echo ($check_query);
//        echo ("above query");
        $searched_row = mysql_fetch_row($searchSchemeId_query);
        $schemeId_result = $searched_row[0];
        if (!$result_row) {
            echo 'Could not run query: ' . mysql_error();
            exit;
        }else{
//                var_dump($searched_row);
//                echo("END");
//                var_dump($schemeId_result);
                $scheme_id = $schemeId_result;
        }

        $insert_query2 = "INSERT INTO User_Donation(user_id,scheme_id,scheme_name,payment_type,corresponder,remarks) VALUES('$user_id','$scheme_id','$scheme_name','$payment_type','$corresponder','$remarks');";
        mysql_query($insert_query2);
        $_SESSION['$user_id'] = $user_id;
        $_SESSION['$first_time_payment'] = "Y";
        Print '<script>alert("Successfully Registered!");</script>';
        Print '<script>window.location.assign("payment.php");</script>';

    }
}
?>
