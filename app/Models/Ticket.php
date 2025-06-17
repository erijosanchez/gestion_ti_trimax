<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ticket';

    protected $fillable = [
        'numero_ticket',
        'id_usuario_solicitante',
        'id_categoria_ticket',
        'id_estado_ticket',
        'id_equipo',
        'id_tecnico_asignado',
        'titulo',
        'descripcion',
        'prioridad',
        'fecha_asignacion',
        'fecha_primera_respuesta',
        'fecha_resolucion',
        'fecha_cierre',
        'tiempo_respuesta_minutos',
        'tiempo_resolucion_minutos',
        'satisfaccion_usuario',
        'comentario_satisfaccion',
        'solucion',
        'causa_raiz',
        'costo_reparacion',
        'requiere_compra',
        'observaciones_internas',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_asignacion' => 'datetime',
        'fecha_primera_respuesta' => 'datetime',
        'fecha_resolucion' => 'datetime',
        'fecha_cierre' => 'datetime',
        'costo_reparacion' => 'decimal:2',
        'requiere_compra' => 'boolean',
    ];

    // Relaciones
    public function solicitante()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_solicitante', 'id_usuario');
    }

    public function tecnico()
    {
        return $this->belongsTo(Usuarios::class, 'id_tecnico_asignado', 'id_usuario');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaTicket::class, 'id_categoria_ticket');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_ticket');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function historial()
    {
        return $this->hasMany(HistorialTicket::class, 'id_ticket');
    }

    // Scopes
    public function scopeAbiertos($query)
    {
        return $query->whereHas('estado', function($q) {
            $q->where('es_estado_final', false);
        });
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeAsignadosA($query, $userId)
    {
        return $query->where('id_tecnico_asignado', $userId);
    }

    // Accessors
    public function getEstaAbiertoAttribute()
    {
        return !$this->estado->es_estado_final;
    }

    public function getTiempoTranscurridoAttribute()
    {
        return $this->fecha_creacion->diffInMinutes(now());
    }
}
