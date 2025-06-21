<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Usuarios;
use App\Models\Equipo;
use App\Models\EstadoAsignacion;
use App\Models\CargoDocumento;

class AsignacionEquipo extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_equipos';
    protected $primaryKey = 'id_asignacion';

    protected $fillable = [
        'id_equipo',
        'id_usuario_asignado',
        'id_usuario_asigna',
        'id_estado_asignacion',
        'fecha_devolucion_programada',
        'fecha_devolucion_real',
        'motivo_asignacion',
        'observaciones_asignacion',
        'ubicacion_asignacion',
        'cargo_firmado',
        'estado'
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_devolucion_programada' => 'date',
        'fecha_devolucion_real' => 'datetime',
        'cargo_firmado' => 'boolean'
    ];

    // Relaciones
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function usuarioAsignado()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_asignado');
    }

    public function usuarioAsigna()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_asigna');
    }

    public function estadoAsignacion()
    {
        return $this->belongsTo(EstadoAsignacion::class, 'id_estado_asignacion');
    }

    public function cargosDocumentos()
    {
        return $this->hasMany(CargoDocumento::class, 'id_asignacion');
    }

    // Accessors
    public function getEstaVencidaAttribute()
    {
        return $this->fecha_devolucion_programada &&
            $this->fecha_devolucion_programada->isPast() &&
            $this->estado === 'activa';
    }

    public function getDiasVencimientoAttribute()
    {
        if (!$this->fecha_devolucion_programada) return null;

        return now()->diffInDays($this->fecha_devolucion_programada, false);
    }
}
