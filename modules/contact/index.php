<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Userticket();

switch($_action)
{
	case 'saveUserticket':
		$model->mungeFormData($_POST);
		if ($model->isValidForm($_POST)) {
			echo(json_encode(array("success"=>$model->sendForm($_POST), "msg"=>$model->msg, "field"=>$model->field)));
		}
		else {
			echo(json_encode(array("success"=>false, "msg"=>$model->msg, "field"=>$model->field)));
		}
		break;
	case 'view':
	default:
		global $data;
		addJavascript("assets/extension/classes/GMAPHelper.js");
		$model->displayTemplate("b2b", "index", $data);
		break;
}