//archivo JS que incluye cosas que puedo necesitar en cualquier lugar entonces para no repetir codigo

//metodo validar la integridad y longitud de un string
function stringvalido(revisar, tamanomax) {
    //revisar que no sea nulo
    if (!revisar || /^\s*$/.test(revisar)) {
        return false;
    }
    //revisar que no sean puros espacios
    if (revisar.length === 0 || !revisar.trim()) {
        return false;
    }
    //revisar que no sobrepase tamano max
    if (revisar.length > tamanomax) {
        return false;
    }
    return true;
}

//funcion sacada de la mejor pagina del mundo (Stackoverflow.com) para conseguir la base del URL desde JS. se usa como para cargar imagenes y demas.
function getbaseurl(){
    var getUrl = window.location;
    return  getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
}