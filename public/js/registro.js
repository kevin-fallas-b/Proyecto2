window.addEventListener('load', iniciar, false);

var btnpersona;
var btnempresa;

var campocedula;
var camponombre;
var campoapellidos;
var campouser;
var campocorreo;
var campocontra;
var campoconfirmarcontra;
var campodireccion;
var campotelefono;

var btnlimpiar;
var btnguardar;

function iniciar() {
    btnempresa = document.getElementById('rbempresa');
    btnpersona = document.getElementById('rbpersona');
    campocedula = document.getElementById('txt_cedula');
    camponombre = document.getElementById('txt_nombre');
    campoapellidos = document.getElementById('txt_apellidos');
    campouser = document.getElementById('txt_user');
    campocorreo = document.getElementById('txt_correo');
    campocontra = document.getElementById('txt_contra');
    campoconfirmarcontra = document.getElementById('txt_confirmarcontra');
    campodireccion = document.getElementById('txt_direccion');
    campotelefono = document.getElementById('txt_telefono');

    btnlimpiar = document.getElementById('btnlimpiar');
    btnguardar = document.getElementById('btnguardar');

    btnempresa.addEventListener('click', selecempresa, false);
    btnpersona.addEventListener('click', selecpersona, false);
    btnlimpiar.addEventListener('click', limpiarcampos, false);
    btnguardar.addEventListener('click', intentarguardar, false);
    alertify.set('notifier', 'position', 'top-right');

}

//metodo ejecutado cuando el usuario selecciona registrarse como empresa
function selecempresa() {
    document.getElementById('txt_apellidos').classList.add('ocultar');
    document.getElementById('txt_cedula').placeholder = 'Cedula Juridica'
    document.getElementById('txt_cedula').title = 'Cedula Juridica'
}

//metodo ejecutado cuando el usuario selecciona registrarse como persona
function selecpersona() {
    campoapellidos.value = '';
    document.getElementById('txt_apellidos').classList.remove('ocultar');
    document.getElementById('txt_cedula').placeholder = 'Cedula'
    document.getElementById('txt_cedula').title = 'Cedula'

}

function limpiarcampos() {
    campocedula.value = '';
    camponombre.value = '';
    campoapellidos.value = '';
    campouser.value = '';
    campocorreo.value = '';
    campocontra.value = '';
    campoconfirmarcontra.value = '';
    campodireccion.value = '';
    campotelefono.value = '';
}

//metodo que se ejecuta al dar click en guardar
function intentarguardar() {
    if (validarcampos()) {
        //campos correctos. intentar guardar

        var form = new FormData();
        axios.post('admin/getsecciones', form)
            .then(function (response) {
                
            })
            .catch(function (error) {
                
            })

    }
}

function validarcampos() {
    //se basa en el metodo stringvalido de general.js
    if (!stringvalido(campocedula.value, 11) || !stringvalido(camponombre.value, 50) || !stringvalido(campocontra.value, 50) || !stringvalido(campoconfirmarcontra.value, 50) || !stringvalido(campodireccion.value, 200) || !stringvalido(campotelefono.value, 11) || !stringvalido(campocorreo.value, 50)) {
        alertify.error('Existen errores en los campos.');
        return false;
    }

    if (btnpersona.checked && !stringvalido(campoapellidos.value, 50)) {
        //estamos registrando persona y no metio un apellido valido
        alertify.error('Existen errores en los campos.');
        return false;
    }

    if (campocontra.value !== campoconfirmarcontra.value) {
        //contrasenas no coinciden
        alertify.error('Las contraseñas no coinciden.');
        return false;
    }
}