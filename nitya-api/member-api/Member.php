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
			.'u.address, u.phone_no, u.whatsapp, DATE_FORMAT(u.dob, "%d/%m/%Y") AS dob, u.company_name, u.email_id, '
			.'DATE_FORMAT(u.start_date, "%d/%m/%Y") AS start_date, u.is_active, '
			.'u.connected_to, u.user_lang, u.scheme_name, u.corresponder, u.remarks, s.scheme_value '
			.' FROM users u, scheme s WHERE s.scheme_id=u.scheme_id '
			.'and u.user_id=' .$id;
		} else {
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'u.address, u.phone_no, u.whatsapp, DATE_FORMAT(u.dob, "%d/%m/%Y") AS dob, u.company_name, u.email_id, '
			.'DATE_FORMAT(u.start_date, "%d/%m/%Y") AS start_date, u.is_active, '
			.'u.connected_to, u.user_lang, u.scheme_name, u.corresponder, u.remarks, s.scheme_value '
			.' FROM users u, scheme s WHERE s.scheme_id=u.scheme_id';
		}
		// echo $query;
		$dbcontroller = new DBController();
		$this->members = $dbcontroller->executeSelectQuery($query);
		return $this->members;
	}
	public function getAllSchemes(){
		$query = 'SELECT  scheme_name,scheme_value FROM scheme';
		// echo $query;
		$dbcontroller = new DBController();
		$this->schemes = $dbcontroller->executeSelectQuery($query);
		// print_r($this->schemes);
		return $this->schemes;
	}

	public function getAllCorresponder(){

		$query = 'SELECT CONCAT(title, " ", first_name, " ", last_name) AS corresponder_name FROM admin';
		// echo $query;
		$dbcontroller = new DBController();
		$this->corresponders = $dbcontroller->executeSelectQuery($query);
		return $this->corresponders;
	}

	public function getAllConnectedTo(){

		$query = 'SELECT connection_name AS connected_to FROM user_connection';
		// echo $query;
		$dbcontroller = new DBController();
		$this->connectedTo = $dbcontroller->executeSelectQuery($query);
		return $this->connectedTo;
	}
