window.addEventListener('load', iniciar, false);

var cedulauser;


var btnagregarcategoria;
var btnguardarcategoriamodal;
var txtnombrecategoria;

var btnagregaroferta;

var editandooferta
var ideditando;

//varas de eliminar
var modaleliminar;
var lblestaseguro;
var ideliminar;
var tipoeliminar;
var btneliminar;

//elementos de agregar oferta nueva
var txtdescripcionoferta;
var txtvacantesoferta;
var txtubicacionoferta;
var txthorariooferta;
var txtcontratooferta;
var txtsalariooferta;
var btnguardarofertamodal;
var txtrequisitosoferta;
var contenedorequisitos;
var requisitos;
var categoriasuser;
var idscategoriasseleccionadas;

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


    txtdescripcionoferta = document.getElementById('txtdescripcionoferta');
    txtvacantesoferta = document.getElementById('txtvacantesoferta');
    txtubicacionoferta = document.getElementById('txtubicacionoferta');
    txthorariooferta = document.getElementById('txthorariooferta');
    txtcontratooferta = document.getElementById('txtcontratooferta');
    txtsalariooferta = document.getElementById('txtsalariooferta');
    btnguardarofertamodal = document.getElementById('btnguardarofertamodal');
    txtrequisitosoferta = document.getElementById('txtrequisitosoferta');
    contenedorequisitos = document.getElementById('contenedortagsoferta');
    requisitos = [];
    categoriasuser = document.getElementsByClassName('checkboxmodal');
    idscategoriasseleccionadas = [];


    btneliminar.addEventListener('click', eliminar, false);
    btnagregarcategoria.addEventListener('click', abrircategorianueva, false)
    btnguardarcategoriamodal.addEventListener('click', guardarcategoria, false)
    btnagregaroferta.addEventListener('click', limpiarcamposmodal, false);
    btnagregaroferta.addEventListener('click', abrirofertanueva, false);
    btnguardarofertamodal.addEventListener('click', guardaroferta, false);
}



function abrircategorianueva() {
    txtnombrecategoria.value = '';
    document.getElementById('modalcategorianueva').style.display = "flex";
}

function limpiarcamposmodal() {
    txtdescripcionoferta.value = '';
    txtvacantesoferta.value = '';
    txtubicacionoferta.value = '';
    txthorariooferta.value = '';
    txtcontratooferta.value = '';
    txtsalariooferta.value = '';
    txtrequisitosoferta.value = '';
    requisitos = [];
    for (var i = 0; i < categoriasuser.length; i++) {
        categoriasuser[i].checked = false;
    }
    generartagsrequisitos();
}

function abrirofertanueva() {
    document.getElementById('modalofertanueva').style.display = "flex";
}

