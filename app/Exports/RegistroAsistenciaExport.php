<?php
namespace App\Exports;

use App\Models\RegistroAsistencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistroAsistenciaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return RegistroAsistencia::with('personal')
            ->whereBetween('fecha', [$this->from, $this->to])
            ->get();
    }

    public function map($row): array
    {
        return [
            str_pad($row->id, 6, '0', STR_PAD_LEFT),
            $row->fecha->format('d'),
            $row->fecha->format('m'),
            $row->fecha->format('Y'),
            optional($row->hora_entrada)->format('H:i'),
            optional($row->hora_salida)->format('H:i'),
            $row->horas_trabajadas,
            $row->horas_extras ?? 0,
            $row->horas_tarde ?? 0,
            $row->personal->nombre . ' ' . $row->personal->apellido,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Día',
            'Mes',
            'Año',
            'Hora Entrada',
            'Hora Salida',
            'Horas Trabajadas',
            'Horas Extras',
            'Horas Tarde',
            'Empleado',
        ];
    }
}
