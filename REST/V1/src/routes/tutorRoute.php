<?php
/**
 * Created by PhpStorm.
 * User: praverma
 * Date: 5/7/2016
 * Time: 9:54 AM
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../include/utility/utility.php';
require_once __DIR__ . '/../include/services/tutorServices.php';
$app->group('/tutorUtils', function () use ($app) {

    $app->get('/tutors', function (Request $request, Response $response, $args) {
        $output = new stdClass();

        $tutorServices = new tutorServices();
        $tutors = $tutorServices->getAllTutors();
        if ($tutors->count()) {
            $data = array();
            $i = 0;
            foreach ($tutors as $tutor) {
                $data[$i] = $tutor;
                $i = $i + 1;
            }
            $output->data = $data;
            $output->result = true;
        } else {
            $output->result = false;
            $output->message = "No tutors found!!";
        }
        $response->withJson($output);
    });
});