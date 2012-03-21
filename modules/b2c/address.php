<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

Permission::checkPermissionRedirect("b2c");

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
		$data = $model->getEntryOwned($_REQUEST[$model->sIndexColumn]);
		echo(json_encode($data));
		break;
	case 'savePostaladdress':
		$_POST["userId"] = $_SESSION["userId"];
		$postaladdressId = $model->saveEntry($_POST);
		$model->insert("user_".$_POST["postaladdressType"], array("userId"=>$_SESSION["userId"], "postaladdressId"=>$postaladdressId));
		echo json_encode(array("success"=>true));
		break;
	case 'deletePostaladdress':
		$model->removeEntryOwned($_REQUEST[$model->sIndexColumn]);
		echo(json_encode(array("success"=>true)));
		break;
	case 'view':
	default:
		// Delivery Address
		$user = new User();
		$data["delivery_address"] = $user->getDeliveryaddresses();
		addJavascript("assets/extension/classes/Postaladdress.js");
		
		$model->displayTemplate("b2c", "address", $data);
		break;
}