<div class="casContent">
	<h1 class="subHeader">KARŞILAŞTIRMA LİSTESİ</h1>
	<table style="width: 100%;">
		<tr>
			{foreach from=$data item=product}
			<td>
				<div class="tac">
					<a href="modules/b2c/product.php?action=show&productId={$product.productId}">
					<img src="img/product/3_{$product.picture.defaultx.pictureFile}" />
					</a>
				</div>
				<h3 class="tac">{$product.productTitle}</h3>
				<div>{$product.productContent}</div>
				<div>
					<h5>Fiyatı</h5>
					{if $product.productimpactDiscountRate neq null or $product.productimpactDiscountPrice neq null}
					<span style="text-decoration: line-through;">{$product.productattributepriceMCur}</span>
					{/if}
					{$product.productattributepriceMDVCur}
				</div>
				<div>
					<h5>Özellikler</h5>
					<ul>
					{foreach from=$product.attributegroups item=attributegroup}
					<li>
						<label>{$attributegroup.attributegroupTitle}: </label>
						{foreach from=$attributegroup.attributes.aaData item=attribute}
						{$attribute.attributeTitle},
						{/foreach}
					</li>
					{/foreach}
					</ul>
				</div>
			</td>
			{foreachelse}
			<td>Karşılaştırma listeniz boş</td>
			{/foreach}
		</tr>
	</table>
</div>