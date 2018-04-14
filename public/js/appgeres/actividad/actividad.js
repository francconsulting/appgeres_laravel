/**
 * Created by fmbv on 24/08/2017.
 */

//definicion de variables
var inputDesactivo,
    tabla,
    bNewRecord,
    formulario;

$(document).ready(function () {
    //establecer el token de laravel en las cabeceras

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    /*********** Añadir eventos a botones *************/
    /**
     * Funcionalidad en el boton cerrar cuando se hace click
     */
    $("#btnCerrar, button.close").on("click", function () {
        $(".modal-title").parent("div").removeClass('alert alert-error');   //eliminar la clase alert
        $(".modal-title").parent("div").removeClass('bg-light-blue-active');  //eliminar la clase de cabecera azul
        $(".modal-title").parent("div").removeClass('alert alert-success');  //eliminar la clase
        $(".modal-title").parent("div").removeClass('alert bg-olive');  //eliminar la clase
        $("#btnEliminar").remove();         //quitar el boton eliminar
    });


    //Actualizar la tabla de registro con el boton Actualizar Tabla
    $('#idRecarga').click(function () {
        tabla.ajax.reload();
    });

    //Añadir nuevo registro
    $("#add").click(function () {
        ventanaModal();
        bNewRecord = true;
        newProfile();
    });
    /************fin añadir eventos a botones ********/


    //Inicializar la tabla con los datos
    Table();

    //desactivar los botones de añadir usuario y recargar tabla hasta que este precargado el formulario
    $("#add, #idRecarga").attr('disabled', true)

    //Precarga del formulario para añadir, ver o modificar registros
    callAjax("/actividad/create", function (result) {
        // console.log(result);
        $("#add, #idRecarga").attr('disabled', false);
        return formulario = result.html;      //almacerar el formulario en una variable
    }, null, null, "GET")

    //capturar el valor de campo select y guardar el valor en un input hidden
    $(document).on('change',"#sTipoActividad", function(){
        var str = ($(this).val() != 0) ? $(this).val() : "#";
       $("#sAuxTipoActividad").val(str);
       $("#avatarActividad").html("<h1>"+str.substring(0,1).toUpperCase()+"</h1>");
    });


});


/**
 * Creacion de la tabla que muestra los registro
 * Usamos el pluging Datatable
 * @constructor
 */

function Table() {
    tabla = $('#listaActividades').DataTable({                      //creacion de la tabla
        "ajax": {
            "method": "POST",                                   //metodo de llamada al ajax
            "url": "/actividad/lista",                          //url donde obtener los datos
            "beforeSend": function (xhr) {                      //añadimos el token antes de la llamada a Ajax
                xhr.setRequestHeader("_token", $('meta[name="csrf-token"]').attr('content'))
            },
            "data": {'_token' : $('meta[name="csrf-token"]').attr('content')},  //pasar el token por POST
            "dataSrc": function (data) {                        //devolucion de los datos obtenidos
                return data;
            }
        },
        "columns": [                        //columnas a mostrar en la tabla
            {
                "data": "sDni",
                "width": "5%"
            },
            {
                "data": "sAvatar",
                "width": "5%",
                "render": function (data, type, row) {          //mostrar una imagen en la tabla
                    return '<img src="/images/avatar_user/' + data + '" width="25" height="25" class="img-circle" title="' + row.sNombre + " " + row.sApellidos + '" alt="Avatar usuario">';
                }
            },
            {
                "data": "id",
                "width": "10%"
            },
            {
                "data": "sNombre",
                "width": "25%"
            },
            {
                "data": "sApellidos",
                "width": "25%"
            },
            {
                "data": "sDni",
                "width": "12%"
            },
            //crear la columna con los botones
            {
                "defaultContent": "<button type='button' class='ver btn btn-xs btn-primary' title='ver'><i class='glyphicon glyphicon-eye-open'></i></button>\t<button type='button' class='editar btn btn-xs btn-primary' title='modificar'><i class='glyphicon glyphicon-pencil'></i></button>\t<button type='button'  class='eliminar btn btn-xs btn-danger' data-toggle='modal' data-target='#modalEliminar' data-backdrop='static' title='borrar'><i class='glyphicon glyphicon-trash'></i></button>",
                "width": "15%"
            }

        ],
        "paging": true,             //habilitar paginado de la tabla
        "lengthChange": false,      //mostrar elegir numeros de registros a mostrar
        "searching": true,          //habilitar busqueda en la tabla
        "ordering": true,           //habilitar ordenar registros
        "info": true,
        "processing": true,         //indicador de procesando
        "autoWidth": false,         //ancho automatico
        "stateSave": true,          //guardar la pagina
        "deferRender": true,        //carga diferida de los datos para mayor rapidez
        "serverSide": false,        //procesamiento del lado del servidor
        "language": idioma_espanol,
        "preDrawCallback": function (setting) {    //funcion llamada antes de la carga
            console.log("antes de cargar");
        },
        "drawCallback": function (settings) {   //funcion llamada cada vez que se pinta la tabla
            console.log('Cargando datos2....');
            $("#ventanaModal").modal('hide');

            //si tiene la clase error, se elimino un elemento de la tabla y hay que resetear la ventana modal
            if($(".modal-title").parent("div").hasClass('alert alert-error')){
                $(".modal-title").parent("div").removeClass('alert alert-error');   //quitar la clase a la ventana modal
                $("#btnEliminar").remove();                                         //quitar el boton de eliminar
            }

            $.fn.dataTable.ext.errMode = 'none';                //evitar las alertas de error de Datatable

            $(document).ajaxError(function (event, jqxhr, settings, exception) {    //se ejecuta cuando hay un error en un llamada en Ajax
                console.log(jqxhr);
                if (jqxhr.status == '401'){// ||  jqxhr.status == '500' ) {                    //lavarel emite error interno del servidor cuando no esta logado o activo el usuario //TODO probar metodo  en clase que controle
                    if ($("#btnEliminar").length) {
                        $("#btnEliminar").remove();                     //borrar el boton eliminar
                    }
                    ventanafinSesion()          //mostrar ventana con informacion para fin de sesion .
                }
            });
        },
        "initComplete": function (setting, data) {        //funcion llamada al finalizar la carga de datos
            // console.log("datos cargados completamente..."+JSON.stringify(data));
            console.log("datos cargados completamente...");

        }
    });

    //Añadir las funcionalidades a los boton de ver, modificar y eliminar
    getDataView("#listaActividades tbody", tabla);          //funcionalidad para ver datos
    getDataUpdate("#listaActividades tbody", tabla);        //funcionalidad para actulizar datos
    getDataEliminar("#listaActividades tbody", tabla);      //funcionalidad para eliminar datos
}



