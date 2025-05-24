@push('page_scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->



    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!-- OPTIONAL SCRIPTS --> <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
        integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script>
    <!-- sortablejs -->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script> <!-- ChartJS -->

    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
    <!-- jsvectormap -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script>
        $(function () {
            const languages = {
                'es': '{{asset('js/Spanish.json')}}'
            };

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
                className: 'btn btn-sm'
            })
            $.extend(true, $.fn.dataTable.defaults, {
                responsive: true,
                language: {
                    url: languages['es']
                },
                pageLength: 25,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'copy',
                    className: 'btn-light',
                    text: 'Copiar',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-light',
                    text: 'CSV',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-light',
                    text: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-light',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-light',
                    text: 'Imprimir',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn-light',
                    text: 'Visibilidad Columnas',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
                ]
            });
        });
    </script>
    <script>
        // Escucha el evento 'input' en todos los campos de tipo text y textareas y convierte a mayúsculas
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los inputs de tipo text y los textareas
            const textInputs = document.querySelectorAll('input[type="text"], textarea');

            // Itera sobre cada input y textarea y agrega el listener
            textInputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    // Convierte el valor del input o textarea a mayúsculas
                    this.value = this.value.toUpperCase();
                });
            });
        });
    </script>

   <script>
$(document).ready(function () {
    function validarFormulario() {
        if ($('.is-invalid').length > 0) {
            $('#btn-submit').prop('disabled', true);
        } else {
            $('#btn-submit').prop('disabled', false);
        }
    }

    // Validar teléfono
    $('#telefono').on('input', function () {
        let telefono = $(this).val();
        telefono = telefono.replace(/\D/g, '').slice(0, 11);
        $(this).val(telefono);
        const regex = /^(0412|0424|0414|0426|0416)[0-9]{7}$/;

        if (!regex.test(telefono)) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            $(this).next('.invalid-feedback').text('Formato incorrecto. Debe comenzar con 0412, 0414, 0424, 0426 o 0416 y tener 11 dígitos.');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').text('');
        }
        validarFormulario();
    });

    // Validar RIF
    $('#rif').on('input', function () {
        let rif = $(this).val();
        const regex = /^[JGV]-\d{8}-\d{1}$/;

        if (!regex.test(rif)) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            $(this).next('.invalid-feedback').text('Formato de RIF inválido. Debe ser como J-12345678-9');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').text('');
        }
        validarFormulario();
    });

    // Validar correo electrónico
    $('#email').on('input', function () {
        let correo = $(this).val();
        const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        if (!regex.test(correo)) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            $(this).next('.invalid-feedback').text('Formato de correo electrónico inválido.');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').text('');
        }
        validarFormulario();
    });

    // Validar nombre, apellido, name (solo letras y espacios)
    $('#nombre, #apellido, #name').on('keypress', function (e) {
        const char = String.fromCharCode(e.which);
        const regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;

        if (!regex.test(char)) {
            e.preventDefault();
        }
    });

    $('#nombre, #apellido, #name').on('input', function () {
        const val = $(this).val();
        const regex = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;

        if (val === '' || !regex.test(val)) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            $(this).next('.invalid-feedback').text('Solo letras y espacios, sin números ni caracteres especiales.');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').text('');
        }
        validarFormulario();
    });

    // Validar cédula venezolana (V- o E- seguido de 7 u 8 dígitos)
    $('#cedula').on('input', function () {
        let cedula = $(this).val().toUpperCase();

        cedula = cedula.replace(/[^VE0-9\-]/g, '');

        if (!/^([VE]-)?/.test(cedula)) {
            cedula = '';
        }

        if (cedula.length > 10) {
            cedula = cedula.slice(0, 10);
        }

        $(this).val(cedula);

        const regex = /^[VE]-[0-9]{7,8}$/;

        if (!regex.test(cedula)) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            $(this).next('.invalid-feedback').text('Debe comenzar con V- o E- seguido de 7 u 8 dígitos.');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').text('');
        }
        validarFormulario();
    });

});
</script>


@endpush