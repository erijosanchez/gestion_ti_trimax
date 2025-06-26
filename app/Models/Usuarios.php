<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use HasFactory;

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
        'password_hash',
        'cargo',
        'fecha_ingreso',
        'estado'
    ];

    protected $hidden = [
        'password_hash'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'ultimo_acceso' => 'datetime',
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime'
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

    public function asignacionesRecibidas()
    {
        return $this->hasMany(AsignacionEquipo::class, 'id_usuario_asignado');
    }

    public function asignacionesRealizadas()
    {
        return $this->hasMany(AsignacionEquipo::class, 'id_usuario_asigna');
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
}
