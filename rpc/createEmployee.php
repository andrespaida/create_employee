<?php

require_once __DIR__ . '/../core/DbConnection.php';
require_once __DIR__ . '/../core/EmployeeRepository.php';

use Psr\Http\Message\ResponseInterface as Response;

function handleCreateEmployee(array $request, Response $response): Response {
    $params = $request['params'] ?? [];
    $id = $request['id'] ?? null;

    $required = ['name', 'email', 'phone', 'position', 'hireDate', 'salary'];

    foreach ($required as $field) {
        if (empty($params[$field])) {
            return writeJson($response, [
                'jsonrpc' => '2.0',
                'error' => ['code' => -32602, 'message' => "Missing field: $field"],
                'id' => $id
            ]);
        }
    }

    $success = EmployeeRepository::create($params);

    if ($success) {
        return writeJson($response, [
            'jsonrpc' => '2.0',
            'result' => 'Employee created successfully',
            'id' => $id
        ]);
    } else {
        return writeJson($response, [
            'jsonrpc' => '2.0',
            'error' => ['code' => -32000, 'message' => 'Database error'],
            'id' => $id
        ]);
    }
}

function writeJson(Response $res, array $data): Response {
    $res->getBody()->write(json_encode($data));
    return $res->withHeader('Content-Type', 'application/json');
}