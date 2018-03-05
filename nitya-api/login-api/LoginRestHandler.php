<?php
require_once("../common/SimpleRest.php");
// require_once("Payment.php");

class LoginRestHandler extends SimpleRest {

	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;
	}
}
?>
