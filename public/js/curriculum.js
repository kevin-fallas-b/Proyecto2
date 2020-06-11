window.addEventListener('load', iniciar, false);

var btnagregartitulo;
var btnagregarexperiencia;
var btnagregarobservacion;

function iniciar() {
    btnagregartitulo = document.getElementById('btnagregartitulo');
    btnagregarexperiencia = document.getElementById('btnagregarexperiencia');
    btnagregarobservacion = document.getElementById('btnagregarobservacion');

    btnagregartitulo.addEventListener('click', abrirtitulonuevo, false);
    btnagregarexperiencia.addEventListener('click', abrirexperiencianueva, false);
    btnagregarobservacion.addEventListener('click', abrirobservacionnuevo, false);
}

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