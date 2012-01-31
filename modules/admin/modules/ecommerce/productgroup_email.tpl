<h2>Alışveriş listesine ekleyenlere e-posta gönderimi</h2>
<form method="post" action="{$SCRIPT_NAME}">
<ul class="ulform">
	<li class="dn">
		<label>productId</label>
		<input type="text" name="productId" value="{$data.product.productId}" readonly="readonly" />
	</li>
	<li>
		Ürün: {$data.product.productTitle}
	</li>
	<li>
		Ürün Kodu: {$data.product.productCode}
	</li>
	<li>
		<label>Gönderi Listesi</label>
		{foreach from=$data.message.to item=to}
		{$to.userEmail},
		{foreachelse}
		{/foreach}
	</li>
	<li>
		<label>Konu</label>
		<input type="text" name="messageSubject" value="{$data.message.subject}" style="width: 100%;" />
	</li>
	<li>
		<label>İçerik</label>
		<textarea class="wysiwyg" name="messageBody">{$data.message.body}</textarea>
	</li>
	<li class="buttonset">
		<button type="submit" onclick="Productattribute.sendEmailToUsersinWishlist(this.form);">Gönder</button>
	</li>
</ul>
</form>