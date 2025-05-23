<form action="{{ route('inasistencias.store') }}" method="POST">
    @csrf

    <div class="form-group mb-3">
        <label for="personal_id">Personal</label>
        <select name="personal_id" class="form-control @error('personal_id') is-invalid @enderror" required>
            <option value="">Seleccione personal</option>
            @foreach($personales as $personal)
                <option value="{{ $personal->id }}" {{ old('personal_id') == $personal->id ? 'selected' : '' }}>
                    {{ $personal->nombre }} {{ $personal->apellido }}
                </option>
            @endforeach
        </select>
        @error('personal_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required>
        @error('fecha')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="motivo">Motivo</label>
        <textarea name="motivo" rows="4" class="form-control @error('motivo') is-invalid @enderror" required>{{ old('motivo') }}</textarea>
        @error('motivo')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mt-4">
        <a href="{{ route('inasistencias.index') }}" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>
