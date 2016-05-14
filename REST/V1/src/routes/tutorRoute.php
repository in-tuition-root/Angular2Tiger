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

        $paramsArray = $request->getQueryParams();
        $tutorServices = new tutorServices();

        $filterParamsArray = array();

        //make array according to mongodb fields
        foreach($paramsArray as $key => $val){
            if($key == "location"){
                if(is_array($val)){
                    $array = array();
                    foreach($val as $geoPoint){
                        array_push($array,(float)$geoPoint);
                    }
                }
                $filterParamsArray["location"] = $array;
                continue;
            }
            if($key == "Subjects"){
                $filterParamsArray["tutor.teaches.Subjects"] = $val;
                continue;
            }
            if($key == "Classes"){
                $filterParamsArray["tutor.teaches.Class"] = $val;
                continue;
            }

            if(isNumericKey($key)){
                $filterParamsArray["tutor." . $key] = (int)$val;
                continue;
            }

            $filterParamsArray["tutor." . $key] = $val;
        }

        $tutors = $tutorServices->getTutors($filterParamsArray);
        if($tutors) {
            $output->tutors = $tutors;
            $output->result = true;
            $output->message = "Tutors Successfully retrieved.";
        }else{
            $output->result = false;
            $output->message = "Sorry, no tutor found that matches your selection criteria.";
        }
        $response->withJson($output);
    });

    $app->get('/tutavailability', function (Request $request, Response $response, $args) {
        $output = new stdClass();
        $tutorServices = new tutorServices();

        $data = $tutorServices->getAvailableTutorsPerClass_Subject();
        //var_dump($data);
        if($data){
            $output->data = $data;
            $output->result = true;
            $output->message = "Got tutors, per subject and class wise!!";
        }else{
            $output->message = "Data not found!!!";
            $output->result = false;
        }
        $response->withJson($output);
    });

    $app->get('/tut_class_sub', function (Request $request, Response $response, $args) {
        $output = new stdClass();
        $tutorServices = new tutorServices();
        $params = $request->getQueryParams();
        $tutors = $tutorServices->getTutorsByClass_Subject($params['class'], $params['subject'], $params['student_long'], $params['student_lat']);
        if ($tutors->count()) {
            $data = array();
            $i = 0;
            foreach ($tutors as $tutor) {
                $data[$i] = $tutor;
                $i = $i + 1;
            }
            $output->data = $data;
            $output->result = true;
        }else{
            $output->message = "Data not found!!!";
            $output->result = false;
        }
        $response->withJson($output);
    });
});