<?php
require_once("AdminRestHandler.php");
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
						$adminRestHandler = new AdminRestHandler();
						$result = $adminRestHandler->getAllAdmins();
						break;

					case "create":
						// to handle REST Url /mobile/create/
						$adminRestHandler = new AdminRestHandler();
						$adminRestHandler->add();
					break;

					case "delete":
						// to handle REST Url /mobile/delete/<row_id>
						$adminRestHandler = new AdminRestHandler();
						$result = $adminRestHandler->deleteAdminById();
					break;

					case "update":
						// to handle REST Url /mobile/update/<row_id>
						$adminRestHandler = new AdminRestHandler();
						$adminRestHandler->editAdminById();
					break;
			}
	}
} else {
	$statusCode = 403;
	$result = array('success' => 0, 'status' => 'Access Denied', 'msg'=>'user not logged in');
	$requestContentType = 'application/json';
	$adminRestHandler = new AdminRestHandler();
	$adminRestHandler ->setHttpHeaders($requestContentType, $statusCode);
	echo $adminRestHandler->encodeJson($result);
}
?>
