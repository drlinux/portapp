<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Product;

switch($_action)
{
	
	/*
	* Attributeimpact
	*/
	case 'deleteAttributeimpact':
		$attributeimpact = new Attributeimpact();
		$attributeimpact->removeEntry($_REQUEST[$attributeimpact->sIndexColumn]);
		echo(json_encode(array("success"=>true)));
		break;
	
	case 'saveAttributeimpact':
		$attributeimpact = new Attributeimpact();
		$attributeimpact->saveEntry($_POST);
		echo(json_encode(array("success"=>true)));
		break;
	
	case 'jsonAttributeimpactByProductId':
		echo(json_encode($model->getAttributeimpactByProductId($_REQUEST[$model->sIndexColumn])));
		break;
	
	
	
	/*
	 * Productimpact
	 */
	case 'deleteProductimpact':
		$productimpact = new Productimpact();
		$productimpact->removeEntry($_REQUEST[$productimpact->sIndexColumn]);
		echo(json_encode(array("success"=>true)));
		break;
		
	case 'saveProductimpact':
		$productimpact = new Productimpact();
		$productimpact->saveEntry($_POST);
		echo(json_encode(array("success"=>true)));
		break;

	case 'jsonProductimpactByProductId':
		echo(json_encode($model->getProductimpactByProductId($_REQUEST[$model->sIndexColumn])));
		break;
		
		

	/*
	 * Productattribute
	 */
	case 'deleteProductattribute':
		$productattribute = new Productattribute();
		$productattribute->removeEntry($_REQUEST[$productattribute->sIndexColumn]);
		echo(json_encode(array("success"=>true)));
		break;
		
	case 'saveProductattribute':
		$productattribute = new Productattribute();
		if (isset($_POST["productattributeId"]) === false) {
			$productattributeCode = $_POST["productattributeCode"];
			$productId = $_POST["productId"];
			$attributeIds = $_POST["attributeIds"];
			
			if ($productattribute->getProductattributeByProductattributeCode($productattributeCode)) {
				echo(json_encode(array("success"=>false, "msg"=>"Kayıtlı bir ürün kodu girdiniz")));
				exit;
			}
			else {
				if ($pa = $productattribute->getProductattributeByProductId($productId, $attributeIds)) {
					$productattributeId = $pa["productattributeId"];
					$productattributeQuantity = $pa["productattributeQuantity"];
				}
				else {
					$productattribute->insert($productattribute->sTable, array("productId"=>$productId, "productattributeCode"=>$productattributeCode));
					$pa = $productattribute->run("select LAST_INSERT_ID() as last_insert_id;");
					$productattributeId = $pa[0]["last_insert_id"];
					$productattributeQuantity = 0;
					foreach ($attributeIds as $attributeId) {
						$productattribute->insert("productattribute_attribute", array("productattributeId"=>$productattributeId, "attributeId"=>$attributeId));
					}
				}
			}
		}
		else {
			$productattributeId = $_POST["productattributeId"];
			$pa = $productattribute->getProductattributeByProductattributeId($productattributeId);
			$productattributeQuantity = $pa["productattributeQuantity"];
		}
		
		$productattributemovementQuantity = $_POST["productattributemovementQuantity"];
		
		$productattributemovement = new Productattributemovement();
		$pam = $productattributemovement->getProductattributemovementByProductattributeId($productattributeId);
		if ($pam["iTotalRecords"] > 0) {
			$productattributemovementId = $pam["aaData"][0]["productattributemovementId"];
			$productattributemovementQuantityAvailable = $pam["aaData"][0]["productattributemovementQuantity"];
			$productattributemovement->update($productattributemovement->sTable, array("productattributemovementQuantity"=>$productattributemovementQuantity+$productattributemovementQuantityAvailable-$productattributeQuantity), "productattributemovementId = :productattributemovementId", array("productattributemovementId"=>$productattributemovementId));
		}
		else {
			$productattributemovement->insert($productattributemovement->sTable, array("productattributeId"=>$productattributeId, "productattributemovementQuantity"=>$productattributemovementQuantity));
		}
			
		echo(json_encode(array("success"=>true)));
		
		break;
	
	case 'jsonProductattributeByProductId':
		echo(json_encode($model->getProductattributesByProductId($_REQUEST[$model->sIndexColumn])));
		break;
		
		
		
		




	case '____jsonAttributegroupsWithAttributes':
		$attributegroup = new Attributegroup();
		print_r(($attributegroup->getAttributegroupsWithAttributes()));
		break;
	case 'jsonRolesHavingPriceDiscrimination':
		$role = new Role;
		echo(json_encode($role->getRolesHavingPriceDiscrimination()));
		break;
	case 'jsonCategories':
		$category = new Category;
		$categories_selected = $category->getCategoriesByProductId($_REQUEST[$model->sIndexColumn]);
		echo($category->jsonTree(null, $categories_selected["selected"]));
		break;
	case 'dataTables':
		$aColumns = array('productId', 'productCode', 'productTitle');
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'deleteProductattributemovement':
		$productattributemovement = new Productattributemovement;
		$productattributemovement->removeEntry($_REQUEST[$productattributemovement->sIndexColumn]);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'deleteProductattributes':
		$productattributemovement = new Productattributemovement;
		$productattributemovement->removeEntryByProductattributeId($_REQUEST["productattributeId"]);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'deletePicture':
		$params = array("scale"=>array(
			array(2.5),
			array(7.5),
			array(15)
		));
		$model->unlinkPicture($_REQUEST["pictureId"], $params);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case '____deletePictures':
		$picture = new Picture;
		$picture->removeEntriesByProductId($_REQUEST["productId"]);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'uploadPictures':
		$formvars = array_merge($_POST, $_FILES);
		$params = array(
			"picture"=>array(
				"resize"=>array(2000,2000),
				"scale"=>array(
					array(2.5),
					array(7.5),
					array(15)
				),
				"isDefault"=>true
			)
		);
		$model->saveFiles($formvars, $params);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'setDefaultPicture':
		$model->setDefaultPicture($_REQUEST[$model->sIndexColumn], $_REQUEST["pictureId"]);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'deleteProducts':
		$model->run("delete from " . $model->sTable);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'deleteProduct':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'ajaxDeleteProduct':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		break;
	case 'ajaxSaveProduct':
		$id = $model->saveProduct($_POST);
		echo(json_encode(array($model->sIndexColumn=>$id)));
		break;
	case 'edit':
		$productId = $_REQUEST[$model->sIndexColumn];
		//$productattribute = new Productattribute;
		//$data["product"] = $productattribute->getProductattributeByProductId($productId);
		//$data["product"] = $model->getEntry($productId);
		$data["product"] = $model->getProductByProductId($productId);
		//print_r($data);exit;

		$attributegroup = new Attributegroup();
		$data["attributegroup"] = $attributegroup->getAttributegroupsWithAttributes();
		//print_r($data);exit;

		//$category = new Category;
		//$data["category"] = $category->getCategoriesByProductId($productId);
		//print_r($data);exit;

		$brand = new Brand;
		$data["brand"] = $brand->getBrands();
		//print_r($data);exit;

		$taxonomy = new Taxonomy;
		$data["taxonomy"] = $taxonomy->getEntries(array("i18n"=>true));
		//print_r($data);exit;

		$warranty = new Warranty();
		$data["warranty"] = $warranty->getEntries();
		//print_r($data);exit;

		$role = new Role;
		$data["role"] = $role->getRolesHavingPriceDiscrimination();
		//print_r($data);exit;

		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$brand = new Brand;
		$data["brand"] = $brand->getBrands();
		//print_r($data);exit;

		$taxonomy = new Taxonomy;
		$data["taxonomy"] = $taxonomy->getEntries(array("i18n"=>true));
		//print_r($data);exit;

		$warranty = new Warranty();
		$data["warranty"] = $warranty->getEntries();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}