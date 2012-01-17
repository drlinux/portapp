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
	<a id="btnRegister" href="modules/b2b/register.php">Üye Ol</a>
	<!--
	<div id="menuOuter">
		<a href="modules/b2b/index.php" class="{$d}{$HOME_PAGE_SELECTED}">{#LABEL_HomePage#}</a>
		<span cas-js="getProductgroups" cas:var="{$smarty.get.productgroupId}" cas:url="modules/b2b/index.php">
			<a href="modules/b2b/productgroup.php?action=show&productgroupId=%s">%s</a>
		</span>
	</div>
	-->
	<div id="menuOuter" cas-js="getPage"></div>
</div>
		