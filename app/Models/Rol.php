<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_rol';

    protected $fillable = [
        'nombre_rol',
        'descripcion',
        'permisos',
        'estado'
    ];

    protected $casts = [
        'permisos' => 'array',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'id_rol');
    }

}
