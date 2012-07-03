<div>
	<form method="post">
		<h3>Mesaj Bilgileri</h3>
		<input type="hidden" name="userticketId" value="{$data.userticketId}" />
		<label>Adı Soyadı</label><br />
		<input type="text" readonly="true" name="userticketId" value="{$data.userticketName}" /><br /><br />
		<label>E-Posta Adresi:</label><br />
		<input type="text" readonly="true" name="userticketEmail" value="{$data.userticketEmail}" /><br /><br />
		<label>Telefon Numarası:</label><br />
		<input type="text" readonly="true" name="userticketPhone" value="{$data.userticketPhone}" /><br /><br />
		<label>Mesaj Konusu:</label><br />
		<input type="text" readonly="true" name="userticketSubject" value="{$data.userticketSubject}" /><br /><br />
		<label>Mesaj:</label><br />
		<textarea readonly="true" rows="6" cols="40" name="userticketMessage">{$data.userticketMessage}"</textarea>
	</form>
</div>