<div id="sidebar">
	<h1>Ürünler</h1>
	<div class="productsList_small" cas-js="getSearchResults" cas:var="{$smarty.get.sSearch}" cas:url="modules/b2b/index.php">
		<a href="modules/b2b/product.php?action=show&productId=%s" class="product">
			<img src="img/product/%s" />
			<span class="name">%s</span>
			<span class="cost">%s</span>
		</a>
	</div>
</div>
