<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Userticket;

switch($_action) {
	case 'dataTables':
		$aColumns = array( 'userticketId', 'userticketName', 'userticketEmail', 'userticketPhone', 'userticketSubject', 'userticketMessage' );
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'edit':
		$data = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$model->displayTemplate("admin", $model->sTable.'_form');
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}