/**
 * Eliminar usuario de la tabla
 * @param id  identificador del usuario
 */
function borrar(datos) {
    param = {
        'id': datos.id,
        '_token': $("input[name=_token]").val(),
        '_method': 'DELETE'
    }
    //   console.log(datos.id);
    ventanaModal();                                                 //abrir la ventana modal
    $(".modal-title").html("Borrar actividad");                       //añadir titulo a ventana modal
    $(".modal-title").parent("div").addClass('alert alert-error');  //añadir la clase

    //añadir el contenido al cuerpo de la ventana modal
    $("#contenidoModal").html("Debes confirmar la eliminacion de la actividad, <strong>" + datos.sNombreActividad+ "</strong>");
    $(".modal-footer").append("<button id='btnEliminar' type='button' class='btn btn-danger'>Eliminar</button>") //añadir el boton de eliminar

    $("#btnEliminar").on('click', function () {           //funcionalidad del boton eliminar
        $("#btnEliminar, #btnCerrar, button.close").attr('disabled', 'disabled');     //desactivar el boton eliminar y cerrar

        callAjax("/actividad/"+datos.id, function (result) {       //eliminar de la tabla el id
                console.log(result)
                if (result.accion == 'exito') {        //si la sesion esta activa y se ha actualizado correctamente
                    tabla.ajax.reload(null, false);         //actualizar la tabla
                }   else  {
                    alert('No se han podido eliminar los datos');
                    $("#ventanaModal").modal('hide');
                }
                $("#btnEliminar, #btnCerrar, button.close").attr('disabled', false);    //activar los botones de nuevo
            }
            ,
            function(jqXHR){
                if(jqXHR.status == 500) {
                    if ($("#btnEliminar").length) {
                        $("#btnEliminar").remove();
                    }
                    ventanafinSesion();
                }
                cbErrorAjax(jqXHR);
            }, param, "POST", "json");
    });
}


/**
 * Actualiza los datos del objeto que se envia por parametros
 * @param datos Objeto con las propiedades a actualizar
 */
