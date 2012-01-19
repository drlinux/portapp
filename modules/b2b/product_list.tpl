<div id="sidebar">
	<h1>Ürünler</h1>
	<!--
	<div class="productsList_small" cas-js="getSearchResults" cas:url="modules/b2b/index.php" cas:var="{$smarty.get.sSearch}" >
		<a href="modules/b2b/product.php?action=show&productId=%s" class="product">
			<img src="img/product/%s" />
			<span class="name">%s</span>
			<span class="cost">%s</span>
		</a>
	</div>
	-->
	<ul class="productsList bigProductList" cas-js="getSearchResults" cas:url="modules/b2b/index.php" cas:var="{$smarty.get.sSearch}" cas:limit="{$_THEME_B2B_LIMITPRODUCTS1}" cas-break="{$_THEME_B2B_NUMBEROFPRODUCTSDISPLAYED}">
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent %s">%%%s</span>
				<span class="discountCount %s">%s</span>
				<span class="discountText %s">İndirimli Ürün</span>
			</label>
			<a href="modules/b2b/product.php?action=show&amp;productId=%s" class="productLogoLink">
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
