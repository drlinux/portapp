<!-- LEFTBAR / START -->
<div id="leftBarOuter" class="sidebar">
	<div class="subMenuOuter" style="display:none;">
		<div class="top">ARAMA YAP</div>
		<div class="center">
			<form method="get" action="modules/b2c/search.php">
				<ul>
					<li>
						<label>Ürün arayın</label>
						<input type="text" name="sSearch" title="Lütfen arama yapmak istediğinizi kelimeyi girin" required="required" />
					</li>
					<li class="buttonset">
						<button type="submit" onclick="Productattribute.searchProductattribute(this.form);">{#BUTTON_Search#}</button>
					</li>
					<li>
						<a href="modules/b2c/search.php">Ayrıntılı Arama</a>
					</li>
				</ul>
			</form>
		</div><!-- .center -->
		<div class="bottom"></div>
	</div><!-- .subMenuOuter -->

	<div class="subMenuOuter">
		<h2 class="top">SEPETİM</h2>
		<div class="center">
			<form cas-form="shoppingbasket" cas-js="getShoppingbasket" method="post" action="modules/b2c/sales.php"></form>
		</div><!-- .center -->
		<div class="bottom"></div>
	</div><!-- .subMenuOuter -->
	
	<div class="subMenuOuter">
		<h2 class="top">ÜYE GİRİŞİ</h2>
		<div class="center">
			<div id="loginFormOuter">
				<form cas-form="getLoginoutFormAndMenu" autocomplete="off" action="modules/b2c/index.php" method="post">
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
								<a href="modules/b2c/reminder.php">Şifremi Unuttum</a><br />
								<a href="modules/b2c/register.php">Üye olmak istiyorum</a>
							</div>
							<button type="submit" onclick="User.loginUser(this.form);">{#BUTTON_Login#}</button>
						</li>
					</ul>
				</form>
			</div><!-- #loginFormOuter -->
		</div><!-- .center -->
		<div class="bottom"></div>
	</div><!-- .subMenuOuter -->
	
	<div class="subMenuOuter">
		<h2 class="top">KATEGORİLER</h2>
		<div class="center">
			<ul class="linkList" cas-js="getCategoriesFromProductHavingPicture" cas:url="modules/b2c/index.php?action=jsonCategoriesFromProductHavingPicture">
				<li><a href="modules/b2c/category.php?action=show&categoryId=%s">%s</a></li>
			</ul>		
		</div><!-- .center -->
		<div class="bottom"></div>
	</div><!-- .subMenuOuter -->
	
	<div class="subMenuOuter">
		<h2 class="top">MARKALAR</h2>
		<div class="center">
			<ul class="linkList" cas-js="getBrandsFromProductHavingPicture" cas:url="modules/b2c/index.php?action=jsonBrandsFromProductHavingPicture">
				<li><a href="modules/b2c/brand.php?action=show&brandId=%s">%s</a></li>
			</ul>	
		</div><!-- .center -->
		<div class="bottom"></div>
	</div><!-- .subMenuOuter -->
	
	
	<div class="subMenuOuter">
		<h2 class="top">İNDİRİMLİ ÜRÜNLER</h2>
		<div class="center">
			<ul class="productsList sidebarProductList padding_9px" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYEDONLEFTBAR}" cas-js="getProductsByProductgroupId" cas:limit="2" cas:var="1" cas:url="modules/b2c/index.php" >
				<li class="productItem">
					<label class="labelDiscount">%s</label>
					<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
						<img class="productLogo" src="img/product/2_%s" width="100px" height="100px">
					</a>
					<a class="productName" href="modules/b2c/product.php?action=show&productId=%s">%s</a>
					<div class="costsOuter">
						<span class="oldCost">
							%s<span class="scratch"></span>
						</span><!-- .oldCost -->
						<span class="currentCost">%s</span>											
						<!--<a href="javascript:Productattribute.updateProductattributebasket(%d, 1);" title="Sepete Ekle" class="btnAddToBasket">Sepete Ekle</a>-->
					</div><!-- .costsOuter -->
				</li><!-- .productItem -->
			</ul>
		</div><!-- .center -->
		<div class="bottom"></div>
	</div><!-- .subMenuOuter -->
	
	
	<!-- SAMPLE
	<div class="subMenuOuter">
		<h2 class="top">MENU TITLE</h2>
		<div class="center">
			MENU CONTENT
		</div>
		<div class="bottom"></div>
	</div>
	-->
		
</div><!-- #leftBarOuter -->
<!-- LEFTBAR / END -->