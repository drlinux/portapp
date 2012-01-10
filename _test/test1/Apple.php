<?php
namespace MyApp;

class Apple extends Fruit {
	public static function getInstance() {
		return new Apple;
	}
	
	function dede() {
		echo "dede";
	}
}