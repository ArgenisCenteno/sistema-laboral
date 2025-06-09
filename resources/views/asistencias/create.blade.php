@extends('layouts.app')
@section('content')

    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Registrar Asistencia</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">


                        </ol>
                    </div>



                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->
            <div class="card pt-3 container d-flex justify-content-center w-50"> <!--begin::Row-->
                <script src="https://unpkg.com/html5-qrcode"></script>

                <div class="mb-3 text-start">
                    <label for="metodo-registro" class="form-label fw-semibold">¿Cómo desea registrar?</label>
                    <select id="metodo-registro" class="form-select">
                        <option value="">-- Selecciona --</option>
                        <option value="qr">Código QR</option>
                        <option value="cedula">Cédula</option>
                    </select>
                </div>

                <!-- Sección para QR -->
                <div id="seccion-qr" style="display:none;">
                    <div id="reader" class="mt-3 mx-auto" style="width: 300px;"></div>
                </div>

                <!-- Sección para Cédula -->
                <div id="seccion-cedula" style="display:none;" class="mt-4">
                    <label for="cedula-input" class="form-label fw-semibold">Ingrese su cédula:</label>
                    <div class="input-group">
                        <select id="tipo-cedula" class="form-select" style="max-width: 80px;">
                            <option value="V-">V-</option>
                            <option value="E-">E-</option>
                        </select>
                        <input type="text" id="cedula-input" class="form-control" maxlength="8"
                            placeholder="Número de cédula" />
                        <button id="btn-registrar-cedula" class="btn btn-primary" disabled>Registrar</button>
                    </div>
                    <div id="cedula-feedback" class="invalid-feedback"></div>
                </div>

                <!-- Resultados -->
                <div id="resultado-positivo" class="mt-3 text-success fw-bold text-center"></div>
                <div id="resultado-negativo" class="mt-3 text-danger fw-bold text-center"></div>
                <div id="personal" class="mt-3 text-black fw-bold text-center pb-4"></div>

            </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->


    @include('layouts.script')
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script>
        const beep = new Audio('/sounds/beep.mp3');
        const html5QrCode = new Html5Qrcode("reader");

        let escaneado = false;
        let escaneando = false; // NUEVO
        const selectMetodoRegistro = document.getElementById('metodo-registro');
        const seccionQr = document.getElementById('seccion-qr');
        const seccionCedula = document.getElementById('seccion-cedula');
        const btnRegistrarCedula = document.getElementById('btn-registrar-cedula');
        const inputCedula = document.getElementById('cedula-input');
        const selectTipoCedula = document.getElementById('tipo-cedula');
        const feedbackCedula = document.getElementById('cedula-feedback');

        // Cambiar método de registro
        selectMetodoRegistro.addEventListener('change', () => {
            const metodo = selectMetodoRegistro.value;
            limpiarResultados();
            detenerCamara();

            inputCedula.value = '';
            btnRegistrarCedula.disabled = true;
            inputCedula.classList.remove('is-invalid');

            if (metodo === 'qr') {
                seccionQr.style.display = 'block';
                seccionCedula.style.display = 'none';
                iniciarCamara();
            } else if (metodo === 'cedula') {
                seccionQr.style.display = 'none';
                seccionCedula.style.display = 'block';
            } else {
                seccionQr.style.display = 'none';
                seccionCedula.style.display = 'none';
            }
        });

        // Validación de cédula
        function validarCedulaInput() {
            const numero = inputCedula.value.trim();
            const regex = /^[0-9]{7,8}$/;

            if (!regex.test(numero)) {
                inputCedula.classList.add('is-invalid');
                feedbackCedula.textContent = 'Debe ingresar 7 u 8 dígitos numéricos.';
                btnRegistrarCedula.disabled = true;
                return false;
            } else {
                inputCedula.classList.remove('is-invalid');
                feedbackCedula.textContent = '';
                btnRegistrarCedula.disabled = false;
                return true;
            }
        }

        inputCedula.addEventListener('input', validarCedulaInput);
        selectTipoCedula.addEventListener('change', validarCedulaInput);

        // Botón registrar por cédula
        btnRegistrarCedula.addEventListener('click', () => {
            if (!validarCedulaInput()) return;

            const cedulaCompleta = selectTipoCedula.value + inputCedula.value.trim();
            registrarAsistenciaAuto(cedulaCompleta);
        });

        // Escanear QR automáticamente
        function iniciarCamara() {
            escaneado = false;
            escaneando = true;

            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: 250 },
                (decodedText) => {
                    if (escaneado) return;
                    escaneado = true;
                    registrarAsistenciaAuto(decodedText);
                },
                () => { }
            ).catch(err => {
                console.error("No se pudo iniciar la cámara", err);
                escaneando = false;
            });
        }

        function detenerCamara() {
            if (!escaneando) return;

            html5QrCode.stop()
                .then(() => {
                    escaneando = false;
                    seccionQr.style.display = 'none';
                })
                .catch((err) => {
                    console.warn("No se pudo detener la cámara (probablemente no estaba activa):", err);
                });
        }

        function limpiarResultados() {
            document.getElementById('resultado-positivo').innerText = '';
            document.getElementById('resultado-negativo').innerText = '';
            document.getElementById('personal').innerText = '';
        }

        function mostrarPersonal(personal) {
            document.getElementById('personal').innerText =
                personal.nombre + " " + personal.apellido + " " + personal.cedula;
        }

        // Registro automático
        function registrarAsistenciaAuto(codigo) {
            beep.play();
            limpiarResultados();

            fetch("{{ route('registro.asistencia') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_code: codigo })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('resultado-positivo').innerText = data.message;
                    } else {
                        if (data.tipo === 'motivo') {
                            const motivo = prompt("Salida antes de la hora permitida. Indica el motivo:");
                            if (motivo) {
                                fetch("{{ route('registro.asistencia') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({ qr_code: codigo, motivo: motivo })
                                })
                                    .then(res => res.json())
                                    .then(data2 => {
                                        if (data2.success) {
                                            document.getElementById('resultado-positivo').innerText = data2.message;
                                        } else {
                                            document.getElementById('resultado-negativo').innerText = data2.message;
                                        }
                                        if (data2.personal) mostrarPersonal(data2.personal);
                                    });
                            }
                        } else {
                            document.getElementById('resultado-negativo').innerText = data.message;
                        }
                    }

                    if (data.personal) mostrarPersonal(data.personal);
                    detenerCamara();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
    <script>
        const cedulaInput = document.getElementById('cedula-input');

        cedulaInput.addEventListener('keypress', function (e) {
            // Permitir solo teclas 0-9
            if (!/^\d$/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Además, evitamos que se peguen letras (por si hacen Ctrl+V)
        cedulaInput.addEventListener('paste', function (e) {
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            if (!/^\d+$/.test(paste)) {
                e.preventDefault();
            }
        });
    </script>
@endsection