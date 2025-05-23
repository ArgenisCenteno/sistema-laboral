<td>
    <div class='btn-list'>
        <a href="{{ route('personal.edit', $id) }}" class='btn btn-info' data-bs-toggle="tooltip"
            data-bs-placement="top" title="Editar">
            <span>Editar</span>
        </a>
        <a href="{{ route('pdf.personal', $id) }}" target="_blank" class='btn btn-warning' data-bs-toggle="tooltip"
            data-bs-placement="top" title="Planilla">
            <span>Planilla</span>
        </a>
          <a href="{{ route('pdf.reportePersonal', $id) }}" target="_blank" class='btn btn-secondary' data-bs-toggle="tooltip"
            data-bs-placement="top" title="Reporte">
            <span>Reporte</span>
        </a>
        <form action="{{ route('personal.destroy', $id) }}" method="POST" class="btn-delete" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Eliminar">
                <span>Eliminar</span>
            </button>
        </form>
    </div>
</td>

<!-- SweetAlert CDN -->
<script src="{{asset('js/sweetalert2.js')}}"></script>

<!-- ALERT DE CONFIRMACION DE ELIMINACION -->
<script>
    $(document).ready(function () {
        $('.btn-delete').submit(function (e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Está seguro?',
                text: "El registro se eliminará permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(13, 172, 85)',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí se envía el formulario si se confirma la eliminación
                    $(this).off('submit').submit();
                }
            });
        });
    });
</script>