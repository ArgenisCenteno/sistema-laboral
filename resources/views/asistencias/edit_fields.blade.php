<form action="{{ route('asistencias.update', $asistencia->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div >

        <div class="card-body row">

            {{-- Datos del Personal --}}
            <div class="col-md-6 mb-3">
                <label>Nombre</label>
                <input type="text" class="form-control" value="{{ $asistencia->personal->nombre }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Apellido</label>
                <input type="text" class="form-control" value="{{ $asistencia->personal->apellido }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Cédula</label>
                <input type="text" class="form-control" value="{{ $asistencia->personal->cedula }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>RIF</label>
                <input type="text" class="form-control" value="{{ $asistencia->personal->rif }}" readonly>
            </div>

            {{-- Datos de la Asistencia --}}
            <div class="col-md-6 mb-3">
                <label>Fecha</label>
                <input type="text" class="form-control" value="{{ $asistencia->fecha->format('Y-m-d') }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Hora de Entrada</label>
                <input type="text" class="form-control" value="{{ $asistencia->hora_entrada->format('H:i') }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Hora de Salida</label>
                <input type="text" class="form-control" value="{{ $asistencia->hora_salida ? $asistencia->hora_salida->format('H:i') : 'Sin completar' }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Horas Trabajadas</label>
                <input type="text" class="form-control" value="{{ $asistencia->horas_trabajadas }}" readonly>
            </div>

            {{-- Observación Editable --}}
            <div class="col-md-12 mb-3">
                <label>Observación</label>
                <textarea name="observacion" class="form-control" rows="3">{{ old('observacion', $asistencia->observacion) }}</textarea>
            </div>
            

        </div>

        <div class="card-footer text-end">
                        <a href="{{ route('asistencias.index') }}" class="btn btn-danger">Cancelar</a>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>
