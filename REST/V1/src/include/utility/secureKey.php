<?php
/**
 * Created by PhpStorm.
 * User: praghav
 * Date: 5/5/2016
 * Time: 12:43 AM
 */

//$key = base64_encode(openssl_random_pseudo_bytes(64));

//echo $key;

require_once('../../../vendor/autoload.php');
include_once dirname(__FILE__) . '/../config/config.php';

use \Firebase\JWT\JWT;

$authData =  new stdClass();
$authData->name = "Pramod Kumar Raghav";
$authData->userid = "praghav";

$tokenId    = base64_encode(mcrypt_create_iv(32)); //Generating a random" secure enough" string for
$issuedAt   = time();
$notBefore  = $issuedAt + 10;  //Adding 10 seconds
$expire     = $notBefore + 86400; // Adding 86400 seconds i.e 24 hour/ 1 day
$serverName = SERVER_NAME;

/*
 * Create the token as an array
 */
$data = [
    'iat'  => $issuedAt,         // Issued at: time when the token was generated
    'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
    'iss'  => $serverName,       // Issuer
    'nbf'  => $notBefore,        // Not before
    'exp'  => $expire,           // Expire
    'data' => $authData          // user access level or auth data
];

header('Content-type: application/json');

/*
 * Extract the key, which is coming from the config file.
 *
 * Best suggestion is the key to be a binary string and
 * store it in encoded in a config file.
 *
 * Can be generated with base64_encode(openssl_random_pseudo_bytes(64)); like
 * K8ri9x3/mOx12psPHgRz+o9dTKeVhkE0ljd/q8o4I1AyU472t0suM381jDy/nWW7g2gBmyjv5DbaVAHQyYm/7A==
 *
 * keep it secure! You'll need the exact key to verify the
 * token later.
 */
$secretKey = base64_decode(MY_SECRET_KEY);

/*
 * Extract the algorithm from the config file too
 */
$algorithm = JWT_ALGORITHM;

/*
 * Encode the array to a JWT string.
 * Second parameter is the key to encode the token.
 *
 * The output string can be validated at http://jwt.io/
 */
$jwt = JWT::encode(
    $data,      //Data to be encoded in the JWT
    $secretKey, // The signing key
    $algorithm  // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
);

$unencodedArray = ['jwt' => $jwt];
echo json_encode($unencodedArray);