<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();

// ✅ Middleware para parsear JSON del cuerpo
$app->addBodyParsingMiddleware();

// ✅ Middleware para habilitar CORS
$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*') // Puedes restringir a una IP si quieres
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// ✅ Manejar preflight (OPTIONS) antes de las peticiones reales
$app->options('/{routes:.+}', function (Request $request, Response $response) {
    return $response;
});

// Ruta JSON-RPC principal
$app->post('/rpc', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    $method = $body['method'] ?? '';
    $id = $body['id'] ?? null;

    if ($method === 'createEmployee') {
        require_once __DIR__ . '/../rpc/createEmployee.php';
        return handleCreateEmployee($body, $response);
    }

    $response->getBody()->write(json_encode([
        'jsonrpc' => '2.0',
        'error' => ['code' => -32601, 'message' => 'Method not found'],
        'id' => $id
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();