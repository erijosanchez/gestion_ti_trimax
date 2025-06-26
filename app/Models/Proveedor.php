<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';

    protected $fillable = [
        'nombre_proveedor',
        'ruc',
        'direccion',
        'telefono',
        'email',
        'contacto_principal',
        'telefono_contacto',
        'email_contacto',
        'condiciones_pago',
        'calificacion',
        'estado'
    ];

    protected $casts = [
        'calificacion' => 'decimal:2',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_proveedor');
    }

}
