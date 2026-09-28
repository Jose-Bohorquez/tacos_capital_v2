document.querySelectorAll('.js-confirm-delete-producto').forEach((form) => {
    form.addEventListener('submit', (evento) => {
        evento.preventDefault();
        const nombre = form.dataset.nombre || 'este producto';

        Swal.fire({
            title: '¿Eliminar producto?',
            html: `Vas a eliminar <strong>"${nombre}"</strong> junto con todas sus imágenes.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc2626',
        }).then((primeraConfirmacion) => {
            if (!primeraConfirmacion.isConfirmed) {
                return;
            }

            Swal.fire({
                title: 'Confirma de nuevo',
                html: `Esta acción <strong>no se puede deshacer</strong>. ¿Eliminar definitivamente "${nombre}"?`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar definitivamente',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc2626',
            }).then((segundaConfirmacion) => {
                if (segundaConfirmacion.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

document.querySelectorAll('.js-confirm-delete-imagen').forEach((form) => {
    form.addEventListener('submit', (evento) => {
        evento.preventDefault();

        Swal.fire({
            title: '¿Eliminar esta imagen?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc2626',
        }).then((resultado) => {
            if (resultado.isConfirmed) {
                form.submit();
            }
        });
    });
});
