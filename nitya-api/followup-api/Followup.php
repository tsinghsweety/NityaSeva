<?php
require_once("../common/dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class Followup {
	private $followups = array();
	public function getAllFollowup(){
		if(isset($_GET['user_id'])){
			$user_id = $_GET['user_id'];
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'f.followup_date, f.followup_remark, f.nxt_followup_date'
			.' FROM Users u, Follow_Up f WHERE u.user_id=f.user_id and '.
			' f.user_id="' .$user_id
			. '" ORDER BY f.followup_date DESC';
		} else {
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, '
			.'f.followup_date, f.followup_remark, f.nxt_followup_date'
			.' FROM Users u, Follow_Up f WHERE u.user_id=f.user_id '
			. ' ORDER BY f.followup_date DESC';
		}
		$dbcontroller = new DBController();
		$this->btgs = $dbcontroller->executeSelectQuery($query);
		return $this->btgs;
	}

	public function addFollowup(){
		$data = json_decode(file_get_contents('php://input'), true);
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'601');
		// $_SESSION['selected_member_id'] = 55;
		// print_r($_SESSION);
		// echo $_SESSION;
		if(isset($_SESSION['selected_member_id']) && isset($data['followup_date'])
		&& isset($data['followup_remark']) && isset($data['nxt_followup_date'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$user_id = mysqli_real_escape_string($con,$_SESSION['selected_member_id']);
	    $followup_date = mysqli_real_escape_string($con,$data['followup_date']);
	    $followup_remark = mysqli_real_escape_string($con,$data['followup_remark']);
	    $nxt_followup_date = mysqli_real_escape_string($con,$data['nxt_followup_date']);

			$dateTime = date_create_from_format('d/m/Y',$followup_date);
			$nxtDateTime = date_create_from_format('d/m/Y',$nxt_followup_date);

			$formatted_date = date_format($dateTime, 'Y-m-d');
			$nxt_formatted_date = date_format($nxtDateTime, 'Y-m-d');

			$insert_followup_query = "INSERT INTO Follow_Up(user_id,followup_date,followup_remark,nxt_followup_date) VALUES('$user_id','$formatted_date','$followup_remark','$nxt_formatted_date');";

			//insert user into Follow_Up table
			$insertFollowupResult = $dbcontroller->executeQuery($insert_followup_query);
			if($insertFollowupResult > 0){
				$result = array('success'=>1, 'msg'=>'Followup added successfully', "code"=>'200', 'userData'=>$data);
			} else {
				$result = array('success'=>0, "msg"=>"API issue", "code"=>'603');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'602');
		}

		return $result;
	}

	public function deleteFollowup(){
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

	public function editFollowup(){
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
