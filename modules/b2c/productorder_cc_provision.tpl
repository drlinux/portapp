<div class="casContent">
	<h1 class="subHeader">3D-Secure İşlemi</h1>

	<script language="JavaScript" src="https://www.posnet.ykb.com/3DSWebService/scriptler/posnet.js"></script>
	<script>
	$(function() {
		var Form = $("[name=formName]");
		submitForm(Form.get(0), 0, 'YKBWindow');
		Form.submit();
	});
	function submitFormEx(Form, OpenNewWindowFlag, WindowName) {
		submitForm(Form, OpenNewWindowFlag, WindowName)
		Form.submit();
	}
	</script>
	
	<p>YKB Posnet 3D-Secure sistemine yönlendiriliyorsunuz.</p>
	<form name="formName" method="post" action="{$data.OOS_TDS_SERVICE_URL}" target="YKBWindow">
	<!--
	<p>YKB Posnet 3D-Secure sistemine yönlenmek için lütfen aşağıdaki linke tıklayınız.</p>
	<A onclick="submitFormEx(formName, 0, 'YKBWindow')" href="javascript:formName.submit()" ><FONT face="Geneva, Arial, Helvetica, sans-serif" size=3><STRONG>Ödeme Yap</STRONG></FONT></A>
	<input type="submit" name="Submit" value="Ödeme Yap" onclick="submitFormEx(formName, 0, 'YKBWindow')">
	-->
	<input name="mid" type="hidden" id="mid" value="{$data.mid}">
	<input name="posnetID" type="hidden" id="PosnetID" value="{$data.posnetid}">
	<input name="posnetData" type="hidden" id="posnetData" value="{$data.posnetData}">
	<input name="posnetData2" type="hidden" id="posnetData2" value="{$data.posnetData2}">
	<input name="digest" type="hidden" id="sign" value="{$data.digest}">
	<input name="vftCode" type="hidden" id="vftCode" value="{$data.vftCode}">
	
	<!-- <input name="useJokerVadaa" type="hidden" id="useJokerVadaa" value="1"> --> <!-- Opsiyonel -->
	<!-- <input name="merchantReturnURL" type="hidden" id=" merchantReturnURL" value="http://www.uyeisyeri.com/kk_provizyon.php"> --> <!-- Opsiyonel -->
	<input name="merchantReturnURL" type="hidden" id=" merchantReturnURL" value="{$data.merchantReturnURL}">
	
	<!-- Static Parameter -->
	<input name="lang" type="hidden" id="lang" value="tr">
	<input name="url" type="hidden" id="url" value="">
	<input name="openANewWindow" type="hidden" id="openANewWindow">
	</form>
	
</div>