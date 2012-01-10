<?php

    /**
     * @package posnet oostest
     */
     
    //Include POSNETOOS Class
    require_once('posnet_util.php');
	require_once('posnettds_config.php');
    require_once('Posnet Modules/Posnet OOS/posnet_oos.php');
	
	////////////////////////////////////////////////////////////
	//PHP4 - PHP5 uyumluluk için eklenilmiþtir. 
	$POST;
	if ((floatval(phpversion()) >= 5) && ((ini_get('register_long_arrays') == '0') || (ini_get('register_long_arrays') == '')))
	{
	  $POST =& $_POST;
	} 
	else 
	{
	  $POST =& $HTTP_POST_VARS;
	}
    ////////////////////////////////////////////////////////////	

    $merchantPacket = $POST['MerchantPacket'];
    $bankPacket = $POST['BankPacket'];
    $sign = $POST['Sign'];
	$tranType = $POST['TranType'];

    $posnetOOS = new PosnetOOS();

    //$posnetOOS->SetDebugLevel(1);
        
    $posnetOOS->SetMid(MID);
    $posnetOOS->SetTid(TID);

    //XML Servisi için (MCrypt Library 'si kullanýlamadýðý zaman gerekli)
    $posnetOOS->SetURL(XML_SERVICE_URL);
    $posnetOOS->SetKey(ENCKEY);
        	
    if($HTTP_GET_VARS['cctran'] == "1")
    {
        if (array_key_exists("WPAmount", $POST)) {
            $WPAmount = convertYTLToYKR($POST['WPAmount']);
			$posnetOOS->SetPointAmount($WPAmount);
    	}
	
		$tempXid = $POST['XID'];
    	$tempAmount = $POST['Amount'];
    	$tempCurrency = $POST['Currency'];
    
        echo("<html>");
        echo("<head>");
        echo("<META HTTP-EQUIV=\"Content-Type\" content=\"text/html; charset=Windows-1254\">");

        echo("<script language=\"JavaScript\">");

        echo("function submitForm(form) {");
        echo("	 form.submit();");
        echo("}");

        echo("</script>");

        echo("<title>YKB - POSNET Redirector</title></head>");
        echo("<body bgcolor=\"#02014E\" OnLoad=\"submitForm(document.form2);\" >");
        
        if(!$posnetOOS->ConnectAndDoTDSTransaction($merchantPacket,
            $bankPacket,
            $sign
         ))
        {
            //echo("Ýþlem gerçekleþtirilemedi.<br>");
            //echo("Hata : ".$posnetOOS->GetLastErrorMessage());
        }
        
        echo(" <form name=\"form2\" method=\"post\" action=\"".MERCHANT_RETURN_URL."\" >");
        
		echo("   <input type=\"hidden\" name=\"XID\" value=\"".$tempXid."\">");
    	echo("   <input type=\"hidden\" name=\"Amount\" value=\"".$tempAmount."\">");
    	echo("   <input type=\"hidden\" name=\"WPAmount\" value=\"".$WPAmount."\">");
    	echo("   <input type=\"hidden\" name=\"Currency\" value=\"".$tempCurrency."\">");
    
    	echo("   <input type=\"hidden\" name=\"ApprovedCode\" value=\"".$posnetOOS->GetApprovedCode()."\">");
        echo("   <input type=\"hidden\" name=\"AuthCode\" value=\"".$posnetOOS->GetAuthcode()."\">");
        echo("   <input type=\"hidden\" name=\"HostLogKey\" value=\"".$posnetOOS->GetHostlogkey()."\">");
        echo("   <input type=\"hidden\" name=\"RespCode\" value=\"".$posnetOOS->GetResponseCode()."\">");
        echo("   <input type=\"hidden\" name=\"RespText\" value=\"".$posnetOOS->GetResponseText()."\">");
        
		echo("   <input type=\"hidden\" name=\"Point\" value=\"".$posnetOOS->GetPoint()."\">");
        echo("   <input type=\"hidden\" name=\"PointAmount\" value=\"".$posnetOOS->GetPointAmount()."\">");
        echo("   <input type=\"hidden\" name=\"TotalPoint\" value=\"".$posnetOOS->GetTotalPoint()."\">");
        echo("   <input type=\"hidden\" name=\"TotalPointAmount\" value=\"".$posnetOOS->GetTotalPointAmount()."\">");
        
		echo("   <input type=\"hidden\" name=\"InstallmentNumber\" value=\"".$posnetOOS->GetInstalmentNumber()."\">");
        echo("   <input type=\"hidden\" name=\"InstallmentAmount\" value=\"".$posnetOOS->GetInstalmentAmount()."\">");
        
		echo("   <input type=\"hidden\" name=\"VftAmount\" value=\"".$posnetOOS->GetVftAmount()."\">");
        echo("   <input type=\"hidden\" name=\"VftDayCount\" value=\"".$posnetOOS->GetVftDayCount()."\">");
        echo(" </form>");
        echo(" </body>");
        echo(" </html>");
		return;
    }
	else
	{
    	if(!$posnetOOS->CheckAndResolveMerchantData($merchantPacket,
            $bankPacket,
            $sign
             ))
        {
            echo("Merchant Datasý çözümlenemedi.<br>");
            echo("Hata : ".$posnetOOS->GetLastErrorMessage());
        }
    	else
		{
    		if($posnetOOS->GetTotalPoint() == "-1") {
				$formatedTotalPoint = "";
				$formatedTotalPointAmount = "";
			}
			else {
				$formatedTotalPoint = $posnetOOS->GetTotalPoint();
				if(strlen($formatedTotalPoint) > 0)
					$formatedTotalPoint = (int)$formatedTotalPoint;
				$formatedTotalPointAmount = currencyFormat($posnetOOS->GetTotalPointAmount(), $posnetOOS->GetCurrency(), true);
			}
		}
		
		$ykrAvailablePointAmount = (int)$posnetOOS->GetTotalPointAmount();
		$ykrTranAmount = (int)$posnetOOS->GetAmount();
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
<META http-equiv="Content-Style-Type" content="text/css">
<META http-equiv="expires" CONTENT="0">
<META http-equiv="cache-control" CONTENT="no-cache">
<META http-equiv="Pragma" CONTENT="no-cache">
<SCRIPT language="JavaScript" src="scripts/util.js"></script>
<SCRIPT language="JavaScript" type="text/JavaScript">
<!--
function giris(){
    findandfocus("WPAmount");
}

function tutarKarsilastirma(pamount, tpamount, amount){
    
    ykr_pamount = parseFloat(pamount);
    ykr_tpamount = parseFloat(tpamount);
    ykr_amount = parseFloat(amount);
    
	if(ykr_pamount > ykr_amount) {
        alert("Kullanýlmak istenen Puan tutarý, Ýþlem tutarýndan büyük olamaz!");
        return false;
    }
    
	//Puan sorgulama yapýlamadý (tpamount == -1) ise sadece iþlem tutarý ile karþýlaþtýrma yapýlsýn
    if(tpamount != -1 && ykr_pamount > ykr_tpamount) {
        alert("Kullanýlmak istenen Puan tutarý, Kullanýlabilir Puan tutarýndan büyük olamaz!");
        return false;
    }
    
    return true;
}

function formKontrol(){
	
	<?php if($tranType != null && $tranType == "SaleWP") { ?>
		var puanTutariObj = findObj("WPAmount");
		if(puanTutariObj == null)
			return false;
		
		if(puanTutariObj.disabled)
			return true;
				 
		if(tutarKontrol("WPAmount"))
		{
			return tutarKarsilastirma(ykr(puanTutariObj.value), 
						<? echo($ykrAvailablePointAmount); ?>, 
						<? echo($ykrTranAmount); ?>);
		}
		else 
			return false;
	<? } else { ?>
		return true;
	<? } ?>
}

//-->
</SCRIPT>
<TITLE>YKB Posnet 3D-Secure Ýþlem Onay Sayfasý</TITLE>
<LINK href="css/global.css" rel="stylesheet" type="text/css" />
<LINK href="css/globalsubpage.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</HEAD>
<BODY onload="giris()">
<FORM name="formResp" method="post" action="posnettds_resp.php?cctran=1" onsubmit="return formKontrol();">

<INPUT name="MerchantPacket" type="hidden" value="<? echo($merchantPacket); ?>">
<INPUT name="BankPacket" type="hidden" value="<? echo($bankPacket); ?>">
<INPUT name="Sign" type="hidden" value="<? echo($sign); ?>">

<INPUT name="XID" type="hidden" value="<? echo($posnetOOS->GetXid()); ?>">
<INPUT name="Amount" type="hidden" value="<? echo($posnetOOS->GetAmount()); ?>">
<INPUT name="Currency" type="hidden" value="<? echo($posnetOOS->GetCurrency()); ?>">
<BR>      
<BR>      
<BR>      
<CENTER>
    <TABLE width="599" border="0" cellpadding="0" cellspacing="0">
      <TBODY>
        <TR> 
          <TD width="172" height="59" align="center" valign="middle" background="images/top_left.gif"> 
            <p>&nbsp;</p></TD>
          <TD width="255" align="center" valign="middle" background="images/top_middle.gif">&nbsp;</TD>
          <TD width="167" align="center" valign="middle" background="images/top_right.gif">&nbsp;</TD>
          <TD width="5" align="center" valign="middle">&nbsp;</TD>
        </TR>
        <TR> 
          <td height="83" colspan="3" align="center" valign="middle" background="images/middle.gif"> 
            <h4> 
              <?php if($HTTP_GET_VARS['cctran'] == null) { 
			  	if(threeDSecureCheck($posnetOOS->GetTDSMDStatus())) { 
			  ?>
              YKB Posnet <span class="style1">3D-Secure</span>  sisteminde, Kredi Kartý 'nýzýn doðrulamasý yapýlmýþtýr. Ýþlemi onlayýp, Kredi Kartý çekiminin yapýlmasý için 
              lütfen aþaðýdaki linke týklayýnýz. <BR>
              <?php } else { ?>
              <font color="#FF0000">3D-Secure</font> doðrulamasý yapýlamadýðý 
              için iþleminize devam edilememektedir. Lütfen Kredi Kartý bilgilerinizi 
              kontrol ediniz. <BR>
              <?php } } ?>
            </h4></td>
          <td width="5" height="6" align="center" valign="middle">&nbsp;</td>
        </TR>
        <TR> 
          <td height="90" colspan="3" align="center" valign="middle" background="images/middle.gif"> 
<table width="260" height="48" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="90" height="25"><h5>Sipariþ No : </h5></td>
                <td width="169" height="25"><h5>&nbsp;<? echo($posnetOOS->GetXid());?></h5></td>
              </tr>
              <tr> 
                <td width="90" height="25"> <h5>Tutar : <br>
                  </h5></td>
                <td width="169" height="25"><h5>&nbsp;<? echo currencyFormat($posnetOOS->GetAmount(), $posnetOOS->GetCurrency(), true); ?></h5></td>
              </tr>
              <tr> 
                <td width="90" height="25"><h5>Hata Mesajý : </h5></td>
                <td width="169" height="25"><h5>&nbsp;<? echo($posnetOOS->GetLastErrorMessage());?></h5></td>
              </tr>
            </table>
          </td>
          <td width="5" height="6" align="center" valign="middle">&nbsp;</td>
        </TR>
        <?php if($tranType != null && $tranType == "SaleWP") { ?>
        <TR> 
          <td colspan="3" align="center" valign="top" background="images/middle.gif"> 
<table width="64%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center" valign="middle"> <fieldset
					style="border: 1px solid #000000;">
                  <legend><font
					style="font-size:12px; color:#ff0000"> <B><font
					face="Arial, Helvetica, sans-serif">Puan Bilgileri</font></B></font> 
                  </legend>
                  <table width="348" height="79" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="224" height="30"> <h5>Kullanýlabilir Toplam Puan 
                          : </h5></td>
                      <td width="124" height="30"> <h5>&nbsp;<? echo($formatedTotalPoint); ?></h5></td>
                    </tr>
                    <tr> 
                      <td width="224" height="30"> <h5> Kullanýlabilir Toplam 
                          Puan Tutarý : <br>
                        </h5></td>
                      <td width="124" height="30"> <h5>&nbsp;<? echo($formatedTotalPointAmount); ?></h5></td>
                    </tr>
                    <tr> 
                      <td height="30"> <h5>Kullanýlmak istenen Puan Tutarý : </h5></td>
                      <td height="30"> <h5>
                          <INPUT NAME="WPAmount" TYPE="text" ID="WPAmount" SIZE="8" MAXLENGTH="10" class="kutuTutar" onkeypress="return tutarKutuBicimle(this, event);" onkeydown="return tutarKutuBicimleSilme(this, event);" VALUE="" <? if($ykrAvailablePointAmount == 0) { ?> DISABLED <? } ?>>
                          <? echo(getCurrencyText($posnetOOS->GetCurrency())); ?> </h5></td>
                    </tr>
                  </table>
                 </fieldset>
				 </td>
              </tr>
            </table>
          </td>
          <td width="5" height="105" align="center" valign="middle">&nbsp;</td>
        </TR>
        <?php } ?>
        <?php if($posnetOOS->GetTDSMDStatus() != null && $posnetOOS->GetTDSMDStatus() != "9") {?>
        <TR> 
          <td height="135" colspan="3" align="center" valign="middle" background="images/middle.gif"> 
            <table width="64%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center" valign="middle"> <fieldset
					style="border: 1px solid #000000;">
                  <legend><font
					style="font-size:12px; color:#ff0000"> <B><font
					face="Arial, Helvetica, sans-serif">3D-Secure Bilgileri</font></B></font> 
                  </legend>
                  <table width="348" height="48" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="100" height="25"><h5><strong>Onay Statüsü : </strong></h5></td>
                      <td width="248" height="25"><h5>&nbsp;<? echo($posnetOOS->GetTDSMDStatus());?></h5></td>
                    </tr>
                    <tr> 
                      <td width="100" height="25"> <h5><strong> Hata Kodu :</strong> 
                          <br>
                        </h5></td>
                      <td width="248" height="25"><h5>&nbsp;<? echo($posnetOOS->GetTDSTXStatus());?></h5></td>
                    </tr>
                    <tr> 
                      <td width="100" height="25"><h5><strong>Hata Mesajý :</strong></h5></td>
                      <td width="248" height="25"><h5>&nbsp;<? echo($posnetOOS->GetTDSMDErrorMessage());?></h5></td>
                    </tr>
                  </table>
                  </fieldset></td>
              </tr>
            </table></td>
          <td width="5" height="135" align="center" valign="middle">&nbsp;</td>
        </TR>
        <?php } ?>
        <TR> 
          <td height="38" colspan="3" align="center" valign="bottom" background="images/middle.gif"> 
            <?php if(threeDSecureCheck($posnetOOS->GetTDSMDStatus())) { ?>
			<input 
				name="imageField" type="image"
				src="images/button_onayla.gif" width="67" height="20" border="0" id="Onayla"
				onClick="if(formKontrol()) { document.formResp.submit();this.disabled=true;}"
			>&nbsp;
			<?php } ?>
            <a href="<?php echo(MERCHANT_INIT_URL);?>">
			<img src="images/button_iptal.gif" width="67" height="20" border="0"/>
			</a> 
		  </td>
          <td width="5" height="38" align="center" valign="middle">&nbsp;</td>
        </TR>
        <TR> 
          <td height="43" align="center" valign="middle" background="images/bottom_left.gif">&nbsp;</td>
          <td height="43" align="center" valign="middle" background="images/bottom_middle.gif">&nbsp;</td>
          <td height="43" align="center" valign="middle" background="images/bottom_right.gif">&nbsp;</td>
          <td width="5" height="43" align="center" valign="middle">&nbsp;</td>
        </TR>
        <TR> 
          <TD height="35" colspan="3" align="center" valign="middle"><img src="images/ykblogo.gif" width="115" height="17"></TD>
          <TD width="5" align="center" valign="middle">&nbsp;</TD>
        </TR>
      </TBODY>
    </TABLE>
</CENTER>
</FORM>
</BODY>
</HTML>