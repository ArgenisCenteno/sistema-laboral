@extends('layouts.app')
@section('content')

    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Personal</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">

                            <a href="{{ route('exportar.personal') }}" class="btn btn-success mr-3">Descargar</a>

                            <a href="{{ route('personal.create') }}" class="btn btn-primary">Registrar</a>
                        </ol>
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->
            <div class="card pt-3 container-fluid"> <!--begin::Row-->

                @include('personal.table')
            </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->


    @include('layouts.script')
    <script src="{{ asset('js/adminlte.js') }}"></script>
@endsection