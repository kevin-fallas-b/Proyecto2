window.addEventListener('load', inicial, false);

var btnbuscar;
var resultadobusqueda;
var contenedordetalles;
var ventanamodal;
var idlistado;//guardar el id del listado que estamos viendo por si se decide aplicar
var cedulauser;//si es -1, el usuario no esta logeado

function inicial() {
    alertify.set('notifier', 'position', 'top-right');
    btnbuscar = document.getElementById('btnbuscar')
    contenedordetalles = document.getElementById('contenedordetalles');
    ventanamodal = document.getElementById('modallistado');
    cedulauser = document.getElementById('lblcedulauser').innerHTML;
    document.getElementById('txtdescripcion').value='';
    document.getElementById('txtcategoria').value='';
    document.getElementById('txtempresa').value='';


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
            console.log(response.data)
            generarresultadosbusqueda();
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar buscar. Por favor intente mas tarde.');
        })
}

function generarresultadosbusqueda() {
    contenedordetalles.innerHTML = '';
    document.getElementById('lblofertasbusqueda').innerHTML='Resultado de la busqueda'
    for (var i = 0; i < resultadobusqueda.length; i++) {
        contenedordetalles.innerHTML += '<div class="detallecontenedor">' +
            '<label>Descripcion: ' + resultadobusqueda[i]['descripcion'] + '</label><br>' +
            '<label>Empresa: ' + resultadobusqueda[i]['empresa'] + '</label><br>' +
            '<label>Vacantes: ' + resultadobusqueda[i]['numero_vacantes'] + '</label><br>' +
            '<label>Fecha de publicacion: ' + resultadobusqueda[i]['fecha'] + '</label><br>' +
            '<input type="button" value="Ver listado" class="btnconestilo" onclick="verlistado(' + resultadobusqueda[i]['id'] + ')">';
        '</div>';
    }
}


function verlistado(id) {
    var listado;
    idlistado = id;
    var form = new FormData();
    form.append('id', id);
    axios.post('/listado', form)
        .then(function (response) {
            listado = response.data;
            //para que llegara bien el JSON se hizo medio desordenado
            //listado es un array que contiene arrays, ciertos arrays de esos contiene arrays
            document.getElementById('lbldescripcion').innerHTML = listado[0]['descripcion'];
            document.getElementById('lblempresa').innerHTML = listado['empresa'][0]['nombre'];
            document.getElementById('lblvacantes').innerHTML = listado[0]['numero_vacantes'];
            document.getElementById('lblubicacion').innerHTML = listado[0]['ubicacion'];
            document.getElementById('lblhorario').innerHTML = listado[0]['horario'];
            document.getElementById('lblcontrato').innerHTML = listado[0]['duracion'];
            document.getElementById('lblsalario').innerHTML = new Intl.NumberFormat().format(listado[0]['salario'])+'.00';
            document.getElementById('lblfecha').innerHTML = listado[0]['fecha'];

            document.getElementById('contenedorcategorias').innerHTML = '';
            document.getElementById('contenedorcategorias').innerHTML = '<div class="titulocategoriasmodal">' +
                '<label id="">Categorias</label>' +
                '</div>';
            for (var i = 0; i < listado['categorias'].length; i++) {
                document.getElementById('contenedorcategorias').innerHTML += '<label>' +
                    '-'+listado['categorias'][i]['nombre'] +
                    '</label><br>'
            }

            document.getElementById('contenedorrequisitos').innerHTML = '';
            document.getElementById('contenedorrequisitos').innerHTML = '<div class="titulocategoriasmodal">' +
                '<label id="">Requisitos</label>' +
                '</div>';
            for (var i = 0; i < listado['requisitos'].length; i++) {
                document.getElementById('contenedorrequisitos').innerHTML += '<label>' +
                    '-' + listado['requisitos'][i]['Descripcion'] +
                    '</label><br>'

                
            }
            //ver si ya aplique a esta aplicacion
            for (var i = 0; i < listado['aplicantes'].length; i++) {
                if (listado['aplicantes'][i]['cedula'] == cedulauser) {
                    document.getElementById('btnaplicaroferta').hidden = true;
                    document.getElementById('btnremoveraplicacion').hidden = false;
                    alertify.success('Ya enviaste una aplicacion a esta empresa');
                    break;
                }
            }
            document.getElementById('lblcantidadaplicantes').innerHTML = listado['aplicantes'].length;
            ventanamodal.style.display ='flex';

        })
        .catch(function (error) {
            alertify.error('Lo sentimos. Ocurrio un error interno al intentar buscar. Por favor intente mas tarde.');
        })
}

function cerrarmodal() {
    ventanamodal.style.display = "none";
    document.getElementById('btnaplicaroferta').hidden = false;
    document.getElementById('btnremoveraplicacion').hidden = true;
}

function aplicaroferta() {
    if (cedulauser == -1) {
        alertify.error('Debe ingresar a su cuenta para poder aplicar a una oferta de trabajo.');
        return;
    } else {
        var form = new FormData();
        form.append('idoferta', idlistado);
        form.append('cedula', cedulauser);
        axios.post('aplicar', form)
            .then(function (response) {
                if (response.data === 'exito') {
                    alertify.success('Aplicacion realizada correctamente.');
                    window.setTimeout(function () {
                        window.location.href = getbaseurl() + '/';
                    }, 1200);
                } else {
                    alertify.error(response.data);
                }
            })
            .catch(function (error) {
                alertify.error('Ocurrio un error interno al intentar aplicar. Por favor intente mas tarde.');
            })
    }
}

function removeraplicacion() {
    var form = new FormData();
    form.append('idoferta', idlistado);
    form.append('cedula', cedulauser);
    axios.post('removerapp', form)
        .then(function (response) {
            if (response.data === 'exito') {
                alertify.success('Aplicacion removida correctamente.');
                window.setTimeout(function () {
                    window.location.href = getbaseurl() + '/';
                }, 1200);
            } else {
                alertify.error(response.data);
            }
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar aplicar. Por favor intente mas tarde.');
        })
}