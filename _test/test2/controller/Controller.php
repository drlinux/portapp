<?php
namespace controller;
use model as model;

class Controller
{
	public function execute()
	{
		$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';
		switch ($_action)
		{
			case 'show' :
				$item = new model\Item();
				require "deneme/page/utils/format.php";
				require "deneme/page/view/item.php";
				break;
			case 'view':
			default:
				$page = new model\Page();
				var_dump($page);
				echo $page->info();
				//echo "done";exit;
				//$data = $model->getDefaultPage();
				//$model->displayTemplate("b2c", "index");
				break;
		}
	}
}