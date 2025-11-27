<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: https://liwacap.com');
    die();
}

define('CRAFT_BASE_PATH', dirname(__DIR__));
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH.'/vendor');

require_once CRAFT_VENDOR_PATH.'/autoload.php';

use GuzzleHttp\Client;

$client = new Client;

$response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
    'form_params' => [
        'secret' => '6LfXOTgiAAAAAK5N30mGT-uSJeYpasbhM0gSKVFC',
        'response' => $_POST['g-recaptcha-response']
    ],
    'http_errors' => false
]);

$body = json_decode($response->getBody());

if (!$body->success) {
    header('Location: https://liwacap.com/market-updates-sign-up');
    die();
}

$message = '<h3>Market Update Subscription:</h3>';
$message .= '<p><b>First name:</b> '.$_POST['firstname'].'</p>';
$message .= '<p><b>Last name:</b> '.$_POST['lastname'].'</p>';
$message .= '<p><b>Email address:</b> '.$_POST['email'].'</p>';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require CRAFT_VENDOR_PATH . '/phpmailer/phpmailer/src/Exception.php';
require CRAFT_VENDOR_PATH . '/phpmailer/phpmailer/src/PHPMailer.php';
require CRAFT_VENDOR_PATH . '/phpmailer/phpmailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

$mail->SMTPDebug  = false;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.office365.com";
$mail->Username   = "investorportal@liwacap.com";
$mail->Password   = "LiwaAGG@2023";

$mail->IsHTML(true);
$mail->AddAddress("info@liwacap.com", "Liwa Capital");
$mail->SetFrom("investorportal@liwacap.com", "Market Updates Subscription");
$mail->Subject = "{$_POST['email']} - Market Updates Subscription";
$content = $message;

$mail->MsgHTML($content);

session_start();

if(!$mail->Send()) {
    header('Location: https://liwacap.com/wizard-error');
} else {
    header('Location: https://liwacap.com/wizard-thank-you');
}
