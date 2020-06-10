window.addEventListener('load', inciar, false);
window.addEventListener('beforeunload', senosva, false);


var btneditar;
var contenedoreditar;
var contenedorinformacionpersonal;

//variables que contienen la informacion editada de un usuario
var campoeditandonombre;
var campoeditandoapellidos;
var campoeditandocorreo;
var campoeditandotelefono;
var campoeditandodireccion;
var campoediandocontra;
var campoediandoconfirmarcontra;

//labels que contienen la informacion de un usuario, la que viene directo de BD
var cedulauser;
var nombreuser;
var apellidouser;
var correouser;
var telefonouser;
var direccionuser;
var tipouser;

//btn para editar
var btncancelar;
var btnguardar;
var editando; //sencilla bandera
var cambiocontra; //sencilla bandera
var btnbuscarimagen;
var filepickerimagen;
var fotooriginal;//nombre de la foto original por si el usuario cancela la edicion
var cambiofoto;//bandera

function inciar() {
    contenedoreditar = document.getElementById('contenedoreditar');
    contenedorinformacionpersonal = document.getElementById('informacionpersonal');
    btneditar = document.getElementById('btneditar');

    //recuperar campos de editar y los labels con info de usuario
    campoeditandoapellidos = document.getElementById('campoeditarapellidos');
    campoeditandonombre = document.getElementById('campoeditarnombre');
    campoeditandotelefono = document.getElementById('campoeditartelefono');
    campoeditandocorreo = document.getElementById('campoeditarcorreo');
    campoeditandodireccion = document.getElementById('campoeditardireccion');
    campoediandocontra = document.getElementById('campoeditarcontra');
    campoediandoconfirmarcontra = document.getElementById('campoeditarconfircontra');

    cedulauser = document.getElementById('cedulauser');
    nombreuser = document.getElementById('nombreuser');
    apellidouser = document.getElementById('apellidosuser');
    correouser = document.getElementById('correouser');
    direccionuser = document.getElementById('direccionuser');
    telefonouser = document.getElementById('telefonouser');
    tipouser = document.getElementById('tipouser').innerHTML;

    btnguardar = document.getElementById('btnguardar');
    btncancelar = document.getElementById('btncancelar');
    btnbuscarimagen = document.getElementById('btnbuscarimagen')
    filepickerimagen = document.getElementById('escogerimagen');

    btneditar.addEventListener('click', editar, false);
    btncancelar.addEventListener('click', cancelaredicion, false);
    btnguardar.addEventListener('click', guardaredicion, false);
    btnbuscarimagen.addEventListener('click', buscarimagen, false);
    filepickerimagen.addEventListener('change', escogiofoto, false);
    alertify.set('notifier', 'position', 'top-right');
    editando = false;
    cambiocontra = false;
    fotooriginal = document.getElementById('fotousuario').src;
}


function editar() {
    editando = true;
    contenedorinformacionpersonal.classList.add('ocultar');
    setTimeout(function () {
        contenedorinformacionpersonal.hidden = true;
        contenedoreditar.hidden = false;
        contenedoreditar.classList.remove('ocultar');
        btnbuscarimagen.hidden = false;
        btnbuscarimagen.classList.remove('ocultar');

    }, 500);
    if (tipouser == 1) {
        campoeditandoapellidos.value = apellidouser.innerHTML;

    }
    campoeditandonombre.value = nombreuser.innerHTML;
    campoeditandocorreo.value = correouser.innerHTML;
    campoeditandotelefono.value = telefonouser.innerHTML;
    campoeditandodireccion.value = direccionuser.innerHTML;
}

function cancelaredicion() {
    editando = false;
    contenedoreditar.classList.add('ocultar');
    btnbuscarimagen.classList.add('ocultar');
    if (cambiofoto) {
        document.getElementById('fotousuario').src = fotooriginal;

    }
    setTimeout(function () {
        contenedoreditar.hidden = true;
        btnbuscarimagen.hidden = true;
        contenedorinformacionpersonal.hidden = false;
        contenedorinformacionpersonal.classList.remove('ocultar');
    }, 500);
}

function guardaredicion() {
    if (validarcampos()) {
        //ajax time baby

        var form = new FormData();
        if (tipouser == 1) {
            form.append('apellidos', campoeditandoapellidos.value);
        } else {
            form.append('apellidos', '');
        }
        form.append('cedula', cedulauser.innerHTML);
        form.append('nombre', campoeditandonombre.value);
        form.append('direccion', campoeditandodireccion.value);
        form.append('correo', campoeditandocorreo.value);
        form.append('telefono', campoeditandotelefono.value);
        if (cambiocontra) {
            form.append('contra', campoediandocontra.value);
        }
        if(cambiofoto){
            //sacar el nombre de la foto y meterla a bd y ademas subir foto al servidor
            form.append('foto',filepickerimagen.files[0]);
        }
        axios.post('miperfil', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    alertify.success('Usuario actualizado correctamente.');
                    setTimeout(function () {
                        editando = false;
                        location.reload();
                    }, 1000);
                } else {
                    alertify.error(response.data);
                }
            })
            .catch(function (error) {
                alertify.error('Ocurrio un error interno al intentar guardar. Por favor intente mas tarde.');
            })
    }
}

//para cuando el usuario intenta editar la informacion personal
function validarcampos() {
    //se basa en el metodo stringvalido de general.js
    if (!stringvalido(campoeditandonombre.value, 50) || !stringvalido(campoeditandodireccion.value, 200) || !stringvalido(campoeditandotelefono.value, 10) || !stringvalido(campoeditandocorreo.value, 50)) {
        alertify.error('Existen errores en los campos.');
        return false;
    }

    if (tipouser == 1 && !stringvalido(campoeditandoapellidos.value, 50)) {
        //estamos actualizando persona y no metio un apellido valido
        alertify.error('Existen errores en los campos.');
        return false;
    }

    if (stringvalido(campoediandocontra.value, 20) || stringvalido(campoediandoconfirmarcontra.value, 20)) {
        //usuario ingreso algo en cmapo de contrase;as
        if (campoediandocontra.value !== campoediandoconfirmarcontra.value) {
            //contrasenas no coinciden

            alertify.error('Las contraseñas no coinciden.');
            return false;
        } else {
            cambiocontra = true;
        }
    } else {
        cambiocontra = false;

    }
    return true;
}

function senosva(e) {
    if (editando) {
        e.preventDefault();
    }
}

function buscarimagen() {
    //guardar nombre de imagen original por si el usuario cancela
    filepickerimagen.click();
}

function escogiofoto() {
    cambiofoto = true;
    document.getElementById('fotousuario').src = URL.createObjectURL(filepickerimagen.files[0])
}