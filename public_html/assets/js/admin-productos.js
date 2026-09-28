// Buscador + DataTables de la vista admin/productos/index.php.
// Vive en un archivo aparte (no inline) porque el CSP del sitio bloquea la ejecución de
// scripts inline (script-src sin 'unsafe-inline') — solo permite 'self' y cdnjs.cloudflare.com.
document.addEventListener('DOMContentLoaded', function () {
    var tablaEl = document.getElementById('tabla-productos');
    if (!tablaEl || typeof jQuery === 'undefined' || !jQuery.fn.DataTable) {
        return;
    }

    var $tabla = jQuery(tablaEl).DataTable({
        dom: "t<'flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2'lip>",
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
        order: [[0, 'asc']],
        columnDefs: [{ targets: 4, orderable: false }],
        language: {
            search: 'Buscar:',
            lengthMenu: 'Mostrar _MENU_ productos',
            info: 'Mostrando _START_–_END_ de _TOTAL_ productos',
            infoEmpty: 'Sin productos',
            infoFiltered: '(filtrado de _MAX_ en total)',
            zeroRecords: 'Sin resultados',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
    });

    var buscador = document.getElementById('buscador-productos');
    var tarjetas = document.querySelectorAll('.tarjeta-producto');
    var sinResultadosBox = document.getElementById('buscador-sin-resultados');
    var terminoSpan = document.getElementById('buscador-termino');

    function aplicarBusqueda(valor) {
        var termino = valor.trim().toLowerCase();
        $tabla.search(termino).draw();

        var visibles = 0;
        tarjetas.forEach(function (tarjeta) {
            var coincide = !termino || tarjeta.dataset.nombre.includes(termino);
            tarjeta.classList.toggle('hidden', !coincide);
            if (coincide) visibles++;
        });

        // El aviso "sin resultados" solo aplica a la vista de tarjetas (móvil); en la tabla
        // DataTables ya muestra su propio "Sin resultados" (zeroRecords).
        var mostrarAviso = termino !== '' && visibles === 0 && window.innerWidth < 640;
        terminoSpan.textContent = termino;
        sinResultadosBox.classList.toggle('hidden', !mostrarAviso);
    }

    buscador.addEventListener('input', function () { aplicarBusqueda(this.value); });

    var btnLimpiar = document.getElementById('buscador-limpiar');
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function () {
            buscador.value = '';
            aplicarBusqueda('');
            buscador.focus();
        });
    }

    // Si el usuario rota el dispositivo o cambia de tamaño de ventana cruzando el breakpoint
    // sm, DataTables necesita recalcular anchos (estaba oculto vía `hidden sm:block`).
    window.addEventListener('resize', function () { $tabla.columns.adjust(); });
});
