<?php
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = function($str, $level) {echo "debug level $level - message: $str<br>";};
$mail->Host = "outlook.office365.com"; // "smtp.office365.com";
$mail->Port = "25"; //"587";
$mail->SMTPAuth = true;
$mail->Username = "customerservice@soccerone.com";
$mail->Password = "Mgn4583*";
// $mail->SMTPSecure = "tls";
$mail->setFrom('customerservice@soccerone.com', 'SoccerOne Customer Service');
$mail->addReplyTo('customerservice@soccerone.com', 'SoccerOne Customer Service');
?>