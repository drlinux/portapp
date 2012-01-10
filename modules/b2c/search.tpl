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
	<ul class="productsList bigProductList " cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getSearchResults" cas:var="{$smarty.get.sSearch}" cas:url="modules/b2c/search.php"  >
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/3_%s">
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

