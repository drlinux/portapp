<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table class="ui-widget-content ui-corner-all">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "currencyCode_empty"}You must supply a code
	{elseif $msg eq "currencyTitle_empty"}You must supply a title
	{elseif $msg eq "currencySign_empty"}You must supply a sign
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>id:</td>
		<td>
			<input type="text" name="currencyId" value="{$data.currencyId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>title:</td>
		<td>
			<input type="text" name="currencyTitle" value="{$data.currencyTitle|escape}" />
		</td>
	</tr>
	<tr>
		<td>code:</td>
		<td>
			<input type="text" name="currencyCode" value="{$data.currencyCode|escape}" />
		</td>
	</tr>
	<tr>
		<td>sign:</td>
		<td>
			<input type="text" name="currencySign" value="{$data.currencySign}" />
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
			{if $data.currencyId neq null}
			<button name="action" value="delete">{#BUTTON_Delete#}</button>
			{/if}
			</span>
		</td>
	</tr>
</tbody>
</table>
</form>