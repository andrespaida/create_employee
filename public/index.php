<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();

// ✅ Importante: permite parsear JSON del cuerpo
$app->addBodyParsingMiddleware();

// Ruta JSON-RPC principal
$app->post('/rpc', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    $method = $body['method'] ?? '';
    $id = $body['id'] ?? null;

    if ($method === 'createEmployee') {
        require_once __DIR__ . '/../rpc/createEmployee.php';
        return handleCreateEmployee($body, $response);
    }

    // Si el método no es válido
    $response->getBody()->write(json_encode([
        'jsonrpc' => '2.0',
        'error' => ['code' => -32601, 'message' => 'Method not found'],
        'id' => $id
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();