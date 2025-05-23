<form action="{{ route('personal.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="cedula">Cédula</label>
            <input type="text" name="cedula" id="cedula" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="rif">RIF</label>
            <input type="text" name="rif" id="rif" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <label for="direccion">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3" class="form-control"></textarea>
        </div>

        <div class="col-md-6 mb-3">
            <label for="departamento_id">Departamento</label>
            <select name="departamento_id" id="departamento_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="btn-list d-flex justify-content-end">
        <a href="{{ route('personal.index') }}" class="btn btn-danger mr-3">Cancelar</a>
        <button type="submit" class="btn btn-primary" id="btn-submit">Registrar</button>
    </div>
</form>
