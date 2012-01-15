<div class="casContent">
	<h1 class="subHeader">İletişim Formu</h1>
	
	<form action="{$SCRIPT_NAME}" method="post">
	<ul class="ulform">
		<li>
			<label>Ad-Soyad:</label>
			<input type="text" name="userticketName" autofocus="autofocus" required="required" />
		</li>
		<li>
			<label>E-Posta:</label>
			<input type="email" name="userticketEmail" required="required" />
		</li>
		<li>
			<label>Telefon:</label>
			<input type="text" class="phone" name="userticketPhone" required="required" />
		</li>
		<li>
			<label>Konu:</label>
			<input type="text" name="userticketSubject" required="required" />
		</li>
		<li>
			<label>Mesaj:</label>
			<textarea name="userticketMessage" required="required"></textarea>
		</li>
		<li class="buttonset">
			<button type="submit" onclick="Userticket.saveUserticket(this.form);">{#BUTTON_Submit#}</button>
		</li>
	</ul>
	</form>
	
	<ul class="ulform">
		<li>
			<label>Adres:</label>
			<span>{$_COMPANY_ADDRESS}</span>
			<a href="https://maps.google.com/maps?f=q&source=s_q&hl=tr&q={$_COMPANY_LATITUDE}+{$_COMPANY_LONGITUDE}&ie=UTF8&z=16" target="_blank" style="font-size: smaller;">[Google Maps]</a>
		</li>
		<li>
			<label>Telefon:</label> 
			<span>{$_COMPANY_PHONE}</span>
		</li>
		<li>
			<label>Faks:</label> 
			<span>{$_COMPANY_FAX}</span>
		</li>
		<li>
			<label>Email:</label> 
			<span>{mailto address=$_COMPANY_EMAIL encode='javascript' subject=''}</span>
		</li>
		<li>
			<!-- <a href="https://maps.googleapis.com/maps/api/staticmap?center={$_COMPANY_LATITUDE},{$_COMPANY_LONGITUDE}&zoom=16&size=800x500&sensor=false" target="_blank">büyült</a> -->
			<div cas-js="getMap" cas:width="600" cas:height="375" cas:lat="{$_COMPANY_LATITUDE}" cas:lng="{$_COMPANY_LONGITUDE}" cas:draggable="false">
				<small>
				<b>{$_COMPANY_NAME}</b><br/>
				{$_COMPANY_ADDRESS}<br/>
				T: {$_COMPANY_PHONE}<br/>
				F: {$_COMPANY_FAX}<br/>
				</small>
			</div>
		</li>
	</ul>
	
</div>