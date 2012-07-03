<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$Company = new Company;

switch($_action)
{
	case 'saveCompany':
		extract($_POST, EXTR_SKIP);
		if($Company->updateCompany($companyId, array(
			"companyTitle"=>$companyTitle,
			"companyTax"=>$companyTax,
			"companyPhone"=>$companyPhone,
			"companyAddress"=>$companyAddress
		)))
		{
			echo json_encode(array("success"=>true, "msg"=>$smarty->getConfigVariable("ALERT_Completed")));
		}
		else
		{
			echo json_encode(array("success"=>false, "msg"=>$smarty->getConfigVariable("ALERT_ErrorOccured")));
		}
	exit;
	
	case 'view':
	default:
		$User = new User;
		
		$data["retailer"] = $User->getB2BUser($_SESSION["userId"]);
		addJavascript("assets/extension/classes/Company.js");
		
		$User->displayTemplate("b2b", "retailer", $data);
		break;
}