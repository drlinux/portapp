<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table class="ui-widget-content ui-corner-all">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "categoryTitle_empty"}You must supply a title
	{elseif $msg eq "pictureFile_empty"}You must supply a logo
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>{#LABEL_Id#}</td>
		<td>
			<input type="text" name="categoryId" value="{$data.model.categoryId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Parent#}</td>
		<td>
			<div id="categoryParent"></div>
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Sorting#}</td>
		<td>
			<input type="text" name="categorySorting" value="{$data.model.categorySorting}" />
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
			<img src="img/category/{$data.model.pictureFile}" />
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
			<input type="text" name="categoryTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.categoryTitle}"/>
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
			{if $data.model.categoryId neq null}
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
	
	var a = $("div#categoryParent");
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
			items.push(tree(response, "{$data.model.categoryParent}", "{$data.model.categoryId}"));
			$('<select/>', {
				'id': '',
				'class': 'ui-widget-content ui-corner-all',
				'name': 'categoryParent',
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