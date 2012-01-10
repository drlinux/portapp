<div data-role="page" class="type-interior">

	<div data-role="header" data-theme="f">
		<h1>Thumbnails</h1>
		<a href="../../" data-icon="home" data-iconpos="notext"
			data-direction="reverse" class="ui-btn-right jqm-home">Home</a>
	</div>
	<!-- /header -->

	<div data-role="content">
		<div class="content-primary">
			<ul data-role="listview">
				{foreach from=$data.aaData item="entry"}
				<li>
					<a href="{$PROJECT_URL}modules/mb2c/product.php?action=show&productId={$entry.productId}" data-transition="flip">
						<img src="img/product/2_{$entry.pictureFile}" />
						<h3>{$entry.productTitle}</h3>
						<p>{$entry.productContent}</p>
					</a>
				</li>
				{/foreach}
			</ul>
		</div><!--/content-primary -->
	</div>
	<!-- /content -->

	<div data-role="footer" class="footer-docs" data-theme="c">
		<p>&copy; 2011 The jQuery Project</p>
	</div>

</div>
<!-- /page -->