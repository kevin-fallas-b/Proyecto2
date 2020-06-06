window.addEventListener('load',inicial,false);

var btnsubmit;
var btnlogin;

function inicial(){
    document.getElementById('txt_username').value ='';
    document.getElementById('txt_password').value ='';
    btnlogin = document.getElementById('btn_login');
    btnsubmit = document.getElementById('btn_submit');

    btnlogin.addEventListener('click',intentarlogin);
    alertify.set('notifier','position','top-right');

}


function intentarlogin(){
    //verificar que los campos esten llenos
    if(document.getElementById('txt_username').value.length > 0 && document.getElementById('txt_username').value.length <= 50 && document.getElementById('txt_password').value.length > 0){
        btnsubmit.click();
    }else{
        alertify.error("Por favor revise los campos.");
    }
}

function mensajeError(texto){
    alertify.error(texto);
}