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
					{if $entry.productimpactDiscountRate neq null}
					{$entry.productimpactDiscountRate * 100}%
					{else}
					{$entry.productimpactDiscountPrice}TL
					{/if}
					</label>
					<a class="productLogoLink" href="modules/b2b/product.php?action=show&productId={$entry.productId}">
						<img class="productLogo" src="img/product/2_{$entry.pictureFile}" width="100px" height="100px">
					</a>
					<a class="productName" href="modules/b2b/product.php?action=show&productId={$entry.productId}">{$entry.productattributeCode}</a>
					<div class="costsOuter">
						<span class="oldCost">
						<!-- {$entry.productattributepriceMVCur}<br /> -->
						{$entry.productattributepriceMDVCur}
							<span class="scratch"></span>
						</span>
						<span class="currentCost">{$entry.productattributePrice}</span>	
						<span class="btnAddToBasket" onclick="Productattribute.updateProductattributebasket_withoutForm({$entry.productattributeId},1); return false;" title="Sepete Ekle" >Sepete Ekle</span>
					</div>
			</li>
		{/foreach}
		</ul>
	</div>
</div>