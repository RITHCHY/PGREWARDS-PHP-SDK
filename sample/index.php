<?php
require './vendor/autoload.php';

use Mds\PGRewards\Auth;
use Mds\PGRewards\Constants;
use Mds\PGRewards\Rewards;
use Mds\PGRewards\VirtualPrepaidCard;

# Define your credentials
$userID = "dacd0191-08cc-4033-8505-805ef282796c";
$secretKey = 'sk_$2a$10$.pAIulTVtfbvYtVhGNxxy.A7stVJ0dkkGmoE9U.uhN8SlU6msitZ2';

# Configure the Environment
$config = ['endpoint' => Constants::$SANBOX_ENDPOINT];

# Authenticate
echo "- Authenticating to get token...\n";
$auth = new Auth($userID, $secretKey, $config);

$balance = $auth->getBalance();

print_r($balance);

// readline("Press enter to continue...");

// # Create a new rewards object
// echo "- Creating a new rewards object...\n";
// $a = new Rewards("louismidson@gmail.com", 45.0);
// print_r($a);

// readline("Press enter to continue...");

// # Send rewards by email
// echo "- Sending rewards by email...\n";
// $result = $a->withAuth($auth)->sendByEmail();
// print_r($result);

// readline("Press enter to continue...");

// # Create a new virtual prepaid Card Object
// echo "- Creating a new virtual prepaid Card Object...\n";
// $v= new VirtualPrepaidCard([
//     'email' => "exemple2@gmail.com",
//     'fullName' => "John Doe",
//     'amount' => 50.0,
//     'person' => 'prepaid',
//     'billingAddress' => [
//         'line1' => '123 Main St',
//         'city' => 'Anytown',
//         'state' => 'CA',
//         'country' => 'US',
//         'postal_code' => '90210'
//     ],
//     'isPhysical' => false
// ]);
// print_r($v);

// readline("Press enter to continue...");

// # Create a new virtual prepaid Card
// echo "- Creating a new virtual prepaid Card...\n";
// $result = $v->withAuth($auth)->create();
// print_r($result);


