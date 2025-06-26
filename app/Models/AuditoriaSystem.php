<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditoriaSystem extends Model
{
    use HasFactory;

    protected $table = 'auditoria_sistema';
    protected $primaryKey = 'id_auditoria';

    protected $fillable = [
        'id_usuario',
        'tabla_afectada',
        'registro_afectado',
        'accion',
        'valores_anteriores',
        'valores_nuevos',
        'ip_usuario',
        'user_agent'
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_nuevos' => 'array',
        'fecha_accion' => 'datetime'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }

}
