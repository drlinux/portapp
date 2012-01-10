<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table>
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "pageSorting_empty"}You must supply a sorting
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>{#LABEL_Id#}</td>
		<td>
			<input type="text" name="pageId" value="{$data.model.pageId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Parent#}</td>
		<td>
			<div id="pageParent"></div>
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Sorting#}</td>
		<td>
			<input type="text" name="pageSorting" value="{$data.model.pageSorting}" />
		</td>
	</tr>
	<tr>
		<td>isDefault</td>
		<td>
			<input type="text" name="pageIsDefault" value="{$data.model.pageIsDefault}" />
		</td>
	</tr>
	<tr>
		<td>redirect</td>
		<td>
			<input type="text" name="pageRedirect" value="{$data.model.pageRedirect}" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Images#}</td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
			<input type="file" name="pictureFile" />
		</td>
	</tr>
	{if $data.model.pictureFile neq null}
	<tr>
		<td></td>
		<td>
			<img src="img/page/100/{$data.model.pictureFile}" />
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
			<input type="text" name="pageTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.pageTitle}"/>
			{/foreach}
		</td>
	</tr>
	<tr>
		<th class="vat">{#LABEL_Description#}</th>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<textarea name="pageDescription[{$entry.iso639.iso639Id}]">{$entry.model.pageDescription}</textarea>
			{/foreach}
		</td>
	</tr>
	<tr>
		<th class="vat">{#LABEL_Content#}</th>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<textarea class="wysiwyg" name="pageContent[{$entry.iso639.iso639Id}]">{$entry.model.pageContent}</textarea>
			{/foreach}
		</td>
	</tr>
	<tr>
		<th class="vat">{#LABEL_Keywords#}</th>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<input type="text" name="pageKeywords[{$entry.iso639.iso639Id}]" value="{$entry.model.pageKeywords}"/>
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
			{if $data.model.pageId neq null}
			<button name="action" value="delete">{#BUTTON_Delete#}</button>
			{/if}
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>

<script>
$(function() {
	var a = $("div#pageParent");
	$.ajax({
		type: "GET",
		url: "{$SCRIPT_NAME}",
		data: "action=jsonTree",
		dataType: "json",
		beforeSend: function() {
		},
		complete: function() {
		},
		statusCode: {
			404: function() {
				CommonItems.casDialog("{#ALERT_PageNotFound#}");
			}
		},
		success: function(response) {
			a.html('');
			var items = [];
			items.push('<option value="">---</option>');
			items.push(tree(response, "{$data.model.pageParent}", "{$data.model.pageId}"));
			$('<select/>', {
				'id': '',
				'class': 'ui-widget-content ui-corner-all',
				'name': 'pageParent',
				'html': items.join('')
			}).appendTo(a);
		}
	});
});

function tree(json, selected, id)
{
	var items = [];
	$.each(json, function(key, val) {
		items.push('<option value="' + val.id + '"');
		if (val.id==id) items.push(' disabled="disabled"'); 
		if (val.id==selected) items.push(' selected="selected"'); 
		items.push('>' + val.text + '</option>');
		if(val.children!=null) {
			items.push(tree(val.children, selected, id));
		}
	});
	return items;
}
</script>