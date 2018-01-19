<?php
require_once("BTGRestHandler.php");
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
						$btgRestHandler = new BTGRestHandler();
						$result = $btgRestHandler->getAllBTGs();
						break;

					case "create":
						// to handle REST Url /mobile/create/
						$btgRestHandler = new BTGRestHandler();
						$btgRestHandler->add();
					break;

					case "delete":
						// to handle REST Url /mobile/delete/<row_id>
						$btgRestHandler = new BTGRestHandler();
						$result = $btgRestHandler->deleteBTGById();
					break;

					case "update":
						// to handle REST Url /mobile/update/<row_id>
						$btgRestHandler = new BTGRestHandler();
						$btgRestHandler->editBTGById();
					break;
			}
	}
} else {
	$statusCode = 403;
	$result = array('success' => 0, 'status' => 'Access Denied', 'msg'=>'user not logged in');
	$requestContentType = 'application/json';
	$btgRestHandler = new PaymentRestHandler();
	$btgRestHandler ->setHttpHeaders($requestContentType, $statusCode);
	echo $btgRestHandler->encodeJson($result);
}
?>
