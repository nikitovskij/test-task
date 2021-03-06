<?php

namespace App;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

use DI\Container;
use Slim\Factory\AppFactory;
use App\Controller\CompanyController;
use App\Controller\JsonController;

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../src/views');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$app->get('/', CompanyController::class . ':index');
$app->post('/company', CompanyController::class . ':getCompany');
$app->get('/json/{ico}', JsonController::class . ':renderJson');

$app->run();
