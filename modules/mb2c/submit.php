<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new CasBase;

switch($_action)
{
	case 'test':
		echo(json_encode(array("dede")));
		break;
	case 'view':
	default:
		$model->displayTemplate('mb2c', 'submit');
		break;
}