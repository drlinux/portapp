<div class="casContent">
	<h1 class="subHeader">KATEGORİLER > {$data.model.categoryTitle}</h1>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByCategoryId" cas:limit="{$_THEME_B2C_LIMITPRODUCTS2}" cas:var="{$data.model.categoryId}" cas:url="modules/b2c/index.php">
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent %s">%%%s</span>
				<span class="discountCount %s">%s</span>
				<span class="discountText %s">İndirimli Ürün</span>
			</label>
			<a href="modules/b2c/product.php?action=show&amp;productId=%s" class="productLogoLink">
				<img src="img/product/3_%s" class="productLogo">
			</a>
			<span class="productName">%s</span>
			<div class="costsOuter">
				<span class="oldCost %s">
					%s
					<span class="cross"></span>
				</span>
				<span class="currentCost">%s</span>
			</div>
			<a class="btnAddToBasket" href="javascript:void(0);" onclick="Productattribute.updateProductattributebasket2('%s', 1);">Sepete Ekle</a>
		</li>
	</ul>
</div>