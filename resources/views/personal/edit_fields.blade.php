<form action="{{ route('personal.update', $personal->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $personal->nombre) }}"
                class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $personal->apellido) }}"
                class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="cedula">Cédula</label>
            <input type="text" name="cedula" id="cedula" value="{{ old('cedula', $personal->cedula) }}"
                class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="rif">RIF</label>
            <input type="text" name="rif" id="rif" value="{{ old('rif', $personal->rif) }}" class="form-control"
                required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $personal->telefono) }}"
                class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $personal->email) }}"
                class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <label for="direccion">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3"
                class="form-control">{{ old('direccion', $personal->direccion) }}</textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label for="departamento_id">Departamento</label>
            <select name="departamento_id" id="departamento_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}" {{ $personal->departamento_id == $departamento->id ? 'selected' : '' }}>
                        {{ $departamento->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="horario_laboral_id">Horario laboral</label>
            <select name="horario_laboral_id" class="form-control">
                <option value="">Seleccione...</option>
                @foreach ($horarios as $horario)
                    <option value="{{ $horario->id }}" {{ $personal->horariosLaborales->last()?->id == $horario->id ? 'selected' : '' }}>
                        {{ $horario->nombre }} ({{ $horario->hora_entrada }} - {{ $horario->hora_salida }})
                    </option>
                @endforeach
            </select>
        </div>
 

        @if ($personal->qr_code)
            <div class="col-md-6 mb-3">
                <label>Código QR:</label><br>
                <div id="qrcode"></div>
            </div>
        @endif
    </div>

    <div class="btn-list d-flex justify-content-end">
        <a href="{{ route('personal.index') }}" class="btn btn-danger mr-3">Cancelar</a>
        <button type="submit" class="btn btn-primary" id="btn-submit">Actualizar</button>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    var qrCodeValue = "{{ $personal->qr_code }}"; // UUID que tienes
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: qrCodeValue,
        width: 150,
        height: 150,
    });
</script>