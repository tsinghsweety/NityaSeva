<?php
require_once("../common/SimpleRest.php");
require_once("BTG.php");

class BTGRestHandler extends SimpleRest {

	function getAllBTGs() {

		$btg = new BTG();
		$rawData = $btg->getAllBTG();
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
		$btg = new BTG();
		$rawData = $btg->addBTG();
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

	function deleteBTGById() {
		$btg = new BTG();
		$rawData = $btg->deleteBTG();

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

	function editBTGById() {
		$btg = new BTG();
		$rawData = $btg->editBTG();
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
