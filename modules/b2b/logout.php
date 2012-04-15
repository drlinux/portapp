<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$usertrack = new Usertrack();
$usertrack->addTrack(2);
$language = $_SESSION["PROJECT_LANGUAGE"];
$_SESSION = array();
session_destroy();
session_start();
$_SESSION["PROJECT_LANGUAGE"] = $language;
header("Location: " . $project['url'] . "modules/b2b/");
