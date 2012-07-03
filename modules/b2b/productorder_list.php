<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

///print_r($_SESSION);


Permission::checkPermissionRedirect("b2b");

$model = new Productorder();
$model->run("SET LC_TIME_NAMES=tr_TR");
$data = array_merge($data, $model->getProductordersOwned());
//print_r($data);exit;


$model->displayTemplate("b2b", $model->sTable."_list", $data);