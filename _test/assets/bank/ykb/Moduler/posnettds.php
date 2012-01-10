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
    
    //Üye iþyeri Bilgileri
    $mid = MID;
    $tid = TID;
    $posnetid = POSNETID;
    $ykbOOSURL = OOS_TDS_SERVICE_URL;
    $xmlServiceURL = XML_SERVICE_URL;
    $openANewWindow = OPEN_NEW_WINDOW;   
    $posnetoosresp_return_url = curPageURL();
    $posnetoosresp_return_url = str_replace(".php", "_resp.php", $posnetoosresp_return_url);
            
    //Ýþlem Bilgileri
    /*
    Bu bilgiler bir önceki sayfadan alýnmaktadýr.Ancak bu bilgilerin
    session'dan alýnmasý sistemin daha güvenli olmasýný saðlýyacaktýr.
    */
    $xid = $POST['XID'];
    $instnumber = $POST['instalment'];
    $amount = $POST['amount'];
    $currencycode = $POST['currency'];
    $custName = $POST['custName'];
    $trantype = $POST['tranType'];
    $vftCode = $POST['vftCode'];
	
	$ccno = $POST['ccno'];
    $expdate = $POST['expdate'];
    $cvc = $POST['cvv'];


    //Eðer ki kredi kartý bilgileri üye iþyeri sayfasýnda alýnacak ise
    if(array_key_exists("ccno", $POST))
        $ccdataisexist = true;
    else
        $ccdataisexist = false;

    $posnetOOS = new PosnetOOS;
    //$posnetOOS->SetDebugLevel(1);

    $posnetOOS->SetPosnetID($posnetid);
    $posnetOOS->SetMid($mid);
    $posnetOOS->SetTid($tid);

    //XML Servisi için
    $posnetOOS->SetURL($xmlServiceURL);
    
    if($ccdataisexist)
    {
        //Eðer ki kredi kartý bilgileri üye iþyeri sayfasýnda alýnacak ise
        if(!$posnetOOS->CreateTranRequestDatas($custName,
                                        $amount,
                                        $currencycode,
                                        $instnumber,
                                        $xid,
                                        $trantype,
                                        $ccno,
                                        $expdate,
                                        $cvc
                                        ))
        {
            echo("<html>");
            echo("PosnetData'lari olusturulamadi.<br>".
                        "Data1 = ".$posnetOOS->GetData1()."<br>".
                        "Data2 = ".$posnetOOS->GetData2()."<br>".
                        "XML Response Data = ".$posnetOOS->GetResponseXMLData()
                );
            echo("Error Code : ".$posnetOOS->GetResponseCode());
            echo("<br>");
            echo("Error Text : ".$posnetOOS->GetResponseText());
            echo("</html>");
            return;
        }
    }
    else
    {
        //Kart Bilgilerinin OOS sisteminde girilmesi isteniyor ise
        if(!$posnetOOS->CreateTranRequestDatas($custName,
                                        $amount,
                                        $currencycode,
                                        $instnumber,
                                        $xid,
                                        $trantype
                                        ))
        {
            echo("<html>");
            echo("PosnetData'lari olusturulamadi.<br>".
                       "Data1 = ".$posnetOOS->GetData1()."<br>".
                       "Data2 = ".$posnetOOS->GetData2()."<br>".
                       "XML Response Data = ".$posnetOOS->GetResponseXMLData()
                );
            echo("Error Code : ".$posnetOOS->GetResponseCode());
            echo("<br>");
            echo("Error Text : ".$posnetOOS->GetResponseText());
            echo("</html>");
            return;
        }
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
<TITLE>
YKB Posnet 3D-Secure Yönlendirme Sayfasý
</TITLE>
<LINK href="css/global.css" rel="stylesheet" type="text/css" />
<LINK href="css/globalsubpage.css" rel="stylesheet" type="text/css" />
<SCRIPT language="JavaScript" src="scripts/posnet.js"></script>
<SCRIPT language="JavaScript" type="text/JavaScript">
function submitFormEx(Form, OpenNewWindowFlag, WindowName) {
    	submitForm(Form, OpenNewWindowFlag, WindowName)
    	Form.submit();
}
</SCRIPT>
</HEAD>
<BODY>
<FORM name="formName" method="post" action="<? echo $ykbOOSURL; ?>" target="YKBWindow">

<INPUT name="posnetData" type="hidden" id="posnetData" value="<? echo $posnetOOS->GetData1(); ?>">
<INPUT name="posnetData2" type="hidden" id="posnetData2" value="<? echo $posnetOOS->GetData2(); ?>">
<INPUT name="digest" type="hidden" id="sign" value="<? echo $posnetOOS->GetSign(); ?>">
<INPUT name="mid" type="hidden" id="mid" value="<? echo $mid; ?>">
<INPUT name="posnetID" type="hidden" id="posnetID" value="<? echo $posnetid; ?>">
<INPUT name="vftCode" type="hidden" id="vftCode" value="<? echo $vftCode; ?>">
<!-- <INPUT name="koiCode" type="hidden" id="koiCode" value="2"> -->
<INPUT name="merchantReturnURL" type="hidden" id="merchantReturnURL" value="<? echo $posnetoosresp_return_url; ?>">
      
<!-- Static Parameters -->
<INPUT name="lang" type="hidden" id="lang" value="tr">
<INPUT name="url" type="hidden" id="url">
<INPUT name="openANewWindow" type="hidden" id="openANewWindow" value="<? echo $openANewWindow; ?>">
<BR>      
<BR>      
<BR>      
<CENTER>
    <TABLE width="599" height="322" border="0" cellpadding="0" cellspacing="0">
      <TBODY>
        <TR> 
          <TD width="172" height="59" align="center" valign="middle" background="images/top_left.gif"> 
            <p>&nbsp;</p></TD>
          <TD width="255" height="59" align="center" valign="middle" background="images/top_middle.gif">&nbsp;</TD>
          <TD width="167" height="59" align="center" valign="middle" background="images/top_right.gif">&nbsp;</TD>
          <TD width="5" align="center" valign="middle">&nbsp;</TD>
        </TR>
        <TR> 
          <td colspan="3" align="center" valign="middle" background="images/middle.gif"> 
            <h4>YKB Posnet 3D-Secure sistemine 
              <br>
              yönlenmek için lütfen aþaðýdaki linke týklayýnýz. </h4></td>
          <td width="5" height="87" align="center" valign="middle">&nbsp;</td>
        </TR>
        <TR> 
          <td height="60" colspan="3" align="center" valign="middle" background="images/middle.gif"> 
            <table width="260" height="48" border="0" cellpadding="0" cellspacing="0">
<tr> 
                <td width="110" height="24"> 
<h5>Tutar : <br>
                  </h5></td>
                <td width="150" height="24">
                  <h5>&nbsp;<? echo currencyFormat($amount, $currencycode, true); ?></h5></td>
              </tr>
              <tr> 
                <td height="24"> <h5>Taksit Sayýsý :</h5></td>
                <td height="24"> <h5>&nbsp;<? echo $instnumber; ?></h5></td>
              </tr>
              <tr> 
                <td width="93" height="24"><h5>Sipariþ No : </h5></td>
                <td width="143" height="24"><h5>&nbsp;<? echo $xid; ?></h5></td>
              </tr>
            </table></td>
          <td width="5" height="60" align="center" valign="middle">&nbsp;</td>
        </TR>
        <TR> 
          <td height="38" colspan="3" align="center" valign="bottom" background="images/middle.gif"> 
            <input 
				name="imageField" type="image"
				src="images/button_onayla.gif" width="67" height="20" border="0"
				onClick="submitFormEx(formName, <? echo $openANewWindow; ?>, 'YKBWindow');this.disabled=true;"
			>
            &nbsp; <a href="<?php echo(MERCHANT_INIT_URL);?>"> <img src="images/button_iptal.gif" width="67" height="20" border="0"/> 
            </a> </td>
          <td width="5" height="38" align="center" valign="middle">&nbsp;</td>
        </TR>
        <TR> 
          <td height="43" background="images/bottom_left.gif">&nbsp;</td>
          <td height="43" background="images/bottom_middle.gif">&nbsp;</td>
          <td height="43" background="images/bottom_right.gif">&nbsp;</td>
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