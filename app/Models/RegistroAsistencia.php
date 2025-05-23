<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistroAsistencia extends Model
{
    use HasFactory;

    protected $table = 'registro_asistencias';

    protected $fillable = [
        'personal_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'horas_trabajadas',
        'observacion',
        'horas_extras',
        'horas_tarde',
        'minutos_tarde'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_entrada' => 'datetime:H:i',
        'hora_salida' => 'datetime:H:i',
    ];

    /**
     * Relación con el modelo Personal
     */
    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
