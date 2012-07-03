<html>
<head>
    <title></title>
</head>
<body>
    <?php
        $strMode = "TEST";
        $strApiVersion = "v0.01";
        $strTerminalProvUserID = "PROVAUT";
        $strType = "sales";
        $strAmount = "100"; 
        $strCurrencyCode = "949";
        $strInstallmentCount = ""; 
        $strTerminalUserID = "PROVAUT";
        $strOrderID = "12308uqajdkajkl1111";
        $strCustomeripaddress = "127.0.0.1";
        $strcustomeremailaddress = "info@tradesis.com";
        $strTerminalID = "111995";
        $strTerminalID_ = "000111995"; 
        $strTerminalMerchantID = "600218"; 
        $strStoreKey = "12345678"; 
        $strProvisionPassword = "123qweASD"; 
        $strSuccessURL = "http://portapp.project.casict.com/modules/b2b/productorder_provision-gb.php";
        $strErrorURL = "http://portapp.project.casict.com/modules/b2b/productorder_provision-gb.php";
        $SecurityData = strtoupper(sha1($strProvisionPassword.$strTerminalID_));
        $HashData = strtoupper(sha1($strTerminalID.$strOrderID.$strAmount.$strSuccessURL.$strErrorURL.$strType.$strInstallmentCount.$strStoreKey.$SecurityData));
    ?>
    <form action="https://sanalposprovtest.garanti.com.tr/servlet/gt3dengine" method="post">
        3D Security Level: 
        <select name="secure3dsecuritylevel">
            <option value="3D_PAY">3D_PAY</option>
            <option value="3D_FULL">3D_FULL</option>
            <option value="3D_HALF">3D_HALF</option>
        </select>
        <br />
        Card Number: <input name="cardnumber" type="text" />
        <br />
        Expire Date (mm): <input name="cardexpiredatemonth" type="text" />
        <br />
        Expire Date (yy): <input name="cardexpiredateyear" type="text" />
        <br />
        CVV2: <input name="cardcvv2" type="text" />
        <br />
        <input id="submit" type="submit" value="��lemi G�nder" />
        <input type="hidden" name="mode" value="<?php  echo $strMode ?>" />
        <input type="hidden" name="apiversion" value="<?php  echo $strApiVersion ?>" />
        <input type="hidden" name="terminalprovuserid" value="<?php  echo $strTerminalProvUserID ?>" />
        <input type="hidden" name="terminaluserid" value="<?php  echo $strTerminalUserID ?>" />
        <input type="hidden" name="terminalmerchantid" value="<?php  echo $strTerminalMerchantID ?>" />
        <input type="hidden" name="txntype" value="<?php  echo $strType ?>" />
        <input type="hidden" name="txnamount" value="<?php  echo $strAmount ?>" />
        <input type="hidden" name="txncurrencycode" value="<?php  echo $strCurrencyCode ?>" />
        <input type="hidden" name="txninstallmentcount" value="<?php  echo $strInstallmentCount ?>" />
        <input type="hidden" name="orderid" value="<?php  echo $strOrderID ?>" />
        <input type="hidden" name="terminalid" value="<?php  echo $strTerminalID ?>" />
        <input type="hidden" name="successurl" value="<?php  echo $strSuccessURL ?>" />
        <input type="hidden" name="errorurl" value="<?php  echo $strErrorURL ?>" />
        <input type="hidden" name="customeripaddress" value="<?php  echo $strCustomeripaddress ?>" />
        <input type="hidden" name="customeremailaddress" value="<?php  echo $strcustomeremailaddress ?>" />
        <input type="hidden" name="secure3dhash" value="<?php  echo $HashData ?>" />
        
    </form>
</body>
</html>