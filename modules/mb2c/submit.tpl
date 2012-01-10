<!-- Start of first page: #one -->
<div data-role="page" id="foo" data-title="öçşığü ÖÇŞİĞÜ">

	<div data-role="header" data-position="inline">
		<h1>Multi-page</h1>
		<a href="index.html" data-icon="gear" class="ui-btn-right">Options</a>
		<div data-role="navbar" data-iconpos="bottom">
			<ul>
				<li><a href="#" class="ui-btn-active" data-icon="grid">One</a></li>
				<li><a href="#" data-icon="gear">Two</a></li>
				<li><a href="#" data-icon="star">Three</a></li>
				<li><a href="#" data-icon="arrow-l">Four</a></li>
				<li><a href="#" data-icon="arrow-r">Five</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content" id="one">	
		<h2>One</h2>
		
		<div data-role="fieldcontain">
    		<label for="search">Search Input:</label>
    		<input type="search" name="password" id="search" value="" />
		</div>
		
		<div data-role="fieldcontain">
			<label for="select-choice-6" class="select">Shipping method:</label>
			<select name="select-choice-6" id="select-choice-6" data-native-menu="false">
				<option value="choose-one" data-placeholder="true">Choose one...</option>
				<option value="standard">Standard: 7 day</option>
				<option value="rush">Rush: 3 days</option>
				<option value="express">Express: next day</option>
				<option value="overnight">Overnight</option>
			</select>
		</div>
		
		<form action="{$SCRIPT_NAME}?action=test" method="get" class="ui-body ui-body-a ui-corner-all">
			<fieldset>
				<div data-role="fieldcontain">
					<label for="shipping" class="select">Shipping method:</label>
					<select name="shipping" id="shipping">
						<option value="Standard shipping">Standard: 7 day</option>
						<option value="Rush shipping">Rush: 3 days</option>
						<option value="Express shipping">Express: next day</option>
						<option value="Overnight shipping">Overnight</option>
					</select>
				</div>
				<button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
			</fieldset>
		</form>
		
		<p>I have an id of "one" on my page container. I'm first in the source order so I'm shown when the page loads.</p>	
		
		<p>This is a multi-page boilerplate template that you can copy to build you first jQuery Mobile page. This template contains multiple "page" containers inside, unlike a <a href="page-template.html"> single page template</a> that has just one page within it.</p>	
		<p>Just view the source and copy the code to get started. All the CSS and JS is linked to the jQuery CDN versions so this is super easy to set up. Remember to include a meta viewport tag in the head to set the zoom level.</p>
		<p>You link to internal pages by referring to the ID of the page you want to show. For example, to <a href="#two" >link</a> to the page with an ID of "two", my link would have a <code>href="#two"</code> in the code.</p>	

		<h3>Show internal pages:</h3>
		<p><a href="#two" data-role="button" data-transition="flip">Show page "two"</a></p>	
		<p><a href="#popup"data-role="button" data-rel="dialog" data-transition="pop">Show page "popup" (as a dialog)</a></p>
	</div><!-- /content -->
	
	<div data-role="footer" data-theme="d">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


<!-- Start of second page: #two -->
<div data-role="page" id="two" data-theme="a">

	<div data-role="header" data-position="inline">
		<a href="index.html" data-icon="delete">Cancel</a>
		<h1>Two</h1>
		<a href="index.html" data-icon="check" data-theme="b">Save</a>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">	
		<h2>Two</h2>
		<p>I have an id of "two" on my page container. I'm the second page container in this multi-page template.</p>	
		<p>Notice that the theme is different for this page because we've added a few <code>data-theme</code> swatch assigments here to show off how flexible it is. You can add any content or widget to these pages, but we're keeping these simple.</p>	
		<p><a href="#one" data-direction="reverse" data-role="button" data-theme="b">Back to page "one"</a></p>	
		
	</div><!-- /content -->
	
	<div data-role="footer" class="ui-bar">
		<div data-role="controlgroup" data-type="horizontal">
			<a href="index.html" data-role="button" data-icon="delete">Remove</a>
			<a href="index.html" data-role="button" data-icon="plus">Add</a>
			<a href="index.html" data-role="button" data-icon="arrow-u">Up</a>
			<a href="index.html" data-role="button" data-icon="arrow-d">Down</a>
		</div>
	</div><!-- /footer -->
</div><!-- /page two -->


<!-- Start of third page: #popup -->
<div data-role="page" id="popup">

	<div data-role="header" data-theme="e">
		<h1>Dialog</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">	
		<h2>Popup</h2>
		<p>I have an id of "popup" on my page container and only look like a dialog because the link to me had a <code>data-rel="dialog"</code> attribute which gives me this inset look and a <code>data-transition="pop"</code> attribute to change the transition to pop. Without this, I'd be styled as a normal page.</p>		
		<p><a href="#one" data-rel="back" data-role="button" data-inline="true" data-icon="back">Back to page "one"</a></p>	
	</div><!-- /content -->
	
	<div data-role="footer" class="ui-bar" data-position="inline">
		<label for="select-choice-1">Shipping:</label>
		<select name="select-choice-1" id="select-choice-1" data-theme="a">
			<option value="standard">Standard: 7 day</option>
			<option value="rush">Rush: 3 days</option>
			<option value="express">Express: next day</option>
			<option value="overnight">Overnight</option>
		</select>
	</div>
</div><!-- /page popup -->
