window.addEventListener('load', iniciar, false);

var txtbuscar;
var btnbuscar;
var contenedorempresas;

function iniciar() {
    txtbuscar = document.getElementById('txtbuscar');
    btnbuscar = document.getElementById('btnbuscar');
    contenedorempresas = document.getElementById('contenedorempresas');
    txtbuscar.value = '';
    btnbuscar.addEventListener('click', buscar, false);
}

function buscar() {
    var empresas;
    var form = new FormData();
    form.append('empresa', txtbuscar.value);
    axios.post('/buscarempresas', form)
        .then(function (response) {
            contenedorempresas.innerHTML = '';
            empresas = response.data;

            for (var i = 0; i < empresas.length; i++) {
                contenedorempresas.innerHTML += '<div class="detallecontenedor">' +
                    '<label>Empresa: ' + empresas[i]['nombre'] + '</label><br>' +
                    '<label>Cedula Juridica: ' + empresas[i]['cedula'] + '</label><br>' +
                    '<form action="/reporte/empresa" id="aplicaciones'+i+'" name="aplicaciones'+i+'" method="POST" target="_blank" hidden>' +
                    '{{csrf_field()}}' +
                    '<input type="text" id="empresa" name="empresa" value="' + empresas[i]['cedula'] + '">' +
                    '</form>' +
                    '<input type="submit" value="Generar" class="btnconestilo" form="aplicaciones'+i+'">'+
                    '</div>';
            }
        })
        .catch(function (error) {
            alertify.error('Ocurrio un error interno al intentar buscar. Por favor intente mas tarde.');
        })

}