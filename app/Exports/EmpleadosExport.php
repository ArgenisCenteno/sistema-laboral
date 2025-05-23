<?php
namespace App\Exports;

use App\Models\Personal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpleadosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Personal::with('departamento')->get()->map(function ($empleado) {
            return [
                'Nombre'        => $empleado->nombre,
                'Apellido'      => $empleado->apellido,
                'RIF'           => $empleado->rif,
                'Dirección'     => $empleado->direccion,
                'Departamento'  => $empleado->departamento->nombre ?? 'No definido',
                'Fecha Registro'=> $empleado->created_at->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'RIF',
            'Dirección',
            'Departamento',
            'Fecha Registro',
        ];
    }
}
