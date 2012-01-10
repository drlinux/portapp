<div id="leftBarOuter" class="sidebar">
	<div class="subMenuOuter" style="display:none;">
		<div class="top">ARAMA YAP</div>
		<div class="center">
			<form method="get" action="modules/b2b/search.php">
				<ul>
					<li>
						<label>Ürün arayın</label>
						<input type="text" name="sSearch" title="Lütfen arama yapmak istediğinizi kelimeyi girin" required="required" />
					</li>
					<li class="buttonset">
						<button type="submit" onclick="Productattribute.searchProductattribute(this.form);">{#BUTTON_Search#}</button>
					</li>
					<li>
						<a href="modules/b2b/search.php">Ayrıntılı Arama</a>
					</li>
				</ul>
			</form>
		</div>
		<div class="bottom"></div>
	</div>

	<div class="subMenuOuter">
		<h2 class="top">SEPETİM</h2>
		<div class="center">
			<form cas-form="shoppingbasket" cas-js="getShoppingbasket" method="post" action="modules/b2b/sales.php"></form>
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">ÜYE GİRİŞİ</h2>
		<div class="center">
			<div id="loginFormOuter">
				<form cas-form="getLoginoutFormAndMenu" autocomplete="off" action="modules/b2b/index.php" method="post">
					<ul>
						<li>
							<label>{#LABEL_Username#}</label>
							<input type="email" id="username" name="username" value="{$data.username}" title="Lütfen kullanıcı adınızı girin" autofocus="autofocus" required="required" />
						</li>
						<li>
							<label>{#LABEL_Password#}</label>
							<input type="password" id="password" name="password" title="Lütfen parolanızı girin" required="required" />
						</li>
						<li class="dn">
							<label>uri</label>
							<input type="text" name="uri" value="{$data.uri}" readonly="readonly" />
						</li>
						<li>
							
							<div class="linksOuter">
								<a href="modules/b2b/reminder.php">Şifremi Unuttum</a><br />
								<a href="modules/b2b/register.php">Üye olmak istiyorum</a>
							</div>
							<button type="submit" onclick="User.loginUser(this.form);">{#BUTTON_Login#}</button>
						</li>
					</ul>
				</form>
			</div>
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">KATEGORİLER</h2>
		<div class="center">
			<ul class="linkList" cas-js="getCategoriesFromProductHavingPicture" cas:url="modules/b2b/index.php?action=jsonCategoriesFromProductHavingPicture">
				<li><a href="modules/b2b/category.php?action=show&categoryId=%s">%s</a></li>
			</ul>
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">MARKALAR</h2>
		<div class="center">
			<ul class="linkList" cas-js="getBrandsFromProductHavingPicture" cas:url="modules/b2b/index.php?action=jsonBrandsFromProductHavingPicture">
				<li><a href="modules/b2b/brand.php?action=show&brandId=%s">%s</a></li>
			</ul>
		</div>
		<div class="bottom"></div>
	</div>
	
</div>