<?php

$productgroup = new Productgroup;
$permission = new Permission;
$page = new Page();
$category = new Category();
$brand = new Brand();
$productattribute = new Productattribute;

// EXTRA PARAMETERS
$data["slider_theme"] = "default";

// MAIN MENU
$data["main_menu"] = $productgroup->getEntries(array("i18n"=>true));


// LOGIN MENU & PERSONAL INFO
if(Permission::checkPermission("b2c"))
{
	$data["user_menu_title"] = "KULLANICI BİLGİLERİ";
	$menuitems = $permission->arrayTree(32);
	
	$menuHtml = '<ul>';
	foreach($menuitems as $mi)
	{
		$menuHtml .= '<li><a href="' . $mi["href"] . '">' . $mi["title"] . '</a></li>';
	}
	$menuHtml .= '</ul>';
}
else
{
	$data["user_menu_title"] = "ÜYE GİRİŞİ";
	$menuHtml = 'no_permission';	
}

$data["user_menu"] = $menuHtml;


/* CATEGORIES MENU */
$categories = $category->getCategoriesFromProductHavingPicture();
foreach($categories["aaData"] as $c)
{
	$categoriesHtml .= '<li><a href="modules/b2c/category.php?action=show&categoryId=' . $c["categoryId"] . '">' . $c["categoryTitle"] . '</a></li>';
}
$data["categories_menu"] = $categoriesHtml;

/* BRANDS MENU */
$brands = $brand->getBrandsFromProductHavingPicture();
foreach($brands["aaData"] as $b)
{
	$brandsHtml .= '<li><a href="modules/b2c/brand.php?action=show&brandId=' . $b["brandId"] .'">' . $b["brandTitle"] . '</a></li>';
}
$data["brands_menu"] = $brandsHtml;


// FOOTER MENU
$data["footer_menu"] = $page->arrayPage(false, null);

// CONTRACTS MENU
$data["contracts_menu"] = $page->arrayPage(false, 6);




/*************************************************************************************************/
/* FUNCTIONS *************************************************************************************/
/*************************************************************************************************/
function parseProductsList(&$products, &$result)
{
	foreach($products as $p)
	{
		$discountPercent = ($p["productimpactDiscountRate"] == null) ? "dn" : "";
		$discountCount = ($p["productimpactDiscountPrice"] == null) ? "dn" : "";
		$discountText = (($p["productimpactDiscountRate"] == null) && ($p["productimpactDiscountPrice"] == null)) ? "dn" : "";
		$oldCost = (($p["productimpactDiscountRate"] == null) && ($p["productimpactDiscountPrice"] == null)) ? "dn" : "";
	
		$result .= '<li class="productItem">
					<label class="labelDiscount">
						<span class="discountPercent ' . $discountPercent . '">% ' . ($p["productimpactDiscountRate"]*100) . '</span>
						<span class="discountCount ' . $discountCount . '">' . $p["productimpactDiscountPrice"] . '</span>
						<span class="discountText ' . $discountText . '">İndirimli Ürün</span>
					</label>
					<a href="modules/b2c/product.php?action=show&amp;productId=' . $p["productId"] . '" class="productLogoLink">
						<img src="img/product/3_' . $p["pictureFile"] . '" class="productLogo">
					</a>
					<span class="productName">' . $p["productTitle"] . '</span>
					<div class="costsOuter">
						<span class="oldCost ' . $oldCost .  '">
							' . $p["productattributepriceMVCur"] .  '
							<span class="cross"></span>
						</span>
						<span class="currentCost">' . $p["productattributepriceMDVCur"] . '</span>
					</div>
					<a class="btnAddToBasket" href="javascript:void(0);" onclick="Productattribute.updateProductattributebasket2(\'' . $p["productattributeId"] . '\', 1);">Sepete Ekle</a>
				</li>';
	}
}

function getBanners(&$result)
{
	$banner = new Banner();
	$banners = $banner->getBanners();
	
	foreach($banners["aaData"] as $b)
	{
		if($b["bannerHref"] == null)
			$result .= '<img src="img/banner/' . $b["pictureFile"]  . '" title="' . $b["bannerTitle"] . '" />';
		else
			$result .= '<a href="' . $b["bannerHref"] . '"><img src="img/banner/' . $b["pictureFile"]  . '" title="' . $b["bannerTitle"] . '" /></a>';
	}
}



