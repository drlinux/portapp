<div id="headerOuter">
	<a id="mainLogo" href="">
		<img src="{$smarty.const._THEMES_DIR_}b2b/{$_THEME_B2B_NAME}/images/mainLogo.png" />
	</a>					
	<div id="searchFormOuter">
		<form method="get" action="modules/b2b/search.php">
			<input type="text" name="sSearch" title="Lütfen arama yapmak istediğinizi kelimeyi girin" required="required" value="{#BUTTON_Search#}"  />
			<button id="buttonSearch"></button>
		</form>
	</div>
	<div id="menuOuter">
		{foreach from=$data.main_menu.aaData item="menu"}
			<a href="modules/b2b/page.php?pageId={$menu.pageId}">{$menu.pageTitle}</a>
		{/foreach}
	</div>
	<a id="btnRegister" href="modules/b2b/register.php">Üye Ol</a>
</div>
		