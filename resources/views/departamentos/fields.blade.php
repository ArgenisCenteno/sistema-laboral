<form action="{{ route('departamentos.store') }}" method="POST">
    @csrf

    <div class="row">
        <!-- Nombre -->
        <div class="col-md-6 mb-3">
            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
            <div class="invalid-feedback">
                @error('nombre')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- Descripción -->
        <div class="col-md-6 mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
            <div class="invalid-feedback">
                @error('descripcion')
                    {{ $message }}
                @enderror
            </div>
        </div>

       

        <!-- Estado -->
        <div class="col-md-6 mb-3">
            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
            <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                <option value="1" {{ old('estado') == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
            <div class="invalid-feedback">
                @error('estado')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- Ente -->
       
    </div>

    <div class="btn-list d-flex justify-content-end">
        <a href="{{ route('departamentos.index') }}" class="btn btn-danger mr-3">Cancelar</a>
        <button type="submit" class="btn btn-primary" id="btn-submit">Registrar</button>
    </div>
</form>