// 'DUE & PAID' WISE PAYMENT REPORT
	public function getDueReport(){
		$data = json_decode(file_get_contents('php://input'), true);

		if(isset($data["category"])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();
			$from_date = mysqli_real_escape_string($con,$data['from_date']);

			$dateTime_from_date = date_create_from_format('d/m/Y',$from_date);
			$formatted_from_date = date_format($dateTime_from_date, 'Y-m-d');

			$to_date = mysqli_real_escape_string($con,$data['to_date']);

			$dateTime_to_date = date_create_from_format('d/m/Y',$to_date);
			$formatted_to_date = date_format($dateTime_to_date, 'Y-m-d');

			if(isset($_GET["id"])){
				$for_user_id = mysqli_real_escape_string($con,$_GET["id"]);
				$query = 'SELECT u.user_id,u.title,u.first_name,u.last_name,DATE_FORMAT(u.start_date, "%d/%m/%Y") AS start_date,DATE_FORMAT(up.related_month, "%M, %Y") AS related_month'
									.' FROM users u LEFT JOIN user_payment up'
									.' ON u.user_id=up.user_id'
									.' AND related_month BETWEEN "'.$formatted_from_date .'" AND "'. $formatted_to_date
									.' WHERE u.user_id="'.$for_user_id.'"'
									.'" ORDER BY u.user_id,up.related_month ASC';
			} else {
				$query = 'SELECT u.user_id,u.title,u.first_name,u.last_name,DATE_FORMAT(u.start_date, "%d/%m/%Y") AS start_date,DATE_FORMAT(up.related_month, "%M, %Y") AS related_month'
									.' FROM users u LEFT JOIN user_payment up'
									.' ON u.user_id=up.user_id'
									.' AND related_month BETWEEN "'.$formatted_from_date .'" AND "'. $formatted_to_date
									.'" ORDER BY u.user_id,up.related_month ASC';

			}


			// echo $query;
			$date_range = array();
			$start    = (new DateTime($formatted_from_date))->modify('first day of this month');
			$end      = (new DateTime($formatted_to_date))->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start, $interval, $end);

			foreach ($period as $dt) {
			    // echo $dt->format("Y-m") . "<br>\n";
					$formatted_dt = $dt->format("F, Y");
					if($date_range!== null){
						array_push($date_range,$formatted_dt);
					}else{
						$date_range = array($formatted_dt);
					}
			}
			// var_dump($date_range);
			$id = null;
			$due_report_data = $dbcontroller->executeSelectQuery($query);
			if(count($due_report_data) === 0) {
				$result = array("success"=>0, "msg"=>"No payment records found for the given date range");
			} else {
				$obj = null;
				$main_obj = array();
				for($i=0; $i<count($due_report_data); $i++){
					$row = $due_report_data[$i];
					// var_dump($row);
					if($id === $row["user_id"]){
						array_push($obj["payment_done_months"],$row["related_month"]);
					} else  {
						if($obj !== null){
								array_push($main_obj,$obj);
						}
						$id = $row["user_id"];
						$obj = array("user_id"=>$row["user_id"],"title"=>$row["title"],"first_name"=>$row["first_name"],"last_name"=>$row["last_name"],"start_date"=>$row["start_date"]);
						$obj["payment_done_months"] = array($row["related_month"]);
					}
				}
				if($obj !== null){
						array_push($main_obj,$obj);
				}
				// $result = $main_obj;
				if(count($main_obj) > 0){
					$result = array("success"=>1, "member_data"=>$main_obj, "date_range"=>$date_range);
				} else {
					$result = array("success"=>0, "msg"=>"API Issue", "code"=> "1002");
				}
			}
		}

		// print_r($due_report_data);
		return $result;
	}

	public function getPaymentReport(){
		echo "getPaymentReport";
		$data = json_decode(file_get_contents('php://input'), true);
	}

	public function getAllByCategory(){
		$data = json_decode(file_get_contents('php://input'), true);
		// print_r($data);
		if(isset($data["category"]) && isset($data["sub_category"])){
			$members = null;
			$category = $data["category"];
			$sub_category = $data["sub_category"];
			if($category !== "" && $sub_category !== ""){
				$column_name = "";
				$column_value = $sub_category;
				$search_type = "full_string";
				$columns_to_send = "u.user_id, u.title, u.first_name, u.last_name, "
				."u.phone_no, u.email_id, DATE_FORMAT(u.start_date, '%d/%m/%Y') AS start_date, u.user_lang, "
				."u.connected_to, u.scheme_name, u.corresponder, "
				."CASE WHEN ldv.last_payment_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_payment_date, '%d/%m/%Y')"
				."  END last_payment_date, "
				."CASE WHEN ldv.last_btg_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_btg_sent_date, '%d/%m/%Y')"
				." END last_btg_sent_date, "
				."CASE WHEN ldv.last_gift_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_gift_sent_date, '%d/%m/%Y')"
				." END last_gift_sent_date, "
				."CASE WHEN ldv.last_prasadam_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_prasadam_sent_date, '%d/%m/%Y')"
				." END last_prasadam_sent_date, "
				."CASE WHEN ldv.last_followup_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_followup_date, '%d/%m/%Y')"
				." END last_followup_date";
				$from_clause = "users u, last_details_view ldv";
				$where_clause = "u.user_id=ldv.user_id";
				$group_by_clause = "";
				$order_by_clause = "u.user_id ASC";

				switch($category) {
					case "all_members":
						$column_name = "All Members";
						if($sub_category === "none"){
							$result = array('success'=>0, "msg"=>"Please select all from sub-category drop down");
						}
						break;
					case "member_name":
						$column_name = "member_name";
						$group_by_clause = "u.user_id";
						break;
					case "phone_num":
						$column_name = "u.phone_no";
						$search_type = "part_string";
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
						."u.phone_no, u.email_id, DATE_FORMAT(u.start_date, '%d/%m/%Y') AS start_date, u.user_lang, "
						."u.connected_to, u.scheme_name, u.corresponder, "
						."CASE WHEN ldv.last_payment_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_payment_date, '%d/%m/%Y')"
						."  END last_payment_date, "
						."CASE WHEN ldv.last_btg_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_btg_sent_date, '%d/%m/%Y')"
						." END last_btg_sent_date, "
						."CASE WHEN ldv.last_gift_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_gift_sent_date, '%d/%m/%Y')"
						." END last_gift_sent_date, "
						."CASE WHEN ldv.last_prasadam_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_prasadam_sent_date, '%d/%m/%Y')"
						." END last_prasadam_sent_date, "
						."CASE WHEN ldv.last_followup_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_followup_date, '%d/%m/%Y')"
						." END last_followup_date";
						$from_clause .= ", user_due ud";
						// $where_clause .= " u.user_id=ud.user_id";
						break;
					case "current_payment_done":
						$column_name = "ud.cp";
						$columns_to_send = "u.user_id, u.title, u.first_name, u.last_name, "
						."u.phone_no, u.email_id, DATE_FORMAT(u.start_date, '%d/%m/%Y') AS start_date, u.user_lang, "
						."u.connected_to, u.scheme_name, u.corresponder, "
						."CASE WHEN ldv.last_payment_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_payment_date, '%d/%m/%Y')"
						."  END last_payment_date, "
						."CASE WHEN ldv.last_btg_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_btg_sent_date, '%d/%m/%Y')"
						." END last_btg_sent_date, "
						."CASE WHEN ldv.last_gift_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_gift_sent_date, '%d/%m/%Y')"
						." END last_gift_sent_date, "
						."CASE WHEN ldv.last_prasadam_sent_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_prasadam_sent_date, '%d/%m/%Y')"
						." END last_prasadam_sent_date, "
						."CASE WHEN ldv.last_followup_date IS NULL THEN 'None' ELSE DATE_FORMAT(ldv.last_followup_date, '%d/%m/%Y')"
						." END last_followup_date";
						$from_clause .= ", user_due ud";
						// $where_clause .= " u.user_id=ud.user_id";
						break;
					case "corresponder_name":
						$column_name = "u.corresponder";
						break;
					case "connected_to":
						$column_name = "u.connected_to";
						break;
				}

				if(empty($result) && $column_name !== ""){
					$query = 'SELECT'." ".$columns_to_send." FROM ".$from_clause;
					$inside_if = false;
					if($column_name === "member_name"){
						$inside_if = true;
						$query .= " WHERE "."LOWER(u.title) LIKE '%".strtolower($column_value)."%'";
						$query .= " OR LOWER(u.first_name) LIKE '%".strtolower($column_value)."%'";
						$query .= " OR LOWER(u.last_name) LIKE '%".strtolower($column_value)."%'";
					} else if($column_name !== "All Members"){
						$inside_if = true;
						if($search_type === "full_string") {
							$query .= " WHERE ".$column_name."='".$column_value."'";
						} elseif ($search_type === "part_string") {
							$query .= " WHERE ".$column_name." LIKE '%".$column_value."%'";
						}
					}
					if($where_clause !== ""){
						if($inside_if){
							$query .= " AND ".$where_clause;
						} else {
							$query .= " WHERE ".$where_clause;
						}

					}
					if($group_by_clause !== ""){
						$query .= " GROUP BY ".$group_by_clause;
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

			// $query = mysqli_query($con,"Select * from users");
	    // $query2 = mysqli_query($con,"Select * from User_Donation");

			$user_already_ex_q = "SELECT user_id,title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang,scheme_id,scheme_name,corresponder,remarks FROM users WHERE phone_no = '$phone_no';";

			$searchSchemeId_query = "SELECT scheme_id,scheme_value FROM scheme WHERE scheme_name = '$scheme_name';";

			// $insert_user_query = "INSERT INTO users(title,first_name,last_name,address,phone_no,whatsapp,email_id,start_date,is_active,connected_to,user_lang) VALUES('$title','$first_name','$last_name','$address','$phone_no','$whatsapp','$email_id','$formatted_date','$is_active','$connected_to','$user_lang');";

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

					$insert_user_query = "INSERT INTO users(title,first_name,last_name,address,phone_no,whatsapp,dob,email_id,company_name,start_date,is_active,connected_to,user_lang,scheme_id,scheme_name,corresponder,remarks) VALUES('$title','$first_name','$last_name','$address','$phone_no','$whatsapp','$formatted_dob_date','$email_id','$company_name','$formatted_start_date','$is_active','$connected_to','$user_lang','$scheme_id','$scheme_name','$corresponder','$remarks');";

					//insert user into users table
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
		&& isset($data['whatsapp']) && isset($data['birth_date']) && isset($data['company_name'])
		&& isset($data['email_id']) && isset($data['start_date'])
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
			$dob = mysqli_real_escape_string($con,$data['birth_date']);
			$company_name = mysqli_real_escape_string($con,$data['company_name']);
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

			$dateTime_dob = date_create_from_format('d/m/Y',$dob);
			$formatted_date_dob = date_format($dateTime_dob, 'Y-m-d');

			$user_already_ex_q = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'u.address, u.phone_no, u.whatsapp, DATE_FORMAT(u.dob, "%d/%m/%Y") AS dob, u.company_name, u.email_id, '
			.'DATE_FORMAT(u.start_date, "%d/%m/%Y") AS start_date, u.is_active, '
			.'u.connected_to, u.user_lang, u.scheme_name, u.corresponder, u.remarks, s.scheme_value '
			.' FROM users u, scheme s WHERE s.scheme_id=u.scheme_id '
			.'and u.user_id=' .$user_id;

			$searchSchemeId_query = "SELECT scheme_id,scheme_value FROM scheme WHERE scheme_name = '$scheme_name';";

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

						$update_user_query = "UPDATE users SET title='$title', first_name='$first_name',"
						."last_name='$last_name',address='$address',phone_no='$phone_no',whatsapp='$whatsapp',"
						."dob='$formatted_date_dob', company_name='$company_name',"
						."email_id='$email_id',start_date='$formatted_date',is_active='$is_active',"
						."connected_to='$connected_to',user_lang='$user_lang',scheme_id='$scheme_id',"
						."scheme_name='$scheme_name',corresponder='$corresponder',remarks='$remarks' WHERE user_id='$user_id';";
					}
				} else {
					$update_user_query = "UPDATE users SET title='$title', first_name='$first_name',"
					." last_name='$last_name',address='$address',phone_no='$phone_no',whatsapp='$whatsapp',"
					."dob='$formatted_date_dob', company_name='$company_name',"
					."email_id='$email_id',start_date='$formatted_date',is_active='$is_active',"
					."connected_to='$connected_to',user_lang='$user_lang',"
					."corresponder='$corresponder',remarks='$remarks' WHERE user_id='$user_id';";
				}

				//update user into users table
				// echo $update_user_query;
				$updateUserResult = $dbcontroller->executeQuery($update_user_query);
				if($updateUserResult > 0){
					$updatedUserRes = $dbcontroller->executeSelectQuery($user_already_ex_q);
					if(count($updatedUserRes) > 0){
						$updatedData = $updatedUserRes[0];
						$result = array('success'=>1, 'msg'=>'Member details updated successfully', "code"=>'200', 'userData'=>$updatedData);
					}
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
