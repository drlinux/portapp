<table>
<caption>Ürün Özellikleri</caption>
<tbody>
	{foreach from=$data.aaData item="attributegroup"}
	<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
		<td>
			<a href="{$SCRIPT_NAME}?action=edit-attributegroup&attributegroupId={$attributegroup.attributegroupId}">{$attributegroup.attributegroupTitle|escape}</a>
			<ul>
				{foreach from=$attributegroup.attribute.aaData item="attribute"}
				<li><a href="{$SCRIPT_NAME}?action=edit-attribute&attributeId={$attribute.attributeId}">{$attribute.attributeTitle|escape}</a></li>
				{/foreach}
				<li><a href="{$SCRIPT_NAME}?action=new-attribute&attributegroupId={$attributegroup.attributegroupId}">{#BUTTON_NewEntry#}</a></li>
			</ul>
		</td>
	</tr>
	{/foreach}
	<tr>
		<td><a href="{$SCRIPT_NAME}?action=new-attributegroup">{#BUTTON_NewEntry#}</a></td>
	</tr>
</tbody>
</table>