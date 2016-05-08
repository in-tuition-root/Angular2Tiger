<?php

require __DIR__ . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../src/include/config/config.php';
require_once __DIR__ . '/../src/include/utility/indexCreation.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
/**
$app = new \Slim\App();

$app->add(new \Slim\Middleware\JwtAuthentication([
    "path" => ["/api", "/admin"],
    "passthrough" => ["/api/token", "/admin/ping"],
    "secret" => "supersecretkeyyoushouldnotcommittogithub"
]));
$app->add(new \Slim\Middleware\JwtAuthentication([
"secret" => "supersecretkeyyoushouldnotcommittogithub",
"callback" => function ($request, $response, $arguments) use ($container) {
$container["jwt"] = $arguments["decoded"];
}
]));
**/
$container = $app->getContainer();
$container["jwt"] = function ($container) {
    return new StdClass;
};

$indexCreation = new indexCreation();
$indexCreation->createIndexOnCollection('temp',array('loc' => '2dsphere'));

$app->add(new \Slim\Middleware\JwtAuthentication([
    "path" => "/",
    "secure" => false,
    "passthrough" => ["/utils", "/api", "/user" ,"/tutorUtils", "/studentUtils"],
    "secret" => MY_SECRET_KEY
]));

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
