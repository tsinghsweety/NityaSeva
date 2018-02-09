<?php
require 'dbConnect.php';
session_start(); //starts the session
?>
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

    <body>
      <a href="getMemberList.php"><span class="glyphicon glyphicon-home"></span></a><br/><br/>
      <h2>Member Info Page</h2>
      <?php require 'logout_modal.php';
      ?>

    </body>
</html>
<?php
        $selected_id = $_GET['user_id_clicked'];
        echo "$selected_id";
        $search_query =  mysqli_query($con,"SELECT title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang FROM Users WHERE user_id = '$selected_id';");
        $records = mysqli_fetch_assoc($search_query);
        $records_array = (array)$records;
        $records_keys = array_keys($records_array);
        $records_values = array_values($records_array);
        $key_array  = array();
        $value_array  = array();
        $n=0;
//        $m++;
//    print_r($records_keys);
        foreach($records_keys as $record_key)
        {
//            ++$n;
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
//                $m--;
            }
        }
        echo "<h4>Personal Details<h4>";
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

        $pmt_query =  mysqli_query($con,"SELECT payment_date,amt_paid,payment_type,payment_details FROM User_Payment WHERE user_id = '$selected_id';");
//        $rowcount=mysqli_num_rows($pmt_query);
//        printf("Result set has %d rows.\n",$rowcount);
        $pmt_row = array();
        echo "<h4>Payment History<h4>";
        echo "<table border='1'><tr>";
        $pmtvalue_array  = array();
        while($pmt_row =  mysqli_fetch_assoc($pmt_query)) {
//            $result_row[] = $pmt_row['user_id'];
            $resultArray[] = $pmt_row;
                 $pm =0;
            foreach ($resultArray as $pmt_row){
                $pn=0;
                $pm++;
                $pmt_records_array = (array)$pmt_row;
//                    print_r($pmt_records_array);
                $pmt_keys = array_keys($pmt_records_array);
                $pmt_values = array_values($pmt_records_array);
                $pmtkey_array  = array();
                foreach($pmt_keys as $pmt_key)
                {
                    ++$pn;
                    array_push($pmtkey_array,$pmt_key);
                }
            }
            foreach($pmt_values as $pmt_value)
                {
                    if($pmt_value)
                    {
                        array_push($pmtvalue_array,$pmt_value);
                    }else{
                        $pm--;
                    }
                }
        }
//echo $pm;
//echo $pn;
        $spltdstrng_pmtkey=explode(" ",implode(" ",$pmtkey_array));
        foreach ($spltdstrng_pmtkey as $key => $value) {
//            if($value!="user_id"){
                echo "<th>$value</th>";
//            }
        }
            echo "</tr><br><tr>";
        $count = 0;
        foreach($pmtvalue_array as $pmt_vals)
        {
//            print_r($pmt_vals);
                $count++;
                if($count==$pn)
                {
                    $count = 0;
                    echo "<td>$pmt_vals</td>";
                    echo "</tr><tr>";
                }else{
                        echo "<td>$pmt_vals</td>";
                }
        }
        echo "</tr><br>";
        echo "</table>";
        echo "<h4>Followup History<h4>";
        echo "<table border='1'><tr>";
    ?>
