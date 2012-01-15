<div class="casContent">
	<h1 class="subHeader">Sepetim</h1>

	<form class="fl w100p" cas-form="shoppingbasket" cas-js="getShoppingbasket2" cas:link="modules/b2b/product.php" method="post" action="modules/b2b/sales.php"></form>
	
	<div class="dn" id="dialog-form" title="Adres girişi">
		<form id="formPostaladdress" method="post" action="modules/b2b/address.php">
			<ul class="ulform">
				<li class="dn">
					<label>{#LABEL_Id#}</label>
					<input type="text" name="postaladdressId" readonly="readonly" />
				</li>
				<li>
					<label>{#LABEL_Address#}</label>
					<input type="text" name="postaladdressContent" required="required" />
				</li>
				<li>
					<label>{#LABEL_City#}</label>
					<input type="text" name="postaladdressCity" required="required" />
				</li>
				<li>
					<label>{#LABEL_County#}</label>
					<input type="text" name="postaladdressCounty" required="required" />
				</li>
				<li>
					<label>{#LABEL_Postalcode#}</label>
					<input type="text" name="postaladdressPostalcode" required="required" />
				</li>
				<li>
					<label>{#LABEL_Country#}</label>
					<input type="text" name="postaladdressCountry" required="required" />
				</li>
				<li class="dn">
					<label>postaladdresstype</label>
					<input type="text" name="postaladdressType" readonly="readonly" required="required" />
				</li>
				<li class="buttonset">
					<button type="submit" onclick="Postaladdress.savePostaladdress(this.form);">{#BUTTON_Save#}</button>
					<button type="button" onclick="Postaladdress.deletePostaladdress(this.form);">{#BUTTON_Delete#}</button>
				</li>
			</ul>
		</form>
	</div>
</div>