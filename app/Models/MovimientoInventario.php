<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = [
        'id_equipo',
        'id_usuario',
        'tipo_movimiento',
        'ubicacion_origen',
        'ubicacion_destino',
        'id_usuario_origen',
        'id_usuario_destino',
        'motivo',
        'observaciones',
        'documento_respaldo',
        'costo_movimiento'
    ];

    protected $casts = [
        'costo_movimiento' => 'decimal:2',
        'fecha_movimiento' => 'datetime'
    ];

    // Relaciones
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }

    public function usuarioOrigen()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_origen');
    }

    public function usuarioDestino()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_destino');
    }
}
