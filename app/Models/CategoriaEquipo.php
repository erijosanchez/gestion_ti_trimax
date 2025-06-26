<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaEquipo extends Model
{
    use HasFactory;

    protected $table = 'categorias_equipos';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre_categoria',
        'descripcion',
        'icono',
        'estado'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function modelos()
    {
        return $this->hasMany(ModeloEquipo::class, 'id_categoria');
    }

}
