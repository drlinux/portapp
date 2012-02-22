<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productgroup();

switch($_action) {
	case 'sendEmailToUsersinWishlist':
		$productId = $_POST["productId"];
		$subject = $_POST["messageSubject"];
		$body = $_POST["messageBody"];
		
		$product = new Product();
		$recipients = $product->getUsersinWishlistByProductId($productId);
		
		$mailer = new CasMailer();
		$mailer->Subject = $subject;
		$mailer->MsgHTML($body);
		
		foreach ($recipients as $recipient) {
			$mailer->AddAddress($recipient["userEmail"], $recipient["userFirstname"] . ' ' . $recipient["userLastname"]);
			$mailer->Send();
		}
		
		echo(json_encode(array("success"=>true)));
		break;
	case 'inform':
		$productId = $_GET["productId"];
		$product = new Product();
		$data["product"] = $product->getProductByProductId($productId);
		//print_r($data);exit;
		
		$productLink = $project["url"] . "modules/b2c/product.php?action=show&productId=" . $productId;
		
		$data["message"]["to"] = $product->getUsersinWishlistByProductId($productId); 
		$data["message"]["subject"] = $smarty->getConfigVariable("MAIL_SUBJECT_WISHLIST");
		$data["message"]["body"] = sprintf($smarty->getConfigVariable("MAIL_BODY_WISHLIST"), $data["product"]["productTitle"], $data["product"]["productCode"], $productLink, $productLink);
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_email', $data);
		break;
	case 'dataTables':
		$aColumns = array("productgroupId", "productgroupTitle");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'save':
		$productgroupId = $model->saveEntry($_POST, array("i18n"=>true));
		$model->delete("productgroup_product", "productgroupId = :productgroupId", array("productgroupId"=>$productgroupId));
		if (isset($_POST["productId"])) {
			foreach ($_POST["productId"] as $productId) {
				$model->insert("productgroup_product", array("productgroupId"=>$productgroupId, "productId"=>$productId));
			}
		}
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'edit':
		//$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$data["model"] = $model->getProductgroup($_REQUEST[$model->sIndexColumn]);
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$product = new Product();
		$data["product"] = $product->getProducts();
		//print_r($data["product"]);exit;
		
		$data["productgroup_product"] = $product->getNumberOfUsersinWishlistByProductgroupId($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$product = new Product();
		$data["product"] = $product->getEntries();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}