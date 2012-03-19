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
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}">
		{$data.products_list}
	</ul>
</div>

