window.addEventListener('load', iniciar, false);

var cedulauser;


var btnagregarcategoria;
var btnguardarcategoriamodal;
var txtnombrecategoria;

var btnagregaroferta;

var editandooferta

//varas de eliminar
var modaleliminar;
var lblestaseguro;
var ideliminar;
var tipoeliminar;
var btneliminar;


function iniciar() {
    alertify.set('notifier', 'position', 'top-right');
    editandooferta = false;
    cedulauser = document.getElementById('cedulauser').innerHTML;

    modaleliminar = document.getElementById('modaleliminar');
    lblestaseguro = document.getElementById('estaseguro');
    btneliminar = document.getElementById('btneliminarmodal');

    btnagregarcategoria = document.getElementById('btnagregarcategoria');
    btnguardarcategoriamodal = document.getElementById('btnguardarcategoriamodal');
    txtnombrecategoria = document.getElementById('txtnombrecategoria');

    btnagregaroferta = document.getElementById('btnagregaroferta');

    btneliminar.addEventListener('click', eliminar, false);
    btnagregarcategoria.addEventListener('click', abrircategorianueva, false)
    btnguardarcategoriamodal.addEventListener('click', guardarcategoria, false)
    btnagregaroferta.addEventListener('click',limpiarcamposmodal,false);
    btnagregaroferta.addEventListener('click',abrirofertanueva,false);
}



function abrircategorianueva() {
    txtnombrecategoria.value = '';
    document.getElementById('modalcategorianueva').style.display = "flex";
}

function limpiarcamposmodal(){

}

function abrirofertanueva() {
    document.getElementById('modalofertanueva').style.display = "flex";
}

function cerrar(ventana) {
    document.getElementById(ventana).style.display = "none";
    editandooferta = false;
}

function guardarcategoria() {
    if (stringvalido(txtnombrecategoria.value, 50)) {
        var form = new FormData();
        form.append('cedula', cedulauser);
        form.append('categoria', txtnombrecategoria.value);

        axios.post('ofertas/categoria', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    alertify.success('Categoria registrado correctamente.');
                    window.setTimeout(function () {
                        window.location.href = getbaseurl() + '/miperfil/ofertas';
                    }, 1200);
                } else {
                    alertify.error(response.data);
                }
            })
            .catch(function (error) {
                alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
            })
    } else {
        alertify.error('Existen errores en el campo de nombre. Corrigalos e intente de nuevo.')
    }
}

function eliminarcategoria(id) {
    ideliminar = id;
    tipoeliminar = 5;
    modaleliminar.style.display = "flex";
    lblestaseguro.innerHTML = '¿Esta seguro de que quiere eliminar esta categoria?\nEsta accion no se puede deshacer.';
}

function eliminarcategoria(id) {
    ideliminar = id;
    tipoeliminar = 4;
    modaleliminar.style.display = "flex";
    lblestaseguro.innerHTML = '¿Esta seguro de que quiere eliminar esta oferta?\nEsta accion no se puede deshacer.';
}


function eliminar() {
    var form = new FormData();
    form.append('cedula', cedulauser);
    form.append('tipo', tipoeliminar);
    form.append('id', ideliminar);
    axios.post('eliminar', form)
        .then(function (response) {
            if (response.data === 'exito') {
                alertify.success('Elemento eliminado correctamente.');
                window.setTimeout(function () {
                    window.location.href = getbaseurl() + '/miperfil/ofertas';
                }, 1200);
            } else {
                alertify.error(response.data);
                window.setTimeout(function () {
                    window.location.href = getbaseurl() + '/miperfil/ofertas';
                }, 2000);
            }
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
        })
}


