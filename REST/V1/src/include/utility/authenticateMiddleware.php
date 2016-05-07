<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/authServices.php';
require_once __DIR__ . '/../services/usersAdminService.php';
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

        $item->IsMobile = $request->getHeaderLine('Is-Mobile');
        $userAdminService = new usersAdminService();
        if($item->IsMobile == 'true'){
            $item->mobileNumber = $request->getHeaderLine('User-id');
            $user = $userAdminService->getUserByMobile($item);
        }else{
            $item->email = $request->getHeaderLine('User-id');
            $user = $userAdminService->getUserByEmail($item);
        }
        if($user){
            $item->_id = $user['_id']->{'$id'};
            // Let decrypt the basic authorization
            $basicAuthorization = $request->getHeaderLine('Authorization');
            $authorization = explode(" ", $basicAuthorization);

            $encryptedAuthorization = $authorization[1];

            $usernamePassword = explode(":", base64_decode ($encryptedAuthorization)); // username:password

            $item->name = $usernamePassword[0];
            $item->password = $usernamePassword[1];

            // Let create the mobileAuth object
            $authServices = new authServices();
            $output = $authServices->isThisValidUser($item);

            if($output['result']){
                $response = $next($request, $response);
            }else{
                $response->withStatus(401); // Unauthorized
            }
        }
        return $response;
    }	
 }