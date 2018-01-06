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
      <link rel="stylesheet" href="css/getMemberList.css">
    </head>
    <?php
        session_start();
    ?>
    <body>
      <a href="dashboard.php"><span class="glyphicon glyphicon-home"></span></a><br/><br/>
      <h2>Member List</h2>
      <form action="getMemberList.php" method="POST">
       <div class="container-fluid">
        <div class="form-group">
            <div class="col-md-2"><label for="sel1_pt">Search By:</label></div>
              <script type="text/javascript">
                function configureDropDownLists(ddl1,ddl2) {
                var donation_category = ['Prabhupada Sevak', 'Jagannath Sevak', 'Govind Sevak'];
                var is_active = ['Y', 'N'];
                var is_due = ['Y', 'N'];
                var corresponder = ['Prashant', 'HG Sevyagovind Pr','Devajyoti'];
                var connected_to = ['BV1', 'BV2','BV3', 'BV4','BV5', 'BV6','BV7', 'BV8','Nitai'];

                switch (ddl1.value) {
                    case 'Donation Category':
                        ddl2.options.length = 0;
                        for (i = 0; i < donation_category.length; i++) {
                            createOption(ddl2, donation_category[i], donation_category[i], "scheme_name");
                        }
                        break;
                    case 'Active':
                        ddl2.options.length = 0;
                    for (i = 0; i < is_active.length; i++) {
                        createOption(ddl2, is_active[i], is_active[i], "is_active");
                        }
                        break;
                    case 'Payment Due':
                        ddl2.options.length = 0;
                        for (i = 0; i < is_due.length; i++) {
                            createOption(ddl2, is_due[i], is_due[i], "is_due");
                        }
                        break;
                    case 'Corresponder':
                        ddl2.options.length = 0;
                    for (i = 0; i < corresponder.length; i++) {
                        createOption(ddl2, corresponder[i], corresponder[i], "corresponder");
                        }
                        break;
                    case 'Connected To':
                        ddl2.options.length = 0;
                    for (i = 0; i < connected_to.length; i++) {
                        createOption(ddl2, connected_to[i], connected_to[i], "connected_to");
                        }
                        break;
                        default:
                            ddl2.options.length = 0;
                        break;
                }}
                function createOption(ddl, text, value,name) {
                    var opt = document.createElement('option');
                    opt.value = value;
                    opt.text = text;ddl.options.add(opt);
                    document.getElementsByTagName("select")[1].setAttribute("name", name);
//                    alert(name);
                }
              </script>
        <div class="col-md-2">
        <select id="ddl" onchange="configureDropDownLists(this,document.getElementById('ddl2'))">
        <option value="">Select</option>
        <option value="Donation Category" name="scheme_name">Donation Category</option>
        <option value="Active" name="is_active">Active</option>
        <option value="Payment Due" name="is_due">Payment Due</option>
        <option value="Corresponder" name="corresponder">Corresponder</option>
        <option value="Connected To" name="connected_to">Connected To</option>
        </select></div>
        <div class="col-md-2">
        <select id="ddl2">
        </select></div>
        </div>
       </div>
       <button type="submit" name="pmt_button" id="pmt_button" class="btn btn-primary">Get List</button>
      </form>
    </body>
</html>

<?php require 'dbConnect.php';
//    $con=mysqli_connect("localhost","root","","Admin_db");
//
//    // Check connection
//    if (mysqli_connect_errno()) {
//      echo "Failed to connect to MySQL: " . mysqli_connect_error();
//    }
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
         if(isset($_POST['scheme_name']))
            {
                if($_POST['scheme_name']!=NULL)
                {
                    $scheme_name = mysqli_real_escape_string($con,$_POST['scheme_name']);
                    $selected_opt = "scheme_name";
                    $selected_val = $scheme_name;
                    $table_name = "User_Donation";
                }
            }
        if(isset($_POST['is_active']))
            {
                if($_POST['is_active']!=NULL)
                {
                    $is_active = mysqli_real_escape_string($con,$_POST['is_active']);
                    $selected_opt = "is_active";
                    $selected_val = $is_active;
                    $table_name = "Users";
                }
            }
        if(isset($_POST['is_due']))
        {
            if($_POST['is_due']!=NULL)
            {
                $is_due = mysqli_real_escape_string($con,$_POST['is_due']);
                $selected_opt = "is_due";
                $selected_val = $is_due;
                $table_name = "User_Due";
            }
        }
        if(isset($_POST['corresponder']))
        {
            if($_POST['corresponder']!=NULL)
            {
                $corresponder = mysqli_real_escape_string($con,$_POST['corresponder']);
                $selected_opt = "corresponder";
                $selected_val = $corresponder;
                $table_name = "User_Donation";
            }
        }
        if(isset($_POST['connected_to']))
        {
            if($_POST['connected_to']!=NULL)
            {
                $connected_to = mysqli_real_escape_string($con,$_POST['connected_to']);
                $selected_opt = "connected_to";
                $selected_val = $connected_to;
                $table_name = "Users";
            }
        }
