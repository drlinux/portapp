<div class="casContent">
	<div id="deliveryAddress" cas-js="getDeliveryaddresses" cas:url="modules/b2c/address.php" cas:var1=""></div>
	<div id="billAddress" cas-js="getInvoiceaddresses" cas:url="modules/b2c/address.php" cas:var1="" class="mt20"></div>
	
	<div class="dn" id="dialog-form" title="Adres girişi">
		<form id="formPostaladdress" method="post" action="modules/b2c/address.php">
			<ul class="ulform">
				<li class="dn">
					<label>postaladdresstype</label>
					<input type="text" name="postaladdressType" required="required" />
				</li>
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
				<li class="buttonset">
					<button type="submit" onclick="Postaladdress.savePostaladdress(this.form);">{#BUTTON_Save#}</button>
					<button type="submit" onclick="Postaladdress.deletePostaladdress(this.form);">{#BUTTON_Delete#}</button>
				</li>
			</ul>
		</form>
	</div>
</div>