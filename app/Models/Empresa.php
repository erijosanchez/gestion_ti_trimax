<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'id_empresa';
    public $timestamps = true;

    protected $fillable = [
        'nombre_empresa',
        'ruc',
        'direccion',
        'telefono',
        'email',
        'estado',
    ];
}
