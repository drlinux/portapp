<div class="casContent">
	<h1 class="subHeader">KATEGORİLER > {$data.model.categoryTitle}</h1>
	<ul class="productsList bigProductList " cas-break="{$_THEME_b2b_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByCategoryId" cas:var="{$data.model.categoryId}" cas:url="modules/b2b/index.php"  >
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent">%%%s</span>
				<span class="discountCount">%s</span>
				<span class="discountText">İndirimli Ürün</span>
			</label>
			<a href="modules/b2b/product.php?action=show&amp;productId=%s" class="productLogoLink">
				<img src="img/product/3_%s" class="productLogo">
			</a>
			<span class="c-ffffff">%s</span>
			<div class="costsOuter">
				<span class="oldCost">
					%s
					<span class="cross"></span>
				</span>
				<span class="currentCost">%s</span>
			</div>
			<a class="btnAddToBasket" href="">Sepete Ekle</a>
		</li>
	</ul>
</div>
