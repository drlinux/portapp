<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Optinout;

switch($_action)
{
	case 'saveOptin':
		$model->mungeFormData($_POST);
		if ($model->isValidForm($_POST))
		{
			$model->saveOptin($_POST);
		}
		$model->displayTemplate("b2c", "index", $_POST);
		break;
	case 'saveOptout':
		$model->mungeFormData($_POST);
		if ($model->isValidForm($_POST))
		{
			$model->saveOptout($_POST);
		}
		$model->displayTemplate("b2c", "index", $_POST);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2c", "index", null);
		break;
}