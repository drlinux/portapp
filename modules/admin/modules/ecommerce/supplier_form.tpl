<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table class="ui-widget-content ui-corner-all">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "companyTitle_empty"}You must supply a title
	{elseif $msg eq "pictureFile_empty"}You must supply a logo
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>id:</td>
		<td>
			<input type="text" name="supplierId" value="{$data.supplierId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>code:</td>
		<td>
			<input type="text" name="supplierCode" value="{$data.supplierCode}" />
		</td>
	</tr>
	<tr>
		<td>title:</td>
		<td>
			<input type="text" name="companyTitle" value="{$data.companyTitle|escape}" />
		</td>
	</tr>
	<tr>
		<td>tax:</td>
		<td>
			<input type="text" name="companyTax" value="{$data.companyTax}" />
		</td>
	</tr>
	<tr>
		<td>phone:</td>
		<td>
			<input type="text" name="companyPhone" value="{$data.companyPhone}" />
		</td>
	</tr>
	<tr>
		<td>fax:</td>
		<td>
			<input type="text" name="companyFax" value="{$data.companyFax}" />
		</td>
	</tr>
	<tr>
		<td>logo:</td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
			<input type="file" name="pictureFile" />
		</td>
	</tr>
	{if $data.pictureFile neq null}
	<tr>
		<td></td>
		<td>
			<img src="img/company/{$data.pictureFile}" />
		</td>
	</tr>
	{/if}
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
			{if $data.supplierId neq null}
			<button name="action" value="delete">{#BUTTON_Delete#}</button>
			{/if}
			</span>
		</td>
	</tr>
</tbody>
</table>
</form>