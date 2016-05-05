<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/mobileAuthService.php';
/**
 * @author Pramod Kumar Raghav
 *
 */

 class authenticateMiddleware 
 {
	/**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
		$item = new stdClass();
		
		$item->mobileNumber = $request->getHeaderLine('Mobile-Number');
		// Let decrypt the basic authorization
		$basicAuthorization = $request->getHeaderLine('Authorization');
		$authorization = explode(" ", $basicAuthorization);

		$encryptedAuthorization = $authorization[1];

		$usernamePassword = explode(":", base64_decode ($encryptedAuthorization)); // username:password

		$item->name = $usernamePassword[0];
		$item->password = $usernamePassword[1];

        // Let create the mobileAuth object
        $mobileAuthService = new mobileAuthService();
        $output = $mobileAuthService->isThisValidUser($item);

        if($output['result']){
            $response = $next($request, $response);
        }else{
            $response->withStatus(401); // Unauthorized
        }
		return $response;
    }	
 }