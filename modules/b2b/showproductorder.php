<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

Permission::checkPermissionRedirect("b2b");

$model = new Productorder();
$data = array_merge($data, $model->getProductorder($_REQUEST[$model->sIndexColumn]));

$model->displayTemplate("b2b", $model->sTable."_show", $data);
