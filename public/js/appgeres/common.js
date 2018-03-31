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
    $("#btnCerrar").removeClass('btn-default');
    $("#btnCerrar, button.close").attr('disabled', false);
    $("#btnCerrar").addClass('btn-warning');
    $("#contenidoModal").html("Su sesión ha caducado. Deberá logarse de nuevo.");
    $("#btnCerrar, button.close").removeAttr('data-dismiss');                 //quitar attr que produce el cierre de la ventana modal
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

/**
 * Callback cuando se produce un status distinto de 200 en
 * llamadas a Ajax
 * @param jqXHR
 */
function cbErrorAjax(jqXHR){
    var exito, mensaje, codStatus;
    accion = null;
    mensaje = null;
    if(jqXHR.hasOwnProperty('responseJSON')){ //si existe la propiedad
        accion = jqXHR.responseJSON.accion;
        mensaje = jqXHR.responseJSON.mensaje;
    }
    codStatus = jqXHR.status;

    $("#mensaje p").html(mensaje);          //rellenar el texto del mensaje
    $("#mensaje").addClass('alert alert-warning alert-dismissible')     //añadir las clases
    $("#mensaje").clearQueue().fadeIn('slow').delay(1500).fadeOut(3000, function(){     //efecto fadeIn->fadeOut
            $("#mensaje").removeClass('alert alert-warning alert-dismissible')
    });

    console.log('Accion realizada : ', accion, ' mensaje: ', mensaje, ' codigo estado html: ', codStatus)
    //$('#profile').bootstrapValidator('resetForm', true);
}

//FUNCIONALIDAD PARA LOS BOTONES VER/AÑADIR/ELIMINAR DE LOS DATATABLES
/**
 * Añade funcionalidad al boton ver de la tabla
 * @param tbody id de la tabla junto con el tag tbody
 * @param table Tabla a la que se aplica la funcionalidad
 */
var getDataView = function (tbody, table) {
    $(tbody).on('click', "button.ver", function () {  //funcionalidad cuando se pulsa el boton
        var datos = table.row($(this).parents("tr")).data();    //captura de datos de la fila
        $(".modal-title").html("Visualizar datos del usuario");
        inputDesactivo = true;
        bNewRecord = false;
        getDatos(datos);
    });

}

/**
 * Añade funcionalidad al boton modificar de la tabla
 * @param tbody id de la tabla junto con el tag tbody
 * @param table Tabla a la que se aplica la funcionalidad
 */
var getDataUpdate = function (tbody, table) {
    $(tbody).on('click', "button.editar", function () {
        var datos = table.row($(this).parents("tr")).data();
        $(".modal-title").html("Modificar datos del usuario");
        inputDesactivo = false;
        bNewRecord = false;
        getDatos(datos);
    });
}

/**
 * Añade funcionalidad al boton eliminar de la tabla
 * @param tbody id de la tabla junto con el tag tbody
 * @param table Tabla a la que se aplica la funcionalidad
 */
var getDataEliminar = function (tbody, table) {
    $(tbody).on('click', "button.eliminar", function () {
        var datos = table.row($(this).parents("tr")).data();
        borrar(datos);
    });
}

//Definir los mensajes mostrados en español en DataTables
var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": " &nbsp; ",             //texto a mostrar en la carga preva
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

}

// FIN FUNCIONALIDAD BOTONES DATATABLES

/**
 * Variables para los mensajes de validacion del formulario
 *
 */
var bvNoVacio = {
    message: 'El campo es requerido. Por favor introduce un valor.'
}
var bvElige = {
    message: 'Por favor, debes elegir un valor.'
}
var bvSoloTexto = {
    regexp: /^[a-zA-ZñÑ\s]+$/i,
    message: "Por favor no estan permitido números ni caracteres especiales"
}
var bvSoloNumero = {
    regexp: /^[0-9]+$/i,
    message: "Por favor solo se permiten números"
}
var bvPassword = {
    //regexp : /(?=^.{8,15}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/  , //letra May, letra min, 1 num ó 1 carct esp,
    regexp: /(?=^.{8,15}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/, //letra May, letra min, 1 num, 1 carct esp,
    message: "Al menos una letra Mayúscula.<br/>Al menos una letra minúscula.<br/>Al menos un dígito.<br/>Al menos un caracter especial.<br/>No se permiten espacios en blanco"
}
var bvTelefono = {
    country: 'ES',
    message: 'El número de teléfono en %s no es un número válido.'
}
var bvZipCode = {
    regexp: /^\d{5}$/,
    message: 'Por favor, el Código Postal debe contener 5 dígitos.'
}

var bvDni = {
    country: 'ES',
    message: 'El CIF/NIF indicado no es correcto.'
}



/**
 * Comprobar si es una imagen el fichero a subir
 * @param extension Extension del archivo a cargar
 * @returns {boolean}
 */
function isImage(extension) {
    switch (extension.toLowerCase()) {
        case 'jpg':
        case 'gif':
        case 'png':
        case 'jpeg':
            return true;
            break;
        default:
            return false;
            break;
    }
}

/**
 * Comprueba si el peso del archivo es el permitido
 * @param peso Peso del archivo
 * @returns {boolean}
 */
function pesoImagen(peso) {
    //console.log(peso);
    if (peso < 2200000) { //2Mg
        return true;
    } else {
        return false;
    }
}