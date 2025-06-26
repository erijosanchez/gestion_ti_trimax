<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CargoDocumento extends Model
{
    use HasFactory;

    protected $table = 'cargos_documentos';
    protected $primaryKey = 'id_cargo';

    protected $fillable = [
        'id_asignacion',
        'id_tipo_documento',
        'numero_cargo',
        'contenido_html',
        'contenido_pdf',
        'hash_documento',
        'fecha_firma_empleado',
        'fecha_firma_responsable',
        'ip_firma_empleado',
        'ip_firma_responsable',
        'firma_digital_empleado',
        'firma_digital_responsable',
        'estado_documento',
        'observaciones'
    ];

    protected $casts = [
        'fecha_generacion' => 'datetime',
        'fecha_firma_empleado' => 'datetime',
        'fecha_firma_responsable' => 'datetime'
    ];

    // Relaciones
    public function asignacion()
    {
        return $this->belongsTo(AsignacionEquipo::class, 'id_asignacion');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento');
    }

    // Accessors
    public function getEstaCompletamenteFirmadoAttribute()
    {
        return $this->estado_documento === 'firmado_completo';
    }

    public function getRequiereFirmaEmpleadoAttribute()
    {
        return in_array($this->estado_documento, ['generado', 'firmado_empleado']);
    }

}
