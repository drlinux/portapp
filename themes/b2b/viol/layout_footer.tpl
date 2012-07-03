<div id="footerOuter">
	<div id="footerMenuOuter">
		{foreach from=$data.footer_menu.aaData item="menu"}
			<a href="modules/b2b/page.php?pageId={$menu.pageId}">{$menu.pageTitle}</a>
		{/foreach}
	</div>
	<div id="contractsMenuOuter">
		{foreach from=$data.contracts_menu.aaData item="menu"}
			<a href="modules/b2b/page.php?pageId={$menu.pageId}">{$menu.pageTitle}</a>
		{/foreach}
	</div>
	<br clear="all" /><br />
	<p id="copyrightText">© 2012 {$_COMPANY_NAME}. {#LABEL_AllRightsReserved#}.</p>
	<br />
	<a id="footerLogo" href="">
		<img src="{$smarty.const._THEMES_DIR_}b2b/{$_THEME_B2B_NAME}/images/footerLogo.png" />
	</a>
	<br /><br />
</div><!-- #footerOuter -->
	