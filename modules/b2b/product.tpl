<script type="text/javascript">
function mycarousel_itemLoadCallback(carousel, state)
{
    // Check if the requested items already exist
    if (carousel.has(carousel.first, carousel.last)) {
        return;
    }
    
    $.getJSON(
        'modules/b2b/product.php',
        {
        	action: "jsonProduct",
        	productId: "{$data.productId}",
            first: carousel.first,
            last: carousel.last
        },
        function(response) {
            mycarousel_itemAddCallback(carousel, carousel.first, carousel.last, response);
        }
    );
};

function mycarousel_itemAddCallback(carousel, first, last, response)
{
    carousel.size(parseInt(response.picture.iTotalRecords));
    
    $.each(response.picture.aaData, function(key, val) {
    	carousel.add(first + key, mycarousel_getItemHTML(val.pictureFile));
    });
};

function mycarousel_getItemHTML(url)
{
	return $('<a/>', {
		'href': 'img/product/' + url,
		'title': '{$data.productTitle}',
		'html': '<img src="img/product/1_' + url + '" width="50" height="50" />'
	}).fancybox({
		onComplete: function() {
			$("#fancybox-img").finezoom({
				zoomIn: "assets/plugins/finezoom/zoom_in.png",
				zoomOut: "assets/plugins/finezoom/zoom_out.png",
				reset: "assets/plugins/finezoom/zoom_reset.png",
				toolbar: true,
				toolbarPos: [ "left", "top" ]
			});
		}
	});
};

$(function() {
	$('#productMiniImagesListOuter').jcarousel({
        // itemVisibleOutCallback: { onAfterAnimation: function(carousel, item, i, state, evt) { carousel.remove(i); } },
        itemLoadCallback: mycarousel_itemLoadCallback
	});
	
	$('.spinnerhide')
	.spinner({
		//showOn: 'both',
		//max: 100,
		min: 1
	})
	.change(function() {
		//Productattribute.checkProductattribute();
		return false;
	});

});

</script>

<div id="productDetailOuter" class="casContent">
	<h1 class="subHeader">{$data.productTitle}</h1>
	<div id="productPictureFilesOuter" class="fl margin_right_10px">
		<a id="productBigImageOuter" class="jqzoom" href="img/product/{$data.pictureFile}" title="{$data.productTitle}">
			<img src="img/product/3_{$data.pictureFile}" />
		</a>
		<div id="productMiniImagesListOuter" class="cb jcarousel-skin-black">
			<ul>
			</ul>
		</div>
	</div>
	<div id="productInfoOuter" class="fl">
		<p style="float:left;">
			<span class="productattributePrice">
				Fiyatı: <span id="productDetailInfoOuterPrice"></span>
			</span>
			<br>
			Stok Durumu: <span id="productDetailInfoOuterQuantity"></span>
			<br>
			<br>
		</p>
		<form name="productForm" cas-js="formBasket" autocomplete="off" method="post" action="modules/b2b/sales.php">
			<ul id="productInfoSelectList" class="ulFormBasket productInfoList">
				<li>
					<p class="productTitle">Ürün Adı: {$data.productTitle}</p>
				</li>
				<li>
					<p class="productCode">Ürün Kodu: {$data.productCode}</p>
				</li>
				<li class="dn">
					<label>productId:</label>
					<input type="text" name="productId" value="{$data.productId}" readonly="readonly"/>
				</li>
				<li class="dn">
					<label>productattributeId:</label>
					<input type="text" id="productattributeId" name="productattributeId" readonly="readonly"/>
				</li>
				<!--<li id="liProductDetailInfoOuterPrice">
					<label>Fiyatı: </label>
					<span id="productDetailInfoOuterPrice"></span>
				</li>
				<li id="liProductDetailInfoOuterQuantity">
					<label>Stok Durumu: </label>
					<span id="productDetailInfoOuterQuantity"></span>
				</li>-->
				{foreach from=$data.attributegroups item="entry"}
				<li>
					<label>{$entry.attributegroupTitle}: </label>
					<select name="attributeIds[]" onchange="Productattribute.checkProductattribute();">
					{html_options options=$entry.attributes.options selected=$entry.attributes.selected}
					</select>
				</li>
				{/foreach}
				<li class="productattributeQuantity">
					<label>{#LABEL_Quantity#}:</label>
					<input id="productattributebasketQuantity" type="text" class="spinnerhide" name="productattributebasketQuantity" value="1" readonly="readonly" />
				</li>
				<li>
					<button type="submit" onclick="Productattribute.updateProductattributebasket(this.form);">Sepete Ekle</button>
				</li>
				<li></li>
				<!--
				<li class="buttonSocial facebook">
					<div class="fb-like" data-href="http://URL.com" data-send="false" data-layout="button_count"  data-width="" data-show-faces="false"></div>
				</li>
				<li class="buttonSocial twitter">
					<a href="https://twitter.com/share" class="twitter-share-button" data-via="twitterapi" data-lang="en">Tweet</a>
				</li>
				<li class="buttonSocial gplus">
					<g:plusone size="medium"></g:plusone>
				</li>-->
				<li class="buttonWishlist">
					<a href="#"></a>
				</li>
				<!--<li class="buttonCompare"></li>
				<li>
					<a href="modules/b2b/productcompare.php">Karşılaştırma Listesi</a>
				</li>-->
			</ul>
		</form>
	</div>
	<div id="productTabMenuOuter" class="tabs cb">
		<ul>
			<li><a href="#tabs-1">Ürün Özellikleri</a></li>
			{if $data.productVideo neq null}
			<li><a href="#tabs-2">Ürün Videosu</a></li>
			{/if}
			<li><a href="#tabs-3">Taksit Seçenekleri</a></li>
			<!--<li><a href="#tabs-4">Yorumlar</a></li>-->
		</ul>
		<div id="tabs-1">
			{$data.productContent}
		</div>
		<div id="tabs-2">
			{if $data.productVideo neq null}
			{$data.productVideo}
			{/if}
		</div>
		<div id="tabs-3">
			<div id="paymentPeriodTable"></div>
		</div>
		<!--<div id="tabs-4">
			<div id="fb-root"></div>
			<div class="fb-comments" data-href="{$project.uri}" data-num-posts="10" data-width="630"></div>
		</div>-->
	</div>
</div>
<div class="casContent">
	<h3 class="subHeader">BENZER ÜRÜNLER</h3>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2B_NUMBEROFPRODUCTSDISPLAYED}">
		{$data.product_list}
	</ul>
</div>