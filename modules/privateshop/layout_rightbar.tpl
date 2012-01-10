{if isset($smarty.session.userId)}
<div id="extra">
	<h1>Sepetim<a name="myBasket"></a></h1>
	<form id="shoppingBasket"></form>
	<h1>Markalar</h1>
	<div id="brands"></div>
	<h1>Kategoriler</h1>
	<ul cas-js="getCategoriesFromProductHavingPicture" cas:url="modules/privateshop/index.php?action=jsonCategoriesFromProductHavingPicture">
		<li><a href="modules/privateshop/category.php?action=show&categoryId=%s">%s</a></li>
	</ul>
	<h1>İndirimli Ürünler</h1>
	<div id="productgroupId_1"></div>
	<h1>En Çok Satanlar</h1>
	<div id="productgroupId_2"></div>
	<h1>Yeni Ürünler</h1>
	<div id="productgroupId_3"></div>
</div>
{/if}