<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Product;

switch($_action)
{
	case 'view':
	default:
		$model->importXml("https://localhost/portapp/modules/nebim/backup/Row.xml");
		echo "tamamlandı";
		break;
}