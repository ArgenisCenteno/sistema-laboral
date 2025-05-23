<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HorarioLaboral extends Model
{
    use HasFactory;

    protected $table = 'horarios_laborales';

    protected $fillable = [
        'nombre',
        'hora_entrada',
        'hora_salida',
    ];

}
