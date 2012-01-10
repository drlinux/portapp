<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productorder;

switch($_action)
{
	case 'sendStatusMessage':
		$mailer = new CasMailer();
		$mailer->Subject = $_POST["subject"];
		$mailer->MsgHTML($_POST["message"]);
		$mailer->AddAddress($_POST["to"]);
		if (isset($_POST["bcc"]) && CasMailer::ValidateAddress($_POST["bcc"])) $mailer->AddBCC($_POST["bcc"]);
		if($mailer->Send()) {
			echo(json_encode(array("success"=>true)));
		}
		else {
			echo(json_encode(array("success"=>false, "msg"=>$mailer->ErrorInfo)));
		}
		break;
	case 'saveStatus':
		$model->update($model->sTable, array("productorderstatusId"=>$_REQUEST["productorderstatusId"]), "productorderId = :productorderId", array("productorderId"=>$_REQUEST[$model->sIndexColumn]));
		echo(json_encode(array("success"=>true)));
		break;
	case 'dataTables':
		$aColumns = array("productorderId", "userFirstname", "userLastname", "XID", "productorderDatetime", "paymentgroupTitle", "transportationTitle", "productorderstatusTitle");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'show':
		$data["model"] = $model->getProductorder($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$productorderstatus = new Productorderstatus();
		$data["productorderstatus"] = $productorderstatus->getEntries(array("i18n"=>true));
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_show', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}