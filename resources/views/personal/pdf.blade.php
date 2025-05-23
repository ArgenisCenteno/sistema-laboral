<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Personal</title>
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

        <h1 class="text-center"><strong>REGISTRO DE PERSONAL</strong></h1>
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

    </div>

    {{-- Espacio para firma u otros elementos --}}
    <div style="margin-top: 50px;"></div>

    {{-- CÉDULA RECORTABLE --}}
    <div style="width: 100%; text-align: center; margin-top: 30px;">
        <table style="margin: 0 auto; border: 2px dashed #333; padding: 10px;">
            <tbody>
                <tr>
                    <!-- Datos a la izquierda -->
                    <td style="padding: 10px; text-align: left;">
                        <p style="padding: 10px; text-align: center;"><strong>CÉDULA DE PERSONAL</strong></p>
                        <p><strong>NOMBRE:</strong> {{ $personal->nombre }} {{ $personal->apellido }}</p>
                        <p><strong>RIF:</strong> {{ $personal->rif }}</p>
                        <p><strong>DEPARTAMENTO:</strong> {{ $personal->departamento->nombre ?? 'No definido' }}</p>
                    </td>

                    <!-- Espaciado opcional -->
                    <td style="width: 30px;"></td>

                    <!-- QR a la derecha -->
                    <td style="padding: 10px;">
                        <img src="data:image/svg+xml;base64,{{ base64_encode($valorQr) }}" width="120" alt="Código QR">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Línea de recorte -->
        <div style="margin-top: 10px; border-top: 1px dashed #000; width: 80%; margin-left: auto; margin-right: auto;">
            <p style="font-size: 0.75rem; margin-top: 5px;">Recortar por aquí</p>
        </div>
    </div>







</body>

</html>