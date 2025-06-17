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

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
    ];

    public function sedes()
    {
        return $this->hasMany(Sede::class, 'id_empresa');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activo');
    }
}
