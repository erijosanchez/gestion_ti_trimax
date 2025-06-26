<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'id_tipo_notificacion',
        'id_usuario_destinatario',
        'id_usuario_origen',
        'titulo',
        'mensaje',
        'datos_adicionales',
        'fecha_leida',
        'fecha_enviada_email',
        'fecha_enviada_sms',
        'estado',
        'prioridad',
        'requiere_accion',
        'url_accion'
    ];

    protected $casts = [
        'datos_adicionales' => 'array',
        'fecha_creacion' => 'datetime',
        'fecha_leida' => 'datetime',
        'fecha_enviada_email' => 'datetime',
        'fecha_enviada_sms' => 'datetime',
        'requiere_accion' => 'boolean'
    ];

    // Relaciones
    public function tipoNotificacion()
    {
        return $this->belongsTo(TipoNotificacion::class, 'id_tipo_notificacion');
    }

    public function usuarioDestinatario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_destinatario');
    }

    public function usuarioOrigen()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_origen');
    }

    // Accessors
    public function getEstaLeidaAttribute()
    {
        return !is_null($this->fecha_leida);
    }

    // Scopes
    public function scopeNoLeidas($query)
    {
        return $query->whereNull('fecha_leida');
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where('id_usuario_destinatario', $userId);
    }

}
