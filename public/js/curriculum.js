window.addEventListener('load', iniciar, false);

var btnagregartitulo;
var btnagregarexperiencia;
var btnagregarobservacion;

var btnguardartitulo;
var btnguardarexperiencia;
var btnguardarobservacion;

//3 sencillas banderas
var editandotitulo;
var editandoexperiencia;
var editandoobservacion;

var cedulauser;

//capturar datos del titulo
var txttitulo;
var txtespecialidad;
var txtinstitucion;
var mesobtencion;
var anoobtencion;

//capturar datos de experiencia
var txtempresa;
var txtpuesto;
var txtresponsabilidades;
var fechaingreso;
var fechasalida;

//capturar datos de meritos u observaciones
var txtmeritos;

//varas de eliminar
var modaleliminar;
var lblestaseguro;
var ideliminar;
var tipoeliminar;
var btneliminar;

function iniciar() {
    cedulauser = document.getElementById('cedulauser').innerHTML;

    btnagregartitulo = document.getElementById('btnagregartitulo');
    btnagregarexperiencia = document.getElementById('btnagregarexperiencia');
    btnagregarobservacion = document.getElementById('btnagregarobservacion');

    btnguardartitulo = document.getElementById('btnguardartitulomodal');
    btnguardarexperiencia = document.getElementById('btnguardarexperienciamodal');
    btnguardarobservacion = document.getElementById('btnguardarobservacionmodal');
    fechaingreso = document.getElementById('fechaingreso');
    fechasalida = document.getElementById('fechasalida');


    txttitulo = document.getElementById('txttitulo');
    txtespecialidad = document.getElementById('txtespecialidad');
    txtinstitucion = document.getElementById('txtinsitucion');
    mesobtencion = document.getElementById('mesobtencion');
    anoobtencion = document.getElementById('anoobtencion');

    txtempresa = document.getElementById('txtempresa');
    txtpuesto = document.getElementById('txtpuesto');
    txtresponsabilidades = document.getElementById('txtresponsabilidades');

    txtmeritos = document.getElementById('txtmerito');

    modaleliminar = document.getElementById('modaleliminar');
    lblestaseguro = document.getElementById('estaseguro');
    btneliminar = document.getElementById('btneliminarmodal');

    btnagregartitulo.addEventListener('click', abrirtitulonuevo, false);
    btnagregartitulo.addEventListener('click', limpiarcampostitulo, false);
    btnagregarexperiencia.addEventListener('click', limpiarcamposexperiencia, false);
    btnagregarexperiencia.addEventListener('click', abrirexperiencianueva, false);
    btnagregarobservacion.addEventListener('click', function () { txtmeritos.value = '' }, false);
    btnagregarobservacion.addEventListener('click', abrirobservacionnuevo, false);

    btnguardartitulo.addEventListener('click', guardartitulo, false);
    btnguardarexperiencia.addEventListener('click', guardarexperiencia, false);
    btnguardarobservacion.addEventListener('click', guardarobservacion, false);

    btneliminar.addEventListener('click', eliminar, false);

    editandotitulo = false;
    editandoexperiencia = false;
    editandoobservacion = false;

    alertify.set('notifier', 'position', 'top-right');
}

/*metodos para controlar las ventanas modal*/
function abrirtitulonuevo() {

    document.getElementById('modaltitulonuevo').style.display = "flex";
}

function abrirexperiencianueva() {
    document.getElementById('modalexperiencianuevo').style.display = "flex";
}

function abrirobservacionnuevo() {
    document.getElementById('modalobservacionnuevo').style.display = "flex";
}

function cerrar(ventana) {
    document.getElementById(ventana).style.display = "none";
}

function limpiarcampostitulo() {
    txtespecialidad.value = '';
    txtinstitucion.value = '';
    txttitulo.value = '';
    mesobtencion.value = '-mes-';
    anoobtencion.value = '-Ano-';
}

function limpiarcamposexperiencia() {
    txtempresa.value = '';
    txtpuesto.value = '';
    txtresponsabilidades.value = '';
    fechaingreso.value = '';
    fechasalida.value = '';
}


