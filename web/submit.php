<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: https://liwacap.com');
    exit();
}

$message = '<h3>General Information:</h3>';

if ($_POST['info'] === 'yes-to-all') {
    $message .= '<p>Yes to all</p>';

    if ($_POST['type'] === 'EU') {
        $message .= '<h3>Investor type:</h3><p>European investor</p>';
        $message .= '<h3>Are you a "professional investor" as defined in the European Union\'s Alternative Investment Fund Managers Directive (the "AIFMD")?</h3><p>'.$_POST['professional-investor'].'</p>';
        $message .= '<h3>Which category of investor qualifies you as a "professional investor" as defined in the AIFMD?</h3>';

        if ($_POST['professional-investor-type'] == 1) {
            $message .= '<p>An entity authorized or regulated by a European member state to operate in the financial markets which is one of the following entities as defined in the Markets in Financial Instruments Directive (“MiFID”)</p>';
        } else if ($_POST['professional-investor-type'] == 2) {
            $message .= '<p>A large undertaking meeting two of the following size requirements on a company basis:<br>a. Balance Sheet Total: EUR 20,000,000.00<br>b. Net Turnover: EUR 10,000,000.00<br>c. Own Funds: EUR 2,000,000.00</p>';
        } else if ($_POST['professional-investor-type'] == 3) {
            $message .= '<p>One of the following entities or organizations:<br>a. National or regional government,<br>b. Public body that manages public debt,<br>c. Central Bank, and;<br>d. International or supranational organization (e.g. the World Bank, the International Monetary Fund, the European Central Bank, the European Investment Bank and other similar international organizations)</p>';
        } else if ($_POST['professional-investor-type'] == 4) {
            $message .= '<p>An institutional investor whose main activity is to invest in financial instruments, including an entity which is dedicated to the securitization of assets or other financing transactions</p>';
        }
    } else if ($_POST['type'] === 'US') {
        $message .= '<h3>Investor type:</h3><p>US investor</p>';
        $message .= '<h3>Are you a US tax exempt entity?</h3><p>'.$_POST['us-investor'].'</p>';
        $message .= '<h3>Definitions that apply to the potential investor:</h3>';

        if ($_POST['us-investor-definition'] == 1) {
            $message .= '<p>I am a natural person with net worth (or joint net worth with my spouse or spousal equivalent) in excess of US$1,000,000.</p>';
        } else if ($_POST['us-investor-definition'] == 2) {
            $message .= '<p>I am a natural person with individual income in excess of US$200,000 in each of the two most recent years or joint income with my spouse or spousal equivalent in excess of US$300,000 in each of those years and have a reasonable expectation of reaching the same income level in the current year.</p>';
        } else if ($_POST['us-investor-definition'] == 3) {
            $message .= '<p>I am a natural person who has in good standing, certain professional certifications, designations or other credentials issued by an accredited educational institution (e.g., Series 7, Series 65 or Series 82 license), which the Securities and Exchange Commission may designate from time to time by order.</p>';
        } else if ($_POST['us-investor-definition'] == 4) {
            $message .= '<p>I am a “family office (as defined under the Investment Advisers Act of 1940, as amended (the “Advisers Act”) (1) with assets under management in excess of $5,000,000, (2) not formed for the specific purpose of acquiring the Interests offered and (3) whose prospective investment is directed by a person with such knowledge and experience in financial and business matters that the family office is capable of evaluating merits and risks of the prospective investment or (b) a “family client” (as defined under the Advisers Act) of such family office whose investment is directed by such family office.</p>';
        } else if ($_POST['us-investor-definition'] == 5) {
            $message .= '<p>I am a large institutional investor or organization with total assets in excess of US$5,000,000 but not formed for the specific purpose of acquiring securities managed by Liwa Capital.</p>';
        } else if ($_POST['us-investor-definition'] == 6) {
            $message .= '<p>I am a bank, insurance company, registered investment company, business development company, or small business investment company.</p>';
        } else if ($_POST['us-investor-definition'] == 7) {
            $message .= '<p>I am an investment adviser registered pursuant to section 203 of the Advisers Act or registered pursuant to the laws of a state; any investment adviser relying on the exemption from registering with the Commission under section 203(l) or (m) of the Advisers Act.</p>';
        } else if ($_POST['us-investor-definition'] == 8) {
            $message .= '<p>I am an employee benefit plan, within the meaning the Employee Retire Income Security Act, and a bank, insurance company, or registered investment adviser makes the investment decisions, and the plan has total assets in excess of $5,000,000.</p>';
        } else if ($_POST['us-investor-definition'] == 9) {
            $message .= '<p>I am a charitable organization, corporation, limited liability company or partnership with assets exceeding $5,000,000 that was not formed for the specific purpose of purchasing the securities offered.</p>';
        } else if ($_POST['us-investor-definition'] == 10) {
            $message .= '<p>I am a trust with assets in excess of $5,000,000, not formed to acquire the securities offered, whose purchases a sophisticated person makes.</p>';
        } else if ($_POST['us-investor-definition'] == 11) {
            $message .= '<p>I am an entity in which all of the owners are accredited investors.</p>';
        } else if ($_POST['us-investor-definition'] == 12) {
            $message .= '<p>None of the above.</p>';
        }

        $message .= '<h3>I certify that I am a US qualified purchaser:</h3>';

        if ($_POST['us-purchaser'] == 1) {
            $message .= '<p>I am a natural person that holds (individually or in joint ownership with my spouse) not less than US$5,000,000 in investments.</p>';
        } else if ($_POST['us-purchaser'] == 2) {
            $message .= '<p>I am a company that owns not less than US$5,000,000 in investments that is owned directly or indirectly by or for two natural persons who are not related as siblings or spouse (or former spouse), or direct lineal descendants by birth or adoption, spouses of such persons, the estates of such persons, or foundations, charitable organizations, or trusts established by or for the benefit of such persons.</p>';
        } else if ($_POST['us-purchaser'] == 3) {
            $message .= '<p>I am any trust not covered by the preceding option and was not formed for the specific purpose of acquiring the securities managed by Liwa Capital, as to which the trustee or other person authorized to make decisions with respect to the trust, and each settler or other person who has contributed assets to the trust, is a person described in the two preceding (or the following) option(s).</p>';
        } else if ($_POST['us-purchaser'] == 4) {
            $message .= '<p>I am a person who, acting for my own account or the accounts of other qualified purchasers, who in the aggregate owns and invests on a discretionary basis, not less than US$25,000,000 in investments.</p>';
        } else if ($_POST['us-purchaser'] == 5) {
            $message .= '<p>None of the above.</p>';
        }
    } else {
        $message .= '<h3>Investor type:</h3><p>Offshore investor (Non-U.S. and non-European investors or U.S. tax-exempt investors only)</p>';
        $message .= '<h3>Have you read and acknowledged the foregoing?</h3><p>'.$_POST['offshore'].'</p>';
    }
} else {
    $message .= '<p>No to any</p>';
}

