<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sede extends Model
{
    use HasFactory;

    protected $table = 'sedes';
    protected $primaryKey = 'id_sede';

    protected $fillable = [
        'id_empresa',
        'nombre_sede',
        'codigo_sede',
        'direccion',
        'telefono',
        'email',
        'responsable_sede',
        'estado'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'id_sede');
    }
}
