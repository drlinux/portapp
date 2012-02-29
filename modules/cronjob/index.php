<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Fxrate;

switch($_action) {
	case 'view':
	default:
		$data = $model->getFromCentralBank();
		//print_r($data);exit;
		break;
}