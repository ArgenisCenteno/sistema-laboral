<form action="{{ route('horarios.store') }}" method="POST">
    @csrf

    <div class="form-group mb-3">
        <label for="nombre">Nombre del horario</label>
        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre') }}" required>
        @error('nombre')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="hora_entrada">Hora de entrada</label>
        <input type="time" name="hora_entrada" class="form-control @error('hora_entrada') is-invalid @enderror"
            value="{{ old('hora_entrada') }}" required>
        @error('hora_entrada')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="hora_salida">Hora de salida</label>
        <input type="time" name="hora_salida" class="form-control @error('hora_salida') is-invalid @enderror"
            value="{{ old('hora_salida') }}" required>
        @error('hora_salida')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mt-4">
        <a href="{{ route('horarios.index') }}" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>