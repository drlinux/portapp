<% 
Number        = Trim(Number) 
Ay              = Trim(Right(Ay,2)) 
Yil               = Trim(Right(Yil,2)) 
Cvv2Val       = Trim(Cvv2Val) 
total           = Trim(total) 
gExpire        = Ay & "/" & Yil 


'-------------------------------------------- 
gServer = "https://www.fbwebpos.com/servlet/ApiServer" 
'-------------------------------------------- 
// FinansWebPos CC Gateway
// TEST ADDRESS $url = "https://cc5test.est.com.tr/servlet/cc5ApiServer"
// OTHER TEST ADDRESS $url = "https://testserver.fbwebpos.com/servlet/cc5ApiServer"
// REAL URL ADDRESS $url = "https://www.fbwebpos.com/servlet/cc5ApiServer"


postdata = "<?xml version=""1.0"" encoding=""ISO-8859-1""?>" & vbNewLine 
postdata = postdata & "<CC5Request>" & vbNewLine 
postdata = postdata & "    <Name>" & Name & "</Name>" & vbNewLine 
postdata = postdata & "    <Password>" & Password & "</Password>" & vbNewLine 
postdata = postdata & "    <ClientId>" & ClientId & "</ClientId>" & vbNewLine 
postdata = postdata & "    <Mode>P</Mode>" & vbNewLine 
postdata = postdata & "    <OrderId></OrderId>" & vbNewLine 
postdata = postdata & "    <Type>Auth</Type>" & vbNewLine 
postdata = postdata & "    <Number>" & Number & "</Number>" & vbNewLine 
postdata = postdata & "    <Expires>" & gExpire & "</Expires>" & vbNewLine 
postdata = postdata & "    <Cvv2Val>" & Cvv2Val & "</Cvv2Val>" & vbNewLine 
postdata = postdata & "    <Total>" & total & "</Total>" & vbNewLine 
postdata = postdata & "    <Taksit>" & taksit & "</Taksit>" & vbNewLine 
postdata = postdata & "    <Currency>949</Currency>" & vbNewLine 
postdata = postdata & "    <UserId></UserId>" & vbNewLine 
postdata = postdata & "    <email></email>" & vbNewLine 
postdata = postdata & "    " & vbNewLine 
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

approved  = objXML.childNodes(1).childNodes(0).text 
respCode  = objXML.childNodes(1).childNodes(1).text 
respText   = objXML.childNodes(1).childNodes(2).text 
yourIP      = objXML.childNodes(1).childNodes(3).text 

sonuc  ="<B>İşlem Sonucu dönen değerler</B><P> " 
sonuc  = sonuc & "approved  :" & approved  & "<BR>" 
sonuc  = sonuc & "respCode  :" & respCode  & "<BR>" 
sonuc  = sonuc & "respText :" & respText & "<BR>" 
sonuc  = sonuc & "yourIP :" & yourIP & "<BR>" 

'response.write sonuc 
'response.End 

Set objXML=Nothing 

'------------------------------------ 

If  approved <> 0 Then 

k_sonuc="ok" 

Else 

k_sonuc="hata" 
hata = respCode &"<P>"& respText 

End If  

%>