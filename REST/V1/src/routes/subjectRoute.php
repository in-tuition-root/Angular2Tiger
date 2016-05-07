<?php
/**
 * Created by PhpStorm.
 * User: nejindal
 * Date: 5/6/2016
 * Time: 10:39 PM
 */

/**
 * Created by PhpStorm.
 * User: praghav
 * Date: 5/5/2016
 * Time: 1:54 PM
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../include/utility/utility.php';
require_once __DIR__ . '/../include/services/subjectServices.php';
require_once __DIR__ . '/../include/utility/jwtAuthenticateMiddleware.php';

$app->get('/subjects', function (Request $request, Response $response, $args) {

    var_dump("successfully executed");
    $output = new stdClass();
    
    $this->logger->info("In-Tuition '/subjects' route");

        $subjectService = new subjectServices();
        $result = $subjectService->getSubjects();
        if($result){
            $output->result = true;
            $output->message = "Successfully retrieved all the subjects";
            $output->subjects = $result;
        }else{
        $output->result = false;
        $output->message = "Error in retrieving subjects";
        }

    $response->withJson($output);
    return $response;
});

$app->post('/subjects', function (Request $request, Response $response, $args) {

    var_dump("successfully executed");
    $item = new stdClass();
    $output = new stdClass();

    $this->logger->info("In-Tuition '/subjects' route");

        $item->newSubject = $request->getParam('newSubject');
        $item->classNames = $request->getParam('classNames');

        $subjectService = new subjectServices();
        $isSubjectExists = $subjectService->getSubjectByName($item->newSubject);
        if($isSubjectExists){
            $output->result = false;
            $output->message = "Subject Already Exists";
        }else{
            $result = $subjectService->addSubject($item);
            if($result){
                $output->result = true;
                $output->message = "New Subject is successfully added";
            }else{
                $output->result = false;
                $output->message = "Error in Creating new subject";
            }
        }

    $response->withJson($output);
    return $response;
});