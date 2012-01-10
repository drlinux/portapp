<a class="button" href="{$SCRIPT_NAME}?action=new">{#BUTTON_NewEntry#}</a>

<table>
<caption>Roller</caption>
<tbody>
	{foreach from=$data.aaData item="entry"}
	<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
		<td><a href="{$SCRIPT_NAME}?action=edit&roleId={$entry.roleId}">{$entry.roleTitle|escape}</a></td>
	</tr>
	{foreachelse}
	<tr>
		<td>{#ALERT_NoRecords#}</td>
	</tr>
	{/foreach}
</tbody>
</table>
