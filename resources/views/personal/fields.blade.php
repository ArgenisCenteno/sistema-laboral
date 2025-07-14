<form action="{{ route('personal.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
            <div class="invalid-feedback d-block">
                @error('nombre') {{ $message }} @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}" required>
            <div class="invalid-feedback d-block">
                @error('apellido') {{ $message }} @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="cedula">Cédula</label>
            <input type="text" name="cedula" id="cedula" class="form-control @error('cedula') is-invalid @enderror" value="{{ old('cedula') }}" required>
            <div class="invalid-feedback d-block">
                @error('cedula') {{ $message }} @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="rif">RIF</label>
            <input type="text" name="rif" id="rif" class="form-control @error('rif') is-invalid @enderror" value="{{ old('rif') }}" required>
            <div class="invalid-feedback d-block">
                @error('rif') {{ $message }} @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}">
            <div class="invalid-feedback d-block">
                @error('telefono') {{ $message }} @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            <div class="invalid-feedback d-block">
                @error('email') {{ $message }} @enderror
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <label for="direccion">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion') }}</textarea>
            <div class="invalid-feedback d-block">
                @error('direccion') {{ $message }} @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="departamento_id">Departamento</label>
            <select name="departamento_id" id="departamento_id" class="form-control @error('departamento_id') is-invalid @enderror" required>
                <option value="">Seleccione...</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                        {{ $departamento->nombre }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback d-block">
                @error('departamento_id') {{ $message }} @enderror
            </div>
        </div>

         <div class="col-md-6 mb-3">
            <label for="horario_laboral_id">Horario laboral</label>
            <select name="horario_laboral_id" id="horario_laboral_id"
                class="form-control @error('horario_laboral_id') is-invalid @enderror">
                <option value="">Seleccione...</option>
                @foreach ($horarios as $horario)
                    <option value="{{ $horario->id }}"
                        {{ old('horario_laboral_id', $personal->horariosLaborales->last()?->id) == $horario->id ? 'selected' : '' }}>
                        {{ $horario->nombre }} ({{ $horario->hora_entrada }} - {{ $horario->hora_salida }})
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                @error('horario_laboral_id'){{ $message }}@enderror
                @if (! $errors->has('horario_laboral_id'))Este campo es obligatorio.@endif
            </div>
        </div>
    </div>

    <div class="btn-list d-flex justify-content-end">
        <a href="{{ route('personal.index') }}" class="btn btn-danger mr-3">Cancelar</a>
        <button type="submit" class="btn btn-primary" id="btn-submit">Registrar</button>
    </div>
</form>
