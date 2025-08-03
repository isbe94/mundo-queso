
$(document).ready(function () {
    const $recetas = $('.receta');
    const recetasPorPagina = 10;
    const totalPaginas = Math.ceil($recetas.length / recetasPorPagina);
    let paginaActual = 1;

    function mostrarPagina(pagina) {
        const inicio = (pagina - 1) * recetasPorPagina;
        const fin = inicio + recetasPorPagina;
        $recetas.hide().slice(inicio, fin).show();

        $('#paginacion').empty();

        // Flecha izquierda
        $('#paginacion').append(`
      <li class="page-item ${pagina === 1 ? 'disabled' : ''}">
        <a class="page-link text-warning bg-white border-warning" href="#" data-pagina="${pagina - 1}">&laquo;</a>
      </li>
    `);

        // Números
        for (let i = 1; i <= totalPaginas; i++) {
            $('#paginacion').append(`
        <li class="page-item ${i === pagina ? 'active' : ''}">
          <a class="page-link ${i === pagina ? 'bg-warning text-white border-warning' : 'text-warning bg-white border-warning'}" href="#" data-pagina="${i}">${i}</a>
        </li>
      `);
        }

        // Flecha derecha
        $('#paginacion').append(`
      <li class="page-item ${pagina === totalPaginas ? 'disabled' : ''}">
        <a class="page-link text-warning bg-white border-warning" href="#" data-pagina="${pagina + 1}">&raquo;</a>
      </li>
    `);
    }

    $(document).on('click', '#paginacion .page-link', function (e) {
        e.preventDefault();
        const pagina = parseInt($(this).data('pagina'));
        if (!isNaN(pagina) && pagina >= 1 && pagina <= totalPaginas) {
            paginaActual = pagina;
            mostrarPagina(paginaActual);
        }
    });

    mostrarPagina(paginaActual);
});
