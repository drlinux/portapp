<div id="mainBannerOuter" class="casContent">
	<div id="mainBanner" cas-js="getBanners"></div>
</div>

<div class="casContent">
	<h1 class="subHeader">{$data.model.productgroupTitle|upper}</h1>
	<ul class="productsList bigProductList " cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="100" cas:var="{$data.model.productgroupId}" cas:url="modules/b2c/index.php"  >
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/3_%s">
			</a>
			<a class="productName" href="modules/b2c/product.php?action=show&productId=%s">%s</a>
			<div class="costsOuter">
				<span class="oldCost">
					%s<span class="scratch"></span>
				</span><!-- .oldCost -->
				<span class="currentCost">%s</span>											
			</div>
		</li>
	</ul>
</div>
