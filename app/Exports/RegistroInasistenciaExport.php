<?php
namespace App\Exports;

use App\Models\Inasistencia;
use App\Models\RegistroAsistencia;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistroInasistenciaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        return Inasistencia::with('personal')
            ->whereBetween('fecha', [$this->from, $this->to])
            ->get();
    }

    public function map($row): array
    {
       // dd($row->fecha);
        return [

            str_pad($row->id, 6, '0', STR_PAD_LEFT),
            Carbon::parse($row->fecha)->format('d')
            ,
            Carbon::parse($row->fecha)->format('m'),
            Carbon::parse($row->fecha)->format('Y'),


            $row->motivo ?? '',
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
            'Motivo',
            'Empleado',
        ];
    }
}
