<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table class="ui-widget-content ui-corner-all">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "brandTitle_empty"}You must supply a title
	{elseif $msg eq "pictureFile_empty"}You must supply a logo
	{elseif $msg eq "brandCode_empty"}You must supply a code
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>id:</td>
		<td>
			<input type="text" name="brandId" value="{$data.brandId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>code:</td>
		<td>
			<input type="text" name="brandCode" value="{$data.brandCode}" />
		</td>
	</tr>
	<tr>
		<td>title:</td>
		<td>
			<input type="text" name="brandTitle" value="{$data.brandTitle|escape}" />
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
			<img src="img/brand/{$data.pictureFile}" />
		</td>
	</tr>
	{/if}
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
			{if $data.brandId neq null}
			<button name="action" value="delete">{#BUTTON_Delete#}</button>
			{/if}
			</span>
		</td>
	</tr>
</tbody>
</table>
</form>