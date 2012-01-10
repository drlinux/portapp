<div id="sidebar">
	<h1>Kampanya</h1>
	<div id="extra">
		<h2>{$data.salescampaignTitle}</h2>
		<p>{$data.salescampaignContent}</p>
		<p>Başlangıç: {$data.salescampaignStart|date_format:$config.datetime}</p>
		<p>Bitiş: {$data.salescampaignEnd|date_format:$config.datetime}</p>
	</div>
	<div id="sidebar">
		<a class="jqzoom" href="img/salescampaign/{$data.pictureFile}" title="{$data.salescampaignTitle}">
			<img src="img/salescampaign/{$data.pictureFile}" />
		</a>
		<div id="pictureFilesOuter">
			{foreach from=$data.picture.aaData item="entry"}
			<a class="fancyboxThumbnail" href="img/salescampaign/{$entry.pictureFile}">
				<img src="img/salescampaign/{$entry.pictureFile}" />
			</a>
			{/foreach}
		</div>
	</div>
	<br clear="all" />
	<div>
		<ul style="list-style-type: none;">
		{foreach from=$data.productattribute.aaData item="entry"}
			<li style="padding: 5px; background-color: {cycle values="#dedede,#eeeeee" advance=true}">
				Ürün Kodu: {$entry.productattributeCode}<br/>
				Fiyat: {$entry.productattributePrice}<br/>
			</li>
		{/foreach}
		</ul>
	</div>
</div>