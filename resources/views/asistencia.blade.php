<script src="https://unpkg.com/html5-qrcode"></script>

<div class="mb-3 text-start">
    <label for="metodo-registro" class="form-label fw-semibold">¿Cómo desea registrar?</label>
    <select id="metodo-registro" class="form-select">
        <option value="">-- Selecciona --</option>
        <option value="qr">Código QR</option>
        <option value="cedula">Cédula</option>
    </select>
</div>

<div class="mb-3 text-start" id="contenedor-tipo-registro" style="display:none;">
    <label for="tipo-registro" class="form-label fw-semibold">Selecciona el tipo de registro:</label>
    <select id="tipo-registro" class="form-select">
        <option value="">-- Selecciona --</option>
        <option value="entrada">Entrada</option>
        <option value="salida">Salida</option>
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
        <input type="text" id="cedula-input" class="form-control" maxlength="8" placeholder="Número de cédula" />
        <button id="btn-registrar-cedula" class="btn btn-primary" disabled>Registrar</button>
    </div>
    <div id="cedula-feedback" class="invalid-feedback"></div>
</div>

<!-- Resultados -->
<div id="resultado-positivo" class="mt-3 text-success fw-bold"></div>
<div id="resultado-negativo" class="mt-3 text-danger fw-bold"></div>
<div id="personal" class="mt-3 text-black fw-bold"></div>

<script>
    const beep = new Audio('/sounds/beep.mp3');

    let metodoRegistroSeleccionado = '';
    let tipoRegistroSeleccionado = '';
    let escaneado = false;

    const html5QrCode = new Html5Qrcode("reader");

    const selectMetodoRegistro = document.getElementById('metodo-registro');
    const contenedorTipoRegistro = document.getElementById('contenedor-tipo-registro');
    const selectTipoRegistro = document.getElementById('tipo-registro');
    const seccionQr = document.getElementById('seccion-qr');
    const seccionCedula = document.getElementById('seccion-cedula');
    const btnRegistrarCedula = document.getElementById('btn-registrar-cedula');
    const inputCedula = document.getElementById('cedula-input');
    const selectTipoCedula = document.getElementById('tipo-cedula');
    const feedbackCedula = document.getElementById('cedula-feedback');

    // Al cambiar método (QR o Cédula)
    selectMetodoRegistro.addEventListener('change', () => {
        metodoRegistroSeleccionado = selectMetodoRegistro.value;
        tipoRegistroSeleccionado = '';
        selectTipoRegistro.value = '';

        // Reset resultados y campos
        limpiarResultados();
        inputCedula.value = '';
        btnRegistrarCedula.disabled = true;
        feedbackCedula.textContent = '';
        inputCedula.classList.remove('is-invalid');

        contenedorTipoRegistro.style.display = metodoRegistroSeleccionado ? 'block' : 'none';

        if (metodoRegistroSeleccionado === 'qr') {
            seccionQr.style.display = 'block';
            seccionCedula.style.display = 'none';
        } else if (metodoRegistroSeleccionado === 'cedula') {
            seccionQr.style.display = 'none';
            seccionCedula.style.display = 'block';
            detenerCamara();
        } else {
            seccionQr.style.display = 'none';
            seccionCedula.style.display = 'none';
            detenerCamara();
        }
    });

    // Al cambiar tipo de registro (entrada/salida)
    selectTipoRegistro.addEventListener('change', () => {
        tipoRegistroSeleccionado = selectTipoRegistro.value;
        limpiarResultados();

        if (metodoRegistroSeleccionado === 'qr' && tipoRegistroSeleccionado) {
            iniciarCamara();
        } else if (metodoRegistroSeleccionado === 'qr') {
            detenerCamara();
        }
    });

    // Validar cédula y habilitar botón
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

    // Botón para registrar cédula
    btnRegistrarCedula.addEventListener('click', () => {
        if (!validarCedulaInput()) return;

        if (!tipoRegistroSeleccionado) {
            alert('Por favor selecciona el tipo de registro (entrada o salida).');
            return;
        }

        const cedulaCompleta = selectTipoCedula.value + inputCedula.value.trim();

        registrarAsistencia(cedulaCompleta, tipoRegistroSeleccionado);
    });

    // Función para limpiar mensajes resultado
    function limpiarResultados() {
        document.getElementById('resultado-positivo').innerText = '';
        document.getElementById('resultado-negativo').innerText = '';
        document.getElementById('personal').innerText = '';
    }

    // Registrar asistencia: se usa para QR y cédula
    function registrarAsistencia(codigo, tipo) {
        beep.play();

        fetch("{{ route('registro.asistencia') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ qr_code: codigo, tipo: tipo })
        })
            .then(response => response.json())
            .then(data => {
                limpiarResultados();

                if (data.success === true) {
                    document.getElementById('resultado-positivo').innerText = data.message;
                } else {
                    document.getElementById('resultado-negativo').innerText = data.message;
                }

                if (data.personal) {
                    let personal = data.personal.nombre + " " + data.personal.apellido + " " + data.personal.cedula;
                    document.getElementById('personal').innerText = personal;
                }

                // Reset y detener escáner si está activo
                if (metodoRegistroSeleccionado === 'qr') {
                    detenerCamara();
                }

                // Reset inputs
                inputCedula.value = '';
                btnRegistrarCedula.disabled = true;
                selectTipoCedula.value = 'V-';
                selectTipoRegistro.value = '';
                tipoRegistroSeleccionado = '';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Iniciar cámara para QR
    function iniciarCamara() {
        if (!tipoRegistroSeleccionado) return;

        escaneado = false;

        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            (decodedText) => {
                if (escaneado) return;

                escaneado = true;

                registrarAsistencia(decodedText, tipoRegistroSeleccionado);
            },
            (errorMessage) => {
                // No hacer nada
            }
        ).catch(err => {
            console.error("No se pudo iniciar la cámara", err);
        });
    }

    // Detener cámara
    function detenerCamara() {
        html5QrCode.stop().catch(() => { });
        seccionQr.style.display = 'none';
    }
</script>
