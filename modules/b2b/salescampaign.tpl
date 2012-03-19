<div class="casContent">
	<h1 class="subHeader">Kampanyalar</h1>
	<ul id="campaignBannersList">
		{foreach from=$data.campaigns.aaData item="campaign"}
			<li class="banner">
				<h2 class="name">{$campaign.salescampaignTitle}</h2>
				<p class="timeLeft">Kampanya bitiş tarihi: <span style="color:#f00;">{$campaign.salescampaignEnd}</span></p>
				<a class="buy" href="modules/b2b/salescampaign.php?action=show&salescampaignId={$campaign.salescampaignId}">SATIN AL</a>
				<a class="imageLink" href="modules/b2b/salescampaign.php?action=show&salescampaignId={$campaign.salescampaignId}">
					<img src="img/salescampaign/{$campaign.pictureFile}" />
				</a>
			</li>
		{/foreach}
	</ul>
</div>