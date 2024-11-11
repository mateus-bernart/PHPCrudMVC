<?php

declare(strict_types=1);

use Alura\Mvc\Controller\Controller;
use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);
$videoRepository = new VideoRepository($pdo);

$routes = require __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";

//verifica se a rota existe, senão retorna erro 404.
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    
    /** @var Controller */
    $controller = new $controllerClass($videoRepository);  
}else{
    $controller = new Error404Controller();
}

/** @var Controller $controller */
$controller->processaRequisicao();
