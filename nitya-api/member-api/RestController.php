<?php
require_once("MemberRestHandler.php");
$method = $_SERVER['REQUEST_METHOD'];
$view = "";
if(isset($_GET["page_key"]))
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
}
?>
