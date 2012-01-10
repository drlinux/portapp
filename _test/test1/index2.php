<?php
include 'Fruit.php';
include 'Apple.php';

$apple = new MyApp\Apple();
$name = 'MyApp\Apple';

var_dump (is_subclass_of($apple, 'MyApp\Fruit'));
var_dump (is_a($apple, 'MyApp\Apple'));
var_dump (new $name);

$apple = new MyApp\Apple();
$apple->getInstance()->dede();