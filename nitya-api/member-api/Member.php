<?php
require_once("../common/dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class Member {
	private $members = array();
	private $corresponders = array();
	private $connectedTo = array();
	public function getAllMember(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'u.address, u.phone_no, u.whatsapp, u.email_id, u.start_date, u.is_active, '
			.'u.connected_to, u.user_lang, u.scheme_name, u.corresponder, u.remarks, s.scheme_value '
			.' FROM Users u, Scheme s WHERE s.scheme_id=u.scheme_id '
			.'and u.user_id=' .$id;
		} else {
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'u.address, u.phone_no, u.whatsapp, u.email_id, u.start_date, u.is_active, '
			.'u.connected_to, u.user_lang, u.scheme_name, u.corresponder, u.remarks, s.scheme_value '
			.' FROM Users u, Scheme s WHERE s.scheme_id=u.scheme_id';
		}
		// echo $query;
		$dbcontroller = new DBController();
		$this->members = $dbcontroller->executeSelectQuery($query);
		return $this->members;
	}

	public function getAllCorresponder(){

		$query = 'SELECT DISTINCT corresponder as corresponder_name FROM Users WHERE corresponder != ""';
		// echo $query;
		$dbcontroller = new DBController();
		$this->corresponders = $dbcontroller->executeSelectQuery($query);
		return $this->corresponders;
	}

	public function getAllConnectedTo(){

		$query = 'SELECT DISTINCT connected_to FROM Users WHERE connected_to != ""';
		// echo $query;
		$dbcontroller = new DBController();
		$this->connectedTo = $dbcontroller->executeSelectQuery($query);
		return $this->connectedTo;
	}

	public function getAllByCategory(){
		$data = json_decode(file_get_contents('php://input'), true);
		if(isset($data["category"]) && isset($data["sub_category"])){
			$category = $data["category"];
			$sub_category = $data["sub_category"];
			if($category !== "" && $sub_category !== ""){
				$column_name = "";
				$column_value = $sub_category;
				$columns_to_send = "user_id, title, first_name, last_name, "
				."phone_no, email_id, start_date, user_lang, "
				."connected_to, scheme_name, corresponder AS corresponder_name";
				$from_clause = "Users";
				$where_clause = "";

				// value:"donation_category", subCatType: "select", subCatValues: ["Prabhupada Sevak", "Jagannath Sevak", "Govind Sevak"]},
	      // {idx: 2, name: "Active Member", value:"active_member", subCatType: "select", subCatValues: ["Y", "N"]},
	      // {idx: 3, name: "Payment Due", value:"payment_due", subCatType: "select", subCatValues: ["Y", "N"]},
	      // {idx: 4, name: "Current Payment Done", value:"current_payment_done", subCatType: "select", subCatValues: ["Y", "N"]},
	      // {idx: 5, name: "Corresponder", value:"corresponder_name", subCatType: "select", url: "member/corresponderlist", ddKey: "corresponder_name"},
	      // {idx: 6, name: "Connected To", value:"connected_to"
				switch($category) {
					case "donation_category":
						$column_name = "scheme_name";
						break;
					case "active_member":
						$column_name = "is_active";
						break;
					case "payment_due":
						$column_name = "ud.is_due";
						$columns_to_send = "u.user_id, u.title, u.first_name, u.last_name, "
						."u.phone_no, u.email_id, u.start_date, u.user_lang, "
						."u.connected_to, u.scheme_name, u.corresponder AS corresponder_name";
						$from_clause = "Users u, User_Due ud";
						break;
					case "current_payment_done":
						$column_name = "ud.cp";
						$columns_to_send = "u.user_id, u.title, u.first_name, u.last_name, "
						."u.phone_no, u.email_id, u.start_date, u.user_lang, "
						."u.connected_to, u.scheme_name, u.corresponder AS corresponder_name";
						$from_clause = "Users u, User_Due ud";
						break;
					case "corresponder_name":
						$column_name = "corresponder";
						break;
					case "connected_to":
						$column_name = "connected_to";
						break;
				}

				if($column_name !== ""){
					$query = 'SELECT'." ".$columns_to_send." FROM ".$from_clause." WHERE ".$column_name."='".$column_value."'";
					if($where_clause !== ""){
						$query .= " AND ".$where_clause;
					}
					// echo $query;
					$dbcontroller = new DBController();
					$members = $dbcontroller->executeSelectQuery($query);
					$result = array('success'=>1, "msg"=>"Members Found", "code"=>'200', "members"=>$members);
				} else {
					$result = array('success'=>0, "msg"=>"API issue", "code"=>'911');
				}
			} else {
				$result = array('success'=>0, "msg"=>"API issue", "code"=>'910');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'909');
		}

		return $result;
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
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'901');
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

			// $query = mysqli_query($con,"Select * from Users");
	    // $query2 = mysqli_query($con,"Select * from User_Donation");

			$user_already_ex_q = "SELECT user_id,title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang,scheme_id,scheme_name,corresponder,remarks FROM Users WHERE phone_no = '$phone_no';";

			$searchSchemeId_query = "SELECT scheme_id,scheme_value FROM Scheme WHERE scheme_name = '$scheme_name';";

			// $insert_user_query = "INSERT INTO Users(title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang) VALUES('$title','$first_name','$last_name','$address','$phone_no','$whatsapp','$email_id','$formatted_date','$is_active','$connected_to','$user_lang');";

			//check if phone no already exists
			$alreadyExistingUserRes = $dbcontroller->executeSelectQuery($user_already_ex_q);
			if(count($alreadyExistingUserRes) > 0){
				//If yes then send already existing message
				$result = array('success'=>0, "msg"=>"Phone number already exists", "code"=>'902');
			} else {
				//If No, check scheme table if scheme exists
				$schemeQueryRes = $dbcontroller->executeSelectQuery($searchSchemeId_query);
				if(count($schemeQueryRes) > 0){
					$scheme_data = $schemeQueryRes[0];
					$scheme_id = $scheme_data["scheme_id"];
					$scheme_value = $scheme_data["scheme_value"];

					$insert_user_query = "INSERT INTO Users(title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang,scheme_id,scheme_name,corresponder,remarks) VALUES('$title','$first_name','$last_name','$address','$phone_no','$whatsapp','$email_id','$formatted_date','$is_active','$connected_to','$user_lang','$scheme_id','$scheme_name','$corresponder','$remarks');";

					//insert user into Users table
					$insertUserResult = $dbcontroller->executeQuery($insert_user_query);
					if($insertUserResult > 0){
						$newUserRes = $dbcontroller->executeSelectQuery($user_already_ex_q);
						if(count($newUserRes) > 0){
							$userData = $newUserRes[0];
							$user_id = $userData['user_id'];
							$_SESSION['selected_member_id'] = $user_id;

							// $insert_ud_query = "INSERT INTO User_Donation(user_id,scheme_id,scheme_name,payment_type,corresponder,remarks) VALUES('$user_id','$scheme_id','$scheme_name','$payment_type','$corresponder','$remarks');";

							// $insertUserDonationRes = $dbcontroller->executeQuery($insert_ud_query);

							// if($insertUserDonationRes > 0){
							// 	$userData['scheme_id'] = $scheme_id;
							// 	$userData['scheme_name'] = $scheme_name;
								$userData['scheme_value'] = $scheme_value;
								$result = array('success'=>1, 'msg'=>'Member added successfully', "code"=>'200', 'userData'=>$userData);
							// } else {
							// 	$result = array('success'=>0, "msg"=>"API issue", "code"=>'904');
							// }
						}
					} else {
						$result = array('success'=>0, "msg"=>"API issue", "code"=>'905');
					}
				} else {
					$result = array('success'=>0, "msg"=>"API issue", "code"=>'904');
				}
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'903');
		}

		return $result;
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
