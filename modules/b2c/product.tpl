<script type="text/javascript">
function mycarousel_itemLoadCallback(carousel, state)
{
    // Check if the requested items already exist
    if (carousel.has(carousel.first, carousel.last)) {
        return;
    }
    
    $.getJSON(
        'modules/b2c/product.php',
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
		<form name="productForm" cas-js="formBasket" autocomplete="off" method="post" action="modules/b2c/sales.php">
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
				<li id="liProductattributebasketQuantity">
					<label>{#LABEL_Quantity#}:</label>
					<input id="productattributebasketQuantity" type="text" name="productattributebasketQuantity" value="1" onkeyup="Productattribute.checkProductattribute();" />
				</li>
				<li>
					<button type="submit" onclick="Productattribute.updateProductattributebasket(this.form);">Sepete Ekle</button>
				</li>
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
			<li><a href="#tabs-4">Yorumlar</a></li>
		</ul>
		<div id="tabs-1">
			{$data.productContent}
		</div>
		<div id="tabs-2">
			{if $data.productVideo neq null}
			<!-- https://www.youtube.com/embed/7765e0QcF88?rel=0 -->
			<iframe width="640" height="360" src="{$data.productVideo}" frameborder="0" allowfullscreen></iframe>
			{/if}
		</div>
		<div id="tabs-3">
			<div id="paymentOptionsOuter"></div>
		</div>
		<div id="tabs-4">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1&appId=294608807247890";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
					
			<div class="fb-comments" data-href="https://www.bedenozgurlugu.com{$data.request_url}" data-num-posts="10" data-width="630"></div>
		</div>
	</div>
</div>
<div class="casContent">
	<h3 class="subHeader">BENZER ÜRÜNLER</h3>
	<ul class="productsList bigProductList" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}" cas-js="getProductsSimilar" cas:var="{$data.category.defaultx.categoryId}" cas:url="modules/b2c/index.php" >
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2c/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/2_%s">
			</a>
			<a class="productName" href="modules/b2c/product.php?action=show&productId=%s">%s</a>
			<div class="costsOuter">
				<span class="oldCost">
					%s<span class="scratch"></span>
				</span>
				<span class="currentCost">%s</span>											
			</div>
		</li>
	</ul>
</div>