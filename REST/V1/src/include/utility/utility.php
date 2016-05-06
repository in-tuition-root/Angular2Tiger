<?php

use \Firebase\JWT\JWT;

/**
 * @author Pramod Kumar Raghav
 *
 */


	/**
	 * Verifying required params posted or not
	 * @param hash $required_fields
	 * @param hash $request_params
	 *
	 * @return  object $output
	 */

	function verifyRequiredParams($required_fields,$request_params) {
		$output = new stdClass();
		$output->result = true;
		
		$result_fields = "";
		foreach ($required_fields as $field) {
			if (!isset($request_params->$field)) {
				$output->result  = false;
				$result_fields .= $field . ', ';
			}
		}

		if (!$output->result) {
			// Required field(s) are missing or empty
			// echo error json and stop the app
			$output = new stdClass();
			$output->result = false;
			$output->message = 'Required field(s) ' . substr($result_fields, 0, -2) . ' is missing or empty';
		}
		
		return $output;
	}

	/**
	 * Send the newly generated verification code to appropriate  (mobile or email) destination
	 *
	 */
	function sendVerificationCode($item) {
		// Replace with your username
		$user = "praghav";

		// Replace with your API KEY (We have sent API KEY on activation email, also available on panel)
		$apikey = "k6HTDE4mouTFIZL6pX7J";

		// Replace if you have your own Sender ID, else do not change
		$senderid  =  "DEMO";

		// Replace with the destination mobile Number to which you want to send sms
		$mobile  =  $item->mobile;

		// Replace with your Message content
		$message   =  $item->message;

		// For Plain Text, use "txt" ; for Unicode symbols or regional Languages like hindi/tamil/kannada use "uni"
		$type   =  "txt";

		$message = urlencode($message);
		$sendsms = "http://smshorizon.co.in/api/sendsms.php?user=" . $user
				. "&apikey=" . $apikey
				. "&mobile=" . $mobile
				. "&message=" . $message
				. "&type=" . $type
				. "&senderid=". $senderid
				;

		$ch = curl_init($sendsms);


		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$msgid = curl_exec($ch);

		sleep (1);

		$ch = curl_init("http://smshorizon.co.in/api/status.php?user=".$user."&apikey=".$apikey."&msgid=".$msgid);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);

		curl_close($ch);

		return TRUE;
	}

	function generateNewToken($item){
                
        $tokenId    = base64_encode(mcrypt_create_iv(32)); //Generating a random" secure enough" string for
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;  //Adding 10 seconds
        $expire     = $notBefore + 30; // Adding 86400 seconds i.e 24 hour/ 1 day
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
            'data' => $item          // user access level or auth data
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
        $secretKey = MY_SECRET_KEY;

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
        
        return $jwt;
    }


	/**
	 * Encrypting password
	 * @param password
	 * @returns salt and encrypted password
	 */
	function hashSSHA($password) {

		$salt = sha1(rand());
		$salt = substr($salt, 0, 10);
		$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
		$hash = array("salt" => $salt, "encrypted" => $encrypted);
		return $hash;
	}

	/**
	 * Decrypting password
	 * @param salt, password
	 * @returns hash string
	 */
	function checkhashSSHA($salt, $password) {

		$hash = base64_encode(sha1($password . $salt, true) . $salt);

		return $hash;
	}