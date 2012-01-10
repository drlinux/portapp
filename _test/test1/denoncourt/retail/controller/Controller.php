<?php
namespace denoncourt\retail\controller;
use denoncourt\retail as retail;

class Controller {
	public function execute() {
		switch ($_GET['action']) {
			case 'showItem' :
				$item = new retail\model\Item();
				require "denoncourt/retail/utils/format.php";
				require "denoncourt/retail/view/item.php";
				break;
		}
	}
}