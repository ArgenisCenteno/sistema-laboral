<div class="table-responsive">
    <table class="table table-hover" id="entes-table">
        <thead class="bg-light">
            <tr>
                <th>Personal</th>
                <th>Cédula</th>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Horas Trabajadas</th>
                <th>Salida Anticipada</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#entes-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('asistencias.index') }}",
            dataType: 'json',
            type: "POST",

            columns: [
                { data: 'personal', name: 'personal' },
                { data: 'cedula', name: 'cedula' },
                { data: 'fecha', name: 'fecha' },

                { data: 'hora_entrada', name: 'hora_entrada' },
                { data: 'hora_salida', name: 'hora_salida' },
                { data: 'horas_trabajadas', name: 'horas_trabajadas' },
                { data: 'motivo_salida_anticipada', name: 'motivo_salida_anticipada' },

            ],

            order: [[0, 'desc']],
            language: {
                lengthMenu: "Mostrar _MENU_ Registros por Página",
                zeroRecords: "Sin resultados",
                info: "",
                infoEmpty: "No hay Registros Disponibles",
                infoFiltered: "Filtrado _TOTAL_ de _MAX_ Registros Totales",
                search: "Buscar",
                paginate: {
                    next: ">",
                    previous: "<"
                }
            }
        });


    });
</script>