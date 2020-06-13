window.addEventListener('load', inicial, false);


var ventanamodal;
var idlistado;//guardar el id del listado que estamos viendo por si se decide eliminar
var cedulauser;//si es -1, el usuario no esta logeado


function inicial() {
    alertify.set('notifier', 'position', 'top-right');
    ventanamodal = document.getElementById('modallistado');
    cedulauser = document.getElementById('lblcedulauser').innerHTML;

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
            document.getElementById('lblsalario').innerHTML = new Intl.NumberFormat().format(listado[0]['salario']) + '.00';
            document.getElementById('lblfecha').innerHTML = listado[0]['fecha'];

            document.getElementById('contenedorcategorias').innerHTML = '';
            document.getElementById('contenedorcategorias').innerHTML = '<div class="titulocategoriasmodal">' +
                '<label id="">Categorias</label>' +
                '</div>';
            for (var i = 0; i < listado['categorias'].length; i++) {
                document.getElementById('contenedorcategorias').innerHTML += '<label>' +
                    '-' + listado['categorias'][i]['nombre'] +
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

            document.getElementById('lblcantidadaplicantes').innerHTML = listado['aplicantes'].length;
            ventanamodal.style.display = 'flex';

        })
        .catch(function (error) {
            alertify.error('Lo sentimos. Ocurrio un error interno al intentar buscar. Por favor intente mas tarde.');
        })
}

function cerrarmodal() {
    ventanamodal.style.display = "none";
    document.getElementById('btnremoveraplicacion').hidden = true;
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
                    window.location.href = getbaseurl() + '/aplicaciones';
                }, 1200);
            } else {
                alertify.error(response.data);
            }
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar remover la aplicacion. Por favor intente mas tarde.');
        })
}

function generarreporte(){
    var form = new FormData();
    form.append('cedula', cedulauser);
    axios.post('reporte/aplicaciones', form)
        .then(function (response) {
            console.log(response)
            if (response.data === 'exito') {
                
            } else {
                alertify.error(response.data);
            }
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar remover la aplicacion. Por favor intente mas tarde.');
        })
}