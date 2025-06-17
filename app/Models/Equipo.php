<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_equipo';

    protected $fillable = [
        'id_modelo',
        'id_proveedor',
        'codigo_inventario',
        'codigo_barras',
        'numero_serie',
        'numero_factura',
        'fecha_compra',
        'fecha_garantia_inicio',
        'fecha_garantia_fin',
        'costo_adquisicion',
        'vida_util_anos',
        'especificaciones_adicionales',
        'observaciones',
        'estado_fisico',
        'estado_funcional',
        'ubicacion_fisica',
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_garantia_inicio' => 'date',
        'fecha_garantia_fin' => 'date',
        'costo_adquisicion' => 'decimal:2',
        'especificaciones_adicionales' => 'json',
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
    ];

    // Relaciones
    public function modelo()
    {
        return $this->belongsTo(ModeloEquipo::class, 'id_modelo');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionEquipo::class, 'id_equipo');
    }

    public function asignacionActiva()
    {
        return $this->hasOne(AsignacionEquipo::class, 'id_equipo')->where('estado', 'activa');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_equipo');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_equipo');
    }

    // Scopes
    public function scopeOperativos($query)
    {
        return $query->where('estado_funcional', 'operativo');
    }

    public function scopeDisponibles($query)
    {
        return $query->whereDoesntHave('asignacionActiva');
    }

    // Accessors
    public function getEstaAsignadoAttribute()
    {
        return $this->asignacionActiva()->exists();
    }

    public function getGarantiaVigentAttribute()
    {
        return $this->fecha_garantia_fin >= now();
    }
}
