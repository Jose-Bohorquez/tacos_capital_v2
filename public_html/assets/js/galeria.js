document.addEventListener('DOMContentLoaded', () => {
    const galeria = document.getElementById('galeria');
    if (!galeria) return;

    const imagenes = Array.from(galeria.querySelectorAll('[data-galeria-imagen]'));
    const miniaturas = Array.from(document.querySelectorAll('[data-galeria-thumb]'));
    let actual = 0;

    function mostrar(indice) {
        actual = (indice + imagenes.length) % imagenes.length;
        imagenes.forEach((img, i) => {
            img.classList.toggle('opacity-100', i === actual);
            img.classList.toggle('opacity-0', i !== actual);
            img.classList.toggle('pointer-events-none', i !== actual);
        });
        miniaturas.forEach((btn, i) => {
            btn.classList.toggle('border-blue-500', i === actual);
            btn.classList.toggle('border-transparent', i !== actual);
        });
    }

    miniaturas.forEach((btn) => {
        btn.addEventListener('click', () => mostrar(parseInt(btn.dataset.indice, 10)));
    });
    galeria.querySelector('[data-galeria-prev]')?.addEventListener('click', () => mostrar(actual - 1));
    galeria.querySelector('[data-galeria-next]')?.addEventListener('click', () => mostrar(actual + 1));
});
