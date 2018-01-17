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

	$title = mysqli_real_escape_string($con,$_POST['title']);
	$first_name = mysqli_real_escape_string($con,$_POST['first_name']);
	$last_name = mysqli_real_escape_string($con,$_POST['last_name']);
	$address = mysqli_real_escape_string($con,$_POST['address']);
	$phone_no = mysqli_real_escape_string($con,$_POST['phone_no']);
	$whatsapp = mysqli_real_escape_string($con,$_POST['whatsapp']);
	$email_id = mysqli_real_escape_string($con,$_POST['email_id']);
	$start_date = mysqli_real_escape_string($con,$_POST['date']);
	$is_corresponder = mysqli_real_escape_string($con,$_POST['is_corresponder']);
	$is_active = mysqli_real_escape_string($con,$_POST['is_active']);
	$connected_to = mysqli_real_escape_string($con,$_POST['connected_to']);
	$scheme_name = mysqli_real_escape_string($con,$_POST['scheme_name']);
	$payment_type = mysqli_real_escape_string($con,$_POST['payment_type']);
	$corresponder = mysqli_real_escape_string($con,$_POST['corresponder']);
	$user_lang = mysqli_real_escape_string($con,$_POST['user_lang']);
	$remarks = mysqli_real_escape_string($con,$_POST['remarks']);

	public function addMember(){
		if(isset($_POST['title']) && isset($_POST['first_name']) && isset($_POST['last_name'])){
			$dbcontroller = new DBController();
			$con = $dbcontroller->$conn;

			$title = mysqli_real_escape_string($con,$_POST['title']);
			$first_name = mysqli_real_escape_string($con,$_POST['first_name']);
			$last_name = mysqli_real_escape_string($con,$_POST['last_name']);
			$address = mysqli_real_escape_string($con,$_POST['address']);
			$phone_no = mysqli_real_escape_string($con,$_POST['phone_no']);
			$whatsapp = mysqli_real_escape_string($con,$_POST['whatsapp']);
			$email_id = mysqli_real_escape_string($con,$_POST['email_id']);
			$start_date = mysqli_real_escape_string($con,$_POST['date']);
			$is_corresponder = mysqli_real_escape_string($con,$_POST['is_corresponder']);
			$is_active = mysqli_real_escape_string($con,$_POST['is_active']);
			$connected_to = mysqli_real_escape_string($con,$_POST['connected_to']);
			$scheme_name = mysqli_real_escape_string($con,$_POST['scheme_name']);
			$payment_type = mysqli_real_escape_string($con,$_POST['payment_type']);
			$corresponder = mysqli_real_escape_string($con,$_POST['corresponder']);
			$user_lang = mysqli_real_escape_string($con,$_POST['user_lang']);
			$remarks = mysqli_real_escape_string($con,$_POST['remarks']);

			$query = "insert into Users (title,first_name,last_name, address,phone_no,whatsapp,email_id,date,is_corresponder,is_active,connected_to,scheme_name,payment_type,corresponder,user_lang,remarks) values ('$name','$model','$color')";

			$result = $dbcontroller->executeQuery($query);
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
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
