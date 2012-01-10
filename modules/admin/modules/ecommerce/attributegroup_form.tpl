<form action="{$SCRIPT_NAME}" method="post">
<table>
	<caption>Özelliğe ait bilgiler</caption>
	<tr class="dn">
		<td>{#LABEL_Id#}</td>
		<td>
			<input type="text" name="attributegroupId" value="{$data.model.attributegroupId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>Renk mi?</td>
		<td>
			<input type="text" name="isColorgroup" value="{$data.model.isColorgroup}" />
		</td>
	</tr>
	<tr>
		<td class="vat">{#LABEL_Title#}</td>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<input type="text" name="attributegroupTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.attributegroupTitle}"/>
			{/foreach}
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="saveAttributegroup">{#BUTTON_Save#}</button>
			{if $data.model.attributegroupId neq null}
			<button name="action" value="deleteAttributegroup">{#BUTTON_Delete#}</button>
			{/if}
			</span>
		</td>
	</tr>
</table>
</form>