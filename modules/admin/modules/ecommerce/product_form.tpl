<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Ürün Bilgisi</a></li>
		{if $data.product.productId neq null}
		<li><a href="#tabs-2">Ürün Fotoğrafları</a></li>
		<li><a href="#tabs-3">Stok Kart</a></li>
		<li><a href="#tabs-4">Fiyatlandırma</a></li>
		<li class="dn"><a href="#tabs-5">Özelliğin ürün fiyatına etkisi</a></li>
		{/if}
	</ul>
	<div id="tabs-1">
		<form id="formCategories">
			<table>
			{if $msg ne ""}
			<caption class="ui-state-error ui-corner-all">
				Hata Kodu: {$msg}
				{if $msg eq "code_empty"}You must supply a code
				{elseif $msg eq "title_empty"}You must supply a title
				{elseif $msg eq "description_empty"}You must supply a description
				{elseif $msg eq "ALERT_IllegalFileFormat"}Illegal File Format
				{elseif $msg eq "ALERT_IllegalFileSize"}Illegal File Size
				{elseif $msg eq "ALERT_Completed"}{$ALERT_Completed}
				{elseif $msg eq "ALERT_ErrorOccured"}Error Occured
				{/if}
			</caption>
			{/if}
			<tbody>
				<tr>
					<td>ürün kodu:</td>
					<td>
						<input type="text" name="productCode" value="{$data.product.productCode}" />
					</td>
				</tr>
				<tr>
					<td>kategoriler:</td>
					<td>
						<div id="categoryIds" name="categoryIds[]"></div>
					</td>
				</tr>
				<tr>
					<td>varsayılan kategori:</td>
					<td>
						<div id="divCategoryDefault">
						{html_options name=categoryId options=$data.product.category.options selected=$data.product.categoryId}
						</div>
					</td>
				</tr>
				<tr>
					<td>marka:</td>
					<td>
						{html_options name=brandId options=$data.brand.options selected=$data.product.brandId}
					</td>
				</tr>
				<tr>
					<td>vergi:</td>
					<td>
						{html_options name=taxonomyId options=$data.taxonomy.options selected=$data.product.taxonomyId}
					</td>
				</tr>
				<tr>
					<td>garanti süresi:</td>
					<td>
						{html_options name=warrantyId options=$data.warranty.options selected=$data.product.warrantyId}
					</td>
				</tr>
				<tr class="dn">
					<td>id:</td>
					<td><input type="text" name="productId"
						value="{$data.product.productId}" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<td>başlık:</td>
					<td><input type="text" name="productTitle"
						value="{$data.product.productTitle|escape}"/>
					</td>
				</tr>
				<tr>
					<td valign="top">içerik:</td>
					<td>
						<textarea class="wysiwyg" name="productContent">{$data.product.productContent|escape}</textarea>
					</td>
				</tr>
				<tr>
					<td>video:</td>
					<td>
						<textarea style="width: 99%;" name="productVideo">{$data.product.productVideo}</textarea>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td>
						<span class="buttonset">
						<button name="action" value="save">{#BUTTON_Save#}</button>
						{if $data.product.productId neq null}
						<button name="action" value="deleteProduct">{#BUTTON_Delete#}</button>
						<a action="delete" id="{$data.product.productId}" href="javascript:return false;">{#BUTTON_Delete#}</a>
						{/if}
						</span>
					</td>
				</tr>
			</tfoot>
			</table>
		</form>
	</div>
	{if $data.product.productId neq null}
	<div id="tabs-2">
		<link rel="stylesheet" href="modules/admin/modules/ecommerce/image_process/jcrop/jquery.Jcrop.css" />
		<link rel="stylesheet" href="modules/admin/modules/ecommerce/image_process/jcrop/crop.css" />
		<link rel="stylesheet" href="modules/admin/modules/ecommerce/image_process/css/style.css" />
		<script type="text/javascript" src="modules/admin/modules/ecommerce/image_process/js/jquery.color.js"></script>
		<script type="text/javascript" src="modules/admin/modules/ecommerce/image_process/jcrop/jquery.Jcrop.min.js"></script>
		<script type="text/javascript" src="modules/admin/modules/ecommerce/image_process/jcrop/crop.js"></script>
		<script type="text/javascript">var resolutions = {$data.resolutions};</script>
		<script type="text/javascript" src="modules/admin/modules/ecommerce/image_process/js/product.js"></script>
	
		<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly"/>
			<input type="hidden" name="productId" value="{$data.product.productId}" readonly="readonly"/>
			<div id="divFiles"></div>
			<a id="btnAddFile" href="javascript:void(0);">Daha fazla resim ekle</a>
			<button name="action" value="uploadPictures">{#BUTTON_Upload#}</button>
		</form>
		<hr/>
		<table id="imagesTable" style="border-spacing: 0px;">
			<tr bgcolor="#cccccc">
				<th style="width: 70px;">Vitrin Resmi</th>
				<th style="width: 170px; padding-left:20px;"></th>
				<th style="width: 50px;">
					{if $data.product.picture.iTotalRecords gt 1}
					<a onclick="if(confirm('{#ALERT_AreYouSureToDeleteAll#}')){ return true; } return false;" href="{$SCRIPT_NAME}?action=deletePictures&productId={$data.product.productId}">{#BUTTON_DeleteAll#}</a>
					{/if}
				</th>
				<th style="width:400px;">
					Küçük Resimler
				</th>
			</tr>
			{foreach from=$data.product.picture.aaData item="entry"}
			<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
				<td>
					<input style="margin-left:30px;" type="radio" name="isDefault" onclick="location.href='{$SCRIPT_NAME}?action=setDefaultPicture&productId={$data.product.productId}&pictureId={$entry.pictureId}';" {if $entry.pictureId eq $data.product.picture.defaultx.pictureId}checked="checked"{/if}/>
				</td>
				<td style="width: 170px; padding-left:20px;">
					<img src="img/product/2_{$entry.pictureFile}" />
				</td>
				<td style="text-align: center;">
					<a onclick="if(confirm('{#ALERT_AreYouSureToDelete#}')){ return true; } return false;" href="{$SCRIPT_NAME}?action=deletePicture&pictureId={$entry.pictureId}">{#BUTTON_Delete#}</a>
				</td>
				<td style="width:650px;">
					<div class="thumbsListOuter">
						<ul>
						</ul>
					</div>
					<span class="btnCropImage" base_image="img/product/{$entry.pictureFile}">Düzenle</span>
				</td>
			</tr>
			{foreachelse}
			<tr>
				<td colspan="2">{#ALERT_NoRecords#}</td>
			</tr>
			{/foreach}
		</table>
	</div>
	<div id="tabs-3">
		<form method="post" action="{$SCRIPT_NAME}">
		<ul class="ulform">
			<li class="dn">
				<label>productId</label>
				<input type="text" name="productId" value="{$data.product.productId}" readonly="readonly" required="required" />
			</li>
			<li>
				<label>Ürün Kodu</label>
				<input type="text" name="productattributeCode" required="required" />
			</li>
			{foreach from=$data.attributegroup.aaData item="attributegroup"}
			<li>
				<label>{$attributegroup.attributegroupTitle}: </label>
				<select name="attributeIds[]" required="required">
				<option value="">-----</option>
				{html_options options=$attributegroup.attribute.options}
				</select>
			</li>
			{/foreach}
			<li>
				<label>{#LABEL_Amount#}</label>
				<input type="text" name="productattributemovementQuantity" required="required" />
			</li>
			<li>
				<button type="submit" onclick="Productattribute.saveProductattribute(this.form);">{#BUTTON_Save#}</button>
			</li>
		</ul>
		</form>
		<div cas-js="getProductattributeByProductId" cas:var="{$data.product.productId}" cas:url="{$SCRIPT_NAME}"></div>
	</div>
	<div id="tabs-4">
		<form method="post" action="{$SCRIPT_NAME}">
		<ul class="ulform">
			<li class="dn">
				<label>productId</label>
				<input type="text" name="productId" value="{$data.product.productId}" readonly="readonly" required="required" />
			</li>
			<li class="dn2">
				<label>role</label>
				{html_options name=roleId options=$data.role.options}
			</li>
			<li>
				<label>{#LABEL_ListPrice#}</label>
				<input type="text" name="productPrice" autofocus="autofocus" required="required" onkeyup="calcProductPrice(this.form);" />
			</li>
			<li class="dn">
				<label>productimpactWeightRate</label>
				<input type="text" name="productimpactWeightRate" onkeyup="calcProductimpactWeight(this.form);" />
			</li>
			<li class="dn">
				<label>productimpactWeightPrice</label>
				<input type="text" name="productimpactWeightPrice" onkeyup="calcProductimpactWeight(this.form);" />
			</li>
			<li class="dn">
				<label>product price before tax</label>
				<input type="text" id="productPriceBeforeTax" onkeyup="calcProductPriceBeforeTax(this.form);" />
			</li>
			<li class="dn">
				<label>tax rate</label>
				<input type="text" id="taxonomyRate" value="{$data.product.taxonomyRate}" readonly="readonly" size="3"/>
			</li>
			<li class="dn">
				<label>product price after tax</label>
				<input type="text" id="productPriceAfterTax" onkeyup="calcProductPriceAfterTax(this.form);" />
			</li>
			<li>
				<label>{#LABEL_DiscountRate#}</label>
				<input type="text" name="productimpactDiscountRate" onkeyup="calcProductimpactDiscount(this.form);" />
			</li>
			<li>
				<label>{#LABEL_DiscountAmount#}</label>
				<input type="text" name="productimpactDiscountPrice" onkeyup="calcProductimpactDiscount(this.form);" />
			</li>
			<li>
				<label>{#LABEL_Price#}</label>
				<input type="text" id="productPriceAfterDiscount" readonly="readonly" />
			</li>
			<li>
				<button type="submit" onclick="Productimpact.saveProductimpact(this.form);">{#BUTTON_Save#}</button>
			</li>
			<li>
				<div cas-js="getProductimpactByProductId" cas:var="{$data.product.productId}" cas:url="{$SCRIPT_NAME}"></div>
			</li>
		</ul>
		</form>
		<script type="text/javascript">
		function calcProductPrice (form)
		{
			var productPrice = Number($("input[name=productPrice]").val());
			var productimpactWeightRate = Number($("input[name=productimpactWeightRate]").val());
			var productimpactWeightPrice = Number($("input[name=productimpactWeightPrice]").val());
			
			var productPriceBeforeTax = productPrice + productPrice * productimpactWeightRate + productimpactWeightPrice;
			$('#productPriceBeforeTax').val(productPriceBeforeTax);
			
			calcProductPriceBeforeTax (form);
		}
		function calcProductPriceBeforeTax (form)
		{
			var productPriceBeforeTax = Number($('#productPriceBeforeTax').val());
			var taxonomyRate = Number($('#taxonomyRate').val());
			
			var omitTaxonomyRate = true;
			var productPriceAfterTax = 0;
			if (omitTaxonomyRate) {
				productPriceAfterTax = productPriceBeforeTax;
			}
			else {
				productPriceAfterTax = productPriceBeforeTax + productPriceBeforeTax * taxonomyRate;
			}
			$('#productPriceAfterTax').val(productPriceAfterTax);
			
			calcProductPriceAfterTax (form);
		}
		function calcProductPriceAfterTax (form)
		{
			var productPriceAfterTax = Number($('#productPriceAfterTax').val());
			var productimpactDiscountRate = Number($("input[name=productimpactDiscountRate]").val());
			var productimpactDiscountPrice = Number($("input[name=productimpactDiscountPrice]").val());
			
			var productPriceAfterDiscount = productPriceAfterTax - productPriceAfterTax * productimpactDiscountRate - productimpactDiscountPrice;
			$('#productPriceAfterDiscount').val(productPriceAfterDiscount);
		}
		function calcProductimpactWeight(form)
		{
			var productPrice = Number($("input[name=productPrice]").val());
			var productimpactWeightRate = Number($("input[name=productimpactWeightRate]").val());
			var productimpactWeightPrice = Number($("input[name=productimpactWeightPrice]").val());
			
			var productPriceBeforeTax = productPrice + productPrice * productimpactWeightRate + productimpactWeightPrice;
			$('#productPriceBeforeTax').val(productPriceBeforeTax);
			
			calcProductPriceBeforeTax (form);
		}
		function calcProductimpactDiscount(form)
		{
			var productPriceAfterTax = Number($("#productPriceAfterTax").val());
			var productimpactDiscountRate = Number($("input[name=productimpactDiscountRate]").val());
			var productimpactDiscountPrice = Number($("input[name=productimpactDiscountPrice]").val());
			
			var productPriceAfterDiscount = productPriceAfterTax - productPriceAfterTax * productimpactDiscountRate - productimpactDiscountPrice;
			$('#productPriceAfterDiscount').val(productPriceAfterDiscount);
		}
		</script>
	</div>
	<div id="tabs-5">
		<form method="post" action="{$SCRIPT_NAME}">
		<ul class="ulform">
			<li class="dn">
				<label>productId</label>
				<input type="text" name="productId" value="{$data.product.productId}" readonly="readonly" required="required" />
			</li>
			<li>
				<label>özellik: </label>
				<!-- {html_options name=attributeId options=$data.attributegroup.optgroup} -->
				<select name="attributeId" required="required">
				<option value="">-----</option>
				{html_options options=$data.attributegroup.optgroup}
				</select>
			</li>
			<li>
				<label>attributeimpactWeightRate</label>
				<input type="text" name="attributeimpactWeightRate" />
			</li>
			<li>
				<label>attributeimpactWeightPrice</label>
				<input type="text" name="attributeimpactWeightPrice" />
			</li>
			<li>
				<label>attributeimpactDiscountRate</label>
				<input type="text" name="attributeimpactDiscountRate" />
			</li>
			<li>
				<label>attributeimpactDiscountPrice</label>
				<input type="text" name="attributeimpactDiscountPrice" />
			</li>
			<li>
				<button type="submit" onclick="Attributeimpact.saveAttributeimpact(this.form);">{#BUTTON_Save#}</button>
			</li>
		</ul>
		</form>
		<div cas-js="getAttributeimpactByProductId" cas:var="{$data.product.productId}" cas:url="{$SCRIPT_NAME}"></div>
	</div>
	{/if}
</div>

<script>
$(function() {
	
	$("form#formCategories a[action=delete]").click(function(){
		var productId = $(this).attr("id");
		var formData = [];
		formData.push({ name: "action", value: "ajaxDeleteProduct" });
		formData.push({ name: "productId", value: productId });
		$.post("{$SCRIPT_NAME}",
				formData,
				function(response, textStatus, xhr){
					alert("POST returned " + response + ", " + textStatus);
					window.location.replace("{$SCRIPT_NAME}");
				}
		);
	});
	
	/*
	$("form#formCategories input").keyup(function() {
		// Serialize standard form fields:
		var formData = $("form#formCategories").serializeArray();
		
		// then append Dynatree selected 'checkboxes':
		var tree = $("#categoryIds").dynatree("getTree");
		formData = formData.concat(tree.serializeArray());

		// and/or add the active node as 'radio button':
		if(tree.getActiveNode()){
			formData.push({ name: "activeNode", value: tree.getActiveNode().data.key });
		}
		formData.push({ name: "action", value: "ajaxSaveProduct" });
		
		console.log(formData);
		
		$.post("{$SCRIPT_NAME}",
				formData,
				function(response, textStatus, xhr){
					//alert("POST returned " + response + ", " + textStatus);
					//window.location.replace("{$SCRIPT_NAME}?action=edit&productId=" + response.productId);
					//CommonItems.casDialog("Tamamlandı");
				},
				"json"
		);
		
	});
	*/
	
	$("form#formCategories").submit(function() {
		// Serialize standard form fields:
		var formData = $(this).serializeArray();

		// then append Dynatree selected 'checkboxes':
		var tree = $("#categoryIds").dynatree("getTree");
		formData = formData.concat(tree.serializeArray());

		// and/or add the active node as 'radio button':
		if(tree.getActiveNode()){
			formData.push({ name: "activeNode", value: tree.getActiveNode().data.key });
		}
		formData.push({ name: "action", value: "ajaxSaveProduct" });

		//alert("POSTing this:\n" + jQuery.param(formData));

		$.post("{$SCRIPT_NAME}",
				formData,
				function(response, textStatus, xhr){
					//alert("POST returned " + response + ", " + textStatus);
					window.location.replace("{$SCRIPT_NAME}?action=edit&productId=" + response.productId);
				},
				"json"
		);
		return false;
	});

	if ($("select[name=categoryId] option").size() == 0) {
		$("#divCategoryDefault").html('<b>Lütfen en az bir kategori seçiniz</b>');
	}
	
	$("#categoryIds").dynatree({
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
			data: { action: "jsonCategories", productId: "{$data.product.productId}", mode: "funnyMode" }
		},
		// .. but here we use a local file instead:
		//initAjax: {
		//	url: "sample-data3.json"
		//},
		onClick: function(node, event) {
			// We should not toggle, if target was "checkbox", because this
			// would result in double-toggle (i.e. no toggle)
			if( node.getEventTargetType(event) == "title" ) {
				node.toggleSelect();
			}
		},
		onSelect: function(flag, node) {
			if( ! flag ) {
				$("select[name=categoryId] option[value='"+node.data.key+"']").remove();
			}
			var selectedNodes = node.tree.getSelectedNodes();
			if (selectedNodes.length == 0) {
				$("#divCategoryDefault").html('<b>Lütfen en az bir kategori seçin</b>');
			}
			else if (selectedNodes.length == 1) {
				$("#divCategoryDefault").html('');
				$('<select/>', {
					'id': '',
					'name': 'categoryId',
					'class': ''
					//'html': items.join('')
				}).appendTo("#divCategoryDefault");
			}
			var selectedKeys = $.map(selectedNodes, function(node){
				if ( $("select[name=categoryId] option[value='"+node.data.key+"']").length == 0 ) {
					$('<option value="'+node.data.key+'">'+node.data.title+'</option>').appendTo("select[name=categoryId]");
				}
				return node.data.key;
			});
		},
		onActivate: function(node) {
			//alert(node + " (" + node.getKeyPath()+ ")");
		},
		onLazyRead: function(node){
			// In real life we would call something like this:
			node.appendAjax({
				url: "{$SCRIPT_NAME}",
				data: {
					action: "jsonCategories",
					productId: "{$data.product.productId}",
					key: node.data.key,
					mode: "funnyMode"
				}
			});
			// .. but here we use a local file instead:
			//node.appendAjax({
			//	url: "sample-data2.json",
				// We don't want the next line in production code:
			//	debugLazyDelay: 750
			//});
		}
	});
	
	moreInput();
	
	$('#btnAddFile')
		.click(function() {
			moreInput();
		});

});

function moreInput() {
	$('#divFiles').append('<span class="db"><input type="file" name="pictureFile[]"/></span>');
}
</script>