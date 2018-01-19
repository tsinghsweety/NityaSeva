<?php
require_once("PaymentRestHandler.php");
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
						$paymentRestHandler = new PaymentRestHandler();
						$result = $paymentRestHandler->getAllPayments();
						break;

					case "create":
						// to handle REST Url /mobile/create/
						$paymentRestHandler = new PaymentRestHandler();
						$paymentRestHandler->add();
					break;

					case "delete":
						// to handle REST Url /mobile/delete/<row_id>
						$paymentRestHandler = new PaymentRestHandler();
						$result = $paymentRestHandler->deletePaymentById();
					break;

					case "update":
						// to handle REST Url /mobile/update/<row_id>
						$paymentRestHandler = new PaymentRestHandler();
						$paymentRestHandler->editPaymentById();
					break;
			}
	}
} else {
	$statusCode = 403;
	$result = array('success' => 0, 'status' => 'Access Denied', 'msg'=>'user not logged in');
	$requestContentType = 'application/json';
	$paymentRestHandler = new PaymentRestHandler();
	$paymentRestHandler ->setHttpHeaders($requestContentType, $statusCode);
	echo $paymentRestHandler->encodeJson($result);
}
?>
