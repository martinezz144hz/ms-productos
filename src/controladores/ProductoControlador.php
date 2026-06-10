<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../modelos/Producto.php';

class ProductoControlador {

     //enlistar los productos
   
    public function listar(Request $request, Response $response): Response {
        $productos = Producto::all();

        return $this->respuesta($response, $productos->toArray(), 200);
    }

    //crear un producto
    
    public function crear(Request $request, Response $response): Response {
        $datos = $request->getParsedBody();

        $nombre      = $datos['nombre']      ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $precio      = $datos['precio']      ?? '';
        $categoria   = $datos['categoria']   ?? '';
        $disponible  = $datos['disponible']  ?? 1;

        if (empty($nombre) || empty($precio) || empty($categoria)) {
            return $this->respuesta($response, [
                'message' => 'Nombre, precio y categoría son requeridos.'
            ], 400);
        }

        $producto = Producto::create([
            'nombre'      => $nombre,
            'descripcion' => $descripcion,
            'precio'      => $precio,
            'categoria'   => $categoria,
            'disponible'  => $disponible,
        ]);

        return $this->respuesta($response, [
            'message'  => 'Producto creado correctamente.',
            'producto' => $producto->toArray()
        ], 201);
    }

    // editar el producto

    public function editar(Request $request, Response $response, array $args): Response {
        $id    = $args['id'];
        $datos = $request->getParsedBody();

        $producto = Producto::find($id);

        if (!$producto) {
            return $this->respuesta($response, [
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        $producto->nombre      = $datos['nombre']      ?? $producto->nombre;
        $producto->descripcion = $datos['descripcion'] ?? $producto->descripcion;
        $producto->precio      = $datos['precio']      ?? $producto->precio;
        $producto->categoria   = $datos['categoria']   ?? $producto->categoria;
        $producto->disponible  = $datos['disponible']  ?? $producto->disponible;
        $producto->save();

        return $this->respuesta($response, [
            'message'  => 'Producto actualizado correctamente.',
            'producto' => $producto->toArray()
        ], 200);
    }

   //eliminar producto

    public function eliminar(Request $request, Response $response, array $args): Response {
        $id       = $args['id'];
        $producto = Producto::find($id);

        if (!$producto) {
            return $this->respuesta($response, [
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        $producto->delete();

        return $this->respuesta($response, [
            'message' => 'Producto eliminado correctamente.'
        ], 200);
    }

   // respuesta de json

    private function respuesta(Response $response, array $datos, int $codigo): Response {
        $response->getBody()->write(json_encode($datos));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($codigo);
    }
}

