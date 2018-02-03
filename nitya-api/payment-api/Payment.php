<?php
require_once("../common/dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class Payment {
	private $payments = array();
	public function getAllPayment(){
		if(isset($_GET['user_id'])){
			$user_id = $_GET['user_id'];DATE_FORMAT(ub.dispatch_date, "%d/%m/%Y") as dispatch_date
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
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'905');
		// print_r($data);
		if(isset($data['payment_type']) && isset($data['ref_num']) && isset($data['amount_paid'])
		 && isset($data['payment_date']) && isset($data['payment_remarks'])
		&& isset($_SESSION['selected_member_id'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$user_id = mysqli_real_escape_string($con,$_SESSION['selected_member_id']);
			$payment_type = mysqli_real_escape_string($con,$data['payment_type']);
	    $ref_num = mysqli_real_escape_string($con,$data['ref_num']);
	    $amount_paid = mysqli_real_escape_string($con,$data['amount_paid']);
	    $payment_date = mysqli_real_escape_string($con,$data['payment_date']);
	    $payment_remarks = mysqli_real_escape_string($con,$data['payment_remarks']);

			$dateTime = date_create_from_format('d/m/Y',$payment_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');

			$user_pmt_total_query = "SELECT SUM(amt_paid) AS total_paid FROM User_Payment WHERE user_id=".$user_id;

			$insert_user_pmt_query = "INSERT INTO User_Payment(user_id,payment_type,payment_date,amt_paid,payment_details,payment_remarks) "
			."VALUES('$user_id','$payment_type','$formatted_date','$amount_paid','$ref_num','$payment_remarks');";

			/check if phone no already exists
			$userPaymentTotalRes = $dbcontroller->executeSelectQuery($user_pmt_total_query);
			if(count($userPaymentTotalRes) > 0){
				// $total_payment_done
				//If yes then send already existing message
				$result = array('success'=>0, "msg"=>"Phone number already exists", "code"=>'902');
			} else {
				//insert payment into User_Payment table
				$insertUserPmtResult = $dbcontroller->executeQuery($insert_user_pmt_query);
				if($insertUserPmtResult > 0){
					$result = array('success'=>1, 'msg'=>'Payment added successfully', "code"=>'200', 'userData'=>$data);
				} else {
					$result = array('success'=>0, "msg"=>"API issue", "code"=>'803');
				}
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'906');
		}

		return $result;
	}

	public function deletePayment(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
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
		if(isset($_POST['name']) && isset($_GET['id'])){
			$name = $_POST['name'];
			$model = $_POST['model'];
			$color = $_POST['color'];
			$query = "UPDATE tbl_mobile SET name = '".$name."',model ='". $model ."',color = '". $color ."' WHERE id = ".$_GET['id'];
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
