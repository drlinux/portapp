<div class="casContent">
	<h1 class="subHeader">{$data.salescampaignTitle}</h1>
	<div id="extra">
		<div id="campaignDetailImageOuter">
			<img src="img/salescampaign/{$data.pictureFile}" />
		</div>
		<br clear="all" />
		<p class="remainingText"><span style="color:#f00">Kampanya Bitimine: </span>{$data.remainingText}</p>
		<div>{$data.salescampaignContent}</div>
		<br clear="all" />
	</div>
	<div id="sidebar">
		<ul style="list-style-type: none; padding: 0px;" class="productsList bigProductList">
		{foreach from=$data.productattribute.aaData item="entry"}
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent {if $entry.productimpactDiscountRate gt 0}{else}dn{/if}">%{$entry.productimpactDiscountRate * 100}</span>
				<span class="discountCount {if $entry.productimpactDiscountPrice gt 0}{else}dn{/if}">{$entry.productimpactDiscountPrice}</span>
				<span class="discountText {if $entry.productimpactDiscountRate gt 0 or productimpactDiscountPrice gt 0}{else}dn{/if}">İndirimli Ürün</span>
			</label>
			<a href="modules/b2b/product.php?action=show&amp;productId={$entry.productId}" class="productLogoLink">
				<img src="img/product/3_{$entry.pictureFile}" class="productLogo">
			</a>
			<span class="productName">{$entry.productTitle}</span>
			<div class="costsOuter">
				<span class="oldCost {if $entry.productimpactDiscountRate gt 0 or productimpactDiscountPrice gt 0}{else}dn{/if}">
					{$entry.productattributepriceMVCur}
					<span class="cross"></span>
				</span>
				<span class="currentCost">{$entry.productattributepriceMDVCur}</span>
			</div>
			<a class="btnAddToBasket" href="javascript:void(0);" onclick="Productattribute.updateProductattributebasket2({$entry.productattributeId}, 1);">Sepete Ekle</a>
		</li>
		{/foreach}
		</ul>
	</div>
</div>