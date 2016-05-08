<?php
/*
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

    $item->_id = $request->getHeaderLine('User-id');
    $userAdminService = new usersAdminService();

    $user = $userAdminService->getUserByID($item);

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

    $item->_id = $request->getHeaderLine('User-id');
    $userAdminService->updateUsers($item,$parsedBody);
});