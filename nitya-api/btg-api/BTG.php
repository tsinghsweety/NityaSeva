<?php
require_once("../common/dbcontroller.php");
/*
A domain Class to demonstrate RESTful web services
*/
Class BTG {
	private $btgs = array();
	public function getAllBTG(){
		if(isset($_GET['user_id'])){
			$user_id = $_GET['user_id'];
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, ub.btg_lang, '
			.' ub.description, ub.is_dispatched, ub.dispatch_date, ub.remarks'
			.' FROM Users u, User_BTG ub WHERE u.user_id=ub.user_id and ub.user_id=' .$user_id
			.' ORDER BY ub.dispatch_date DESC';
		} else {
			$query = 'SELECT u.user_id, u.title, u.first_name, u.last_name, ub.btg_lang, '
			.' ub.description, ub.is_dispatched, ub.dispatch_date, ub.remarks'
			.' FROM Users u, User_BTG ub WHERE u.user_id=ub.user_id '
			.' ORDER BY ub.dispatch_date DESC';
		}

		$dbcontroller = new DBController();
		$this->btgs = $dbcontroller->executeSelectQuery($query);
		return $this->btgs;
	}

	public function addBTG(){
		$data = json_decode(file_get_contents('php://input'), true);
		$result = array('success'=>0, "msg"=>"API issue", "code"=>'801');
		// $_SESSION['selected_member_id'] = 55;
		// print_r($_SESSION);
		// echo $_SESSION;
		if(isset($_SESSION['selected_member_id']) && isset($data['btg_lang'])
		&& isset($data['sent_btg_lang']) && isset($data['btg_desc'])
		&& isset($data['btg_is_dispatched']) && isset($data['btg_dispatch_date'])
		&& isset($data['btg_remarks'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->connectDB();

			$user_id = mysqli_real_escape_string($con,$_SESSION['selected_member_id']);
			$sent_btg_lang = mysqli_real_escape_string($con,$data['sent_btg_lang']);
	    $btg_desc = mysqli_real_escape_string($con,$data['btg_desc']);
	    $btg_is_dispatched = mysqli_real_escape_string($con,$data['btg_is_dispatched']);
	    $btg_dispatch_date = mysqli_real_escape_string($con,$data['btg_dispatch_date']);
	    $btg_remarks = mysqli_real_escape_string($con,$data['btg_remarks']);

			$dateTime = date_create_from_format('d/m/Y',$btg_dispatch_date);
			$formatted_date = date_format($dateTime, 'Y-m-d');

			$insert_user_btg_query = "INSERT INTO User_BTG(user_id,btg_lang,description,is_dispatched,dispatch_date,remarks) VALUES('$user_id','$sent_btg_lang','$btg_desc','$btg_is_dispatched','$formatted_date','$btg_remarks');";

			//insert user into User_BTG table
			$insertUserBTGResult = $dbcontroller->executeQuery($insert_user_btg_query);
			if($insertUserBTGResult > 0){
				$result = array('success'=>1, 'msg'=>'BTG added successfully', "code"=>'200', 'userData'=>$data);
			} else {
				$result = array('success'=>0, "msg"=>"API issue", "code"=>'803');
			}
		} else {
			$result = array('success'=>0, "msg"=>"API issue", "code"=>'802');
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
