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
			.'u.address, u.phone_no, u.whatsapp, u.email_id, DATE_FORMAT(u.start_date, "%d/%m/%Y") as start_date, u.is_active, '
			.'u.connected_to, u.user_lang, u.scheme_name, u.corresponder, u.remarks, s.scheme_value '
			.' FROM Users u, Scheme s WHERE s.scheme_id=u.scheme_id '
			.'and u.user_id=' .$id;
		} else {
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'u.address, u.phone_no, u.whatsapp, u.email_id, DATE_FORMAT(u.start_date, "%d/%m/%Y") as start_date, u.is_active, '
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
			$members = null;
			$category = $data["category"];
			$sub_category = $data["sub_category"];
			if($category !== "" && $sub_category !== ""){
				$column_name = "";
				$column_value = $sub_category;
				$columns_to_send = "u.user_id, u.title, u.first_name, u.last_name, "
				."u.phone_no, u.email_id, u.start_date, u.user_lang, "
				."u.connected_to, u.scheme_name, u.corresponder, "
				."IFNULL(ldv.last_payment_date, 'None') AS last_payment_date, "
				."IFNULL(ldv.last_btg_sent_date, 'None') AS last_btg_sent_date, "
				."IFNULL(ldv.last_gift_sent_date, 'None') AS last_gift_sent_date, "
				."IFNULL(ldv.last_prasadam_sent_date, 'None') AS last_prasadam_sent_date, "
				."IFNULL(ldv.last_followup_date, 'None') AS last_followup_date";
				$from_clause = "Users u, last_details_view ldv";
				$where_clause = "u.user_id=ldv.user_id";
				$order_by_clause = "u.user_id ASC";

				switch($category) {
					case "all_members":
						$column_name = "All Members";
						break;
					case "donation_category":
						$column_name = "u.scheme_name";
						break;
					case "active_member":
						$column_name = "u.is_active";
						break;
					case "payment_due":
						$column_name = "ud.is_due";
						$columns_to_send = "u.user_id, u.title, u.first_name, u.last_name, "
						."u.phone_no, u.email_id, u.start_date, u.user_lang, "
						."u.connected_to, u.scheme_name, u.corresponder, "
						."IFNULL(ldv.last_payment_date, 'None') AS last_payment_date, "
						."IFNULL(ldv.last_btg_sent_date, 'None') AS last_btg_sent_date, "
						."IFNULL(ldv.last_gift_sent_date, 'None') AS last_gift_sent_date, "
						."IFNULL(ldv.last_prasadam_sent_date, 'None') AS last_prasadam_sent_date, "
						."IFNULL(ldv.last_followup_date, 'None') AS last_followup_date";
						$from_clause .= ", User_Due ud";
						$where_clause .= " AND u.user_id=ud.user_id";
						break;
					case "current_payment_done":
						$column_name = "ud.cp";
						$columns_to_send = "u.user_id, u.title, u.first_name, u.last_name, "
						."u.phone_no, u.email_id, u.start_date, u.user_lang, "
						."u.connected_to, u.scheme_name, u.corresponder, "
						."IFNULL(ldv.last_payment_date, 'None') AS last_payment_date, "
						."IFNULL(ldv.last_btg_sent_date, 'None') AS last_btg_sent_date, "
						."IFNULL(ldv.last_gift_sent_date, 'None') AS last_gift_sent_date, "
						."IFNULL(ldv.last_prasadam_sent_date, 'None') AS last_prasadam_sent_date, "
						."IFNULL(ldv.last_followup_date, 'None') AS last_followup_date";
						$from_clause .= ", User_Due ud";
						$where_clause .= " AND u.user_id=ud.user_id";
						break;
					case "corresponder_name":
						$column_name = "u.corresponder";
						break;
					case "connected_to":
						$column_name = "u.connected_to";
						break;
				}

				if(!is_null($members)){
					$result = array('success'=>1, "msg"=>"Members Found", "code"=>'200', "members"=>$members);
				} else if($column_name !== ""){
					$query = 'SELECT'." ".$columns_to_send." FROM ".$from_clause." WHERE ";
					if($where_clause !== ""){
						$query .= $where_clause;
						if(($column_name !== "") && ($column_name !== "All Members")){
							$query .= " AND ".$column_name."='".$column_value."'";
						}
					} else {
						if(($column_name !== "All Members") || ($column_name !== "")){
							$query .= " WHERE ".$column_name."='".$column_value."'";
						}
					}

					if($order_by_clause !== ""){
						$query .= " ORDER BY ".$order_by_clause;
					}
					// echo $query;
					$dbcontroller = new DBController();
					$members = $dbcontroller->executeSelectQuery($query);
					$result = array('success'=>1, "msg"=>"Members Found", "code"=>'200', "members"=>$members);
				} else if(empty($result)){
					$result = array('success'=>0, "msg"=>"API issue", "code"=>'913');
				}
			} else {
				$result = array('success'=>0, "msg"=>"API issue", "code"=>'912');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'911');
		}

		return $result;
	}

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
			$dob = mysqli_real_escape_string($con,$data['birth_date']);
			$email_id = mysqli_real_escape_string($con,$data['email_id']);
			$company_name = mysqli_real_escape_string($con,$data['company_name']);
			$start_date = mysqli_real_escape_string($con,$data['start_date']);
			$is_active = mysqli_real_escape_string($con,$data['is_active']);
			$connected_to = mysqli_real_escape_string($con,$data['connected_to']);
			$scheme_name = mysqli_real_escape_string($con,$data['scheme_name']);
			// $payment_type = mysqli_real_escape_string($con,$data['payment_type']);
			$corresponder = mysqli_real_escape_string($con,$data['corresponder']);
			$user_lang = mysqli_real_escape_string($con,$data['user_lang']);
			$remarks = mysqli_real_escape_string($con,$data['remarks']);

			$dateTime_dob = date_create_from_format('d/m/Y',$dob);
			$formatted_dob_date = date_format($dateTime_dob, 'Y-m-d');

			$dateTime = date_create_from_format('d/m/Y',$start_date);
			$formatted_start_date = date_format($dateTime, 'Y-m-d');

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

					$insert_user_query = "INSERT INTO Users(title,first_name,last_name,address,phone_no,whatsapp,dob,email_id,company_name,start_date,is_active,connected_to,user_lang,scheme_id,scheme_name,corresponder,remarks) VALUES('$title','$first_name','$last_name','$address','$phone_no','$whatsapp','$formatted_dob_date','$email_id','$company_name','$formatted_start_date','$is_active','$connected_to','$user_lang','$scheme_id','$scheme_name','$corresponder','$remarks');";

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
		$data = json_decode(file_get_contents('php://input'), true);
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'921');
		// print_r($data);
		if(isset($_GET['id']) && isset($data['title']) && isset($data['first_name'])
		&& isset($data['last_name']) && isset($data['address']) && isset($data['phone_no'])
		&& isset($data['whatsapp']) && isset($data['email_id']) && isset($data['start_date'])
		&& isset($data['is_active']) && isset($data['connected_to']) && isset($data['scheme_name'])
		&& isset($data['corresponder']) && isset($data['user_lang'])
		&& isset($data['remarks'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$user_id = mysqli_real_escape_string($con,$_GET['id']);
			$title = mysqli_real_escape_string($con,$data['title']);
			$first_name = mysqli_real_escape_string($con,$data['first_name']);
			$last_name = mysqli_real_escape_string($con,$data['last_name']);
			$address = mysqli_real_escape_string($con,$data['address']);
			$phone_no = mysqli_real_escape_string($con,$data['phone_no']);
			$whatsapp = mysqli_real_escape_string($con,$data['whatsapp']);
			$email_id = mysqli_real_escape_string($con,$data['email_id']);
			$start_date = mysqli_real_escape_string($con,$data['start_date']);
			$is_active = mysqli_real_escape_string($con,$data['is_active']);
			$connected_to = mysqli_real_escape_string($con,$data['connected_to']);
			$scheme_name = mysqli_real_escape_string($con,$data['scheme_name']);
			$corresponder = mysqli_real_escape_string($con,$data['corresponder']);
			$user_lang = mysqli_real_escape_string($con,$data['user_lang']);
			$remarks = mysqli_real_escape_string($con,$data['remarks']);

			$dateTime = date_create_from_format('d/m/Y',$start_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');

			$user_already_ex_q = "SELECT user_id,title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang,scheme_id,scheme_name,corresponder,remarks FROM Users WHERE phone_no = '$phone_no';";

			$searchSchemeId_query = "SELECT scheme_id,scheme_value FROM Scheme WHERE scheme_name = '$scheme_name';";

			//check if phone no already exists
			$alreadyExistingUserRes = $dbcontroller->executeSelectQuery($user_already_ex_q);
			if(count($alreadyExistingUserRes) > 0){
				$userData = $alreadyExistingUserRes[0];
				if($userData['scheme_name'] !== $scheme_name){
					$schemeQueryRes = $dbcontroller->executeSelectQuery($searchSchemeId_query);
					if(count($schemeQueryRes) > 0){
						$scheme_data = $schemeQueryRes[0];
						$scheme_id = $scheme_data["scheme_id"];
						$scheme_value = $scheme_data["scheme_value"];

						$update_user_query = "UPDATE Users SET title='$title', first_name='$first_name',"
						." last_name='$last_name',address='$address',phone_no='$phone_no',whatsapp='$whatsapp',"
						."email_id='$email_id',start_date='$start_date',is_active='$is_active',"
						."connected_to='$connected_to',user_lang='$user_lang',scheme_id='$scheme_id',"
						."scheme_name='$scheme_name',corresponder='$corresponder',remarks='$remarks' WHERE user_id='$user_id';";
					}
				} else {
					$update_user_query = "UPDATE Users SET title='$title', first_name='$first_name',"
					." last_name='$last_name',address='$address',phone_no='$phone_no',whatsapp='$whatsapp',"
					."email_id='$email_id',start_date='$start_date',is_active='$is_active',"
					."connected_to='$connected_to',user_lang='$user_lang',"
					."corresponder='$corresponder',remarks='$remarks' WHERE user_id='$user_id';";
				}

				//update user into Users table
				$updateUserResult = $dbcontroller->executeQuery($update_user_query);
				if($updateUserResult > 0){
					$result = array('success'=>1, 'msg'=>'Member details updated successfully', "code"=>'200', 'userData'=>$userData);
				} else {
					$result = array('success'=>0, "msg"=>"Member details aready upto-date", "code"=>'924');
				}
			} else {
				$result = array('success'=>0, "msg"=>"User does not exist", "code"=>'923');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'922');
		}

		return $result;
	}

}
?>
