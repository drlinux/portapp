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
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="2" cas:var="1" cas:url="modules/b2b/index.php" >
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/2_%s">
			</a>
			<a class="productName" href="modules/b2c/product.php?action=show&productId=%s">%s</a>
			<div class="costsOuter">
				<span class="oldCost">
					%s<span class="scratch"></span>
				</span>
				<span class="currentCost">%s</span>											
			</div>
		</li>
	</ul>
</div>

<div class="casContent">
	<h3 class="subHeader">En Çok Satanlar</h3>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="2" cas:var="2" cas:url="modules/b2b/index.php" >
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/2_%s">
			</a>
			<a class="productName" href="modules/b2c/product.php?action=show&productId=%s">%s</a>
			<div class="costsOuter">
				<span class="oldCost">
					%s<span class="scratch"></span>
				</span>
				<span class="currentCost">%s</span>											
			</div>
		</li>
	</ul>
</div>

<div class="casContent">
	<h3 class="subHeader">Yeni Ürünler</h3>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsByProductgroupId" cas:limit="2" cas:var="3" cas:url="modules/b2b/index.php" >
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/2_%s">
			</a>
			<a class="productName" href="modules/b2c/product.php?action=show&productId=%s">%s</a>
			<div class="costsOuter">
				<span class="oldCost">
					%s<span class="scratch"></span>
				</span>
				<span class="currentCost">%s</span>											
			</div>
		</li>
	</ul>
</div>

</div>
{/if}
