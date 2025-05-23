<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label for="name">Nombre de usuario</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3 col-md-6">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3 col-md-6">
            <label for="password">Contraseña</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3 col-md-6 d-flex align-items-end">
            <div class="form-check form-switch ml-5">
                <input type="checkbox" class="form-check-input" id="es_personal" name="es_personal" {{ old('es_personal') ? 'checked' : '' }}>
                <label class="form-check-label" for="es_personal">¿También es personal?</label>
            </div>
        </div>
    </div>

    <div id="campos_personal" style="display: none;">
        <h5 class="mt-4">Datos de Personal</h5>
        <div class="row">
            <div class="form-group mb-3 col-md-6">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}">
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="cedula">Cédula</label>
                <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}">
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="rif">RIF</label>
                <input type="text" name="rif" class="form-control" value="{{ old('rif') }}">
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="departamento_id">Departamento</label>
                <select name="departamento_id" class="form-control">
                    <option value="">Seleccione un departamento</option>
                    @foreach($departamentos as $departamento)
                        <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3 col-12">
                <label for="direccion">Dirección</label>
                <textarea name="direccion" class="form-control">{{ old('direccion') }}</textarea>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        function toggleCamposPersonal() {
            if ($('#es_personal').is(':checked')) {
                $('#campos_personal').slideDown();
            } else {
                $('#campos_personal').slideUp();
            }
        }

        $('#es_personal').on('change', toggleCamposPersonal);
        toggleCamposPersonal();
    });
</script>
