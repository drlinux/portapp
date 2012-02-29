<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute;

switch($_action)
{
	case 'jsonProductattributes':
		$data = $model->getProductattributes($_GET);
		echo(($data));
		break;
	case 'search':
		$model->displayTemplate("b2c", "search", $_GET);
		break;
	case 'view':
	default:
		//if ($_REQUEST["sSearch"] == null) header("Location: " . _MODULE_DIR_ . "b2c/");
		$model->displayTemplate("b2c", "search");
		break;
}