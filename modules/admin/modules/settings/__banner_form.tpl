<script type="text/javascript">
jQuery(function($){
	// Create variables (in this scope) to hold the API and image size
	var jcrop_api, boundx, boundy;

	$('#target').Jcrop({
		onChange	: updatePreview,
		onSelect	: updatePreview,
		aspectRatio	: 1
	},function(){
		// Use the API to get the real image size
		var bounds = this.getBounds();
		boundx = bounds[0];
		boundy = bounds[1];
		// Store the API in the jcrop_api variable
		jcrop_api = this;
	});

	function updatePreview(c)
	{
		if (parseInt(c.w) > 0)
		{
			var rx = 100 / c.w;
			var ry = 100 / c.h;

			$('#preview').css({
				width		: Math.round(rx * boundx) + 'px',
				height		: Math.round(ry * boundy) + 'px',
				marginLeft	: '-' + Math.round(rx * c.x) + 'px',
				marginTop	: '-' + Math.round(ry * c.y) + 'px'
			});
		}
		
		jQuery('#x').val(c.x);
		jQuery('#y').val(c.y);
		jQuery('#w').val(c.w);
		jQuery('#h').val(c.h);

	};

});
</script>

<table>
	<tr>
		<td>
			<img src="img/banner/pool.jpg" id="target" alt="Flowers" />
		</td>
		<td>
			<div style="width:100px;height:100px;overflow:hidden;">
				<img src="img/banner/pool.jpg" id="preview" alt="Preview" />
			</div>
		</td>
	</tr>
</table>

<!-- This is the form that our event handler fills -->
<div class="jc_coords">
<form action="{$SCRIPT_NAME}" method="post">
	<input type="hidden" id="x" name="x" />
	<input type="hidden" id="y" name="y" />
	<input type="hidden" id="w" name="w" />
	<input type="hidden" id="h" name="h" />
	<input type="hidden" name="action" value="crop" />
	<button type="submit">Crop Image</button>
</form>
</div>