function actualizar(datos) {
     console.log('aqui', datos);
    if(datos==undefined) {
        datos = [];
    }
    var bUpdate = false,
        nuevosDatos = getElementForm('#profile input, #profile textArea'),     //capura de todos los elementos del formulario
        param = new Object();                               //crear el objeto param
    //  console.log(nuevosDatos);     console.log(datos);

    for (var item  in nuevosDatos) {    //recorrer todos los elemento del formulario
        console.log("item:"+item+ "  nuevoDato:"+nuevosDatos[item]+"   -> "+datos[item]);

        if (datos[item] == undefined) { //establecer a vacio los elementos que viajan indefinido
            datos[item] = ''
        }
        if (nuevosDatos[item] != datos[item]) { //si hay cambios con los datos anteriores se actualizara el registro
            bUpdate = true;
        }
        param[item] = nuevosDatos[item];        //guardar los valores en las propiedades del Objeto
    }
    param['sDescripcionActividad'] = CKEDITOR.instances['sDescripcionActividad'].getData();
    if (bUpdate) {      //si hay cambios se realiza el insert o el update
        //console.log(bNewRecord)
        if ( bNewRecord ){
            url = '/actividad' ;
            param['_method'] = 'POST';       //agregar el metodo estandarizado del insert a la propiedade del objeto
        }else{
            url = "/actividad/"+datos.id;
            param['_method'] = 'PUT';        //agregar el metodo estandarizado del update a la propiedade del objeto
        }
        //param['accion'] = 'update';
        param['_token'] = $('input[name=_token]').val();    //agregar la propiedad token al objeto


        callAjax(url, function (result) {               //Callback en caso de exito
                tabla.ajax.reload(null, false);

                // $("#ventanaModal").modal('hide');
                $(".modal-title").parent("div").removeClass('alert alert-error');   //eliminar la clase alert
                $(".modal-title").parent("div").removeClass('bg-light-blue-active');  //eliminar la clase de cabecera azul
                $(".modal-title").parent("div").removeClass('alert alert-success');  //eliminar la clase
                $(".modal-title").parent("div").removeClass('alert bg-olive');  //eliminar la clase

            }, function(jqXHR) {        //Callback en caso de error
                if(jqXHR.status == 500) {
                    if ($("#btnEliminar").length) {
                        $("#btnEliminar").remove();
                    }
                    ventanafinSesion();
                }
                cbErrorAjax(jqXHR);
                loadSpinner('loaderImage');
            }
            , param, "POST", "json");
    }
}

/**
 * Cargar el formulario de nuevo usuario en la
 * ventana modal.
 * @returns {String} Contenido HTML a mostrar en la ventana
 */
function newProfile() {
    bNewRecord = true;
    $(".modal-title").parent("div").addClass('bg-olive');                   //añadir la clase de cabecera verde
    $(".modal-title").html("Añadir nueva actividad");

    $("#contenidoModal").html(formulario);                          //cargar el HTML en el div
    noSubmit('profile');                                            //evitar el envio del formulario

    $("#sNombreActividad").keyup(function () {                               //añadir el nombre debajo del avatar
        $("#NombreActividad").html($("#sNombreActividad").val());
    });
    $("#sTipoActividad").change(function () {                           //añadir el apellido debajo del avatar
        $("#TipoActividad").html($("select[name='sTipoActividad'] option:selected").text());
    });

    $("#btnActualizar").parent('div').prepend('<div id="loaderImage">')     //añadir el contenedor del spinner de carga de datos
    loadSpinner('loaderImage');                                             //cargar el spinner en el contenedor
    avatarDefault();                                                        //poner el avatar por defecto     //canbiar la imagen del avatar
    bvValidarForm();                                                        //comprobaciones de validacion del formulario
}


/**
 * Establecer la imagen por defecto del avatar
 * al formulario del perfil
 */
function avatarDefault(textAvatar) {
    var avatar = textAvatar || '#';
    //console.log(imagenAvatar);
    //$("#avatar").attr("src", "/images/avatar_user/" + avatar);
    $("#avatar").width(100);
    $("#avatar").height(100);
    $("#avatar").html('<span id="avatarActividad"><h1>'+avatar+'</h1></span>')
}

/**
 * Cumplimenta los datos en el formulario de perfil,
 * con los que existen en función el registro elegido en
 * la tabla
 * @param datos Valores de la fila elegida
 * @returns {String} Contenido HTML a mostrar en la ventana modal
 */
