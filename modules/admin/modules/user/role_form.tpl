<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Rol</a></li>
	</ul>
	<div id="tabs-1">
		<form id="formPermissions">
		<table>
		{if $msg ne ""}
		<caption class="ui-state-error ui-corner-all">
			{if $msg eq "roleTitle_empty"}You must supply a title.
			{/if}
		</caption>
		{/if}
		<tbody>
			<tr class="dn">
				<th>{#LABEL_Id#}</th>
				<td><input type="text" name="roleId" value="{$data.model.roleId}" readonly="readonly" /></td>
			</tr>
			<tr>
				<th>{#LABEL_Title#}</th>
				<td><input type="text" name="roleTitle" value="{$data.model.roleTitle}" title="" /></td>
			</tr>
			<tr>
				<th>hasPriceDiscrimination</th>
				<td><input type="text" name="hasPriceDiscrimination" value="{$data.model.hasPriceDiscrimination}" title="" /></td>
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
					<div id="permissionIds" name="permissionIds[]"></div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<td>
					<span class="buttonset">
						<button name="action" value="save">{#BUTTON_Save#}</button>
						{if $data.model.roleId neq null}
						<button name="action" value="delete">{#BUTTON_Delete#}</button>
						<a action="delete" id="{$data.model.roleId}" href="javascript:return false;">{#BUTTON_Delete#}</a>
						{/if}
					</span>
				</td>
			</tr>
		</tfoot>
		</table>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	
	$("#btnExpandAll").click(function(){
		$("#permissionIds").dynatree("getRoot").visit(function(node){
			node.expand(true);
		});
		return false;
	});
	$("#btnCollapseAll").click(function(){
		$("#permissionIds").dynatree("getRoot").visit(function(node){
			node.expand(false);
		});
		return false;
	});
	$("#btnToggleExpand").click(function(){
		$("#permissionIds").dynatree("getRoot").visit(function(node){
			node.toggleExpand();
		});
		return false;
	});
	$("#btnSortAll").click(function(){
		var node = $("#permissionIds").dynatree("getRoot");
		node.sortChildren(null, true);
		return false;
	});



	$("form#formPermissions a[action=delete]").click(function(){
		var roleId = $(this).attr("id");
		var formData = [];
		formData.push({ name: "action", value: "ajaxDeleteRole" });
		formData.push({ name: "roleId", value: roleId });
		$.post("{$SCRIPT_NAME}",
				formData,
				function(response, textStatus, xhr){
					alert("POST returned " + response + ", " + textStatus);
					window.location.replace("{$SCRIPT_NAME}");
				}
		);
	});
	
	$("form#formPermissions").submit(function() {
		// Serialize standard form fields:
		var formData = $(this).serializeArray();

		// then append Dynatree selected 'checkboxes':
		var tree = $("#permissionIds").dynatree("getTree");
		formData = formData.concat(tree.serializeArray());

		// and/or add the active node as 'radio button':
		if(tree.getActiveNode()){
			formData.push({ name: "activeNode", value: tree.getActiveNode().data.key });
		}
		formData.push({ name: "action", value: "ajaxSaveRole" });

		//alert("POSTing this:\n" + jQuery.param(formData));

		$.post("{$SCRIPT_NAME}",
				formData,
				function(response, textStatus, xhr){
					alert("POST returned " + response + ", " + textStatus);
					window.location.replace("{$SCRIPT_NAME}?action=edit&roleId=" + response.roleId);
				},
				"json"
		);
		return false;
	});
	
	$("#permissionIds").dynatree({
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
			$("#permissionIds").dynatree("getRoot").visit(function(node){
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
	
});
</script>