<div class="table-responsive">
    <table class="table table-hover" id="entes-table">
        <thead class="bg-light">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
                <th>RIF</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Departamento</th>
                <th>Acciones</th>
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
            ajax: "{{ route('personal.index') }}",
            dataType: 'json',
            type: "POST",

             columns: [
                { data: 'nombre', name: 'nombre' },
                { data: 'apellido', name: 'apellido' },
                { data: 'cedula', name: 'cedula' },
                { data: 'rif', name: 'rif' },
                { data: 'telefono', name: 'telefono' },
                { data: 'email', name: 'email' },
                { data: 'direccion', name: 'direccion' },
                { data: 'departamento', name: 'departamento.nombre' },
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