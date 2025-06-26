<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
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
        'observaciones_internas'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_asignacion' => 'datetime',
        'fecha_primera_respuesta' => 'datetime',
        'fecha_resolucion' => 'datetime',
        'fecha_cierre' => 'datetime',
        'costo_reparacion' => 'decimal:2',
        'requiere_compra' => 'boolean'
    ];

    // Relaciones
    public function usuarioSolicitante()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_solicitante');
    }

    public function categoriaTicket()
    {
        return $this->belongsTo(CategoriaTicket::class, 'id_categoria_ticket');
    }

    public function estadoTicket()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_ticket');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function tecnicoAsignado()
    {
        return $this->belongsTo(Usuarios::class, 'id_tecnico_asignado');
    }

    public function historial()
    {
        return $this->hasMany(HistorialTicket::class, 'id_ticket');
    }

    // Accessors
    public function getEstaVencidoAttribute()
    {
        if (!$this->categoriaTicket) return false;

        $slaHoras = $this->categoriaTicket->sla_horas;
        $fechaLimite = $this->fecha_creacion->addHours($slaHoras);

        return now()->isAfter($fechaLimite) && !$this->estadoTicket->es_estado_final;
    }

    public function getTiempoRestanteSlaAttribute()
    {
        if (!$this->categoriaTicket) return null;

        $slaHoras = $this->categoriaTicket->sla_horas;
        $fechaLimite = $this->fecha_creacion->addHours($slaHoras);

        return $fechaLimite->diffForHumans();
    }

    // Generar número de ticket automáticamente
    public static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (!$ticket->numero_ticket) {
                $ticket->numero_ticket = 'TK-' . date('Y') . '-' . str_pad(
                    static::whereYear('fecha_creacion', date('Y'))->count() + 1,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }
}
