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
var barraseguridad;
var nivelSeguridad;//mide el nivel actual de seguridad de la contraseña 0 mala, 1 normal, 2 buena, 3 fuerte, 4 excelente

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
    barraseguridad = document.getElementById('seguridadcontra');

    btnempresa.addEventListener('click', selecempresa, false);
    btnpersona.addEventListener('click', selecpersona, false);
    btnlimpiar.addEventListener('click', limpiarcampos, false);
    btnguardar.addEventListener('click', intentarguardar, false);
    alertify.set('notifier', 'position', 'top-right');

    nivelSeguridad = 0;

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
        if (btnpersona.checked) {
            form.append('tipo', 1);
            form.append('apellidos', campoapellidos.value);
        } else {
            form.append('tipo', 2);
            form.append('apellidos', '');
        }
        form.append('cedula', campocedula.value);
        form.append('nombre', camponombre.value);
        form.append('usuario', campouser.value);
        form.append('contra', campocontra.value);
        form.append('direccion', campodireccion.value);
        form.append('correo', campocorreo.value);
        form.append('telefono', campotelefono.value);
        axios.post('registro', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    alertify.success('Usuario registrado correctamente. Pronto sera redireccionado a la pagina de log in.');
                    window.setTimeout(function () {
                        // Move to a new location or you can do something else
                        window.location.href = getbaseurl() + '/login';
                    }, 3000);
                } else {
                    alertify.error(response.data);
                }
            })
            .catch(function (error) {
                alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
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
    if (nivelSeguridad < 3) {
        alertify.error('La contraseña es muy debil.');
        return false;
    }
    return true;
}

//funcion que analiza que tan segura es una contraseña y en base a eso llena el progress bar
function seguridadcontra() {
    var contra = campocontra.value;
    var tipopass = document.getElementById('tipopass');
    nivelSeguridad = 0;

    if (contra.match(/[a-z]/)) {
        nivelSeguridad += 1;
    }
    if (contra.match(/[0-9]/)) {
        nivelSeguridad += 1;
    }
    if (contra.match(/[A-Z]/)) {
        nivelSeguridad += 1;
    }
    if (contra.match(/[!@#$%^&*()~<>?]/)) {
        nivelSeguridad += 1;
    }
    if (contra.length > 7) {
        nivelSeguridad += 1;
    }

    switch (nivelSeguridad) {
        case 0:
            barraseguridad.value = 0;
            tipopass.innerHTML = 'No Aceptable';
            tipopass.hidden = true;
            tipopass.style.left = '43px';

            break;
        case 1:
            barraseguridad.value = 20;
            barraseguridad.className = '';
            tipopass.hidden = false;
            barraseguridad.classList.add('red');
            tipopass.style.color = 'black';
            tipopass.innerHTML = 'No Aceptable';
            tipopass.style.left = '43px';

            break;
        case 2:
            barraseguridad.value = 40;
            barraseguridad.className = '';
            tipopass.hidden = false;
            barraseguridad.classList.add('red');
            tipopass.innerHTML = 'No Aceptable';
            tipopass.style.color = 'black';
            tipopass.style.left = '43px';
            break;
        case 3:
            barraseguridad.value = 60;
            tipopass.hidden = false;
            barraseguridad.classList.add('blue');
            tipopass.innerHTML = 'Aceptable';
            tipopass.style.color = 'white';
            tipopass.style.left = '55px';
            break;
        case 4:
            barraseguridad.value = 80;
            tipopass.hidden = false;
            tipopass.innerHTML = 'Buena';
            tipopass.style.color = 'white';
            tipopass.style.left = '65px';
            break;
        case 5:
            barraseguridad.value = 100;
            tipopass.hidden = false;
            barraseguridad.className = '';
            barraseguridad.classList.add('green');
            tipopass.style.color = 'white';
            tipopass.innerHTML = 'Excelente';
            tipopass.style.left = '58px';
            break;
    }
}

//metodo que se llama cuando el usuario digita en confirmar contrasena
function contraconciden() {
    if (campoconfirmarcontra.value.length > 0) {
        document.getElementById('contraconciden').hidden = false;
        if (campocontra.value == campoconfirmarcontra.value) {
            document.getElementById('contraconciden').innerHTML = "Las contraseñas coinciden.";
            document.getElementById('contraconciden').style.right = '300px'
        }else{
            document.getElementById('contraconciden').innerHTML = "Las contraseñas no coinciden.";
            document.getElementById('contraconciden').style.right = '280px'
        }
    } else {
        document.getElementById('contraconciden').hidden = true;
    }

}