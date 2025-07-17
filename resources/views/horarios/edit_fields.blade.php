 

    <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="nombre">Nombre del horario</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $horario->nombre) }}" required>
            @error('nombre')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="hora_entrada">Hora de entrada</label>
            <input type="text" id="hora_entrada" name="hora_entrada"
                class="form-control @error('hora_entrada') is-invalid @enderror"
                value="{{ old('hora_entrada', $horario->hora_entrada) }}" required>
            @error('hora_entrada')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="hora_salida">Hora de salida</label>
            <input type="text" id="hora_salida" name="hora_salida"
                class="form-control @error('hora_salida') is-invalid @enderror"
                value="{{ old('hora_salida', $horario->hora_salida) }}" required>
            @error('hora_salida')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <a href="{{ route('horarios.index') }}" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form> 
 
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#hora_entrada", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
        });

        flatpickr("#hora_salida", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
        });
    </script> 
