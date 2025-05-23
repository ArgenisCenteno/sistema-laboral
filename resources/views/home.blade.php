@extends('layouts.app')
@section('content')

    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Dashboard
                            </li>
                        </ol>
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->
            <div class="card pt-4 pb-4 container-fluid"> <!--begin::Row-->
                <div class="row mb-4">
                    <!-- Departamento -->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>{{$departamentos}}</h3>
                                <p>Departmantos</p>
                            </div><svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 2h18a1 1 0 0 1 1 1v19h-2v-2H4v2H2V3a1 1 0 0 1 1-1Zm6 14v-2H7v2h2Zm0-4v-2H7v2h2Zm0-4V6H7v2h2Zm4 8v-2h-2v2h2Zm0-4v-2h-2v2h2Zm0-4V6h-2v2h2Zm4 8v-2h-2v2h2Zm0-4v-2h-2v2h2Zm0-4V6h-2v2h2Z" />
                            </svg>

                        </div> <!--end::Small Box Widget 1-->
                    </div>
                    <!-- Personal -->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3>{{$personales}}</h3>
                                <p>Personal</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10Zm0 12c4.418 0 8 2.239 8 5v3H4v-3c0-2.761 3.582-5 8-5Z" />
                            </svg>

                        </div> <!--end::Small Box Widget 1-->
                    </div>

                    <!-- Asistencias -->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3>{{$asistencias}}</h3>
                                <p>Asistencias</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z" />
                            </svg>

                        </div> <!--end::Small Box Widget 1-->
                    </div>

                    <!-- Inasistencias -->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3>{{$inasistencias}}</h3>
                                <p>Inasistencias</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.3 5.71 12 12l6.3 6.29-1.41 1.42L12 13.41l-6.29 6.3-1.42-1.42L10.59 12 4.29 5.71 5.71 4.29 12 10.59l6.29-6.3z" />
                            </svg>

                        </div> <!--end::Small Box Widget 1-->
                    </div>
                </div>

                <!-- Gráfica -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header">Asistencias Mensuales</div>
                            <div class="card-body">
                                <canvas id="asistenciasChart" height="120"></canvas>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header">Inasistencias Mensuales</div>
                            <div class="card-body">

                                <canvas id="inasistenciasChart" height="120"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->


    @include('layouts.script')
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const asistenciasCtx = document.getElementById('asistenciasChart').getContext('2d');
        const inasistenciasCtx = document.getElementById('inasistenciasChart').getContext('2d');

        const labels = {!! json_encode(array_keys($asistenciasData->toArray())) !!};
        const asistencias = {!! json_encode(array_values($asistenciasData->toArray())) !!};
        const inasistencias = {!! json_encode(array_values($inasistenciasData->toArray())) !!};

        new Chart(asistenciasCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Asistencias por mes',
                    data: asistencias,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });

        new Chart(inasistenciasCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Inasistencias por mes',
                    data: inasistencias,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection