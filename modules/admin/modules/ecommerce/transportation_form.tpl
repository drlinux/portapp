<script type="text/javascript">
$(function () {
	$('#picture').imgAreaSelect({ 
		//x1: 40, y1: 80, x2: 200, y2: 200,
		//aspectRatio: '1:1', 
		onSelectChange: function (img, selection) {
			if (!selection.width || !selection.height) return;
			$('input[name=x1]').val(selection.x1);
			$('input[name=y1]').val(selection.y1);
			$('input[name=x2]').val(selection.x2);
			$('input[name=y2]').val(selection.y2);
			$('input[name=w]').val(selection.width);
			$('input[name=h]').val(selection.height);    
		},
		handles: true,
		fadeSpeed: 200
	});
});
</script>

<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table class="ui-widget-content ui-corner-all">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "transportationTitle_empty"}You must supply a title
	{elseif $msg eq "pictureFile_empty"}You must supply a logo
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>{#LABEL_Id#}</td>
		<td>
			<input type="text" name="transportationId" value="{$data.model.transportationId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Sorting#}</td>
		<td>
			<input type="text" name="transportationSorting" value="{$data.model.transportationSorting}" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Price#}</td>
		<td>
			<input type="text" name="transportationPrice" value="{$data.model.transportationPrice}" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Logo#}</td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
			<input type="file" name="pictureFile" />
		</td>
	</tr>
	{if $data.model.pictureFile neq null}
	<tr>
		<td></td>
		<td>
			<img id="picture" src="img/transportation/{$data.model.pictureFile}" style="width: 300px; float: left;"/>
			<ul class="fl dn">
				<li>
				x1: <input type="text" name="x1" value="-" /><br/>
				</li>
				<li>
				y1: <input type="text" name="y1" value="-" /><br/>
				</li>
				<li>
				x2: <input type="text" name="x2" value="-" /><br/>
				</li>
				<li>
				y2: <input type="text" name="y2" value="-" /><br/>
				</li>
				<li>
				w: <input type="text" name="w" value="-" /><br/>
				</li>
				<li>
				h: <input type="text" name="h" value="-" /><br/>
				</li>
				<li>
				filename: <input type="text" name="filename" value="{$data.model.pictureFile}" /><br/>
				</li>
			</ul>
		</td>
	</tr>
	{/if}




	<tr>
		<td></td>
		<td><hr/></td>
	</tr>



	<tr>
		<td class="vat">{#LABEL_Title#}</td>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<input type="text" name="transportationTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.transportationTitle}"/>
			{/foreach}
		</td>
	</tr>

	<tr>
		<td class="vat">{#LABEL_Content#}</td>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<textarea name="transportationContent[{$entry.iso639.iso639Id}]">{$entry.model.transportationContent}</textarea>
			{/foreach}
		</td>
	</tr>

</tbody>
<tfoot>
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
			{if $data.model.transportationId neq null}
			<button name="action" value="delete">{#BUTTON_Delete#}</button>
			{/if}
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>