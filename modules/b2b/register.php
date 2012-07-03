<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User;
$company = new Company;

switch($_action)
{
	case 'getUserAgreement':
		$pageId = 2; // TODO: UserAgreement için pageId
		$page = new Page;
		$detailPage = $page->getEntry($pageId, array("i18n"=>true));
		echo $detailPage["pageContent"];
		break;
	case 'saveUser':
		extract($_POST, EXTR_SKIP);
		
		if ($model->isValidB2BRegisterForm($_POST)) {
			if($userId = $model->saveRegisterFormTypeB2B($_POST, $smarty->getVariable("_USER_ROLE_B2B"), $smarty->getVariable("_USER_INITIALSTATUS_B2B")))
			{
				if($company->addCompany(array("companyTax"=>$companyTax, "companyTitle"=>$companyTitle, "companyPhone"=>$companyPhone, "companyFax"=>$companyFax, "companyAddress"=>$companyAddress, "userId"=>$userId)))
					echo(json_encode(array("success"=>true, "msg"=>$model->msg, "field"=>$model->field)));
				else
					echo(json_encode(array("success"=>false, "msg"=>$model->msg, "field"=>$model->field)));
			}
			else
			{
				echo(json_encode(array("success"=>false, "msg"=>$model->msg)));
			}
		}
		else {
			echo(json_encode(array("success"=>false, "msg"=>$model->msg, "field"=>$model->field)));
		}
		break;
	case 'view':
	default:
		addJavascript("assets/extension/classes/User.js");
		$model->displayTemplate("b2b", "register", null);
		break;
}