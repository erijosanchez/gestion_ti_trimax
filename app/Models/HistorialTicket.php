<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialTicket extends Model
{
    use HasFactory;

    protected $table = 'historial_tickets';
    protected $primaryKey = 'id_historial';

    protected $fillable = [
        'id_ticket',
        'id_usuario',
        'id_estado_anterior',
        'id_estado_nuevo',
        'accion',
        'comentario',
        'tiempo_invertido_minutos',
        'es_publico',
        'adjuntos'
    ];

    protected $casts = [
        'es_publico' => 'boolean',
        'adjuntos' => 'array',
        'fecha_accion' => 'datetime'
    ];

    // Relaciones
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }

    public function estadoAnterior()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_anterior');
    }

    public function estadoNuevo()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_nuevo');
    }

}
