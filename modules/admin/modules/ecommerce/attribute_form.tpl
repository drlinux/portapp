<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Özellik</a></li>
		{if $data.attribute.attributeId neq null}
		<li><a href="#tabs-2">...</a></li>
		{/if}
	</ul>
	<div id="tabs-1">
		<form action="{$SCRIPT_NAME}" method="post">
		<table>
			<tr class="dn">
				<td>attributeId</td>
				<td>
					<input type="text" name="attributeId" value="{$data.attribute.attributeId}" readonly="readonly" />
				</td>
			</tr>
			<tr class="dn">
				<td>attributegroupId</td>
				<td>
					<input type="text" name="attributegroupId" value="{$data.attributegroup.attributegroupId}" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>Özellik</td>
				<td>{$data.attributegroup.attributegroupTitle}</td>
			</tr>
			{if $data.attributegroup.isColorgroup neq null}
			<tr>
				<td>Renk değeri</td>
				<td>
					<input type="text" name="color" value="{$data.attribute.color}" />
				</td>
			</tr>
			{/if}
			<tr>
				<td class="vat">{#LABEL_Title#}</td>
				<td>
					{foreach from=$data.i18n item="entry"}
					<div>{$entry.iso639.iso639Title}</div>
					<input type="text" name="attributeTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.attributeTitle}"/>
					{/foreach}
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="buttonset">
						<button name="action" value="saveAttribute">{#BUTTON_Save#}</button>
						{if $data.attribute.attributeId neq null}
						<button name="action" value="deleteAttribute">{#BUTTON_Delete#}</button>
						{/if}
					</span>
				</td>
			</tr>
		</table>
		</form>
	</div>
	{if $data.attribute.attributeId neq null}
	<div id="tabs-2">
	</div>
	{/if}
</div>