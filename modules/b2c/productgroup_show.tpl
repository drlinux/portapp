<div id="mainBannerOuter" class="casContent slider-wrapper {$_THEME_B2C_NIVOSLIDER}">
	<div id="mainBanner" cas:theme="{$_THEME_B2C_NIVOSLIDER}">
		{$data.banner_files}
	</div>
</div>
<div class="casContent">
	<h1 class="subHeader">{$data.model.productgroupTitle|upper}</h1>
	
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}">
		{$data.products_list}
	</ul>
</div>
