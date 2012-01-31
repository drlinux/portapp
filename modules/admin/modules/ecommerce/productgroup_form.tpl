<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Ürün Grubu</a></li>
		{if $data.model.productgroupId neq null}
		<li><a href="#tabs-2">Alışveriş Listesine Ekleyenler</a></li>
		{/if}
	</ul>
	<div id="tabs-1">
		<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
		<table>
		{if $msg ne ""}
		<caption class="ui-state-error ui-corner-all">
			{if $msg eq "productgroupTitle_empty"}You must supply a title
			{/if}
		</caption>
		{/if}
		<tbody>
			<tr class="dn">
				<td>{#LABEL_Id#}</td>
				<td>
					<input type="text" name="productgroupId" value="{$data.model.productgroupId}" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>{#LABEL_Sorting#}</td>
				<td>
					<input type="text" name="productgroupSorting" value="{$data.model.productgroupSorting}" />
				</td>
			</tr>
			<tr>
				<td class="vat">{#LABEL_Title#}</td>
				<td>
					{foreach from=$data.i18n item="entry"}
					<div>{$entry.iso639.iso639Title}</div>
					<input type="text" name="productgroupTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.productgroupTitle}"/>
					{/foreach}
				</td>
			</tr>
			<tr>
				<td>Ürünler</td>
				<td>
					<select class="multiselect" name="productId[]" multiple="multiple" size="5">
					{html_options options=$data.product.options selected=$data.model.product.selected}
					</select>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td>
					<span class="buttonset">
					<button name="action" value="save">{#BUTTON_Save#}</button>
					{if $data.model.productgroupId neq null}
					<button name="action" value="delete">{#BUTTON_Delete#}</button>
					{/if}
					</span>
				</td>
			</tr>
		</tfoot>
		</table>
		</form>
	</div>
	<div id="tabs-2">
		<table>
		<tr>
			<td>Ürün</td>
			<td>Ekleyen Kullanıcı Sayısı</td>
			<td></td>
		</tr>
		{foreach from=$data.productgroup_product item=entry}
		<tr>
			<td>{$entry.productCode} - {$entry.productTitle}</td>
			<td>{$entry.numberOfUsers}</td>
			<td>
				{if $entry.numberOfUsers gt 0}
				<a href="{$SCRIPT_NAME}?action=inform&productId={$entry.productId}">Bilgilendir</a>
				{/if}
			</td>
		</tr>
		{foreachelse}
		{/foreach}
		</table>
	</div>
</div>