<?php
require_once("dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class Member {
	private $members = array();
	public function getAllMember(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$query = 'SELECT * FROM Users WHERE user_id=' .$id;
		} else {
			$query = 'SELECT * FROM Users';
		}
		$dbcontroller = new DBController();
		$this->members = $dbcontroller->executeSelectQuery($query);
		return $this->members;
	}

	// $title = mysqli_real_escape_string($con,$_POST['title']);
	// $first_name = mysqli_real_escape_string($con,$_POST['first_name']);
	// $last_name = mysqli_real_escape_string($con,$_POST['last_name']);
	// $address = mysqli_real_escape_string($con,$_POST['address']);
	// $phone_no = mysqli_real_escape_string($con,$_POST['phone_no']);
	// $whatsapp = mysqli_real_escape_string($con,$_POST['whatsapp']);
	// $email_id = mysqli_real_escape_string($con,$_POST['email_id']);
	// $start_date = mysqli_real_escape_string($con,$_POST['date']);
	// $is_corresponder = mysqli_real_escape_string($con,$_POST['is_corresponder']);
	// $is_active = mysqli_real_escape_string($con,$_POST['is_active']);
	// $connected_to = mysqli_real_escape_string($con,$_POST['connected_to']);
	// $scheme_name = mysqli_real_escape_string($con,$_POST['scheme_name']);
	// $payment_type = mysqli_real_escape_string($con,$_POST['payment_type']);
	// $corresponder = mysqli_real_escape_string($con,$_POST['corresponder']);
	// $user_lang = mysqli_real_escape_string($con,$_POST['user_lang']);
	// $remarks = mysqli_real_escape_string($con,$_POST['remarks']);

	public function addMember(){
		$data = json_decode(file_get_contents('php://input'), true);
		// print_r($data);
		if(isset($data['title']) && isset($data['first_name']) && isset($data['last_name'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$title = mysqli_real_escape_string($con,$data['title']);
			$first_name = mysqli_real_escape_string($con,$data['first_name']);
			$last_name = mysqli_real_escape_string($con,$data['last_name']);
			$address = mysqli_real_escape_string($con,$data['address']);
			$phone_no = mysqli_real_escape_string($con,$data['phone_no']);
			$whatsapp = mysqli_real_escape_string($con,$data['whatsapp']);
			$email_id = mysqli_real_escape_string($con,$data['email_id']);
			$start_date = mysqli_real_escape_string($con,$data['start_date']);
			// $is_corresponder = mysqli_real_escape_string($con,$data['is_corresponder']);
			$is_active = mysqli_real_escape_string($con,$data['is_active']);
			$connected_to = mysqli_real_escape_string($con,$data['connected_to']);
			$scheme_name = mysqli_real_escape_string($con,$data['scheme_name']);
			$payment_type = mysqli_real_escape_string($con,$data['payment_type']);
			$corresponder = mysqli_real_escape_string($con,$data['corresponder']);
			$user_lang = mysqli_real_escape_string($con,$data['user_lang']);
			$remarks = mysqli_real_escape_string($con,$data['remarks']);

			$dateTime = date_create_from_format('d/m/Y',$start_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');

			$query = mysqli_query($con,"Select * from Users");
	    $query2 = mysqli_query($con,"Select * from User_Donation");

			$user_already_ex_q = "SELECT user_id FROM Users WHERE phone_no = '$phone_no';";

			$searchSchemeId_query = "SELECT scheme_id,scheme_value FROM Scheme WHERE scheme_name = '$scheme_name';";

			$insert_user_query = "INSERT INTO Users(title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang) VALUES('$title','$first_name','$last_name','$address','$phone_no','$whatsapp','$email_id','$formatted_date','$is_active','$connected_to','$user_lang');";

			$result = array('success'=>0, "msg"=>"method not run");
			//check if phone no already exists
			$alreadyExistingUserRes = $dbcontroller->executeSelectQuery($user_already_ex_q);
			if(count($alreadyExistingUserRes) > 0){
				//If yes then send already existing message
				$result = array('success'=>0, "msg"=>"phone number already taken");
			} else {
				//If No, then insert user into Users table
				$insertUserResult = $dbcontroller->executeQuery($insert_user_query);
				if($insertUserResult > 0){
					$newUserRes = $dbcontroller->executeSelectQuery($user_already_ex_q);
					if(count($newUserRes) > 0){
						$user_id = $newUserRes[0]['user_id'];
						$schemeQueryRes = $dbcontroller->executeSelectQuery($searchSchemeId_query);
						if(count($schemeQueryRes) > 0){
							$scheme_id = $schemeQueryRes[0]["scheme_id"];

							$insert_ud_query = "INSERT INTO User_Donation(user_id,scheme_id,scheme_name,payment_type,corresponder,remarks) VALUES('$user_id','$scheme_id','$scheme_name','$payment_type','$corresponder','$remarks');";

							$insertUserDonationRes = $dbcontroller->executeQuery($insert_ud_query);

							if($insertUserDonationRes > 0){
								$result = array('success'=>1, 'status'=>'created', 'msg'=>'member added successfully');
							}
						}
					}
				}
				// echo($insertUserResult);
			}

			// $result = $dbcontroller->executeQuery($query);
			// if($result != 0){
			// 	$result = array('success'=>1);
			// 	return $result;
			// }

			return $result;
		}
	}

	public function deleteMember(){
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

	public function editMember(){
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
