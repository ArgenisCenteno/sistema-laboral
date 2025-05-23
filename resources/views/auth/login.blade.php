@extends('layouts.layout-auth')

@section('content')
<section class="vh-100">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-sm-6 d-flex flex-column justify-content-center align-items-center text-black">

                <div class="text-center mb-4">
                    <i class="fas fa-crow fa-2x mb-2" ></i>
                    <h4> <strong>SISTEMA DE GESTIÓN DE PERSONAL</strong> </h4>
                </div>

                <form method="POST" action="{{ route('login') }}" style="width: 80%;">
                    @csrf

                    <h3 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">Ingresar</h3>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" placeholder="Email" id="email" name="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" placeholder="Contraseña" id="password" name="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-1 mb-4">
                        <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                    </div>

                    <p class="small text-center">
                        <a class="text-muted" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    </p>
                </form>
            </div>

            <div class="col-sm-6 px-0 d-none d-sm-block">
                <img src="iconos/banner.jpeg"
                    alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
        </div>
    </div>
</section>
@endsection
