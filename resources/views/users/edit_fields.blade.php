<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <label for="name">Nombre</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
<div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="password">Nueva contraseña <small class="text-muted">(Opcional)</small></label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" id="btn-submit" class="btn btn-primary">Actualizar</button>
    </div>
</form>