//        mysql_connect("localhost", "root","") or die(mysql_error());
//        mysql_select_db("Admin_db") or die("Cannot connect to database");
        if($selected_val==NULL){
            Print '<script>alert("Select an option!");</script>';
            Print '<script>window.location.assign("getMemberList.php");</script>';
        }
        $result_query = mysqli_query($con,"SELECT user_id FROM $table_name WHERE $selected_opt = '$selected_val';");
        $query_check = "SELECT user_id FROM $table_name WHERE $selected_opt = '$selected_val';";
//        echo($query_check);
        $result_row = array();

        while($row =  mysqli_fetch_assoc($result_query)) {
            $result_row[] = $row['user_id'];
        }
//        var_dump($result_row);
        if (!$result_row) {
            echo 'No matching record found ' . mysqli_error($con);
            exit;
        }else{
//            echo "user id<br>";
                //m=NUMBER OF ROWS  n =NUMBER OF COLUMNS
                $m =0;
                $value_array = array();
                foreach ($result_row as $value) {
//                    echo "$value <br>";
                    $record_query= mysqli_query($con,"SELECT * FROM Users WHERE user_id = '$value';");
                    $records = mysqli_fetch_assoc($record_query);
                    $records_array = (array)$records;
                    $records_keys = array_keys($records_array);
                    $records_values = array_values($records_array);
                    $key_array = array();
                    $n=0;
                    $m++;
                    foreach($records_keys as $record_key)
                    {
                        ++$n;
                        array_push($key_array,$record_key);
                    }
//                    print_r($records_values);
                    foreach($records_values as $record_value)
                    {
                        if($record_value)
                        {
//                            echo("$record_value: ");
                            array_push($value_array,$record_value);
                        }else{
//                            echo("User Info corresponding to user_id: ".$value."  does not exist! <br> ");
                            $m--;
                        }
                    }
                }
//                    echo("m:");
//                    echo($m);
//                    echo("n:");
//                    echo($n);
                         echo "<table border='1'><tr>";
                    $splittedstring_key=explode(" ",implode(" ",$key_array));
                    foreach ($splittedstring_key as $key => $value) {
                        echo "<th>$value</th>";
                    }
                        echo "</tr><br><tr>";
                    $count = 0;
                    foreach($value_array as $val)
                    {
                        $count++;
                        if($count==$n)
                        {
                            $count = 0;
                            echo "<td>$val</td>";
                            echo "</tr><tr>";
                        }else{
                            echo "<td>$val</td>";
                        }
                    }
                    echo "</tr><br>";
                    echo "</table>";
                    echo"<form action='followUp.php' method='POST'>
                    <div class='conatiner-fluid'>
                        <div class='row'>
                            <div class='col-md-2'>Enter user id:</div>
                            <div class='col-md-2'><input type='text' name='user_id' required='required' /></div>
                            <div class='col-md-2'><button type='submit' name='followup_btn' id='followup_btn' class='btn btn-primary'>Follow Up</button></div>
                        </div>
                    </div>";
                    echo "</form>";
//                    $_SESSION['$user_id'] = $_GET["user_id"];
//                    echo $_GET['user_id'];

             }
       // }
//                    $_SESSION['$user_id'] = $user_id;
//        Print '<script>window.location.assign("getMemberist.php");</script>';
    }
?>
