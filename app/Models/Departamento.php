<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';

    protected $fillable = [
        'id_sede',
        'nombre_departamento',
        'codigo_departamento',
        'descripcion',
        'jefe_departamento',
        'presupuesto_tecnologia',
        'estado'
    ];

    protected $casts = [
        'presupuesto_tecnologia' => 'decimal:2',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'id_departamento');
    }

}
