<div class="casContent">
	<h1 class="subHeader">Ayrıntılı Arama</h1>
	<form method="get" action="modules/b2c/search.php">
		<ul class="ulform">
			<li>
				<label>Arama yapmak istediğiniz kelimeyi yazın</label>
				<input type="text" name="sSearch" value="{$smarty.get.sSearch}" title="Lütfen arama yapmak istediğinizi kelimeyi girin" required="required" autofocus="autofocus" />
			</li>
			<li>
				<span class="buttonset">
					<button type="submit" onclick="Productattribute.searchProductattribute(this.form);">{#BUTTON_Search#}</button>
				</span>
			</li>
		</ul>
	</form>
	<br /><br />
	<ul class="productsList bigProductList" cas-js="getSearchResults" cas:url="{$SCRIPT_NAME}" cas:var="{$smarty.get.sSearch}" cas:limit="{$_THEME_B2C_LIMITPRODUCTS1}" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}">
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

