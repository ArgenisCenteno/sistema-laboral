<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HorarioLaboralPersonal extends Model
{
    use HasFactory;

    protected $table = 'horario_laboral_personal';

    protected $fillable = [
        'personal_id',
        'horario_laboral_id',
        'desde',
        'hasta',
    ];

    protected $dates = [
        'desde',
        'hasta',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function horarioLaboral()
    {
        return $this->belongsTo(HorarioLaboral::class);
    }
}
