<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstadoAsignacion extends Model
{
    use HasFactory;

    protected $table = 'estados_asignacion';
    protected $primaryKey = 'id_estado_asignacion';

    protected $fillable = [
        'nombre_estado',
        'descripcion',
        'requiere_cargo',
        'permite_reasignacion',
        'color_hex'
    ];

    protected $casts = [
        'requiere_cargo' => 'boolean',
        'permite_reasignacion' => 'boolean',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function asignaciones()
    {
        return $this->hasMany(AsignacionEquipo::class, 'id_estado_asignacion');
    }
}
