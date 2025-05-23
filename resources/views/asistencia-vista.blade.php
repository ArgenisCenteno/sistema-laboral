@extends('layouts.layout-auth')

@section('content')
    <section class="vh-100 d-flex align-items-center justify-content-center bg-light" style="background: url('iconos/banner.jpeg') no-repeat center center/cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="card shadow rounded-4 p-4 text-center">
                        <div class="card-body">

                            <div class="mb-4">
                                <i class="fas fa-qrcode fa-2x mb-2 text-primary"></i>
                                <h4 class="fw-bold">REGISTRAR ASISTENCIA</h4>
                            </div>

                           @include('asistencia')

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
