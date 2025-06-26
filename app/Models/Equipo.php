<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';
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
        'ubicacion_fisica'
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_garantia_inicio' => 'date',
        'fecha_garantia_fin' => 'date',
        'costo_adquisicion' => 'decimal:2',
        'especificaciones_adicionales' => 'array',
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime'
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

    // Accessors
    public function getEstaEnGarantiaAttribute()
    {
        return $this->fecha_garantia_fin && $this->fecha_garantia_fin->isFuture();
    }

    public function getValorDepreciadoAttribute()
    {
        if (!$this->costo_adquisicion || !$this->fecha_compra) {
            return 0;
        }

        $antiguedad = $this->fecha_compra->diffInYears(now());
        $depreciacion = ($this->costo_adquisicion / $this->vida_util_anos) * $antiguedad;
        
        return max(0, $this->costo_adquisicion - $depreciacion);
    }

}
