/**
 * Created by fmbv on 24/08/2017.
 */
//document.write('en common.js hola');

/*$(document).ready(function () {

});
*/
/**
 * Cambia el titulo de la pagina de forma
 * dinamica.
 * @param titulo String con el texto a mostrar en el titulo
 */
function cambiarTitulo(titulo) {
    $("title")[0].innerHTML = titulo;
}

/**
 * Evitar el envio del formulario pasado por parametros
 * @param idForm    Id del formulario
 */
function noSubmit(idForm) {
    $("#" + idForm).submit(function (evt) {
        evt.preventDefault();
    });
}


/**
 * envio de formulario con js
 * @param formulario   formulario que se va a enviar
 * @param url           uri con la url donde se van a mandar los datos
 */
function enviarForm(formulario, url) {
    $("#" + formulario).attr("action", url);
    //$("#"+form).submit();  //TODO ->no funciona ??
    document[formulario].submit();
}

/**
 * Capturar todos los elementos del formulario para
 * almacenarlos en un objeto. Se pasa como parametro
 * el id del formulario y los tipos de elementos a capturar.
 * P.Ej. getElementForm('#myForm input');
 * @param formulario   idFormulario
 * @returns {Object}
 */
function getElementForm(formulario) {
    var datos = new Object();
    $(formulario).each(function (index, element) {
        //console.log(index+ "  "+ element.id+" : " +element.value);        // nombre = eval(element.id);
        datos[element.id] = element.value;
    });
    return datos;
}

/**
 * Almacenar el valor del checkbox en un array
 * @param element   checkbox seleccionado
 * @param array     array que esta almacenando los valores
 * @returns {*|Array}
 */
function checkboxToArray(element, array) {
    var arrayTmp = array || [];
//almacenar-actualizar los valores del rol en un array segun se marquen o desmarquen
        if ($(element).is(':checked')) {
            arrayTmp.push($(element).val());                   //si se marca arradir al array
        } else {
            var indice = arrayTmp.indexOf($(element).val());    //buscar el indice en el array del elemento desmarcado
            arrayTmp.splice(indice, 1);                       //eliminar elemento
        }
        arrayTmp.sort()                                     //ordenar el array
        return arrayTmp;                           //devolver los valores actualizados del array

}


/**
 *  Abrir la ventana modal con
 *  estilo boostrap
 */
function ventanaModal() {
    $("#ventanaModal").data('bs.modal', null);  //evitar perder la referencia previa al backdrop y limpiar el bs modal data
    $("#ventanaModal").modal({backdrop: 'static', keyboard: false}); //anular tecla de escape o click fuera de la ventana
}

/**
 * Ventana modal que se muestra cuando finaliza la sesion.
 * La ventana redirige al formulario de login
 */
function ventanafinSesion() {
    ventanaModal();
    $(".modal-title").html("Información de Sesion");                       //añadir titulo a ventana modal
    $(".modal-title").parent("div").removeClass('bg-light-blue-active bg-olive alert alert-error');  //eliminar las clases
    $(".modal-title").parent("div").addClass('alert alert-warning ');  //añadir la clase
    $("#btnCerrar").removeClass('btn-default')
    $("#btnCerrar").addClass('btn-warning')
    $("#contenidoModal").html("Su sesión ha caducado. Deberá logarse de nuevo.");
    $("#btnCerrar, button.close").on('click', function () {
            $(location).attr('href', '/');
    });
}

/**
 * Recoger el valor del elemento del menu que se ha seleccionado
 * y recorgar la página iniciar la pagina con los valores recogidos
 */
var menu = function () {
    $(".sidebar-menu a").on('click', function (evt) {
        //console.log($(this).data().modulo.toUpperCase());
        $("#hmod").val($(this).data().modulo);  //asignacion del valor al input hmod oculto
        evt.preventDefault();   //evitar la accion por defecto del evento
        //envio del formulario a la pagina indicada
        enviarForm("frmCuerpo", "page.php"); //TODO -> descomentar
    })
}


/**
 * Obtener las cookie que coincida con el nombre pasado por parametros
 * @param nombre String Nombre de la cookie
 * @returns {*} Valor de la cookie
 */
function getCookie(nombre) {
    var aCookies = decodeURIComponent(document.cookie).split(";");
    var signoIgual, sNombreCook, sValorCook = null;
    for (var i = 0; i < aCookies.length; i++) {
        signoIgual = aCookies[i].indexOf("=");
        sNombreCook = aCookies[i].substr(0, signoIgual);
        // alert("array "+i+" "+sNombreCook+ " "+nombre);
        if (sNombreCook == nombre) {
            sValorCook = aCookies[i].substr(signoIgual + 1);
            //  alert("array "+sValorCook);
        }

    }
    return sValorCook;
}


/**
 * cargar el spiner de actualizacion de datos
 */
function loadSpinner(idLoaderImage, textoSpinner){
    textoSpinner = textoSpinner || "Actualizando datos ...."
    $("#"+idLoaderImage).hide()
    $("#"+idLoaderImage).html("<img id='spinner'> <span>" + textoSpinner +"</span>")
    $('#spinner').attr('src', "/images/images_geres/spinner.gif" )
    $('#spinner').css({'position':'absolute','z-index': '9999', 'margin-top':'0%', 'margin-left':'20%'})
    $("#loaderImage span").css({'position':'absolute','z-index': '9999', 'margin-top':'1%', 'margin-left':'30%', 'line-height': '30px', 'font-weight': 'bold','color': '#1041CA'})
}
/**
 * Mostrar el spiner de actualizacion de datos
 */
function mostrarSpinner(){
    $("#loaderImage").clearQueue().fadeIn();     //mostramos el mensaje con efecto y eliminando de la cola los elementos no procesados aun
}

