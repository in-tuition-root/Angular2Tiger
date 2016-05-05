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

    $item->mobileNumber = $request->getHeaderLine('Mobile-Number');

    // Let create the mobileAuth object
    $mobileAuthService = new mobileAuthService();

    $result = $mobileAuthService->getUserByMobile($item);

    if($result){
        $output->user =  $result;
        $output->result = true;
    }else{
        $output->result = false;
        $output->message = "User does not exists";
    }
    $response->withJson($output);
    return $response;
});