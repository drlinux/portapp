<div id="rightBarOuter" class="sidebar">
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
		</div>
		<div class="bottom"></div>
	</div>

	<div class="subMenuOuter">
		<h2 class="top">SEPETİM</h2>
		<div class="center">
			<form cas-form="shoppingbasket" cas-js="getShoppingbasket" cas:link="modules/b2c/product.php" method="post" action="modules/b2c/sales.php"></form>
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">{$data.user_menu_title}</h2>
		<div class="center">
			<div id="loginFormOuter">
				<form autocomplete="off" action="modules/b2c/index.php" method="post">
					{if $data.user_menu neq "no_permission"}
						{$data.user_menu}
					{else}
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
					{/if}
				</form>
			</div>
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">KATEGORİLER</h2>
		<div class="center">
			<ul class="linkList">
				{$data.categories_menu}
			</ul>		
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">MARKALAR</h2>
		<div class="center">
			<ul class="linkList">
				{$data.brands_menu}
			</ul>	
		</div>
		<div class="bottom"></div>
	</div>
	
</div>