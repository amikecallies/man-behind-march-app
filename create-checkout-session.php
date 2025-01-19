<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';


session_start();

// $stripeSecret = getenv('STRIPE_SECRET');
$amazonSesUserName = getenv('AMAZON_SES_SMTP_USERNAME');
$amazonSesPassword = getenv('AMAZON_SES_SMTP_PASSWORD');

\Stripe\Stripe::setApiKey('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');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://www.manbehindthemarch.com';
$o_fullName=$_SESSION['fullName'];
$o_email=$_SESSION['email'];
$o_country=$_SESSION['country'];
$o_address=$_SESSION['address'];
$o_suite=$_SESSION['suite'];
$o_city=$_SESSION['city'];
$o_state=$_SESSION['state'];
$o_zipcdoe=$_SESSION['zipcode'];
$o_phone=$_SESSION['phone'];
$o_hardBookQty=$_SESSION['hardBookQty'];
$o_paperbackBookQty=$_SESSION['paperbackBookQty'];

if($o_suite == '') 
{
  $o_suite = 'N/A';
}

function sendMsgSeller($o_fullName, $o_email, $o_country, $o_address, $o_suite, $o_city, $o_state, $o_zipcdoe, $o_phone, $o_hardBookQty, $o_paperbackBookQty) {

  // Instantiate a new PHPMailer 
  $mail = new PHPMailer;

  // Tell PHPMailer to use SMTP
  $mail->isSMTP();

  //$mail->SMTPDebug = 2;

  // Replace sender@example.com with your "From" address. 
  // This address must be verified with Amazon SES.
  $mail->setFrom('acallies15@apu.edu', 'New Home Realty  Admin');
  // Replace recipient@example.com with a "To" address. If your account 
  // is still in the sandbox, this address must be verified.


  //$mail->addAddress('amcallies2018@gmail.com', 'Adrian Callies'); //Use this email only for testing this feature
  $mail->addAddress('manbehindmarch@gmail.com', 'Arlington Callies');

  // Replace smtp_username with your Amazon SES SMTP user name.
  $mail->Username = $amazonSesUserName;

  // Replace smtp_password with your Amazon SES SMTP password.
  $mail->Password = $amazonSesPassword;
      
  // Specify a configuration set. If you do not want to use a configuration
  // set, comment or remove the next line.
  //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', 'ConfigSet');
  
  // If you're using Amazon SES in a region other than US West (Oregon), 
  // replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP  
  // endpoint in the appropriate region.
  $mail->Host = 'email-smtp.us-west-2.amazonaws.com';// May be subject to change since most emails will be sent in the Texas Area

  // The subject line of the email
  $mail->Subject = 'Man Behind the March: New Order!';

  // The HTML-formatted body of the email
  $mail->Body = "<h1>Someone has just made a new order for your book! Please ship and fulfill this order!</h1>
  <p>".$o_fullName." has made this purchase. Please review the shipping information below:</p>
  <i><ol>
  <li>Email: ".$o_email."</li>
  <li>Country: ".$o_country."</li>
  <li>Address: ".$o_address."</li>
  <li>Suite: ".$o_suite."</li>
  <li>City: ".$o_city."</li>
  <li>State: ".$o_state."</li>
  <li>Zip Code: ".$o_zipcdoe."</li>
  <li>Phone: ".$o_phone."</li>
  <li>Number of Hard Cover Books: ".$o_hardBookQty."</li>
  <li>Number of Paperback Books: ".$o_paperbackBookQty."</li>
  </ol>
  <b>Please verify that ".$o_fullName." has submitted payment BEFORE you process this order at your earliest convenience.</b>";

  // Tells PHPMailer to use SMTP authentication
  $mail->SMTPAuth = true;

  // Enable TLS encryption over port 587
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  // Tells PHPMailer to send HTML-formatted email
  $mail->isHTML(true);

  // The alternative email body; this is only displayed when a recipient
  // opens the email in a non-HTML email client. The \r\n represents a 
  // line break.
  $mail->AltBody = "Email Test\r\nThis email was sent through the 
      Amazon SES SMTP interface using the PHPMailer class.";


  if(!$mail->send()) {
      echo "Email not sent. " , $mail->ErrorInfo , PHP_EOL;
  }
}

if($o_hardBookQty == '') {
  $o_hardBookQty = 0;
}

if($o_paperbackBookQty == '') {
  $o_paperbackBookQty = 0;
}

if($o_hardBookQty > 0 && $o_paperbackBookQty > 0) {

  $checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
      [
      'price_data' => [
        'currency' => 'usd',
        'unit_amount' => 2300,
        'product_data' => [
          'name' => 'Man Beind the March Book - Hard Cover',
          'images' => ["https://i.imgur.com/IunDNun.jpg"],
        ],
      ],
      'quantity' => $o_hardBookQty,
    ],
    [
      'price_data' => [
        'currency' => 'usd',
        'unit_amount' => 1800,
        'product_data' => [
          'name' => 'Man Beind the March Book - Paperback',
          'images' => ["https://i.imgur.com/IunDNun.jpg"],
        ],
      ],
      'quantity' => $o_paperbackBookQty,
    ]
  ],
    'mode' => 'payment',
    
    'success_url' => $YOUR_DOMAIN . '/success.html',
    'cancel_url' => $YOUR_DOMAIN . '/index.html',
  ]);
}
else if($o_hardBookQty > 0 && $o_paperbackBookQty == 0) {
  $checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
      [
      'price_data' => [
        'currency' => 'usd',
        'unit_amount' => 2300,
        'product_data' => [
          'name' => 'Man Beind the March Book - Hard Cover',
          'images' => ["https://i.imgur.com/IunDNun.jpg"],
        ],
      ],
      'quantity' => $o_hardBookQty,
    ]
  ],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/success.html',
    'cancel_url' => $YOUR_DOMAIN . '/index.html',
  ]);
}
else {
  $checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
      [
      'price_data' => [
        'currency' => 'usd',
        'unit_amount' => 1800,
        'product_data' => [
          'name' => 'Man Beind the March Book - Paperback',
          'images' => ["https://i.imgur.com/IunDNun.jpg"],
        ],
      ],
      'quantity' => $o_paperbackBookQty,
    ]
  ],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/success.html',
    'cancel_url' => $YOUR_DOMAIN . '/index.html',
  ]);
}

echo json_encode(['id' => $checkout_session->id]);
sendMsgSeller($o_fullName, $o_email, $o_country, $o_address, $o_suite, $o_city, $o_state, $o_zipcdoe, $o_phone, $o_hardBookQty, $o_paperbackBookQty);
?>
