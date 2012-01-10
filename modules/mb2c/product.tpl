<div data-role="page" class="type-interior">

	<div data-role="header" data-theme="f">
		<h1>{#LABEL_Product#}</h1>
		<a href="modules/mb2c/index.php" data-icon="home" data-iconpos="notext" data-direction="reverse" class="ui-btn-right jqm-home">Home</a>
	</div>
	<!-- /header -->

	<div data-role="content">
		<div class="ui-body ui-body-b">
			<h1>{$data.productTitle}</h1>
			<p>{$data.productContent}</p>
			<p>This is a paragraph that contains <strong>strong</strong>, <em>emphasized</em> and <a href="index.html">linked</a> text. Here is more text so you can see how HTML markup works in content. Here is more text so you can see how HTML markup works in content.</p>
			<p><img src="img/product/{$data.pictureFile}" /></p>
			<div data-role="collapsible" data-collapsed="true" data-theme="b">
				<h3>I'm a themed collapsible</h3>
				<p>I have <code> data-theme</code> attribute set manually on my container to set the color to match the content block I'm in. </p>
			</div><!-- /collapsible -->
			<div data-role="collapsible" data-theme="b" data-content-theme="b">
				<h3>I'm a themed collapsible with a themed content</h3>
				<p>I have <code> data-content-theme</code> attribute set manually on my container to set the color to match the content block I'm in. </p>
			</div>
		</div><!-- /themed container -->
	</div>
	<!-- /content -->

	<div data-role="footer" class="footer-docs" data-theme="c">
		<p>&copy; 2011 The jQuery Project</p>
	</div>

</div>
<!-- /page -->