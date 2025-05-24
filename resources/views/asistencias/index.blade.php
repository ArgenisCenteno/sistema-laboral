@extends('layouts.app')
@section('content')

    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Asistencias Laborales</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <a href="{{ route('asistencias.exportar.mensual') }}" class="btn btn-success">
                                Reporte General Mensual
                            </a>

                        </ol>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-end mt-3">


                        <form action="{{ route('asistencias.exportar') }}" method="GET"
                            class="d-flex align-items-end flex-wrap">

                            <div class="me-2">
                                <label for="desde" class="form-label mb-1">Desde</label>
                                <input class="form-control @error('desde') is-invalid @enderror" type="date" name="desde"
                                    id="desde" value="{{ old('desde') }}" required style="width: 180px;">
                                @error('desde')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="me-2">
                                <label for="hasta" class="form-label mb-1">Hasta</label>
                                <input class="form-control @error('hasta') is-invalid @enderror" type="date" name="hasta"
                                    id="hasta" value="{{ old('hasta') }}" required style="width: 180px;">
                                @error('hasta')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <button type="submit" id="btn-submit" class="btn btn-primary mb-1">Consultar</button>
                            </div>
                        </form>

                    </div>



                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->
            <div class="card pt-3 container-fluid"> <!--begin::Row-->

                @include('asistencias.table')
            </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->


    @include('layouts.script')
    <script src="{{ asset('js/adminlte.js') }}"></script>
@endsection