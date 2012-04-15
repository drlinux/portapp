<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table class="ui-widget-content ui-corner-all">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "permissionHref_empty"} Sayfa adresini girin
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>{#LABEL_Id#}</td>
		<td>
			<input type="text" name="permissionId" value="{$data.model.permissionId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Parent#}</td>
		<td>
			<div id="permissionParent"></div>
		</td>
	</tr>
	<tr>
		<td>href</td>
		<td>
			<input type="text" name="permissionHref" value="{$data.model.permissionHref}" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Sorting#}</td>
		<td>
			<input type="text" name="permissionSorting" value="{$data.model.permissionSorting}" />
		</td>
	</tr>
	
	
	<tr>
		<td></td>
		<td><hr/></td>
	</tr>


	<tr>
		<td class="vat">{#LABEL_Title#}</td>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<input type="text" name="permissionTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.permissionTitle}"/>
			{/foreach}
		</td>
	</tr>
	<tr>
		<td class="vat">Menüde Görünsün mü?</td>
		<td>
			<input type="checkbox" {if $data.model.display eq 1} checked="checked" {/if} name="display" value="1" />
		</td>
	</tr>
	
</tbody>
<tfoot>
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
			{if $data.model.permissionId neq null}
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
	var a = $("div#permissionParent");
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
			items.push(tree(response, "{$data.model.permissionParent}", "{$data.model.permissionId}"));
			$('<select/>', {
				'id': '',
				'class': 'ui-widget-content ui-corner-all',
				'name': 'permissionParent',
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