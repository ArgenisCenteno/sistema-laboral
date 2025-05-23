<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inasistencia extends Model
{
    use HasFactory;

    protected $table = 'inasistencias';

    protected $fillable = [
        'personal_id',
        'fecha',
        'motivo',
    ];

    protected $dates = [ 
         'fecha' => 'date',
        'created_at',
        'updated_at',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
