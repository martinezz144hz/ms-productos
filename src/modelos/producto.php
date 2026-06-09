<?php

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {

    // Nombre de la tabla en la BD
    protected $table = 'productos';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'categoria',
        'disponible',
    ];
}