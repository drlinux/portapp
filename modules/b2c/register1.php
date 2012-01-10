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
	case 'register':
		$model->mungeRegisterFormData($_POST);
		if ($model->isValidRegisterForm($_POST))
		{
			$model->saveRegisterForm($_POST);
		}
		$_POST['userBirthdate'] = implode(".", array_reverse(explode("-", trim($_POST['userBirthdate']))));
		$model->displayTemplate("b2c", "register1", $_POST);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2c", "register1", null);
		break;
}