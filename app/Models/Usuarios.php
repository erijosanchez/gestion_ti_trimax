<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuarios extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'id_departamento',
        'id_rol',
        'codigo_empleado',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'username',
        'password',
        'cargo',
        'fecha_ingreso',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_ingreso' => 'date',
        'ultimo_acceso' => 'datetime',
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
    ];

    // Relaciones
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionEquipo::class, 'id_usuario_asignado');
    }

    public function ticketsCreados()
    {
        return $this->hasMany(Ticket::class, 'id_usuario_solicitante');
    }

    public function ticketsAsignados()
    {
        return $this->hasMany(Ticket::class, 'id_tecnico_asignado');
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    // Scope para usuarios activos
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
