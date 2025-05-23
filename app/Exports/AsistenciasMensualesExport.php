<?php

namespace App\Exports;

use App\Models\RegistroAsistencia;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsistenciasMensualesExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        $datos = RegistroAsistencia::selectRaw('MONTH(fecha) as mes, COUNT(*) as total')
            ->groupByRaw('MONTH(fecha)')
            ->orderByRaw('MONTH(fecha)')
            ->pluck('total', 'mes')
            ->toArray();

        // Convertir a array con nombres de meses
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $resultado = [];

        foreach ($datos as $mes => $total) {
            $resultado[] = [
                'mes' => $meses[$mes] ?? 'Desconocido',
                'total_asistencias' => $total,
            ];
        }

        return $resultado;
    }

    public function headings(): array
    {
        return ['Mes', 'Total de Asistencias'];
    }
}
