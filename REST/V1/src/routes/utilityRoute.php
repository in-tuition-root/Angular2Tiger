<?php
/**
 * Created by PhpStorm.
 * User: praghav
 * Date: 5/5/2016
 * Time: 1:54 PM
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../include/utility/utility.php';
require_once __DIR__ . '/../include/utility/authenticateMiddleware.php';
require_once __DIR__ . '/../include/services/usersAdminService.php';
require_once __DIR__ . '/../include/services/authServices.php';

include __DIR__ . '/../model/UserProfile.php';

/**
 * ----------- METHODS WITHOUT AUTHENTICATION ---------------------------------
 */
$app->group('/utils', function () use ($app) {

    /**
     * API to get the current date
     */

    $app->get('/date', function (Request $request, Response $response, $args) {
        $output = new stdClass();

        $output->result = true;
        $output->current_date = date('Y-m-d H:i:s');
        $response->withJson($output);
        return $response;
    });


    /**
     * API to get the current time
     */

    $app->get('/time', function (Request $request, Response $response, $args) {
        $output = new stdClass();

        $output->result = true;
        $output->current_time = time();
        $response->withJson($output);
        return $response;
    });

    /**
     * API to login
     */

    $app->get('/mobile_login', function (Request $request, Response $response, $args) {
        $this->logger->info("In-Tuition '/mobile_login' route");

        $item = new stdClass();
        $output = new stdClass();

        $item->mobileNumber = $request->getHeaderLine('Mobile-Number');

        // Let create the mobileAuth object
        $authServices = new authServices();

        $result = $authServices->getUserByMobile($item);
        $item->_id = $result['_id'];
        $item->authData = $result['authData'];
        // Let generate the new JWT token
        $output->jwt = generateNewToken($item);
        $output->result = true;
        $output->message = "Login successfully.";
        $response->withJson($output);
        return $response;
    })->add( new authenticateMiddleware());


    /**
     * API to register new user.
     *  First we have to create user document in user collection and then create new mobileAuth document
     *  Second generate the token and return this token.
     * @param string mobileNumber
     * @param Username
     * @param Password
     * @return token (JWT)
     */
    $app->post('/register', function (Request $request, Response $response, $args) {

        $this->logger->info("In-Tuition '/register' route");

        $item = new stdClass();

        $parsedBody = $request->getParsedBody();

        // get the mobile number and password form header parameters

        $item->mobileNumber = $request->getHeaderLine('Mobile-Number');

        // Let decrypt the basic authorization
        $basicAuthorization = $request->getHeaderLine('Authorization');
        $authorization = explode(" ", $basicAuthorization);

        $encryptedAuthorization = $authorization[1];

        $usernamePassword = explode(":", base64_decode ($encryptedAuthorization)); // username:password

        $item->name = $usernamePassword[0];
        $item->password = $usernamePassword[1];

        // Let validating required parameters
        $output = verifyRequiredParams(array('mobileNumber', 'name', 'password'),$item);

        if($output->result){
            // Required parameters got successfully let now create new user

            // First we have to create user document in user collection
            // Second we have to create new mobileAuth document
            $usersAdminService = new usersAdminService();

            //Is user exits
            $result = $usersAdminService->isUserExists($item);

            if($result){
                // user already exits.
                $output->result = false;
                $output->message = "User already exists....";
                $response->withStatus(100); //Continue
            }else{
                //Let map the parsedBody with User model
                $userProfileModel = new \InTution\lib\Models\UserProfile();

                foreach($userProfileModel as $var => $value) {
                    if(isset($parsedBody[$var])){
                        $item->$var = $parsedBody[$var];
                    }
                }
                // Now create the new user
                $result = $usersAdminService->createUsers($item);
                if($result){
                    // New user document created successfully its time to create new mobileAuth document for this user
                    $authService = new authServices();

                    $result = $authService->createMobileAuth($item);
                    if($result){
                        $data = new stdClass();
                        $user = $authService->getUserByMobile($item);
                        $data->_id = $user['_id'];
                        $data->authData = $user['authData'];
                        //wow great we have successfully create user and mobileAuth its time to generate token
                        $output->jwt = generateNewToken($data);

                        $output->result = true;
                        $output->message = "User created successfully.";
                        $response->withStatus(201); // Created
                    }else{
                        // Oh no mobile auth creation failed. We have to delete the user document from the user collection
                        $usersAdminService->deleteUser($item);

                        $output->result = false;
                        $output->message = "Failed to create mobile Auth.";
                        $response->withStatus(201); // Created
                    }
                }else{
                    $output->result = false;
                    $output->message = "Oops! An error occurred while user registration.";
                    $response->withStatus(202); // The request has been accepted for processing, but the processing has not been completed
                }

            }
		}

		$response->withJson($output);
		return $response;
	});


    /**
     * API to send sms
     */
	$app->post('/sendsms', function (Request $request, Response $response, $args) {
		$output = new stdClass();
		$body = new stdClass();
		
		$parsedBody = $request->getParsedBody();
		$body->mobileNumber = $parsedBody['mobileNumber'];
		$body->message = $parsedBody['message'];
	
		// Validating required parameters
		$output = verifyRequiredParams(array('mobileNumber', 'message'),$body);
	
		if($output->result){
			sendVerificationCode($body);
		}

		
        $response->withJson($output);
		return $response;
    });
});