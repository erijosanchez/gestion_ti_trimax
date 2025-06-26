<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstadoTicket extends Model
{
    use HasFactory;

    protected $table = 'estados_tickets';
    protected $primaryKey = 'id_estado_ticket';

    protected $fillable = [
        'nombre_estado',
        'descripcion',
        'es_estado_inicial',
        'es_estado_final',
        'requiere_solucion',
        'color_hex',
        'orden_flujo'
    ];

    protected $casts = [
        'es_estado_inicial' => 'boolean',
        'es_estado_final' => 'boolean',
        'requiere_solucion' => 'boolean',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_estado_ticket');
    }

    public function historialTickets()
    {
        return $this->hasMany(HistorialTicket::class, 'id_estado_nuevo');
    }

}
