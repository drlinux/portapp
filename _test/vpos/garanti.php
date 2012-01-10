<% 

Number        = Trim(Number) 
Ay              = Trim(Right(Ay,2)) 
Yil               = Trim(Right(Yil,2)) 
Cvv2Val       = Trim(Cvv2Val) 
total           = Trim(total) 
gExpire         = Ay & "/" & Yil 

'-------------------------------------------- 
gServer = "https://ccpos.garanti.com.tr/servlet/cc5ApiServer" 
'-------------------------------------------- 

    postData = "<?xml version=""1.0"" encoding=""ISO-8859-1""?>" & vbNewLine 
    postData = postData &"<CC5Request>" & vbNewLine 
    postData = postData &"    <Name>" & Name & "</Name>" & vbNewLine 
    postData = postData &"    <Password>" & Password & "</Password>" & vbNewLine 
    postData = postData &"    <ClientId>" & ClientId & "</ClientId>" & vbNewLine 
    postData = postData &"    <IPAddress></IPAddress>" & vbNewLine 
    postData = postData &vbNewLine  
    postData = postData &"    <Email></Email>" & vbNewLine 
    postData = postData &"    <Mode>P</Mode>" & vbNewLine 
    postData = postData &"    <OrderId>" & OrderId & "</OrderId>" & vbNewLine 
    postData = postData &"    <GroupId></GroupId>" & vbNewLine 
    postData = postData &"    <TransId></TransId>" & vbNewLine 
    postData = postData &vbNewLine  
    postData = postData &"    <UserId></UserId>" & vbNewLine 
    postData = postData &"        <Type>Auth</Type>" & vbNewLine 
    postData = postData &"        <Number>" & Number & "</Number>" & vbNewLine 
    postData = postData &"        <Expires>" & gExpire & "</Expires>" & vbNewLine 
    postData = postData &"        <Cvv2Val>" & Cvv2Val & "</Cvv2Val>" & vbNewLine 
    postData = postData &"        <Total>" & total & "</Total>" & vbNewLine 
    postData = postData &"        <Currency>949</Currency>" & vbNewLine 
        'postData = postData &"        <Currency>792</Currency>" & vbNewLine 
    postData = postData &"        <Taksit>" & taksit & "</Taksit>" & vbNewLine 
    postData = postData &vbNewLine  
    postData = postData &"    <BillTo>" & vbNewLine 
    postData = postData &"        <Name></Name>" & vbNewLine 
    postData = postData &"        <Street1></Street1>" & vbNewLine 
    postData = postData &"        <Street2></Street2>" & vbNewLine 
    postData = postData &"        <Street3></Street3>" & vbNewLine 
    postData = postData &"        <City></City>" & vbNewLine 
    postData = postData &"        <StateProv></StateProv>" & vbNewLine 
    postData = postData &"        <PostalCode></PostalCode>" & vbNewLine 
    postData = postData &"        <Country></Country>" & vbNewLine 
    postData = postData &"        <Company></Company>" & vbNewLine 
    postData = postData &"        <TelVoice></TelVoice>" & vbNewLine 
    postData = postData &"    </BillTo>" & vbNewLine 
    postData = postData &vbNewLine  
    postData = postData &"    <ShipTo>" & vbNewLine 
    postData = postData &"        <Name></Name>" & vbNewLine 
    postData = postData &"        <Street1></Street1>" & vbNewLine 
    postData = postData &"        <Street2></Street2>" & vbNewLine 
    postData = postData &"        <Street3></Street3>" & vbNewLine 
    postData = postData &"        <City></City>" & vbNewLine 
    postData = postData &"        <StateProv></StateProv>" & vbNewLine 
    postData = postData &"        <PostalCode></PostalCode>" & vbNewLine 
    postData = postData &"        <Country></Country>" & vbNewLine 
    postData = postData &"    </ShipTo>" & vbNewLine 
    postData = postData &vbNewLine  
    postData = postData &"    <Extra></Extra>" & vbNewLine 
    postData = postData &"</CC5Request>" & vbNewLine 

'------------------------------------ 
postData = "DATA=" & Server.URLEncode(postData) 
'------------------------------------ 

    Set Xobj = Server.CreateObject("Msxml2.XMLHTTP") 
    Xobj.Open "POST",gServer,False 
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