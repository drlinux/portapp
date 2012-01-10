<div class="casContent">
	<h1 class="subHeader">MARKALAR > {$data.model.brandTitle}</h1>
	<ul class="productsList bigProductList" cas-break="{$_THEME_b2b_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByBrandId" cas:var="{$data.model.brandId}" cas:url="modules/b2b/index.php">
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2b/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/3_%s">
			</a>
			<a class="productName" href="modules/b2b/product.php?action=show&productId=%s">%s</a>
			<div class="costsOuter">
				<span class="oldCost">
					%s<span class="scratch"></span>
				</span>
				<span class="currentCost">%s</span>
			</div>
		</li>
	</ul>
</div>