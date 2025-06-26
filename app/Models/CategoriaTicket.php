<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaTicket extends Model
{
    use HasFactory;

    protected $table = 'categorias_tickets';
    protected $primaryKey = 'id_categoria_ticket';

    protected $fillable = [
        'nombre_categoria',
        'descripcion',
        'sla_horas',
        'prioridad_default',
        'requiere_aprobacion',
        'color_hex',
        'estado'
    ];

    protected $casts = [
        'requiere_aprobacion' => 'boolean',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_categoria_ticket');
    }

}
