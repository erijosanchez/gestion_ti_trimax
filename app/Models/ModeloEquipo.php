<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModeloEquipo extends Model
{
    use HasFactory;

    protected $table = 'modelos_equipos';
    protected $primaryKey = 'id_modelo';

    protected $fillable = [
        'id_categoria',
        'id_marca',
        'nombre_modelo',
        'especificaciones',
        'garantia_meses',
        'precio_referencial',
        'estado'
    ];

    protected $casts = [
        'especificaciones' => 'array',
        'precio_referencial' => 'decimal:2',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(CategoriaEquipo::class, 'id_categoria');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_modelo');
    }

}
