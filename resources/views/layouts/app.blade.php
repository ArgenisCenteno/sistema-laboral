<html>
@include('layouts.head')

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper"> <!--begin::Header-->
    @include('layouts.cabecera')
    @include('layouts.menu')
    @yield('content')
    @stack('third_party_scripts')
    @stack('page_scripts')
</div>  
@yield('js')
@include('layouts.script')
@include('sweetalert::alert')
@include('layouts.datatable_css')
@include('layouts.datatables_js')
</body>
</html>