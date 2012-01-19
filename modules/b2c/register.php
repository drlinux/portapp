<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User;

switch($_action)
{
	case 'getUserAgreement':
		$pageId = 2; // TODO: UserAgreement için pageId
		$page = new Page;
		$detailPage = $page->getEntry($pageId, array("i18n"=>true));
		echo $detailPage["pageContent"];
		break;
	case 'saveUser':
		if ($model->isValidRegisterForm($_POST)) {
			echo(json_encode(array("success"=>$model->saveRegisterForm($_POST, $smarty->getVariable("_USER_ROLE_B2C") , $smarty->getVariable("_USER_INITIALSTATUS_B2C")), "msg"=>$model->msg, "field"=>$model->field)));
		}
		else {
			echo(json_encode(array("success"=>false, "msg"=>$model->msg, "field"=>$model->field)));
		}
		break;
	case 'view':
	default:
		$model->displayTemplate("b2c", "register", null);
		break;
}