<div id="headerOuter">
	<a id="mainLogo" href="">
		<img src="{$smarty.const._THEMES_DIR_}b2b/{$_THEME_B2B_NAME}/images/mainLogo.png" />
	</a>					
	<div class="dn" id="searchFormOuter">
		<form method="get" action="modules/b2b/search.php">
			<input type="text" name="sSearch" title="Lütfen arama yapmak istediğinizi kelimeyi girin" required="required" value="{#BUTTON_Search#}"  />
			<button id="buttonSearch"></button>
		</form>
	</div><!-- #searchFormOuter -->
	<a class="dn" id="btnRegister" href="modules/b2b/register.php">Üye Ol</a>
	<div id="menuOuter">
		{foreach from=$data.main_menu.aaData item="menu"}
			<a href="modules/b2b/page.php?pageId={$menu.pageId}">{$menu.pageTitle}</a>
		{/foreach}
	</div><!-- #menuOuter -->
</div><!-- #headerOuter -->
		