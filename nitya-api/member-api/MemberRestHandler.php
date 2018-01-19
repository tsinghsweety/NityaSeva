<?php
require_once("SimpleRest.php");
require_once("Member.php");

class MemberRestHandler extends SimpleRest {

	function getAllMembers() {

		$member = new Member();
		$rawData = $member->getAllMember();
        //var_dump($rawData);

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);
		} else {
			$statusCode = 200;
		}

//		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$requestContentType = 'application/json';
		$this ->setHttpHeaders($requestContentType, $statusCode);

		$result["output"] = $rawData;

		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}

	function add() {
		$member = new Member();
		$rawData = $member->addMember();
		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);
		} else {
			$statusCode = 200;
		}

		// $requestContentType = $_SERVER['HTTP_ACCEPT'];
		$requestContentType = 'application/json';
		$this ->setHttpHeaders($requestContentType, $statusCode);
		$result = $rawData;

		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}

	function deleteMobileById() {
		$member = new Member();
		$rawData = $member->deleteMember();

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);
		} else {
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		$result = $rawData;

		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}

	function editMemberById() {
		$member = new Member();
		$rawData = $member->editMember();
		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);
		} else {
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		$result = $rawData;

		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}

	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;
	}
}
?>
