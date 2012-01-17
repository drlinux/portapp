{if isset($smarty.session.userId)}
<div id="extra">
	<h1>Sepetim<a name="myBasket"></a></h1>
	<form cas-js="getShoppingbasket" cas:url="modules/b2b/sales.php"></form>
	<h1>Markalar</h1>
	<ul cas-js="getBrandsFromProductHavingPicture" cas:url="modules/b2b/index.php?action=jsonBrandsFromProductHavingPicture">
		<li><a href="modules/b2b/brand.php?action=show&brandId=%s">%s</a></li>
	</ul>
	<h1>Kategoriler</h1>
	<ul cas-js="getCategoriesFromProductHavingPicture" cas:url="modules/b2b/index.php?action=jsonCategoriesFromProductHavingPicture">
		<li><a href="modules/b2b/category.php?action=show&categoryId=%s">%s</a></li>
	</ul>

<div class="casContent">
	<h3 class="subHeader">İndirimli Ürünler</h3>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2B_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="{$_THEME_B2B_LIMITPRODUCTSONLEFTBAR}" cas:var="1" cas:url="modules/b2b/index.php" >
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent %s">%%%s</span>
				<span class="discountCount %s">%s</span>
				<span class="discountText %s">İndirimli Ürün</span>
			</label>
			<a href="modules/b2b/product.php?action=show&amp;productId=%s" class="productLogoLink">
				<img src="img/product/2_%s" class="productLogo">
			</a>
			<span class="productName">%s</span>
			<div class="costsOuter">
				<span class="oldCost %s">
					%s
					<span class="cross"></span>
				</span>
				<span class="currentCost">%s</span>
			</div>
			<a class="btnAddToBasket" href="javascript:void(0);" onclick="Productattribute.updateProductattributebasket2(%s, 1);">Sepete Ekle</a>
		</li>
	</ul>
</div>

<div class="casContent">
	<h3 class="subHeader">En Çok Satanlar</h3>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2B_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="{$_THEME_B2B_LIMITPRODUCTSONLEFTBAR}" cas:var="2" cas:url="modules/b2b/index.php" >
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent %s">%%%s</span>
				<span class="discountCount %s">%s</span>
				<span class="discountText %s">İndirimli Ürün</span>
			</label>
			<a href="modules/b2b/product.php?action=show&amp;productId=%s" class="productLogoLink">
				<img src="img/product/2_%s" class="productLogo">
			</a>
			<span class="productName">%s</span>
			<div class="costsOuter">
				<span class="oldCost %s">
					%s
					<span class="cross"></span>
				</span>
				<span class="currentCost">%s</span>
			</div>
			<a class="btnAddToBasket" href="javascript:void(0);" onclick="Productattribute.updateProductattributebasket2(%s, 1);">Sepete Ekle</a>
		</li>
	</ul>
</div>

<div class="casContent">
	<h3 class="subHeader">Yeni Ürünler</h3>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2B_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="{$_THEME_B2B_LIMITPRODUCTSONLEFTBAR}" cas:var="3" cas:url="modules/b2b/index.php" >
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent %s">%%%s</span>
				<span class="discountCount %s">%s</span>
				<span class="discountText %s">İndirimli Ürün</span>
			</label>
			<a href="modules/b2b/product.php?action=show&amp;productId=%s" class="productLogoLink">
				<img src="img/product/2_%s" class="productLogo">
			</a>
			<span class="productName">%s</span>
			<div class="costsOuter">
				<span class="oldCost %s">
					%s
					<span class="cross"></span>
				</span>
				<span class="currentCost">%s</span>
			</div>
			<a class="btnAddToBasket" href="javascript:void(0);" onclick="Productattribute.updateProductattributebasket2(%s, 1);">Sepete Ekle</a>
		</li>
	</ul>
</div>

</div>
{/if}
