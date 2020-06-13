window.addEventListener('load', inicial, false);

var btnbuscar;
var resultadobusqueda;
var contenedordetalles;

function inicial() {
    alertify.set('notifier', 'position', 'top-right');
    btnbuscar = document.getElementById('btnbuscar')
    contenedordetalles = document.getElementById('contenedordetalles');


    btnbuscar.addEventListener('click', buscarofertas, false);
}

function buscarofertas() {
    var form = new FormData();
    form.append('descripcion', document.getElementById('txtdescripcion').value);
    form.append('categoria', document.getElementById('txtcategoria').value);
    form.append('empresa', document.getElementById('txtempresa').value);

    axios.post('/', form)
        .then(function (response) {
            resultadobusqueda = response.data;
            generarresultadosbusqueda();
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar buscar. Por favor intente mas tarde.');
        })
}

function generarresultadosbusqueda() {
    contenedordetalles.innerHTML = '';
    for (var i = 0; i < resultadobusqueda.length; i++) {
        contenedordetalles.innerHTML += '<div class="detallecontenedor">' +
            '<label>Descripcion: '+resultadobusqueda[i]['descripcion']+'</label><br>' +
            '<label>Empresa: '+resultadobusqueda[i]['empresa']+'</label><br>' +
            '<label>Vacantes: '+resultadobusqueda[i]['numero_vacantes']+'</label><br>' +
            '<label>Fecha de publicacion: '+resultadobusqueda[i]['fecha']+'</label><br>' +
            '<input type="button" value="Ver listado" class="btnconestilo" onclick="verlistado('+resultadobusqueda[i]['id']+')">';
        '</div>';
    }
}
