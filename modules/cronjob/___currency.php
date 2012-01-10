<?php

define('DB_DSN', "mysql:host=localhost;dbname=casict_ferrosan");
define('DB_USER', "casict_ferrosan");
define('DB_PASSWORD', "F1q2w3e4r");

try {
	$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
	die('Veritabanı bağlantı hatası: ' . $e->getMessage());
}

$query = "SELECT * FROM `user` ";
$query .= "WHERE `user_status` = 'A' ";
$query .= "AND `user_email` <> '' ";
$query .= "AND date_format(`user_birthday`,'%m-%d') = date_format(now(),'%m-%d') ";

$stmt = $dbh->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rowCount = $stmt->rowCount();
if ($rowCount>0) {
	echo sprintf("%d row(s) found<br/>\n", $rowCount);
}
else {
	die("No rows found");
}

$eol = "\r\n";
$headers = "";
$headers .= "From: Ferrosan <ferrosancrm@ferrosancrm.com>" . $eol;
$headers .= "Sender: Ferrosan <ferrosancrm@ferrosancrm.com>" . $eol;
$headers .= "Cc: Akgun Egemen <akge@ferrosan.com>" . $eol;
$headers .= "Bcc: Ferrosan CRM <ferrosancrm@ferrosancrm.com>" . $eol;
$headers .= "X-Mailer: PHP/" . phpversion() . $eol;
$headers .= "X-Priority: 3" . $eol; // 1: Urgent, 3: Normal
$headers .= "Return-Path: Ferrosan <ferrosancrm@ferrosancrm.com>" . $eol;
$headers .= "MIME-Version: 1.0" . $eol;
$headers .= "Content-type: text/html; charset=UTF-8";

ini_set("SMTP", "mail.ferrosancrm.com");
ini_set("smtp_port", 26);
ini_set("sendmail_from", "ferrosancrm@ferrosancrm.com");
//ini_set(sendmail_path, "/usr/sbin/sendmail -t -f ferrosancrm@ferrosancrm.com");// For UNIX
	
foreach ($rows as $row) {

	$subject = sprintf("Nice Mutlu Yıllara %s", $row["user_fullname"]);
	$body = sprintf("<p>Sayın %s.</p><p>Doğum günüzü kutlar, sağlık ve mutluluk dolu seneler dileriz.</p><p>Saygılarımızla.<br/>Ferrosan Türkiye</p>", $row["user_fullname"]);
	$to = $row["user_email"];
	
	if (mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', wordwrap(stripslashes($body)), $headers)) {
		echo sprintf("Sent to %s<br/>\n", $to);
	}
	else {
		echo sprintf("Couldn't sent to %s<br/>\n", $to);
	}
	
}

$dbh = null;
exit;