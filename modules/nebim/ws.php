<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new ProductOdbc;

switch($_action)
{
	case 'view':
	default:
		/* soak in the passed variable or set our own */
		$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
		$format = ( isset($_GET['format']) && strtolower($_GET['format']) == 'json' ) ? 'json' : 'xml'; //xml is the default
		
		$formvars = array("limit"=>$number_of_posts);
		
		$data = $model->getEntries($formvars);
		$posts = $data["aaData"];
		//print_r($data);exit;

		if($format == 'json') {
			header('Content-type: application/json');
			echo json_encode(array('posts'=>$posts));
		}
		else {
			header('Content-type: text/xml');
			echo '<?xml version="1.0" encoding="UTF-8"?>',PHP_EOL;
			echo '<Root>',PHP_EOL;
			foreach($posts as $index => $post) {
				if(is_array($post)) {
					foreach($post as $key => $value) {
						echo "\t",'<',$key,'>';
						if(is_array($value)) {
							foreach($value as $tag => $val) {
								echo PHP_EOL,"\t\t",'<',$tag,'>',htmlentities($val),'</',$tag,'>';
							}
						}
						echo PHP_EOL,"\t",'</',$key,'>',PHP_EOL;
					}
				}
			}
			echo '</Root>';
		}

		//$model->displayTemplate("b2c", "index", $data);
		break;
}