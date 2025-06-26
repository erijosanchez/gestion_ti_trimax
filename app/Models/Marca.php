<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marca extends Model
{
     use HasFactory;

    protected $table = 'marcas';
    protected $primaryKey = 'id_marca';

    protected $fillable = [
        'nombre_marca',
        'sitio_web',
        'soporte_telefono',
        'soporte_email',
        'estado'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function modelos()
    {
        return $this->hasMany(ModeloEquipo::class, 'id_marca');
    }

}
