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
function getCurrentUrl(){ //retorna algo como localhost:8000/registro
    var getUrl = window.location;
    return  getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
}

function getbaseurl(){
    var getUrl = window.location;
    return  getUrl.protocol + "//" + getUrl.host;
}

https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

https://stackoverflow.com/questions/7295843/allow-only-numbers-to-be-typed-in-a-textbox
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


function mensaje(mensaje, tipomensaje){
    if(tipomensaje == 1){
        alertify.success(mensaje);
    }else{
        alertify.error(mensaje);
    }
}