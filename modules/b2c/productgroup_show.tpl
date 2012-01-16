<div id="mainBannerOuter" class="casContent slider-wrapper {$_THEME_B2C_NIVOSLIDER}">
	<div id="mainBanner" cas-js="getBanners" cas:theme="{$_THEME_B2C_NIVOSLIDER}"></div>
</div>
<div class="casContent">
	<h1 class="subHeader">{$data.model.productgroupTitle|upper}</h1>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="{$_THEME_B2C_LIMITPRODUCTS2}" cas:var="{$data.model.productgroupId}" cas:url="modules/b2c/index.php"  >
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent">%%%s</span>
				<span class="discountCount">%s</span>
				<span class="discountText">İndirimli Ürün</span>
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
			<a class="btnAddToBasket" href="">Sepete Ekle</a>
		</li>
	</ul>
</div>
