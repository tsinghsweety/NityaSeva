<?php
require_once("../common/dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class GiftPrasadam {
	private $btgs = array();
	public function getAllGiftPrasadam(){
		if(isset($_GET['member_id']) && isset($_GET['type'])){
			$user_id = $_GET['member_id'];
			$type = $_GET['type'];
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'ugp.description, ugp.is_dispatched, DATE_FORMAT(ugp.dispatch_date, "%d/%m/%Y") as dispatch_date, ugp.remarks'
			.' FROM users u, user_gift_prasadam ugp WHERE u.user_id=ugp.user_id and '.
			' ugp.user_id=' .$user_id. ' and ugp.type="'.$type
			. '" ORDER BY ugp.dispatch_date DESC';
		} else if(isset($_GET['type'])){
			$type = $_GET['type'];
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'ugp.description, ugp.is_dispatched, DATE_FORMAT(ugp.dispatch_date, "%d/%m/%Y") as dispatch_date, ugp.remarks'
			.' FROM users u, user_gift_prasadam ugp WHERE u.user_id=ugp.user_id and '.
			'  ugp.type="'.$type
			. '" ORDER BY ugp.dispatch_date DESC';
		} else {
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'ugp.description, ugp.is_dispatched, DATE_FORMAT(ugp.dispatch_date, "%d/%m/%Y") as dispatch_date, ugp.remarks'
			.' FROM users u, user_gift_prasadam ugp WHERE u.user_id=ugp.user_id '
			. ' ORDER BY ugp.dispatch_date DESC';
		}
		$dbcontroller = new DBController();
		$this->btgs = $dbcontroller->executeSelectQuery($query);
		return $this->btgs;
	}

	public function addGiftPrasadam(){
		$data = json_decode(file_get_contents('php://input'), true);
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'701');
		// $_SESSION['selected_member_id'] = 55;
		// print_r($_SESSION);
		// echo $_SESSION;
		if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] === true)
		&& isset($_GET['member_id']) && isset($_GET['type']) && isset($data['gp_desc'])
		&& isset($data['gp_is_dispatched']) && isset($data['gp_dispatch_date'])
		&& isset($data['gp_remarks'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$user_id = mysqli_real_escape_string($con,$_GET['member_id']);
	    $gp_desc = mysqli_real_escape_string($con,$data['gp_desc']);
	    $gp_is_dispatched = mysqli_real_escape_string($con,$data['gp_is_dispatched']);
	    $gp_dispatch_date = mysqli_real_escape_string($con,$data['gp_dispatch_date']);
	    $gp_remarks = mysqli_real_escape_string($con,$data['gp_remarks']);
	    $type = mysqli_real_escape_string($con,$_GET['type']);

			$dateTime = date_create_from_format('d/m/Y',$gp_dispatch_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');

			$insert_user_gp_query = "INSERT INTO user_gift_prasadam(user_id,type,description,is_dispatched,dispatch_date,remarks) VALUES('$user_id','$type','$gp_desc','$gp_is_dispatched','$formatted_date','$gp_remarks');";

			//insert user into User_BTG table
			$insertUserGPResult = $dbcontroller->executeQuery($insert_user_gp_query);
			if($insertUserGPResult > 0){
				$typeStr = $type === "gift" ? "Gift" : "Prasadam";
				$result = array('success'=>1, 'msg'=>$typeStr.' added successfully', "code"=>'200', 'userData'=>$data);
			} else {
				$result = array('success'=>0, "msg"=>"API issue", "code"=>'703');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'702');
		}

		return $result;
	}

	public function deleteGiftPrasadam(){
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

	public function editGiftPrasadam(){
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
