<div id="mainBannerOuter" class="casContent slider-wrapper {$_THEME_B2C_NIVOSLIDER}">
	<div id="mainBanner" cas-js="getBanners" cas:url="{$SCRIPT_NAME}" cas:theme="{$_THEME_B2C_NIVOSLIDER}"></div>
</div>
<div class="casContent">
	<h3 class="subHeader">İNDİRİMLİ ÜRÜNLER</h3>
	<ul class="productsList bigProductList" cas-js="getProductsByProductgroupId" cas:url="{$SCRIPT_NAME}" cas:var="1" cas:loopstyle="loop1" cas:limit="5" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}">
		<li class="productItem">
			<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/3_%s">
			</a>
			<span class="c-ffffff">%s</span>
			<div class="costsOuter">
				<span class="currentCost">%s</span>											
			</div>
		</li>
	</ul>
</div>