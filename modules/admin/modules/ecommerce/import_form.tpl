<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table>
<caption>
	<a href="modules/nebim/backup/Row.xml" target="_blank">Örnek XML dosyasını indirin</a>
</caption>
<tbody>
	<tr>
		<td>{#LABEL_XmlFile#}</td>
		<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
			<input type="file" name="xmlFile" />
		</td>
	</tr>
</tbody>
<tfoot>
	<tr>
		<th></th>
		<td>
			<span class="buttonset">
				<button name="action" value="import">{#BUTTON_Import#}</button>
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>