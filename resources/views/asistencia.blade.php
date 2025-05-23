<script src="https://unpkg.com/html5-qrcode"></script>
<div class="mb-3 text-start">
    <label for="tipo-registro" class="form-label fw-semibold">Selecciona el tipo de registro:</label>
    <select id="tipo-registro" class="form-select">
        <option value="">-- Selecciona --</option>
        <option value="entrada">Entrada</option>
        <option value="salida">Salida</option>
    </select>
</div>

<div id="reader" class="mt-3 mx-auto" style="width: 300px; display: none;"></div>
<div id="resultado-positivo" class="mt-3 text-success fw-bold"></div>
<div id="resultado-negativo" class="mt-3 text-danger fw-bold"></div>
<div id="personal" class="mt-3 text-black fw-bold"></div>
<script>
    const beep = new Audio('/sounds/beep.mp3');

    let tipoRegistroSeleccionado = '';
    
    const html5QrCode = new Html5Qrcode("reader");

    document.getElementById('tipo-registro').addEventListener('change', function () {
        tipoRegistroSeleccionado = this.value;

        if (tipoRegistroSeleccionado) {
            document.getElementById('reader').style.display = 'block';
            iniciarCamara();
        } else {
            html5QrCode.stop().then(() => {
                document.getElementById('reader').style.display = 'none';
            }).catch(() => { });
        }
    });

    function registrarAsistencia(qr_code, tipo) {
        beep.play();
        fetch("{{ route('registro.asistencia') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ qr_code, tipo })
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('personal').innerText = '';
                document.getElementById('resultado-negativo').innerText = '';
                document.getElementById('resultado-positivo').innerText = '';
               
                if (data.success == true) {
                    document.getElementById('resultado-positivo').innerText = data.message;
                } else {
                    document.getElementById('resultado-negativo').innerText = data.message;
                }

                if (data.personal) {
                    let personal = data.personal.nombre + " " + data.personal.apellido + " " + data.personal.cedula
                    document.getElementById('personal').innerText = personal;
                }
                // detener escáner después de un registro
                document.getElementById('reader').style.display = 'none';
                document.getElementById('tipo-registro').value = "";
                 html5QrCode.stop();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

   let escaneado = false;

function iniciarCamara() {
    escaneado = false; // reiniciamos el flag al iniciar

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: 250
        },
        (decodedText) => {
            if (escaneado) return; // si ya se escaneó, no hagas nada

            escaneado = true; // marcamos que ya se escaneó
            html5QrCode.stop().then(() => {
                document.getElementById('reader').style.display = 'none';
                document.getElementById('tipo-registro').value = "";
            }).catch(err => {
                console.error("Error al detener el escáner", err);
            });

            registrarAsistencia(decodedText, tipoRegistroSeleccionado);
        },
        (errorMessage) => {
            // silencioso
        }
    ).catch(err => {
        console.error("No se pudo iniciar la cámara", err);
    });
}

</script>