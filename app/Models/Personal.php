<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'rif',
        'telefono',
        'email',
        'direccion',
        'qr_code',
        'departamento_id',
    ];

    // Relación con Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function horariosLaborales()
    {
        return $this->belongsToMany(HorarioLaboral::class, 'horario_laboral_personal')

            ->withTimestamps();
    }

    public function asistencias(){
        return $this->hasMany(RegistroAsistencia::class, 'personal_id');
    }

     public function inasistencias(){
        return $this->hasMany(Inasistencia::class, 'personal_id');
    }


}
