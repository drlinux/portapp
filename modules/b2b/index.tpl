{if $data.useCampaignModule eq 'true'}
	<div class="casContent">
		{if $data.active_campaigns neq 'not_exist'}
		<h1 class="subHeader">Devam Eden Kampanyalar</h1>
		<ul id="campaignBannersList">
			{$data.active_campaigns}
		</ul>	
		<br /><br />
		{/if}
		
		{if $data.time_passed_campaigns neq 'not_exist'}
		<h1 class="subHeader">Biten Kampanyalar</h1>
		<ul id="campaignBannersList_typeTwo">
			{$data.time_passed_campaigns}
		</ul>
		{/if}
	</div>
{else}
	<div id="mainBannerOuter" class="casContent slider-wrapper {$_THEME_B2C_NIVOSLIDER}">
		<div id="mainBanner" cas:theme="{$_THEME_B2C_NIVOSLIDER}">
			{$data.banner_files}
		</div>
	</div>
	<div class="casContent">
		<h3 class="subHeader">İNDİRİMLİ ÜRÜNLER</h3>
		<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}">
			{$data.products_list}
		</ul>
	</div>
{/if}