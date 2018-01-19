<?php
require_once("../common/SimpleRest.php");
require_once("GiftPrasadam.php");

class GiftPrasadamRestHandler extends SimpleRest {

	function getAllGiftPrasadams() {

		$giftPrasadam = new GiftPrasadam();
		$rawData = $giftPrasadam->getAllGiftPrasadam();
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
		$giftPrasadam = new GiftPrasadam();
		$rawData = $giftPrasadam->addGiftPrasadam();
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

	function deleteGiftPrasadamById() {
		$giftPrasadam = new GiftPrasadam();
		$rawData = $giftPrasadam->deleteGiftPrasadam();

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

	function editGiftPrasadamById() {
		$giftPrasadam = new GiftPrasadam();
		$rawData = $giftPrasadam->editGiftPrasadam();
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
