<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Personal</title>
    <link rel="stylesheet" href="{{ public_path('css/pdfAENE.css') }}">
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">
    <style>
        .cedula {
            border: 2px dashed #333;
            padding: 10px;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            font-size: 12px;
        }


        .qr {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    {{-- Encabezado institucional --}}
    <header class="text-center mb-4">
        <br>
        <br>
        <strong>
            <p style="margin: 0; font-size: 0.7rem;">REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
            <p style="margin: 0; font-size: 0.7rem;">ESTADO MONAGAS</p>
            <p style="margin: 0; font-size: 0.7rem;">MUNICIPIO EZEQUIEL ZAMORA</p>
            <p style="margin: 0; font-size: 0.7rem;">PUNTA DE MATA</p>
        </strong>
    </header>

    <div class="container">

        <h1 class="text-center"><strong>REPORTE DE PERSONAL</strong></h1>
        <br>
        <br>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px;">
            <tbody>
                <tr>
                    <td style="border: 1px solid #333; padding: 8px;"><strong>NOMBRE COMPLETO:</strong></td>
                    <td style="border: 1px solid #333; padding: 8px;"><strong>RIF:</strong></td>

                </tr>
                <tr>
                    <td style="border: 1px solid #333; padding: 8px;">{{ $personal->nombre }} {{ $personal->apellido }}
                    </td>
                    <td style="border: 1px solid #333; padding: 8px;">{{ $personal->rif }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #333; padding: 8px;"><strong>DIRECCIÓN:</strong></td>
                    <td style="border: 1px solid #333; padding: 8px;"><strong>DEPARTAMENTO:</strong></td>

                </tr>
                <tr>
                    <td style="border: 1px solid #333; padding: 8px;">{{ $personal->direccion }}</td>
                    <td style="border: 1px solid #333; padding: 8px;">
                        {{ $personal->departamento->nombre ?? 'No definido' }}
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #333; padding: 8px;"><strong>CÓDIGO DE CONTROL:</strong></td>
                    <td style="border: 1px solid #333; padding: 8px;"><strong>FECHA DE REGISTRO:</strong></td>


                </tr>
                <tr>
                    <td style="border: 1px solid #333; padding: 8px;">{{ str_pad($personal->id, 6, '0', STR_PAD_LEFT) }}
                    </td>
                    <td style="border: 1px solid #333; padding: 8px;">{{ $personal->created_at->format('d/m/Y') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Tabla de Asistencias --}}
        <h3 class="text-center mt-5"><strong>ASISTENCIAS</strong></h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #333; padding: 5px;">ID</th>
                    <th style="border: 1px solid #333; padding: 5px;">DÍA</th>
                    <th style="border: 1px solid #333; padding: 5px;">MES</th>
                    <th style="border: 1px solid #333; padding: 5px;">AÑO</th>
                    <th style="border: 1px solid #333; padding: 5px;">ENTRADA / SALIDA</th>
                    <th style="border: 1px solid #333; padding: 5px;">HORAS EXTRAS</th>
                    <th style="border: 1px solid #333; padding: 5px;">HORAS TRABAJADAS</th>
                    <th style="border: 1px solid #333; padding: 5px;">HORAS TARDE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_extras = 0;
                    $total_trabajadas = 0;
                    $total_tarde = 0;
                @endphp
                @foreach ($personal->asistencias as $index => $asistencia)
                    <tr>
                        <td style="border: 1px solid #333; padding: 5px;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="border: 1px solid #333; padding: 5px;">
                            {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d') }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">
                            {{ \Carbon\Carbon::parse($asistencia->fecha)->format('m') }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">
                            {{ \Carbon\Carbon::parse($asistencia->fecha)->format('Y') }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">{{ $asistencia->hora_entrada }} /
                            {{ $asistencia->hora_salida }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">{{ $asistencia->horas_extras }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">{{ $asistencia->horas_trabajadas }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">{{ $asistencia->horas_tarde }}</td>
                    </tr>
                    @php
                        $total_extras += $asistencia->horas_extras;
                        $total_trabajadas += $asistencia->horas_trabajadas;
                        $total_tarde += $asistencia->horas_tarde;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5" style="border: 1px solid #333; padding: 5px; text-align: right;">
                        <strong>TOTALES</strong></td>
                    <td style="border: 1px solid #333; padding: 5px;"><strong>{{ $total_extras }}</strong></td>
                    <td style="border: 1px solid #333; padding: 5px;"><strong>{{ $total_trabajadas }}</strong></td>
                    <td style="border: 1px solid #333; padding: 5px;"><strong>{{ $total_tarde }}</strong></td>
                </tr>
            </tbody>
        </table>

        {{-- Tabla de Inasistencias --}}
        <h3 class="text-center mt-5"><strong>INASISTENCIAS</strong></h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #333; padding: 5px;">ID</th>
                    <th style="border: 1px solid #333; padding: 5px;">DÍA</th>
                    <th style="border: 1px solid #333; padding: 5px;">MES</th>
                    <th style="border: 1px solid #333; padding: 5px;">AÑO</th>
                    <th style="border: 1px solid #333; padding: 5px;">MOTIVO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($personal->inasistencias as $index => $inasistencia)
                    <tr>
                        <td style="border: 1px solid #333; padding: 5px;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="border: 1px solid #333; padding: 5px;">
                            {{ \Carbon\Carbon::parse($inasistencia->fecha)->format('d') }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">
                            {{ \Carbon\Carbon::parse($inasistencia->fecha)->format('m') }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">
                            {{ \Carbon\Carbon::parse($inasistencia->fecha)->format('Y') }}</td>
                        <td style="border: 1px solid #333; padding: 5px;">{{ $inasistencia->motivo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>








</body>

</html>