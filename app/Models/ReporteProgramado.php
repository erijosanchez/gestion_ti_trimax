<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReporteProgramado extends Model
{
    use HasFactory;

    protected $table = 'reportes_programados';
    protected $primaryKey = 'id_reporte';

    protected $fillable = [
        'nombre_reporte',
        'descripcion',
        'query_sql',
        'parametros',
        'formato_salida',
        'frecuencia',
        'dia_ejecucion',
        'hora_ejecucion',
        'usuarios_destinatarios',
        'ultimo_ejecutado',
        'proximo_ejecutar',
        'estado',
        'creado_por'
    ];

    protected $casts = [
        'parametros' => 'array',
        'usuarios_destinatarios' => 'array',
        'ultimo_ejecutado' => 'datetime',
        'proximo_ejecutar' => 'datetime',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function creador()
    {
        return $this->belongsTo(Usuarios::class, 'creado_por');
    }

}
