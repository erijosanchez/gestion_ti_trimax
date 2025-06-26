<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'tipos_documentos';
    protected $primaryKey = 'id_tipo_documento';

    protected $fillable = [
        'nombre_tipo',
        'descripcion',
        'template_html',
        'requiere_firma_digital',
        'vigencia_dias',
        'estado'
    ];

    protected $casts = [
        'requiere_firma_digital' => 'boolean',
        'fecha_creacion' => 'datetime'
    ];

    // Relaciones
    public function cargosDocumentos()
    {
        return $this->hasMany(CargoDocumento::class, 'id_tipo_documento');
    }

}
