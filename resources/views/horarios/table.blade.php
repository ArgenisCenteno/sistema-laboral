<div class="table-responsive">
    <table class="table table-hover" id="entes-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Entrada</th>
                <th>Salida</th>
               
                <th>Opciones</th>
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
            ajax: "{{ route('horarios.index') }}",
            dataType: 'json',
            type: "POST",

            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' },
                { data: 'hora_entrada', name: 'hora_entrada' },
                { data: 'hora_salida', name: 'hora_entrada' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
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