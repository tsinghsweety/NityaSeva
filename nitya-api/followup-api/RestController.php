<?php
require_once("FollowupRestHandler.php");
$method = $_SERVER['REQUEST_METHOD'];
$view = "";
session_start();
// print_r($_SESSION)
// var_dump($_GET)
if(isset($_SESSION["logged_in"]) && ($_SESSION["logged_in"] === true) && !empty($_SESSION["logged_in_user"])){
	if(isset($_GET["page_key"])){
			$page_key = $_GET["page_key"];
		/*
		controls the RESTful services
		URL mapping
		*/
			switch($page_key){

					case "list":
						// to handle REST Url /mobile/list/
						$followupRestHandler = new FollowupRestHandler();
						$result = $followupRestHandler->getAllFollowups();
						break;

					case "create":
						// to handle REST Url /mobile/create/
						$followupRestHandler = new FollowupRestHandler();
						$followupRestHandler->add();
					break;

					case "delete":
						// to handle REST Url /mobile/delete/<row_id>
						$followupRestHandler = new FollowupRestHandler();
						$result = $followupRestHandler->deleteGiftPrasadamById();
					break;

					case "update":
						// to handle REST Url /mobile/update/<row_id>
						$followupRestHandler = new FollowupRestHandler();
						$followupRestHandler->editGiftPrasadamById();
					break;
			}
	}
} else {
	$statusCode = 403;
	$result = array('success' => 0, 'status' => 'Access Denied', 'msg'=>'user not logged in');
	$requestContentType = 'application/json';
	$followupRestHandler = new FollowupRestHandler();
	$followupRestHandler ->setHttpHeaders($requestContentType, $statusCode);
	echo $followupRestHandler->encodeJson($result);
}
?>
