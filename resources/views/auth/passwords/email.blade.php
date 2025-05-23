@extends('layouts.layout-auth')

@section('content')
    <section class="vh-100">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-sm-6 d-flex flex-column justify-content-center align-items-center text-black">

                    <div class="text-center mb-4">
                        <i class="fas fa-crow fa-2x mb-2"></i>
                        <h4> <strong>Recuperar Contraseña</strong> </h4>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email ') }}</label>
                            <input id="email" type="email"
                                class="form-control form-control-lg  @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" style="width: 400px;" required autocomplete="email" autofocus>


                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-5">
                                {{ __('Enviar') }}
                            </button>
                        </div>
                    </form>

                </div>

                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="../iconos/banner.jpeg" alt="Login image" class="w-100 vh-100"
                        style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>
@endsection