<div class="casContent">
	<h1 class="subHeader">MARKALAR</h1>
	<ul>
		{foreach from=$data.brand_list.aaData item="brand"}
			<li><a href="modules/b2b/brand.php?action=show&brandId={$brand.brandId}">{$brand.brandTitle}</a></li>
		{/foreach}
	</ul>
</div>
