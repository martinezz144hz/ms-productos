<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/controladores/ProductoControlador.php';
require __DIR__ . '/middleware/AuthMiddleware.php';

$productoControlador = new ProductoControlador();
$authMiddleware      = new AuthMiddleware();

// ============================================
// RUTAS DE PRODUCTOS
// ============================================

// GET /productos — listar todos los productos
$app->get('/productos', function (Request $request, Response $response) use ($productoControlador) {
    return $productoControlador->listar($request, $response);
})->add($authMiddleware);

// POST /productos — crear producto
$app->post('/productos', function (Request $request, Response $response) use ($productoControlador) {
    return $productoControlador->crear($request, $response);
})->add($authMiddleware);

// PUT /productos/{id} — editar producto
$app->put('/productos/{id}', function (Request $request, Response $response, array $args) use ($productoControlador) {
    return $productoControlador->editar($request, $response, $args);
})->add($authMiddleware);

// DELETE /productos/{id} — eliminar producto
$app->delete('/productos/{id}', function (Request $request, Response $response, array $args) use ($productoControlador) {
    return $productoControlador->eliminar($request, $response, $args);
})->add($authMiddleware);