<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="form-group mb-3 col-md-6">
            <label for="name">Nombre de usuario</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" required>
                <div class="invalid-feedback"></div>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-md-6">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required>
                  <div class="invalid-feedback"></div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-md-6">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
           <div class="invalid-feedback"></div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-md-6 d-flex align-items-end">
            <div class="form-check form-switch ml-5">
                <input id="es_personal" type="checkbox" class="form-check-input" name="es_personal" {{ old('es_personal') ? 'checked' : '' }}>
                <label class="form-check-label" for="es_personal">¿También es personal?</label>
            </div>
        </div>
    </div>

    <div id="campos_personal" style="display: none;">
        <h5 class="mt-4">Datos de Personal</h5>
        <div class="row">
            <div class="form-group mb-3 col-md-6">
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}">
                <div class="invalid-feedback"></div>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="apellido">Apellido</label>
                <input id="apellido" type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}">
                <div class="invalid-feedback"></div>
                @error('apellido')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="cedula">Cédula</label>
                <input id="cedula" type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror" value="{{ old('cedula') }}">
                <div class="invalid-feedback"></div>
                @error('cedula')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="rif">RIF</label>
                <input id="rif" type="text" name="rif" class="form-control @error('rif') is-invalid @enderror" value="{{ old('rif') }}">
                <div class="invalid-feedback"></div>
                @error('rif')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="telefono">Teléfono</label>
                <input id="telefono" type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}">
                <div class="invalid-feedback"></div>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-md-6">
                <label for="departamento_id">Departamento</label>
                <select id="departamento_id" name="departamento_id" class="form-control @error('departamento_id') is-invalid @enderror">
                    <option value="">Seleccione un departamento</option>
                    @foreach($departamentos as $departamento)
                        <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nombre }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
                @error('departamento_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-12">
                <label for="direccion">Dirección</label>
                <textarea id="direccion" name="direccion" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion') }}</textarea>
              <div class="invalid-feedback"></div>
                @error('direccion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-danger">Cancelar</a>
        <button type="submit" id="btn-submit" class="btn btn-primary">Registrar</button>
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
