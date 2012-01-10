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
		<th>Yetkiler</th>
		<td>
			<p>
				<a href="#" id="btnExpandAll">Expand all</a> -
				<a href="#" id="btnCollapseAll">Collapse all</a> -
				<a href="#" id="btnToggleExpand">Toggle expand</a> -
				<a href="#" id="btnSortAll">Sort tree</a>
			</p>
			<div id="permissionParent" name="permissionParent[]"></div>
		</td>
	</tr>
	<!--
	<tr>
		<td>{#LABEL_Parent#}</td>
		<td>
			<div id="permissionParent"></div>
		</td>
	</tr>
	-->
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
	
	$("#btnExpandAll").click(function(){
		$("#permissionParent").dynatree("getRoot").visit(function(node){
			node.expand(true);
		});
		return false;
	});
	$("#btnCollapseAll").click(function(){
		$("#permissionParent").dynatree("getRoot").visit(function(node){
			node.expand(false);
		});
		return false;
	});
	$("#btnToggleExpand").click(function(){
		$("#permissionParent").dynatree("getRoot").visit(function(node){
			node.toggleExpand();
		});
		return false;
	});
	$("#btnSortAll").click(function(){
		var node = $("#permissionParent").dynatree("getRoot");
		node.sortChildren(null, true);
		return false;
	});

	$("#permissionParent").dynatree({
		debugLevel: 0,
		//persist: true,
		checkbox: true,
		selectMode: 2,
		title: "Lazy loading sample",
		fx: { height: "toggle", duration: 200 },
		autoFocus: false, // Set focus to first child, when expanding or lazy-loading.
		// In real life we would call a URL on the server like this:
		initAjax: {
			url: "{$SCRIPT_NAME}",
			data: { action: "jsonPermissions", roleId: "{$data.model.roleId}", mode: "funnyMode" }
		},
		onClick: function(node, event) {
			if( node.getEventTargetType(event) == "title" ) {
				node.toggleSelect();
			}
		},
		onPostInit: function(isReloading, isError) {
			$("#permissionParent").dynatree("getRoot").visit(function(node){
				node.expand(true);
			});
		},
		onLazyRead: function(node){
			node.appendAjax({
				url: "{$SCRIPT_NAME}",
				data: {
					action: "jsonPermissions",
					roleId: "{$data.model.roleId}",
					key: node.data.key,
					mode: "funnyMode"
				}
			});
		}
	});
	
	/*
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
	*/
	
});

/*
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
*/
</script>