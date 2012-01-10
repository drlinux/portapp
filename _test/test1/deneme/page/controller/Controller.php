<?php
namespace deneme\page\controller;
use deneme\page as page;

class Controller
{
	public function execute()
	{
		$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';
		switch ($_action)
		{
			case 'show' :
				$item = new page\model\Item();
				require "deneme/page/utils/format.php";
				require "deneme/page/view/item.php";
				break;
			case 'view':
			default:
				$page = new page\model\Page();
				var_dump($page);
				//echo "done";exit;
				//$data = $model->getDefaultPage();
				//$model->displayTemplate("b2c", "index");
				break;
		}
	}
}