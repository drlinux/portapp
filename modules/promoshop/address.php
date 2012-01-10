<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("promoshop");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Postaladdress;

switch($_action)
{
	case 'jsonDeliveryaddresses':
		$user = new User();
		echo(json_encode($user->getDeliveryaddresses()));
		break;
	case 'jsonInvoiceaddresses':
		$user = new User();
		echo(json_encode($user->getInvoiceaddresses()));
		break;
	case 'jsonPostaladdress':
		$postaladdress = new Postaladdress;
		$postaladdressId = $_REQUEST["postaladdressId"];
		$data = $postaladdress->getEntryOwned($postaladdressId);
		echo(json_encode($data));
		break;
	case 'savePostaladdress':
		$postaladdressType = $_POST["postaladdressType"];
		$postaladdressId = $_POST["postaladdressId"];
		$postaladdressContent = $_POST["postaladdressContent"];
		$postaladdressCity = $_POST["postaladdressCity"];
		$postaladdressCounty = $_POST["postaladdressCounty"];
		$postaladdressPostalcode = $_POST["postaladdressPostalcode"];
		$postaladdressCountry = $_POST["postaladdressCountry"];
		
		$postaladdress = new Postaladdress;
		$postaladdressId = $postaladdress->saveEntry(
			array(
				"postaladdressId"=>$postaladdressId,
				"userId"=>$_SESSION["userId"],
				"postaladdressContent"=>$postaladdressContent,
				"postaladdressCity"=>$postaladdressCity,
				"postaladdressCounty"=>$postaladdressCounty,
				"postaladdressPostalcode"=>$postaladdressPostalcode,
				"postaladdressCountry"=>$postaladdressCountry
			)
		);
		
		$postaladdress->insert("user_".$postaladdressType, array("userId"=>$_SESSION["userId"], "postaladdressId"=>$postaladdressId));
		
		echo json_encode($_POST);
		break;
	case 'deletePostaladdress':
		$postaladdressId = $_POST["postaladdressId"];
		$postaladdress = new Postaladdress;
		$data = $postaladdress->getEntryOwned($postaladdressId);
		$postaladdress->removeEntryOwned($postaladdressId);
		echo(json_encode($data));
		break;
	case 'view':
	default:
		$model->displayTemplate("promoshop", "address", $data);
		break;
}