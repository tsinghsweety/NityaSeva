<?php
require_once("MemberRestHandler.php");
$method = $_SERVER['REQUEST_METHOD'];
$view = "";
session_start();
// print_r($_SESSION)
// var_dump($_GET)
if(isset($_SESSION["logged_in"]) && ($_SESSION["logged_in"] == true) && !empty($_SESSION["logged_in_user"])){
	if(isset($_GET["page_key"])){
			$page_key = $_GET["page_key"];
		/*
		controls the RESTful services
		URL mapping
		*/
			switch($page_key){

					case "list":
						// to handle REST Url /mobile/list/
						$memberRestHandler = new MemberRestHandler();
						$result = $memberRestHandler->getAllMembers();
						break;

					case "create":
						// to handle REST Url /mobile/create/
						$memberRestHandler = new MemberRestHandler();
						$memberRestHandler->add();
					break;

					case "delete":
						// to handle REST Url /mobile/delete/<row_id>
						$memberRestHandler = new MemberRestHandler();
						$result = $memberRestHandler->deleteMemberById();
					break;

					case "update":
						// to handle REST Url /mobile/update/<row_id>
						$memberRestHandler = new MemberRestHandler();
						$memberRestHandler->editMemberById();
					break;

					case "corresponderlist":
						//to handle REST Url /member/corresponderlist
						$memberRestHandler = new MemberRestHandler();
						$memberRestHandler->getAllCorresponders();
			}
	}
} else {
	$statusCode = 403;
	$result = array('success' => 0, 'status' => 'Access Denied', 'msg'=>'user not logged in');
	$requestContentType = 'application/json';
	$memberRestHandler = new MemberRestHandler();
	$memberRestHandler ->setHttpHeaders($requestContentType, $statusCode);
	echo $memberRestHandler->encodeJson($result);
}
?>