function getDatos(datos) {
    //console.log(datos);
    //Cargar con Ajax el contenido HTML en la ventana modal

    $(".modal-title").parent("div").addClass('bg-light-blue-active');               //añadir la clase de cabecera azul
    $("#contenidoModal").html(formulario);                                  //cargar el HTML con el formulario en el div de la ventana modal
    $("#btnActualizar").parent('div').prepend('<div id="loaderImage">')     //contenedor del spinner de carga de datos
    loadSpinner('loaderImage');                                             //cargar el spinner en el contenedor
    noSubmit('profile');                                                    //evitar el envio del formulario

    //Carga los datos en el formualrio
    $("#NombreActividad").html(datos.sNombreActividad);
    $("#TipoActividad").html(datos.sTipoActividad);

    var avatar = ''
        avatar = datos.sTipoActividad.substring(0,1).toUpperCase();

    avatarDefault(avatar);                                  //establecer la imagen del avatar

    $("#idActividad").val(datos.id);

    $("#sNombreActividad").val(datos.sNombreActividad);
    $("#sDescripcionActividad").val(datos.sDescripcionActividad);
    $("#sTipoActividad").val(datos.sTipoActividad);
    $("#sAuxTipoActividad").val(datos.sTipoActividad);

    $("#auditoria").html("<i class=\"fa fa-book margin-r-5\"></i><strong>Auditoria:</strong><br/>Creado: "+datos.dtA+ " por "+ datos.idAnombre +"     -   Actualizado: " + datos.dtU + " por " + datos.idAnombre );

    if (inputDesactivo) {                                //Cuando es solo visualizar los datos en el formulario
        $("#btnActualizar").hide();                         //ocultar el boton de actualizar
        $("#sTipoActividad").attr('disabled', 'disabled');    //desactivar select
    }

    $("form input").attr("disabled", inputDesactivo);   //habilitar o desabilitar los campos del formulario

    ventanaModal();     //abrir ventana modal
    bvValidarForm(datos);  //comprobaciones de validacion del formulario
}


/**
 * Validacion de los datos del formulario con
 * boostrapValidator
 * @param datos
 */
function bvValidarForm(datos) {
    $("#profile").bootstrapValidator({
        message: 'Valor errorneo',
        excluded: [':disabled'],   //necesario para el textArea con ckeditor
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            sNombreActividad: {
                validators: {
                    notEmpty: bvNoVacio,
                    stringLength: {
                        min: 2,
                        max: 90,
                        message: "El nombre debe tener entre 2 y 90 caracteres "
                    },
                    regexp: bvSoloTexto
                }
            },
           sDescripcionActividad: {
                validators: {
                    notEmpty: bvNoVacio,
                    callback: {
                        message: 'La descripcion debe tener menos de 250 caracteres',
                        callback: function (value, validator, $field) {
                           // console.log($field," ",validator);
                            
                            // Get the plain text without HTML
                            //var div = $('<div/>').html(value).get(0),
                             //   text = div.textContent || div.innerText;
                            // return text.length <= 2;
                            textLenght = CKEDITOR.instances['sDescripcionActividad'].getData().replace(/<[^>]*>/gi, '').length - 1
                            if (textLenght <= 250 && textLenght >= 0){
                                console.log(textLenght <= 3 ,' ', textLenght >= 0, ' ' ,textLenght )
                                validator.updateStatus('sDescripcionActividad', 'VALID');
                                $("#cke_sDescripcionActividad").removeClass('bordeError');
                                return true;
                            }
                            $("#cke_sDescripcionActividad").addClass('bordeError');
                            validator.updateStatus('sDescripcionActividad', 'NOT_VALIDATED');
                            return false;

                        }
                    }
                }
              },
            sTipoActividad:{
                validators: {
                    notEmpty: bvNoVacio
                }
            }
        }
    })
    .on('status.field.bv', function(e, data){
        //acciones con el estado del campo
        //console.log(data);
        $(".control-label").css('color','#000');
    })
    .on('error.form.bv', function (e) {                                     //acciones cuando hay error en el formulario
        //  console.log($(e.target));
        var $form = $(e.target);
        console.log($form.data('bootstrapValidator').getInvalidFields());
        console.log(CKEDITOR.instances.sDescripcionActividad);

        $("#btnActualizar").attr('disabled', false)
    })
    .on('success.form.bv', function (e) {                                   //actualizacion de datos y estados de campos del formularios con el envio correcto
        e.preventDefault();
        $("#btnActualizar").attr('disabled', 'disabled')
        mostrarSpinner();
        actualizar(datos);
    })
    .on('success.field.bv', function (e, data) {                               //acciones cuando success, por campo
        //console.log( data.field);

    })
    .on('error.field.bv', function (e, data) {                                  //acciones cuando existe error, por campo
          //  console.log( data.field);

    })
    .on('error.validator.bv', function (e, data) {                              //SOLO UN MENSAJE POR ERROR
         //console.log ( $(e.target) );   // --> The field element
        // data.bv        --> The BootstrapValidator instance
       // console.log(data.field); //     --> The field name
        // data.element   --> The field element
        // data.validator --> The current validator name
        data.element
            .data('bv.messages')
            .find('.help-block[data-bv-for="' + data.field + '"]').hide()       // Ocultar todos los mensajes
            .filter('[data-bv-validator="' + data.validator + '"]').show();     // mostrar solo el mensaje asociado con el actual validador
    });

    CKEDITOR.instances.sDescripcionActividad.on('change', function (){
      $('#profile').bootstrapValidator('revalidateField', 'sDescripcionActividad');

  });


}




