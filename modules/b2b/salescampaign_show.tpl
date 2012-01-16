<div class="casContent">
	<h1>Kampanya</h1>
	<div id="extra">
		<h2>{$data.salescampaignTitle}</h2>
		<p>{$data.salescampaignContent}</p>
		<p>Başlangıç: {$data.salescampaignStart|date_format:$config.datetime}</p>
		<p>Bitiş: {$data.salescampaignEnd|date_format:$config.datetime}</p>
	</div>
	<div id="sidebar">
		<ul style="list-style-type: none; padding: 0px;" class="productsList bigProductList">
		{foreach from=$data.productattribute.aaData item="entry"}
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent">{if $entry.productimpactDiscountRate gt 0}%{$entry.productimpactDiscountRate * 100}{/if}</span>
				<span class="discountCount">{if $entry.productimpactDiscountPrice gt 0}{$entry.productimpactDiscountPrice}{/if}</span>
				<span class="discountText">{if $entry.productimpactDiscountRate gt 0 or productimpactDiscountPrice gt 0}İndirimli Ürün{/if}</span>
			</label>
			<a href="modules/b2b/product.php?action=show&amp;productId={$entry.productId}" class="productLogoLink">
				<img src="img/product/3_{$entry.pictureFile}" class="productLogo">
			</a>
			<span class="productName">{$entry.productTitle}</span>
			<div class="costsOuter">
				<!-- <span class="oldCost {if $entry.productimpactDiscountRate eq null and productimpactDiscountPrice eq null}dn{/if}"> -->
				<span class="oldCost {if $entry.productimpactDiscountRate gt 0 or productimpactDiscountPrice gt 0}{else}dn{/if}">
					{$entry.productattributepriceMVCur}
					<span class="cross"></span>
				</span>
				<span class="currentCost">{$entry.productattributepriceMDVCur}</span>
			</div>
			<a class="btnAddToBasket" href="modules/b2b/sales.php?action=updateProductattributebasket&productattributeId={$entry.productattributeId}&productattributebasketQuantity=1">Sepete Ekle</a>
		</li>
		{/foreach}
		</ul>
	</div>
</div>