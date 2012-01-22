<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Banner;

switch($_action)
{
	case 'crop':
		$aspectRatio = $_POST['w']/$_POST['h'];
		$targ_w = 100;
		$targ_h = $targ_w/$aspectRatio;
		
		$jpeg_quality = 90;
	
		$src = _PS_IMG_DIR_ . 'banner/pool.jpg';
		$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
	
		imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
	
		header('Content-type: image/jpeg');
		imagejpeg($dst_r, null, $jpeg_quality);
		break;
	case 'dataTables':
		echo $model->dataTables($model->aAllField, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'deleteBanners':
		$model->run("delete from " . $model->sTable);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn], true);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		//$model->mungeFormData($formvars);
		//if($model->isValidForm($formvars)) {
			$model->saveEntry($formvars, array("picture"=>array("resize"=>array(720, 300), "isDefault"=>true)));
			header("Location: " . $_SERVER["PHP_SELF"]);
		//} else {
			//$model->displayTemplate("admin", $model->sTable.'_form', $formvars);
		//}
		break;
	case 'edit':
		$data = $model->getEntry($_REQUEST[$model->sIndexColumn], array("i18n"=>false, "picture"=>true));
		//print_r($data);exit;
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$model->displayTemplate("admin", $model->sTable.'_form');
		break;
	case 'view':
	default:
		$data = $model->getEntries();
		$model->displayTemplate("admin", $model->sTable.'_list', $data);
		break;
}