/*metodos para guardar cuando alguien genera un registro nuevo o edita uno*/
function guardartitulo() {
    if (validartitulo()) {
        var form = new FormData();
        if (editandotitulo) {
            //meter id y en php if isset(id) entonces actualizar
        }
        form.append('cedula', cedulauser);
        form.append('titulo', txttitulo.value);
        form.append('institucion', txtinstitucion.value);
        form.append('especialidad', txtespecialidad.value);
        form.append('mes', mesobtencion.value);
        form.append('ano', anoobtencion.value);
        axios.post('curriculum/titulo', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    alertify.success('Titulo registrado correctamente.');
                    window.setTimeout(function () {
                        // Move to a new location or you can do something else
                        window.location.href = getbaseurl() + '/miperfil/curriculum';
                    }, 1200);
                } else {
                    alertify.error(response.data);
                }
            })
            .catch(function (error) {
                alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
            })
    } else {
        alertify.error('Existen errores en los campos');
    }

}

function guardarexperiencia() {
    if (validarexperiencia()) {
        var form = new FormData();
        if (editandotitulo) {
            //meter id y en php if isset(id) entonces actualizar
        }
        form.append('cedula', cedulauser);
        form.append('empresa', txtempresa.value);
        form.append('puesto', txtpuesto.value);
        form.append('responsabilidades', txtresponsabilidades.value);
        form.append('fechaingreso', fechaingreso.value);
        form.append('fechasalida', fechasalida.value);
        axios.post('curriculum/experiencia', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    alertify.success('Experiencia profesional registrado correctamente.');
                    window.setTimeout(function () {
                        // Move to a new location or you can do something else
                        window.location.href = getbaseurl() + '/miperfil/curriculum';
                    }, 1200);
                } else {
                    alertify.error(response.data);
                }
            })
            .catch(function (error) {
                alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
            })
    } else {
        alertify.error('Existen errores en los campos');
    }
}

function guardarobservacion() {
    if (stringvalido(txtmeritos.value, 250)) {
        var form = new FormData();
        if (editandoobservacion) {
            //meter id y en php if isset(id) entonces actualizar
        }
        form.append('cedula', cedulauser);
        form.append('merito', txtmeritos.value);

        axios.post('curriculum/observacion', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    alertify.success('Observacion o merito registrado correctamente.');
                    window.setTimeout(function () {

                        window.location.href = getbaseurl() + '/miperfil/curriculum';
                    }, 1200);
                } else {
                    alertify.error(response.data);
                }
            })
            .catch(function (error) {
                alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
            })
    } else {
        alertify.error("Existen errores en el campo de descripcion. Por favor revise e intente de nuevo.");
    }
}

function validartitulo() {
    //validar que los campos cumplan con los requerimientos de BD y asi
    if (!stringvalido(txttitulo.value, 50) || !stringvalido(txtespecialidad.value, 50) || !stringvalido(txtinstitucion.value, 50) || mesobtencion.value == '-mes-' || anoobtencion.value == '-Ano-') {
        return false;
    }
    return true;
}

function validarexperiencia() {
    //validar que los campos cumplan con los requerimientos de BD y asi
    if (!stringvalido(txtempresa.value, 50) || !stringvalido(txtpuesto.value, 50) || !stringvalido(txtresponsabilidades.value, 200) || fechaingreso.value == '') {
        return false;
    }
    return true;
}

function eliminartitulo(id) {
    ideliminar = id;
    tipoeliminar = 1;
    modaleliminar.style.display = "flex";
    lblestaseguro.innerHTML = '¿Esta seguro de que quiere eliminar este titulo de su curriculum?\nEsta accion no se puede deshacer.'
}

function eliminarexperiencia(id) {
    ideliminar = id;
    tipoeliminar = 2;
    modaleliminar.style.display = "flex";
    lblestaseguro.innerHTML = '¿Esta seguro de que quiere eliminar esta experiencia profesional de su curriculum?\nEsta accion no se puede deshacer.'
}

function eliminarobservacion(id) {
    ideliminar = id;
    tipoeliminar = 3;
    modaleliminar.style.display = "flex";
    lblestaseguro.innerHTML = '¿Esta seguro de que quiere eliminar este merito u observacion de su curriculum?\nEsta accion no se puede deshacer.'
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

                    window.location.href = getbaseurl() + '/miperfil/curriculum';
                }, 1200);
            } else {
                alertify.error(response.data);
            }
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
        })
}