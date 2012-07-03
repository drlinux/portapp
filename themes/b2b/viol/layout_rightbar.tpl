{if $display neq 0}
<div id="rightBarOuter" class="sidebar">
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
			<form cas-form="shoppingbasket" cas-js="getShoppingbasket" cas:link="modules/b2b/product.php" method="post" action="modules/b2b/sales.php"></form>
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">MENÜ</h2>
		<div class="center">
			<div id="loginFormOuter">
				<form autocomplete="off" action="modules/b2b/index.php" method="post">
					{$data.user_menu}
				</form>
			</div>
		</div>
		<div class="bottom"></div>
	</div>
	
	<div class="subMenuOuter">
		<h2 class="top">KATEGORİLER</h2>
		<div class="center">
			<div class="linkList treeList">
				{$data.categories_menu}
			</div>		
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
{/if}