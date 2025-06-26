<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoNotificacion extends Model
{
    use HasFactory;

    protected $table = 'tipos_notificaciones';
    protected $primaryKey = 'id_tipo_notificacion';

    protected $fillable = [
        'nombre_tipo',
        'descripcion',
        'template_email',
        'template_sms',
        'es_sistema',
        'requiere_confirmacion',
        'estado'
    ];

    protected $casts = [
        'es_sistema' => 'boolean',
        'requiere_confirmacion' => 'boolean',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_tipo_notificacion');
    }

}
