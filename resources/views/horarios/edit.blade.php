@extends('layouts.app')
@section('content')

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Editar horario</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="card pt-3 container-fluid"> <!--begin::Row-->
           
            @include('horarios.edit_fields')
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->


@include('layouts.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
@endsection