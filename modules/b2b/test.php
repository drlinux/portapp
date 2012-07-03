<?php require_once dirname(__FILE__) . '/../../classes/config.inc.php';

$SC = new Salescampaign;
$temp = $SC->run("SELECT NOW()");
print_r($temp);
exit;

/*
$mailer = new CasMailer();
$mailer->SMTPAuth = false;
$mailer->Mailer = "mail";
$mailer->Subject = $smarty->getConfigVariable("MAIL_SUBJECT_USERREGISTER");
$mailer->MsgHTML(sprintf($smarty->getConfigVariable("MAIL_BODY_USERREGISTER"), "hazar.artuner@gmail.com", $userPass));
$mailer->AddAddress("hazar.artuner@gmail.com", "Hazar Artuner");
	
echo $mailer->Send() ? "Send Succeed!" : "Send Error";*/