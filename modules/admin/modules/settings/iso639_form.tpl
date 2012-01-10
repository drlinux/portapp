<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table>
	{if $msg ne ""}
	<tr>
		<td bgcolor="yellow" colspan="2">
		{if $msg eq "iso639A2_empty"}You must supply a A2 Code.
		{elseif $msg eq "iso639Title_empty"}You must supply a title.
		{elseif $msg eq "iso639Status_empty"}You must supply a status.
		{/if}
		</td>
	</tr>
	{/if}
	<tr class="dn">
		<th>{#LABEL_Id#}</th>
		<td><input type="text" name="iso639Id" value="{$data.iso639Id}" readonly="readonly"/></td>
	</tr>
	<tr>
		<th>A2</th>
		<td><input type="text" name="iso639A2" value="{$data.iso639A2}"/></td>
	</tr>
	<tr>
		<th>{#LABEL_Title#}</th>
		<td><input type="text" name="iso639Title" value="{$data.iso639Title}"/></td>
	</tr>
	<tr>
		<th>{#LABEL_Status#}</th>
		<td><input type="text" name="iso639Status" value="{$data.iso639Status}"/></td>
	</tr>
	<tr>
		<td>{#LABEL_Logo#}</td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
			<input type="file" name="pictureFile" />
		</td>
	</tr>
	{if $data.pictureFile neq null}
	<tr>
		<td></td>
		<td>
			<img src="img/iso639/100/{$data.pictureFile}" />
		</td>
	</tr>
	{/if}
	<tr>
		<th></th>
		<td>
			<span class="buttonset">
				<button name="action" value="save">{#BUTTON_Save#}</button>
				<button name="action" value="delete">{#BUTTON_Delete#}</button>
			</span>
		</td>
	</tr>
</table>
</form>