<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/controladores/ProductoControlador.php';
require __DIR__ . '/middleware/AuthMiddleware.php';

$productoControlador = new ProductoControlador();
$authMiddleware      = new AuthMiddleware();

// rutas de los productos

$app->get('/productos', function (Request $request, Response $response) use ($productoControlador) {
    return $productoControlador->listar($request, $response);
})->add($authMiddleware);

$app->post('/productos', function (Request $request, Response $response) use ($productoControlador) {
    return $productoControlador->crear($request, $response);
})->add($authMiddleware);

$app->put('/productos/{id}', function (Request $request, Response $response, array $args) use ($productoControlador) {
    return $productoControlador->editar($request, $response, $args);
})->add($authMiddleware);

$app->delete('/productos/{id}', function (Request $request, Response $response, array $args) use ($productoControlador) {
    return $productoControlador->eliminar($request, $response, $args);
})->add($authMiddleware);

//endopint verificar que el servicio este activo
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode([
        'servicio' => 'ms-productos',
        'estado'   => 'activo',
        'puerto'   => 3030
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});