$message .= '<h3>Which of the following applies to the Subscriber:</h3><p>'.$_POST['subscriber-type'].'</p>';
$message .= '<h3>User Identification:</h3>';
$message .= '<p><b>First name:</b> '.$_POST['firstname'].'</p>';
$message .= '<p><b>Last name:</b> '.$_POST['lastname'].'</p>';
$message .= '<p><b>Legal entity name:</b> '.$_POST['legalentityname'].'</p>';
$message .= '<p><b>Street address:</b> '.$_POST['address'].'</p>';
$message .= '<p><b>City:</b> '.$_POST['city'].'</p>';
$message .= '<p><b>State/province:</b> '.$_POST['state'].'</p>';
$message .= '<p><b>Country:</b> '.$_POST['country'].'</p>';
$message .= '<p><b>Zip/postal code:</b> '.$_POST['zip'].'</p>';
$message .= '<p><b>Email address:</b> '.$_POST['email'].'</p>';
$message .= '<p><b>Telephone:</b> '.$_POST['telephone'].'</p>';

define('CRAFT_BASE_PATH', dirname(__DIR__));
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH.'/vendor');

require_once CRAFT_VENDOR_PATH.'/autoload.php';

use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require CRAFT_VENDOR_PATH . '/phpmailer/phpmailer/src/Exception.php';
require CRAFT_VENDOR_PATH . '/phpmailer/phpmailer/src/PHPMailer.php';
require CRAFT_VENDOR_PATH . '/phpmailer/phpmailer/src/SMTP.php';

$client = new Client;

$response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
    'form_params' => [
        'secret' => '6Leu__8pAAAAANfTZF4WMm8rD60ZMmjJmMaLuUlV',
        'response' => $_POST['g-recaptcha-response']
    ],
    'http_errors' => false
]);

$body = json_decode($response->getBody());

if (!$body->success) {
    header('Location: https://liwacap.com/wizard');
    die();
}

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
$mail->AddAddress("liwasubscriptions@liwacap-ky.com", "Liwa Capital");
$mail->SetFrom("investorportal@liwacap.com", "Indication of Interest");
$mail->Subject = "{$_POST['email']} - Indication of Interest";
$content = $message;

$mail->MsgHTML($content);

if(!$mail->Send()) {
    header('Location: https://liwacap.com/wizard-error');
} else {
    header('Location: https://liwacap.com/wizard-thank-you');
}

exit();
