<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'nombre_empresa',
        'ruc',
        'direccion',
        'telefono',
        'email',
        'estado'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime'
    ];

    // Relaciones
    public function sedes()
    {
        return $this->hasMany(Sede::class, 'id_empresa');
    }
}
