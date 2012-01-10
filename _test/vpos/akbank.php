<% 

Number        = Trim(Number) 
Ay              = Trim(Right(Ay,2)) 
Yil               = Trim(Right(Yil,2)) 
Cvv2Val       = Trim(Cvv2Val) 
total           = Trim(total) 
gExpire         = Ay & "/" & Yil 

'-------------------------------------------- 
gServer = "https://vpos.est.com.tr/servlet/cc5ApiServer" 
'gServer = "https://cc5test.est.com.tr/servlet/cc5ApiServer" 'TEST 
'-------------------------------------------- 

postdata = "<?xml version=""1.0"" encoding=""ISO-8859-1""?>" & vbNewLine 
postdata = postdata & "<CC5Request>" & vbNewLine 
postdata = postdata & "    <Name>" & Name & "</Name>" & vbNewLine 
postdata = postdata & "    <Password>" & Password & "</Password>" & vbNewLine 
postdata = postdata & "    <ClientId>" & ClientId & "</ClientId>" & vbNewLine 
postdata = postdata & "    <Mode>P</Mode>" & vbNewLine 
postdata = postdata & "    <OrderId>" & OrderId & "</OrderId>" & vbNewLine 
postdata = postdata & "    <Type>Auth</Type>" & vbNewLine 
postdata = postdata & "    <IPAddress></IPAddress>" & vbNewLine 
postdata = postdata & "    <Number>" & Number & "</Number>" & vbNewLine 
postdata = postdata & "    <Expires>" & gExpire & "</Expires>" & vbNewLine 
postdata = postdata & "    <Cvv2Val>" & Cvv2Val & "</Cvv2Val>" & vbNewLine 
postdata = postdata & "    <Total>" & total & "</Total>" & vbNewLine 
postdata = postdata & "    <Taksit>" & taksit & "</Taksit>" & vbNewLine 
postdata = postdata & "    <Currency>949</Currency>" & vbNewLine 
postdata = postdata & "    <UserId></UserId>" & vbNewLine 
postdata = postdata & "    <email></email>" & vbNewLine 
postdata = postdata & "    <CardholderPresentCode>1</CardholderPresentCode>" & vbNewLine 
postdata = postdata & "    <PayerSecurityLevel>13</PayerSecurityLevel>" & vbNewLine 
postdata = postdata & "    <PayerTxnId>1</PayerTxnId>" & vbNewLine 
postdata = postdata & "    <PayerAuthenticationCode>1</PayerAuthenticationCode>" & vbNewLine 
postdata = postdata & "    <BillTo>" & vbNewLine 
postdata = postdata & "    <Name></Name>" & vbNewLine 
postdata = postdata & "        <Street1></Street1>" & vbNewLine 
postdata = postdata & "        <Street2></Street2>" & vbNewLine 
postdata = postdata & "        <Street3></Street3>" & vbNewLine 
postdata = postdata & "        <City></City>" & vbNewLine 
postdata = postdata & "        <PostalCode></PostalCode>" & vbNewLine 
postdata = postdata & "        <TelVoice></TelVoice>" & vbNewLine 
postdata = postdata & "    </BillTo>" & vbNewLine 
postdata = postdata & "    <ShipTo>" & vbNewLine 
postdata = postdata & "        <Name></Name>" & vbNewLine 
postdata = postdata & "        <Street1></Street1>" & vbNewLine 
postdata = postdata & "        <Street2></Street2>" & vbNewLine 
postdata = postdata & "        <Street3></Street3>" & vbNewLine 
postdata = postdata & "        <City></City>" & vbNewLine 
postdata = postdata & "        <PostalCode></PostalCode>" & vbNewLine 
postdata = postdata & "        <TelVoice></TelVoice>" & vbNewLine 
postdata = postdata & "    </ShipTo>" & vbNewLine 
postdata = postdata & "</CC5Request>" & vbNewLine 


'------------------------------------ 
postData = "DATA=" & Server.URLEncode(postData) 
'------------------------------------ 

    Set Xobj = Server.CreateObject("Msxml2.XMLHTTP") 
    Xobj.Open "POST",gServer,false 
    Xobj.setRequestHeader "Content-Type","application/x-www-form-urlencoded" 
    Xobj.Send postData 
    result = Xobj.Responsetext  

    'Set Xobj = CreateObject("SOFTWING.ASPtear") 
    'Xobj.FollowRedirects=True 
    'result = Xobj.Retrieve(gServer, 1, postData, "", "") 

    Set Xobj  = Nothing 

donenxml = result 

'Response.Write "<P>" & donenxml 
'Response.End 


'------------------------------------ 
Set objXML = CreateObject("Microsoft.XMLDOM")  
objXML.async = false  
objXML.LoadXML donenxml 

OrderID = objXML.childNodes(1).childNodes(0).text 
GroupId = objXML.childNodes(1).childNodes(1).text 
Responseg = objXML.childNodes(1).childNodes(2).text 
AuthCode = objXML.childNodes(1).childNodes(3).text 
HostRefNumber = objXML.childNodes(1).childNodes(4).text 
ProcReturnCode = objXML.childNodes(1).childNodes(5).text 
TransId = objXML.childNodes(1).childNodes(6).text 
ErrMsg = objXML.childNodes(1).childNodes(7).text 
Extra = objXML.childNodes(1).childNodes(8).text 

sonuc  ="<B>İşlem Sonucu dönen değerler</B><P> " 
sonuc  = sonuc &"OrderID :" & OrderID & "<BR>" 
sonuc  = sonuc & "GroupId :" & GroupId & "<BR>" 
sonuc  = sonuc & "Responseg :" & Responseg& "<BR>" 
sonuc  = sonuc & "AuthCode :" & AuthCode & "<BR>" 
sonuc  = sonuc & "HostRefNumber :" & HostRefNumber & "<BR>" 
sonuc  = sonuc & "ProcReturnCode :" & ProcReturnCode& "<BR>" 
sonuc  = sonuc & "TransId :" & TransId & "<BR>" 
sonuc  = sonuc & "ErrMsg :" & ErrMsg & "<BR>" 
sonuc  = sonuc & "Extra :" & Extra& "<BR>" 

'response.write sonuc 
'response.End 

Set objXML=Nothing 

'------------------------------------ 

If  ProcReturnCode = 0 Then 

k_sonuc="ok" 

Else 

k_sonuc="hata" 
hata = ErrMsg &"<P>"& Extra 

End If  

%><!-- CEVAP ÖRNEĞİ 
<?xml version="1.0" encoding="ISO-8859-9"?> 
<CC5Response> 
  <OrderId>19127148</OrderId> 
  <GroupId></GroupId> 
  <Response>Error</Response> 
  <AuthCode></AuthCode> 
  <HostRefNum></HostRefNum> 
  <ProcReturnCode>99</ProcReturnCode> 
  <TransId></TransId> 
  <ErrMsg>Insufficient permissions to perform requested operation.</ErrMsg> 
  <Extra> 
    <HOSTMSG>Islem yetkisi yok, client id, kullanici adi veya sifre hatali girilmis olabilir.</HOSTMSG> 
    <NUMCODE>00009900641096</NUMCODE> 
  </Extra> 
</CC5Response> 
-->