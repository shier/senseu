<?php

//define('__ROOT__', dirname(dirname(__FILE__))); 
require_once('lib/Stripe.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://manage.stripe.com/account
Stripe::setApiKey("sk_live_EjRmoLPQqBK8ydHDlvrHDntZ");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
$charge = Stripe_Charge::create(array(
  "amount" => $_REQUEST['amount'], // amount in cents, again
  "currency" => "usd",
  "card" => $token,
  "description" => $_REQUEST['desc'])
);
} catch(Stripe_CardError $e) {
  // The card has been declined
}
// Save the customer ID in your database so you can use it later
header("Location: purchase.php");  
?>

