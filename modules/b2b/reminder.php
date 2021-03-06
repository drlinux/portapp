<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User;

switch($_action)
{
	case 'resetUserPass':
		if ($model->isValidReminderForm($_POST)) {
			echo(json_encode(array("success"=>$model->sendReminderForm($_POST), "msg"=>$model->msg, "field"=>$model->field)));
		}
		else {
			echo(json_encode(array("success"=>false, "msg"=>$model->msg, "field"=>$model->field)));
		}
		break;
	case 'view':
	default:
		addJavascript("assets/extension/classes/User.js");
		$model->displayTemplate("b2b", "reminder", null);
		break;
}