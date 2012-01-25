<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table>
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "bannerTitle_empty"} Lütfen bir başlık girin
	{elseif $msg eq "bannerDescription_empty"} Lütfen bir açıklama girin
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<th>{#LABEL_Id#}</th>
		<td><input type="text" name="bannerId" value="{$data.bannerId}" readonly="readonly"/></td>
	</tr>
	<tr>
		<th>{#LABEL_Title#}</th>
		<td><input type="text" name="bannerTitle" value="{$data.bannerTitle}"/></td>
	</tr>
	<tr>
		<th>{#LABEL_Description#}</th>
		<td><textarea name="bannerDescription">{$data.bannerDescription}</textarea></td>
	</tr>
	<tr>
		<th>{#LABEL_Start#}</th>
		<td><input type="text" class="datetimepicker" name="bannerStart" value="{$data.bannerStart}"/></td>
	</tr>
	<tr>
		<th>{#LABEL_End#}</th>
		<td><input type="text" class="datetimepicker" name="bannerEnd" value="{$data.bannerEnd}"/></td>
	</tr>
	<tr>
		<th>Bağlantı</th>
		<td><input type="text" name="bannerHref" value="{$data.bannerHref}"/></td>
	</tr>
	<tr>
		<td>{#LABEL_Image#}</td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
			<input type="file" name="pictureFile" />
		</td>
	</tr>
	{if $data.pictureFile neq null}
	<tr>
		<td></td>
		<td>
			<img src="img/banner/{$data.pictureFile}" />
		</td>
	</tr>
	{/if}
</tbody>
<tfoot>
	<tr>
		<th></th>
		<td>
			<span class="buttonset">
				<button name="action" value="save">{#BUTTON_Save#}</button>
				{if $data.bannerId neq null}
				<button name="action" value="delete">{#BUTTON_Delete#}</button>
				{/if}
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>