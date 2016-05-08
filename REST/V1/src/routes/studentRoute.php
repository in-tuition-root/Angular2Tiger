<?php
/**
 * Created by PhpStorm.
 * User: praverma
 * Date: 5/8/2016
 * Time: 8:41 AM
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../include/utility/utility.php';
require_once __DIR__ . '/../include/services/studentServices.php';
$app->group('/studentUtils', function () use ($app) {
    $app->get('/trendingsub', function (Request $request, Response $response, $args) {
        $output = new stdClass();

        $studentServices = new studentServices();
        $data = $studentServices->getTrendingSubjectsPerClass_Subject();

        if ($data) {
            $output->data = $data;
            $output->result = true;
            $output->message = "Got trending subjects, class wise!!";
        } else {
            $output->result = false;
            $output->message = "No tutors found!!";
        }
        $response->withJson($output);
    });
});