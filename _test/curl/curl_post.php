<?php
$url	= "https://localhost/portapp/_test/curl/curl_result.php";
//$data	= array('action' => 'submit', 'name' => 'Foo', 'file' => '@/home/user/test.png');
$data	= array('action' => 'submit', 'firstname' => 'Foo', 'lastname' => 'baz');

$ch = curl_init(); // initialize curl handle

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_CAINFO, "D:/sdk/xampp/apache/conf/ssl.crt/server.crt");

$result = curl_exec($ch); // run the whole process

if (curl_errno($ch)) {
	print curl_error($ch);
} else {
	curl_close($ch);
}



