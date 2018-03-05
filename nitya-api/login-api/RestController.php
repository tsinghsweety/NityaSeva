<?php
require_once("LoginRestHandler.php");
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

					case "checkloggedin":
						$statusCode = 200;
						$result = array('success' => 1, 'status' => 'Access Granted', 'msg'=>'user logged in');
						$requestContentType = 'application/json';
						$loginRestHandler = new LoginRestHandler();
						$loginRestHandler ->setHttpHeaders($requestContentType, $statusCode);
						echo $loginRestHandler->encodeJson($result);
						break;

					case "checksuperadmin":
						if(isset($_SESSION["is_super_admin"]) && ($_SESSION["is_super_admin"] === true)){
							$statusCode = 200;
							$result = array('success' => 1, 'status' => 'Access Granted', 'msg'=>'user logged in');
							$requestContentType = 'application/json';
							$loginRestHandler = new LoginRestHandler();
							$loginRestHandler ->setHttpHeaders($requestContentType, $statusCode);
							echo $loginRestHandler->encodeJson($result);
						} else {
							$statusCode = 403;
							$result = array('success' => 0, 'status' => 'Access Denied', 'msg'=>'secure content');
							$requestContentType = 'application/json';
							$loginRestHandler = new LoginRestHandler();
							$loginRestHandler ->setHttpHeaders($requestContentType, $statusCode);
							echo $loginRestHandler->encodeJson($result);
						}
						break;
			}
	}
} else {
	$statusCode = 403;
	$result = array('success' => 0, 'status' => 'Access Denied', 'msg'=>'user not logged in');
	$requestContentType = 'application/json';
	$loginRestHandler = new LoginRestHandler();
	$loginRestHandler ->setHttpHeaders($requestContentType, $statusCode);
	echo $loginRestHandler->encodeJson($result);
}
?>
