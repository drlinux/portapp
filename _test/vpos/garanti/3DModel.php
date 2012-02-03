<html>
<head>
<title>3D</title>
<meta http-equiv="Content-Language" content="tr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="now">
</head>
<body>

<?php

$clientId	= "9258469";//Banka tarafindan verilen is yeri numarasi
$amount		= "9.95";//Islem tutari
$oid		= "";//Siparis numarasi

$okUrl		= "https://www.bedenozgurlugu.com/portapp/_test/vpos/garanti/3DModelOdeme.php";
$failUrl	= "https://www.bedenozgurlugu.com/portapp/_test/vpos/garanti/3DModelOdeme.php";

$rnd = microtime();

$storekey	= "Z1q2w3e4r";//is yeri ayiraci (is yeri anahtari)
$storetype	= "3d";

$hashstr = $clientId . $oid . $amount . $okUrl . $failUrl . $rnd  . $storekey;
$hash = base64_encode(pack('H*',sha1($hashstr)));

// ISTEGE BAGLI ALANLAR
$description	= "";//Açiklama
$xid			= "";//Islem takip numarasi 3D için XID i magaza üretirse o kullanir, yoksa sistem üretiyor. (3D secure islemleri için islem takip numarasi 20 bytelik bilgi 28 karaktere base64 olarak kodlanmali, geçersiz yada bos ise sistem tarafindan üretilir.)
$lang			= "";//gösterim dili bos ise Türkçe (tr), Ingilizce için (en)
$email			= "";//email adresi
$userid			= "";//Kullanici takibi için id

?>

<form method="post" action="https://ccpos.garanti.com.tr/servlet/gar3Dgate">
	<table>
	<tr>
		<td>Credit Card Number</td>
		<td><input type="text" name="pan" size="20"/>
	</tr>
	<tr>
		<td>CVV</td>
		<td><input type="text" name="cv2" size="4" value=""/></td>
	</tr>
	<tr>
		<td>Expiration Date Year</td>
		<td><input type="text" name="Ecom_Payment_Card_ExpDate_Year" value=""/></td>
	</tr>
	<tr>
		<td>Expiration Date Month</td>
		<td><input type="text" name="Ecom_Payment_Card_ExpDate_Month" value=""/></td>
	</tr>
	<tr>
		<td>Choosing Visa / Master Card</td>
		<td>
			<select name="cardType">
				<option value="1">Visa</option>
				<option value="2">MasterCard</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<input type="submit" value="Complete Payment"/>
		</td>
	</tr>
	</table>
	<input type="hidden" name="clientid" value="<?php  echo $clientId ?>">
	<input type="hidden" name="amount" value="<?php  echo $amount ?>">
	<input type="hidden" name="oid" value="<?php  echo $oid ?>">	
	<input type="hidden" name="okUrl" value="<?php  echo $okUrl ?>">
	<input type="hidden" name="failUrl" value="<?php  echo $failUrl ?>">
	<input type="hidden" name="rnd" value="<?php  echo $rnd ?>" >
	<input type="hidden" name="hash" value="<?php  echo $hash ?>" >
	<input type="hidden" name="storetype" value="3d" >		
	<input type="hidden" name="lang" value="tr">
	<input type="hidden" name="currency" value="949">
</form>

</body>
</html>