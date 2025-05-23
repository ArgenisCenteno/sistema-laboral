@extends('layouts.layout-auth')

@section('content')
    <section class="vh-100 d-flex align-items-center justify-content-center bg-light"
        style="background: url('iconos/banner.jpeg') no-repeat center center/cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="card shadow rounded-4 p-4 text-center">
                        <div class="card-body">

                            <div class="mb-4">
                                <i class="fas fa-qrcode fa-2x mb-2 text-primary"></i>
                                <h4 class="fw-bold">DATOS DEL PERSONAL</h4>
                            </div>

                            <button id="btn-iniciar" class="btn btn-primary mb-3">Iniciar escáner</button>

                            <div id="reader" style="width: 300px; display: none;" class="mx-auto mb-4"></div>

                            <div id="form-datos" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">Nombre</label>
                                        <input type="text" id="nombre" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">Apellido</label>
                                        <input type="text" id="apellido" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">Cédula</label>
                                        <input type="text" id="cedula" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">RIF</label>
                                        <input type="text" id="rif" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="text" id="email" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">Teléfono</label>
                                        <input type="text" id="telefono" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">Dirección</label>
                                        <input type="text" id="direccion" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label fw-semibold">Departamento</label>
                                        <input type="text" id="departamento" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <a href="#" id="btnReporte" class="btn btn-info" target="_blank">Reporte</a>
                                    </div>

                                </div>
                            </div>

                            <div id="resultado-negativo" class="text-danger fw-bold mt-2"></div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <audio id="beep-sound" src="{{ asset('sounds/beep.mp3') }}"></audio>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");

        function reproducirBeep() {
            const beep = document.getElementById('beep-sound');
            beep.play();
        }

        function mostrarDatos(personal) {
            document.getElementById('nombre').value = personal.nombre;
            document.getElementById('apellido').value = personal.apellido;
            document.getElementById('cedula').value = personal.cedula;
            document.getElementById('rif').value = personal.rif;
            document.getElementById('email').value = personal.email;
            document.getElementById('direccion').value = personal.direccion;
            document.getElementById('departamento').value = personal.departamento.nombre;
            document.getElementById('telefono').value = personal.telefono;
            document.getElementById('form-datos').style.display = 'block';

            let urlReporte = `/pdfReporte/${personal.id}`;

    // Asignar el enlace al botón
    document.getElementById('btnReporte').href = urlReporte;
        }

        function escanearQR() {
            document.getElementById('reader').style.display = 'block';

            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText) => {
                    registrarPersonal(decodedText);
                },
                (errorMessage) => {
                    // silencioso
                }
            ).catch(err => {
                console.error("No se pudo iniciar la cámara", err);
            });
        }

        function registrarPersonal(qr_code) {
            fetch("{{ route('personal-datos') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_code: qr_code })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.personal) {
                        reproducirBeep();
                        mostrarDatos(data.personal);
                        html5QrCode.stop();
                    } else {
                        document.getElementById('resultado-negativo').innerText = data.message || 'QR inválido.';
                    }
                })
                .catch(err => {
                    console.error(err);
                });
        }

        // Escuchar clic en el botón "Iniciar escáner"
        document.getElementById('btn-iniciar').addEventListener('click', escanearQR);
    </script>
@endsection