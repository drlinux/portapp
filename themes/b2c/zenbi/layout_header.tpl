<div id="siteCentering">
	<div id="siteContentsOuter">
		<div id="headerOuter">
			<a id="mainLogo" href="">
				<img src="{$smarty.const._THEMES_DIR_}b2c/{$_THEME_B2C_NAME}/images/mainLogo.png" />
			</a>					
			<div id="searchFormOuter">
				<form method="get" action="modules/b2c/search.php">
					<input type="text" name="sSearch" title="Lütfen arama yapmak istediğinizi kelimeyi girin" required="required" value="{#BUTTON_Search#}"  />
					<button type="submit" id="buttonSearch" name="action" value="search"></button>
				</form>
			</div><!-- #searchFormOuter -->
			<a id="btnRegister" href="modules/b2c/register.php">Üye Ol</a>
			<div id="menuOuter">
				<a href="modules/b2c/index.php" class="{$d}{$HOME_PAGE_SELECTED}">{#LABEL_HomePage#}</a>
				<span cas-js="getProductgroups" cas:var="{$smarty.get.productgroupId}" cas:url="modules/b2c/index.php">
					<a href="modules/b2c/productgroup.php?action=show&productgroupId=%s">%s</a>
				</span>
			</div><!-- #menuOuter -->
		</div><!-- #headerOuter -->
		<div id="wholeContentsOuter">