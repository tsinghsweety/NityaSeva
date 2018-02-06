<?php
require_once("../common/dbcontroller.php");
require_once("../common/CommonUtils.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class Payment {
	private $payments = array();
	public function getAllPayment(){
		if(isset($_GET['user_id'])){
			$user_id = $_GET['user_id'];
			$query = 'SELECT u.title, u.first_name,'
			.' u.last_name, u.user_id, up.payment_type, DATE_FORMAT(up.payment_date, "%d/%m/%Y") as payment_date,'
			.' up.amt_paid, up.payment_details, up.payment_remarks '
			.'FROM Users u, User_Payment up WHERE u.user_id=up.user_id and up.user_id=' .$user_id
			. ' ORDER BY up.payment_date DESC';
		} else {
			$query = 'SELECT u.title, u.first_name,'
			.' u.last_name, u.user_id, up.payment_type, DATE_FORMAT(up.payment_date, "%d/%m/%Y") as payment_date,'
			.' up.amt_paid, up.payment_details, up.payment_remarks '
			.'FROM Users u, User_Payment up WHERE u.user_id=up.user_id'
			. ' ORDER BY up.payment_date DESC';
		}
		$dbcontroller = new DBController();
		$this->payments = $dbcontroller->executeSelectQuery($query);
		return $this->payments;
	}

	public function addPayment(){
		$data = json_decode(file_get_contents('php://input'), true);
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'API401');
		// print_r($data);
		// print_r($_SESSION);
		if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] === true)
		&& isset($_GET['member_id']) && isset($data['payment_type'])
		&& isset($data['ref_num']) && isset($data['amount_paid'])
	  && isset($data['payment_date']) && isset($data['payment_remarks'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$user_id = mysqli_real_escape_string($con,$_GET['member_id']);
			$payment_type = mysqli_real_escape_string($con,$data['payment_type']);
	    $ref_num = mysqli_real_escape_string($con,$data['ref_num']);
	    $amount_paid = mysqli_real_escape_string($con,$data['amount_paid']);
	    $payment_date = mysqli_real_escape_string($con,$data['payment_date']);
	    $payment_remarks = mysqli_real_escape_string($con,$data['payment_remarks']);
	    $payment_scheme_value = mysqli_real_escape_string($con,$data['payment_scheme_value']);

			$dateTime = date_create_from_format('d/m/Y',$payment_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');
			$month_of_pmt = date_format($dateTime, 'F');


			$insert_user_pmt_query = "INSERT INTO User_Payment(user_id,payment_type,payment_date,amt_paid,payment_details,payment_remarks) "
			."VALUES('$user_id','$payment_type','$formatted_date','$amount_paid','$ref_num','$payment_remarks');";
			//insert payment details into User_Payment table
			$insertUserPmtResult = $dbcontroller->executeQuery($insert_user_pmt_query);

			if($insertUserPmtResult > 0){
				$current_date = date("Y-m-d");
				$current_year = date('Y');
				$current_month = date('F');

				$fetch_user_startDate_query = "SELECT start_date FROM Users WHERE user_id='$user_id';";
				$user_start_date_res = $dbcontroller->executeSelectQuery($fetch_user_startDate_query);
				$start_date = $user_start_date_res[0]["start_date"];
				$total_mnths = CommonUtils::getMonthDiff($start_date,$current_date);
				//FETCH TOTAL DUE INFO
				$net_amt_paid = 0;
				$user_pmt_total_query = "SELECT SUM(amt_paid) AS total_paid FROM User_Payment WHERE user_id=".$user_id;
				$user_pmt_total_res = $dbcontroller->executeSelectQuery($user_pmt_total_query);
				$net_amt_paid = $user_pmt_total_res[0]["total_paid"];
				$total_amt_tobepaid = $total_mnths * $payment_scheme_value ;
				$due_amt = $total_amt_tobepaid - $net_amt_paid;

        // SET is_due flag value for TOTAL DUE
				if($due_amt === 0)
        {
            $is_due = "N";
        }
        else{
            $is_due = "Y";
        }
        if($month_of_pmt === $current_month){
            $cp = "Y"; //current monthly payment flag is set to "Y" for current monthly payment done
        }else{
            $cp = "N"; //current monthly payment flag is set to "N" for no payment done during current month
        }

				$count_user_due_query = "SELECT user_id FROM User_Due WHERE user_id='$user_id';";
				$count_user_due_query_res = $dbcontroller->executeSelectQuery($count_user_due_query);
				if(count($count_user_due_query_res)>0)
        {
           $query_due ="UPDATE User_Due SET is_due='$is_due',cp='$cp' WHERE user_id='$user_id';";
        }
        else{
           $query_due ="INSERT INTO User_Due(user_id,is_due,cp) VALUES('$user_id','$is_due','$cp');";
        }
				$query_due_exc = $dbcontroller->executeQuery($query_due);
				if($query_due_exc > 0){
					$result = array('success'=>1, 'msg'=>'Payment details added successfully', "code"=>'200', 'userData'=>$data);
				} else {
					$result = array('success'=>0, "msg"=>"Payment made recently");
				}
			} else{
				$result = array('success'=>0, "msg"=>"API issue", "code"=>'API403');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'API404');
		}

		return $result;
	}

	public function deletePayment(){
		if(isset($_GET['member_id'])){
			$id = $_GET['member_id'];
			$query = 'DELETE FROM tbl_mobile WHERE id = '.$id;
			$dbcontroller = new DBController();
			$result = $dbcontroller->executeQuery($query);
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
	}

	public function editPayment(){
		if(isset($_POST['name']) && isset($_GET['member_id'])){
			$name = $_POST['name'];
			$model = $_POST['model'];
			$color = $_POST['color'];
			$query = "UPDATE tbl_mobile SET name = '".$name."',model ='". $model ."',color = '". $color ."' WHERE id = ".$_GET['member_id'];
		}
		$dbcontroller = new DBController();
		$result= $dbcontroller->executeQuery($query);
		if($result != 0){
			$result = array('success'=>1);
			return $result;
		}
	}

}
?>