function cerrar(ventana) {
    document.getElementById(ventana).style.display = "none";
    editandooferta = false;
    limpiarcamposmodal();
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

function eliminaroferta(id) {
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


function guardaroferta() {
    if (validarcamposoferta()) {
        var form = new FormData();
        if (editandooferta) {
            form.append('id', ideditando);
        }
        form.append('cedula', cedulauser);
        form.append('descripcion', txtdescripcionoferta.value);
        form.append('vacantes', txtvacantesoferta.value);
        form.append('ubicacion', txtubicacionoferta.value);
        form.append('horario', txthorariooferta.value);
        form.append('contrato', txtcontratooferta.value);
        form.append('salario', txtsalariooferta.value);
        console.log(JSON.stringify(idscategoriasseleccionadas));
        form.append('requisitos', JSON.stringify(requisitos));
        form.append('categorias', JSON.stringify(idscategoriasseleccionadas));
        axios.post('ofertas', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    if (editandooferta) {
                        alertify.success('Oferta actualizada correctamente.');
                        editandooferta = false;

                    } else {
                        alertify.success('Oferta guardada correctamente.');

                    }
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
}

function validarcamposoferta() {
    if (!stringvalido(txtdescripcionoferta.value, 200) || !stringvalido(txtvacantesoferta.value, 11) || !stringvalido(txtubicacionoferta.value, 50) || !stringvalido(txtsalariooferta.value, 11) || !stringvalido(txthorariooferta.value, 50) || !stringvalido(txtcontratooferta.value, 50)) {
        alertify.error('Existen errores en los campos, por favor verifiquelos e intente de nuevo.');
        return false;
    }
    if (requisitos.length == 0) {
        alertify.error('No puede guardar una oferta sin ningun requisito.');
        return false;
    }
    idscategoriasseleccionadas = [];
    for (var i = 0; i < categoriasuser.length; i++) {
        if (categoriasuser[i].checked) {
            idscategoriasseleccionadas.push(categoriasuser[i].value);
        }
    }
    if (idscategoriasseleccionadas.length == 0) {
        alertify.error('No se puede guardar una oferta sin ninguna categoria.');
        return false;
    }
    return true;
}

function agregarrequisito(e) {
    if (e.keyCode === 13) {
        if (!requisitos.includes(txtrequisitosoferta.value) && stringvalido(txtrequisitosoferta.value, 200)) {
            requisitos.push(txtrequisitosoferta.value);
            txtrequisitosoferta.value = '';
            generartagsrequisitos();
        } else {
            if (stringvalido(txtrequisitosoferta.value, 200)) {
                alertify.warning('Ya existe el requisito.');
            } else {
                alertify.error('Requisito no valido.')
            }
            txtrequisitosoferta.value = '';
        }

    }
}

function eliminarrequisito(indexrequisito) {
    requisitos.splice(indexrequisito, 1);
    generartagsrequisitos();
}

function generartagsrequisitos() {
    contenedorequisitos.innerHTML = '';
    for (var i = 0; i < requisitos.length; i++) {
        contenedorequisitos.innerHTML += '<span class="tag">' + requisitos[i] + '<span class="closetag" onclick="eliminarrequisito(' + i + ')"></span></span>';

    }
}

function editaroferta(id) {
    ideditando = id;
    editandooferta = true;
    var todoslasofertas = document.getElementsByClassName('hijoshorizontal');
    var oferta;
    var contenedoroferta;
    var contenedorrequisitos;
    var contenedorcategorias;
    for (var i = 0; i < todoslasofertas.length; i++) {
        if (todoslasofertas[i].id == id) {
            oferta = todoslasofertas[i];
            break;
        }
    }

    contenedoroferta = oferta.getElementsByClassName('contenedoroferta')[0];
    contenedorrequisitos = document.getElementById('contenedorrequisitos' + id);

    for (var i = 0; i < contenedoroferta.childNodes.length; i++) {
        if (contenedoroferta.childNodes[i].className == 'descripcionoferta') {
            txtdescripcionoferta.value = contenedoroferta.childNodes[i].innerHTML;
        }
        if (contenedoroferta.childNodes[i].className == 'vacantesoferta') {
            txtvacantesoferta.value = contenedoroferta.childNodes[i].innerHTML;
        }
        if (contenedoroferta.childNodes[i].className == 'ubicacionoferta') {
            txtubicacionoferta.value = contenedoroferta.childNodes[i].innerHTML;
        }
        if (contenedoroferta.childNodes[i].className == 'salariooferta') {
            txtsalariooferta.value = contenedoroferta.childNodes[i].innerHTML;
        }
        if (contenedoroferta.childNodes[i].className == 'horariooferta') {
            txthorariooferta.value = contenedoroferta.childNodes[i].innerHTML;
        }
        if (contenedoroferta.childNodes[i].className == 'duracionoferta') {
            txtcontratooferta.value = contenedoroferta.childNodes[i].innerHTML;
        }
    }
    requisitos = [];
    for (var i = 0; i < contenedorrequisitos.childNodes.length; i++) {
        if (contenedorrequisitos.childNodes[i].className == 'requisito') {
            requisitos.push(contenedorrequisitos.childNodes[i].innerHTML);
        }
    }

    contenedorcategorias = oferta.getElementsByClassName('contenedorcategorias')[0];
    for (var i = 0; i < contenedorcategorias.childNodes.length; i++) {
        if (contenedorcategorias.childNodes[i].className == 'cate') {
            for (var k = 0; k < categoriasuser.length; k++) {
                if (categoriasuser[k].name == contenedorcategorias.childNodes[i].innerHTML) {
                    categoriasuser[k].checked = true;
                }
            }
        }
    }

    abrirofertanueva();
    generartagsrequisitos();
}