<?php
// Pear Mail Library
require_once "Mail.php";

// Fixing CORS for AMP
header("access-control-allow-credentials:true");
header("access-control-allow-headers:Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");
header("access-control-allow-methods:POST, GET, OPTIONS");
header("access-control-allow-origin: *");
//header("access-control-allow-origin:".$_SERVER['HTTP_ORIGIN']);
header("AMP-Access-Control-Allow-Source-Origin: *");
//header("AMP-Access-Control-Allow-Source-Origin:".$_SERVER['HTTP_ORIGIN']);
header("AMP-Same-Origin: true");
header("access-control-expose-headers:AMP-Access-Control-Allow-Source-Origin");
header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
//header("access-control-expose-headers:AMP-Redirect-To,AMP-Access-Control-Allow-Source-Origin");

header("Content-Type: application/json");
header("Cache-Control: private, no-cache");

// This define who will receive the e-mails
$recipient = $_GET['recipient'];

// Example data for subject and who is sending the mail
$from = 'contato@alewfdesign.com.br';
$to = $recipient;
$subject = 'AMP Contact Form';

$body = "All Data\r\n";

foreach($_POST as $key => $value)
{
    $body .= $key . ': ' . $value . "\r\n";
}

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

// Define data for smtp connection
$smtp = Mail::factory('smtp', array(
    'host' => 'alewfdesign.com.br',
    'port' => '465',
    'auth' => true,
    'username' => 'contato@alewfdesign.com.br',
    'password' => 'emailcontato'
));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
    http_response_code(500);
    $message = array('message' => 'Something bad happen, ' . $mail->getMessage());
    echo json_encode($message);
} else {
    $message = array('message' => 'Data sent successfully!');
	echo json_encode($message);
}
