<div class="table-responsive">
    <table class="table table-hover" id="entes-table">
        <thead class="bg-light">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Creado en</th>
                <th>Actualizado en</th> 
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
            ajax: "{{ route('users.index') }}",
            dataType: 'json',
            type: "POST",

             columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' }, 
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