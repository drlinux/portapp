<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new CasBase;

switch($_action)
{
	case 'view':
	default:
		$model->displayTemplate('mb2c', 'category');
		break;
}