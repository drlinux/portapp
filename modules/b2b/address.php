<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

Permission::checkPermissionRedirect("b2b");

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
		$postaladdressId = $_REQUEST["postaladdressId"];
		$data = $model->getEntryOwned($postaladdressId);
		echo(json_encode($data));
		break;
	case 'savePostaladdress':
		$postaladdressType = $_POST["postaladdressType"];
		$_POST["userId"] = $_SESSION["userId"];
		$postaladdressId = $model->saveEntry($_POST);
		$model->insert("user_".$postaladdressType, array("userId"=>$_SESSION["userId"], "postaladdressId"=>$postaladdressId));
		echo(json_encode(array("success"=>true)));
		break;
	case 'deletePostaladdress':
		$model->removeEntryOwned($_POST[$model->sIndexColumn]);
		echo(json_encode(array("success"=>true)));
		break;
	case 'view':
	default:
		$model->displayTemplate("b2b", "address", $data);
		break;
}