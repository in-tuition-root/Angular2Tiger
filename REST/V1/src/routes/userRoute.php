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
require_once __DIR__ . '/../include/services/usersAdminService.php';

$app->get('/user', function (Request $request, Response $response, $args) {
    $item = new stdClass();
    $output = new stdClass();

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
        $output->data =  $user;
        $output->result = true;
    }else{
        $output->result = false;
        $output->message = "User does not exists";
    }
    $response->withJson($output);
    return $response;
});

$app->put('/user', function (Request $request, Response $response, $args) {
    $item = new stdClass();
    $userAdminService = new usersAdminService();

    $parsedBody = $request->getParsedBody();
    $item->IsMobile = $request->getHeaderLine('Is-Mobile');

    if($item->IsMobile == 'true'){
        $item->mobileNumber = $request->getHeaderLine('User-id');
        $user = $userAdminService->getUserByMobile($item);
    }else{
        $item->email = $request->getHeaderLine('User-id');
        $user = $userAdminService->getUserByEmail($item);
    }

    $item->_id=$user['_id'];
    $userAdminService->updateUsers($item,$parsedBody);
});