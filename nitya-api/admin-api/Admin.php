<?php
require_once("../common/dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class Admin {
	private $admins = array();
	public function getAllAdmin(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$query = 'SELECT admin_id, title, first_name, last_name, '
			.'username, pwd, phone_no, email_id, DATE_FORMAT(start_date, "%d/%m/%Y") as start_date, is_superAdmin '
			.' FROM Admin WHERE admin_id='.$id;
		} else {
			$query = 'SELECT admin_id, title, first_name, last_name, '
			.'username, pwd, phone_no, email_id, DATE_FORMAT(start_date, "%d/%m/%Y") as start_date, is_superAdmin '
			.' FROM Admin';
		}
		// echo $query;
		$dbcontroller = new DBController();
		$this->admins = $dbcontroller->executeSelectQuery($query);
		return $this->admins;
	}

	public function addAdmin(){
		$data = json_decode(file_get_contents('php://input'), true);
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'501');
		// print_r($data);
		if(isset($data['title']) && isset($data['first_name'])
			&& isset($data['last_name']) && isset($data['phone_no'])
			&& isset($data['email_id']) && isset($data['start_date'])
			&& isset($data['username'])&& isset($data['password'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$title = mysqli_real_escape_string($con,$data['title']);
			$first_name = mysqli_real_escape_string($con,$data['first_name']);
			$last_name = mysqli_real_escape_string($con,$data['last_name']);
			$phone_no = mysqli_real_escape_string($con,$data['phone_no']);
			$email_id = mysqli_real_escape_string($con,$data['email_id']);
			$start_date = mysqli_real_escape_string($con,$data['start_date']);
			$username = mysqli_real_escape_string($con,$data['username']);
			$password = mysqli_real_escape_string($con,$data['password']);

			$dateTime = date_create_from_format('d/m/Y',$start_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');

			$admin_already_ex_q = "SELECT admin_id FROM Admin WHERE phone_no = '$phone_no';";
			$username_already_ex_q = "SELECT admin_id FROM Admin WHERE username = '$username';";
			$is_superAdmin = "N";
			$insert_admin_query = "INSERT INTO Admin(title,first_name,last_name,username,pwd,phone_no,email_id,start_date,is_superAdmin) VALUES('$title','$first_name','$last_name','$username','$password','$phone_no','$email_id','$formatted_date','c');";

			//check if phone no already exists
			$alreadyExistingUserRes = $dbcontroller->executeSelectQuery($admin_already_ex_q);
			if(count($alreadyExistingUserRes) > 0){
				//If yes then send already existing message
				$result = array('success'=>0, "msg"=>"Phone number already exists", "code"=>'503');
			} else {
				//check if username already exists
				$alreadyExistingUsernameRes = $dbcontroller->executeSelectQuery($username_already_ex_q);
				if(count($alreadyExistingUsernameRes) > 0){
					//If yes then send already existing message
					$result = array('success'=>0, "msg"=>"Username already exists", "code"=>'504');
				}else{
					//insert admin details into Admin table
					$insertAdminResult = $dbcontroller->executeQuery($insert_admin_query);
					if($insertAdminResult > 0){
						$result = array('success'=>1, 'msg'=>'Admin added successfully', "code"=>'200');
					}else{
						$result = array('success'=>0, "msg"=>"API issue", "code"=>'505');
					}
				}
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'502');
		}

		return $result;
	}

	public function deleteAdmin(){
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

	public function editAdmin(){
		$data = json_decode(file_get_contents('php://input'), true);
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'506');
		// print_r($_GET);
		if(isset($_GET['id']) && isset($data['title']) && isset($data['first_name'])
			&& isset($data['last_name']) && isset($data['phone_no'])
			&& isset($data['email_id']) && isset($data['start_date'])
			&& isset($data['username'])&& isset($data['password'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$admin_id = mysqli_real_escape_string($con,$_GET['id']);
			$title = mysqli_real_escape_string($con,$data['title']);
			$first_name = mysqli_real_escape_string($con,$data['first_name']);
			$last_name = mysqli_real_escape_string($con,$data['last_name']);
			$phone_no = mysqli_real_escape_string($con,$data['phone_no']);
			$email_id = mysqli_real_escape_string($con,$data['email_id']);
			$start_date = mysqli_real_escape_string($con,$data['start_date']);
			$username = mysqli_real_escape_string($con,$data['username']);
			$password = mysqli_real_escape_string($con,$data['password']);

			$dateTime = date_create_from_format('d/m/Y',$start_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');

			$update_admin_query = "UPDATE Admin SET title='$title',first_name='$first_name',last_name='$last_name',username='$username',pwd='$password',phone_no='$phone_no',email_id='$email_id',start_date='$formatted_date' WHERE admin_id='$admin_id';";

			$updateAdminResult = $dbcontroller->executeQuery($update_admin_query);
			// echo $updateAdminResult;
			if($updateAdminResult > 0){
				$result = array('success'=>1, 'msg'=>'Admin details saved successfully', "code"=>'200');
			}else{
				$result = array('success'=>0, "msg"=>"Admin details already upto-date", "code"=>'508');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'507');
		}

		return $result;
	}

}
?>
