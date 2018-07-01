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
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

    //Añadir nuevo usuario
    $("#addUser").click(function () {
        //var param = {'_token': $('meta[name="_token"]').attr('content')}
         ventanaModal();
        bNewRecord = true;
        newProfile();
    });
    /************fin añadir eventos a botones ********/


        //Inicializar la tabla con los datos
        Table();

        //desactivar los botones de añadir usuario y recargar tabla hasta que este precargado el formulario
        $("#addUser, #idRecarga").attr('disabled', true)

    //Precarga del formulario para añadir, ver o modificar registros
    callAjax("/sanitario/create", function (result) {
       // console.log(result);
        $("#addUser, #idRecarga").attr('disabled', false);
        return formulario = result.html;      //almacerar el formulario en una variable
    }, null, null, "GET")

    //funcionalidad onchange al boton type=file del formulario preargado
    $(document).on('change', '#fAvatar', function(){
        //console.log(this.value.length);
        if(!this.value.length) return false;    //detener accion si no se ha seleccionado archivo
        previewFile();      //previsualizar el avatar cuando se cambie
    })
});


/**
 * Creacion de la tabla que muestra los registro
 * Usamos el pluging Datatable
 * @constructor
 */

function Table() {
    tabla = $('#listaUsuario').DataTable({                      //creacion de la tabla
        "ajax": {
            "method": "POST",                                   //metodo de llamada al ajax
            "url": "/sanitario/lista",                          //url donde obtener los datos
            //"headers": { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            "beforeSend": function (xhr) {                      //añadimos el token antes de la llamada a Ajax
                xhr.setRequestHeader("_token", $('meta[name="csrf-token"]').attr('content'))
            },
            "data": {'_token' : $('meta[name="csrf-token"]').attr('content')},  //pasar el token por POST
            "dataSrc": function (data) {                        //devolucion de los datos obtenidos
                //    console.log("en AJAX:" + JSON.stringify(data));
                return data;
            }
        },
        "columns": [                        //columnas a mostrar en la tabla
            {
                "data": "id",
                "width": "7%"
            },
            {
                "data": "sAvatar",
                "width": "7%",
                "render": function (data, type, row) {          //mostrar una imagen en la tabla
                    return '<img src="/images/avatar_user/' + data + '" width="25" height="25" class="img-circle" title="' + row.sNombre + " " + row.sApellidos + '" alt="Avatar usuario">';
                }
            },
            {
                "data": "sDni",
                "width": "10%"
            },
            {
                "data": "sNombre",
                "width": "27%"
            },
            {
                "data": "sApellidos",
                "width": "37%"
            },

            //crear la columna con los botones
            {
                "defaultContent": "<button type='button' class='ver btn btn-xs btn-primary' title='ver'><i class='glyphicon glyphicon-eye-open'></i></button>\t<button type='button' class='editar btn btn-xs btn-primary' title='modificar'><i class='glyphicon glyphicon-pencil'></i></button>\t<button type='button'  class='eliminar btn btn-xs btn-danger' data-toggle='modal' data-target='#modalEliminar' data-backdrop='static' title='borrar'><i class='glyphicon glyphicon-trash'></i></button>",
                "width": "10%"
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
                if (jqxhr.status == '401'){// ||  jqxhr.status == '500' ) {                    //lavarel emite error interno del servidor cuando no esta logado o activo el usuario //TODO porbar metodo  en clase que controle
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
    getDataView("#listaUsuario tbody", tabla);          //funcionalidad para ver datos
    getDataUpdate("#listaUsuario tbody", tabla);        //funcionalidad para actulizar datos
    getDataEliminar("#listaUsuario tbody", tabla);      //funcionalidad para eliminar datos
}



/**
 * Eliminar usuario de la tabla
 * @param id  identificador del usuario
 */
function borrar(datos) {
    param = {
        'idUser': datos.id,
       // 'accion': 'del',
        '_token': $("input[name=_token]").val(),
        '_method': 'DELETE'
    }
         //   console.log(datos.id);
            ventanaModal();                                                 //abrir la ventana modal
            $(".modal-title").html("Borrar usuario");                       //añadir titulo a ventana modal
            $(".modal-title").parent("div").addClass('alert alert-error');  //añadir la clase

            //añadir el contenido al cuerpo de la ventana modal
            $("#contenidoModal").html("Debes confirmar la eliminacion del usuario, <strong>" + datos.sNombre + " " + datos.sApellidos + "</strong>");
            $(".modal-footer").append("<button id='btnEliminar' type='button' class='btn btn-danger'>Eliminar</button>") //añadir el boton de eliminar

            $("#btnEliminar").on('click', function () {           //funcionalidad del boton eliminar
                $("#btnEliminar, #btnCerrar, button.close").attr('disabled', 'disabled');     //desactivar el boton eliminar y cerrar

                callAjax("/sanitario/"+datos.id, function (result) {       //eliminar de la tabla el id
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
   // console.log('aqui', datos);
    if(datos==undefined) {
        datos = [];
    }
    var bUpdate = false,
        nuevosDatos = getElementForm('#profile input'),     //capura de todos los elementos del formulario
        param = new Object();                               //crear el objeto param
    //  console.log(nuevosDatos);     console.log(datos);

    for (var item  in nuevosDatos) {    //recorrer todos los elemento del formulario
        //console.log(item+ "  "+nuevosDatos[item]+"   -> "+datos[item]);

        if (datos[item] == undefined) { //establecer a vacio los elementos que viajan indefinido
            datos[item] = ''
        }
        if (nuevosDatos[item] != datos[item]) { //si hay cambios con los datos anteriores se actualizara el registro
            bUpdate = true;
        }
        param[item] = nuevosDatos[item];        //guardar los valores en las propiedades del Objeto
    }
    //console.log(param);
    if (bUpdate) {      //si hay cambios se realiza el insert o el update
        //console.log(bNewRecord)
       if ( bNewRecord ){
            url = '/sanitario' ;
           param['_method'] = 'POST';       //agregar el metodo estandarizado del insert a la propiedade del objeto
        }else{
           url = "/sanitario/"+datos.id;
           param['_method'] = 'PUT';        //agregar el metodo estandarizado del update a la propiedade del objeto
       }
        //param['accion'] = 'update';
        param['_token'] = $('input[name=_token]').val();    //agregar la propiedad token al objeto

        callAjax(url, function (result) {               //Callback en caso de exito
           // console.log(result);
                if ($("#fAvatar")[0].files[0] != undefined) {   //uploader para el avatar si se ha definido
                   if(bNewRecord ) { $("#idUser").val(result.last_insert_id); }
                    cargarArchivo();
                } else {
                    tabla.ajax.reload(null, false);
                }
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
                $("#sDNI").closest('.form-group')
                    .removeClass('has-sucess')
                    .addClass('has-error')
                    .find('[data-bv-icon-for="sDNI"]')
                    .removeClass('glyphicon-ok')
                    .addClass('glyphicon-remove')
                $("#fAvatar").show();
                $("#fAvatar").closest('.fileinput-button').attr('disabled', false);
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
    $(".modal-title").html("Añadir nuevo personal");

            $("#contenidoModal").html(formulario);                          //cargar el HTML en el div
            noSubmit('profile');                                            //evitar el envio del formulario

            $("#sNombre").keyup(function () {                               //añadir el nombre debajo del avatar
                $("#NombrePerfil").html($("#sNombre").val());
            });
            $("#sApellidos").keyup(function () {                           //añadir el apellido debajo del avatar
                $("#ApellidosPerfil").html($("#sApellidos").val());
            });

            $("#btnActualizar").parent('div').prepend('<div id="loaderImage">')     //añadir el contenedor del spinner de carga de datos
            loadSpinner('loaderImage');                                             //cargar el spinner en el contenedor
            avatarDefault();                                                        //poner el avatar por defecto
            toggleAvatar();                                                         //canbiar la imagen del avatar
            bvValidarForm();                                                        //comprobaciones de validacion del formulario
}


/**
 * Establecer la imagen por defecto del avatar
 * al formulario del perfil
 */
function avatarDefault(imagenAvatar) {
    var avatar = imagenAvatar || 'avatar_m1.jpg';
    //console.log(imagenAvatar);
    if (imagenAvatar == undefined) $("#cGeneroM").prop('checked', true);
    $("#avatar").attr("src", "/images/avatar_user/" + avatar);
    $("#avatar").width(100);
    $("#avatar").height(100);
    $("#sAvatar").val(avatar)
}

/**
 * Alternar las imagens por defecto del avatar cuando
 * se cambia el sexo en el formulario.
 */
function toggleAvatar() {
    $("[name=cGeneroAux]:radio").on('click', function () {              //accion que se realiza cuando se selecciona la opcion del radiobutton
        var avatar = $("#avatar").attr("src");                          //captura del avatar disponible
        if ($(this).is(':checked')) {
            $("#cGenero").val($(this).val());                           //guardar el valor en el formulario para usar en el POST

            if (avatar.search('avatar_m1.jpg') >= 0 || avatar.search('avatar_h1.jpg') >= 0) {       //Si el avatar actual es alguno de los por defecto
                avatar = ($(this).val() != 'H') ?  'avatar_m1.jpg' : 'avatar_h1.jpg'
                avatarDefault(avatar);                                  //establecer la imagen del avatar
            }
        }
    });
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
            $("#NombrePerfil").html(datos.sNombre);
            $("#ApellidosPerfil").html(datos.sApellidos);

            var avatar = ''
            var genero = (datos.cGenero == '') ?  'M' :  datos.cGenero;

            if (datos.sAvatar == null) {
                avatar =  (genero == 'H') ? 'avatar_h1.jpg' :  'avatar_m1.jpg';
            } else {
                avatar = datos.sAvatar;
            }
            avatarDefault(avatar);                                  //establecer la imagen del avatar
            $("#cGenero").val(genero);
            $("#idUser").val(datos.id);
            $("#sDNI").val(datos.sDni);
            $("#sNombre").val(datos.sNombre);
            $("#sApellidos").val(datos.sApellidos);
            (genero == 'H') ? $("#cGeneroH").prop('checked', true) : $("#cGeneroM").prop('checked', true);      //Establecer el check del genero a marcar en la carga del formulario según los datos de la tabla
            $("#sEmail").val(datos.sEmail);
            $("#sTelefono1").val(datos.sTelefono1);
            $("#sTelefono2").val(datos.sTelefono2);
            $("#sDireccion").val(datos.sDireccion);
            $("#sCodigoPostal").val(datos.sCodigoPostal);
            $("#auditoria").html("<i class=\"fa fa-book margin-r-5\"></i><strong>Auditoria:</strong><br/>Creado: "+datos.dtA+ " por "+ datos.idAnombre +"     -   Actualizado: " + datos.dtU + " por " + datos.idAnombre );

            if (inputDesactivo) {                                //Cuando es solo visualizar los datos en el formulario
                $("#btnActualizar").hide();                     //ocultar el boton de actualizar
                $("#fAvatar").closest('.form-group').hide();    //ocultar el boton de carga del avatar
            }

            $("form input").attr("disabled", inputDesactivo);   //habilitar o desabilitar los campos del formulario

            ventanaModal();     //abrir ventana modal
            toggleAvatar();  //canbiar la imagen del avatar
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
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            sNombre: {
                validators: {
                    notEmpty: bvNoVacio,
                    stringLength: {
                        min: 2,
                        max: 45,
                        message: "El nombre debe tener entre 2 y 45 caracteres "
                    },
                    regexp: bvSoloTexto

                }
            },
            sApellidos: {
                validators: {
                    notEmpty: bvNoVacio,
                    stringLength: {
                        min: 2,
                        max: 90,
                        message: "Los apellidos debe tener entre 2 y 90 caracteres "
                    },
                    regexp: bvSoloTexto
                }
            },
            sDNI:{
                validators: {
                    notEmpty: bvNoVacio,
                    id: bvDni
                }
            },
            sEmail: {
                validators: {
                    notEmpty: bvNoVacio,
                    emailAddress: 'No es una direccion de email valida.'
                }
            },
            sTelefono1: {
                validators: {
                    notEmpty: bvNoVacio,
                    phone: bvTelefono
                }
            },
            sTelefono2: {
                validators: {
                    //notEmpty: bvNoVacio,
                    phone: bvTelefono
                }
            },
            sCodigoPostal: {
                validators: {
                    regexp: bvZipCode
                    // regexp : bvZipCode5
                }
            },
            cGeneroAux: {
                validators: {
                    notEmpty: bvElige
                }
            }

        }
    })
        .on('status.field.bv', function(e, data){                               //acciones con el estado del campo
            $(".control-label").css('color','#000');
        })
        .on('error.form.bv', function (e) {                                     //acciones cuando hay error en el formulario
          //  console.log(e);
            $("#btnActualizar").attr('disabled', false)
        })
        .on('success.form.bv', function (e) {                                   //actualizacion de datos y estados de campos del formularios con el envio correcto
            e.preventDefault();
            $("#cGenero").val( $("input[name='cGeneroAux']:checked").val() );
            $("#fAvatar").hide();
            $("#fAvatar").closest('.fileinput-button').attr('disabled', true);

            $("#btnActualizar").attr('disabled', 'disabled')

            mostrarSpinner();
            actualizar(datos);
        })
        .on('success.field.bv', function (e, data) {                               //acciones cuando success, por campo
            //console.log( data.field);
            if ($("#sCodigoPostal").val() == '' && data.field == "sCodigoPostal") {  //acciones para el codigo postal
                data.element
                    .closest('.form-group')                                           //obtener el campo padre
                    .removeClass('has-success')                                      //quitar la clase
                    .find('[data-bv-icon-for="sCodigoPostal"]').hide()  //buscar el campo con icono para el campo indicado
                //data.element.parents('.form-group').find('.form-control-feedback[data-bv-icon-for=sCP]').hide();
            }
            if (data.field == 'cGeneroAux') {                                       //acciones para el campo Sexo
                moverIconoBv('cGeneroAux');
            }

        })
        .on('error.field.bv', function (e, data) {                                  //acciones cuando existe error, por campo
            if (data.field == 'cGeneroAux') {                                       //acciones para el campo Sexo
                moverIconoBv('cGeneroAux');
            }

        })
        .on('error.validator.bv', function (e, data) {                              //SOLO UN MENSAJE POR ERROR
            // $(e.target)    --> The field element
            // data.bv        --> The BootstrapValidator instance
            // data.field     --> The field name
            // data.element   --> The field element
            // data.validator --> The current validator name
            data.element
                .data('bv.messages')
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()       // Ocultar todos los mensajes
                .filter('[data-bv-validator="' + data.validator + '"]').show();     // mostrar solo el mensaje asociado con el actual validador
        });
}

/**
 * Posicion del icono de BV cuando no se muestra alineado con
 * el resto de iconos de validacion de los otros campos
 * @param nameField   Nombre del campo donde se aplica el posicionamiento
 */
function moverIconoBv(nameField) {
    var padre = $("[name='" + nameField + "']").closest('.form-group');     //obtener el nombre del padre
    var padreAncho = padre.width();                                         //establecer el ancho
    var ico = padre.find('[data-bv-icon-for="' + nameField + '"]');         //capturar el icono
    ico.offset({left: padre.offset().left + padreAncho - 50});              //posicionar el icono
}

/**
 * Previsualizacion de imagenes en navegador
 * antes de realizar la carga (upload) del fichero
 */
function previewFile(inputFile) {
    var file = $("#fAvatar")[0].files[0];
    //console.log(file);
    fileName = file.name,                                           //nombre del archivo
    fileExt = fileName.substring(fileName.lastIndexOf('.') + 1),     //extension del archivo
    fileSize = file.size,                                           //tamaño del archvo
    fileType = file.type;                                           //tipo de archivo

    if (isImage(fileExt) && pesoImagen(fileSize)) {
        var reader = new FileReader();                              //leer el contenido file
        reader.readAsDataURL(file);                                 //leer fichero almacenado en buffer cliente
        reader.onload = function () {                               //cuando la lectura se completa
            $('#avatar')
                .attr("src", reader.result)                         //asignar la imagen al elemento donde mostrarla
                .width(100)
                .height(100)

            $('#sAvatar').val(file.name)                            //almacenar el nombre de la imagen en un campo del formulario
            $('#sAvatar').closest('.form-group')
                .removeClass('has-error')
                .addClass('has-feedback has-success')               //añadir la clase success y feedbak
                .find('[data-bv-icon-for="fAvatar"]').show();
            $("#msgfile")                                           //establecer formato y contenido del mensaje
                .text('')
                .removeClass('has-error')
                .addClass('has-success')
                .append('<i style="" class="form-control-feedback glyphicon glyphicon-ok" data-bv-icon-for="sAvatar"></i>')//limpiar el mensaje de error
        };
        reader.onerror = function () {                                  //si se produce un error en la carga del archivo
            alert('se ha producido un error en la carga del archivo');
           // console.log("error");
        }
    } else {                                                            //cuando no es correcto el tipo y/o el peso de la imagen
        $("#sAvatar")
            .closest('.form-group')                                     //obtener el campo padre
            .removeClass('has-success')
            .addClass('has-feedback has-error')                         //añadir la clase error y feedbak
            .find('[data-bv-icon-for="fAvatar"]').show();
        $("#msgfile")                                                   //establecer formato y contenido del mensaje
            .text('')
            .addClass('has-error')
            .append('<small style="" class="help-block"  data-bv-for="sAvatar" data-bv-result="INVALID">Por favor, revisa el tamaño y el tipo de archivo (jpg, gif, png, jpeg) </small>')
            .append('<i style="" class="form-control-feedback glyphicon glyphicon-remove" data-bv-icon-for="sAvatar"></i>')
    }
}


/**
 * Permite el upload de un archivo en el servidor
 * @returns {boolean}
 */
function cargarArchivo() {
    var file = $("#fAvatar")[0].files[0];                                   //obtener el fichero y guardarlo en una variable
    if (file != undefined) {
        var fileName = file.name,
            fileExt = fileName.substring(fileName.lastIndexOf('.') + 1),
            fileSize = file.size,
            fileType = file.type;

        if (isImage(fileExt) && pesoImagen(fileSize)) {
            var formData = new FormData(document.getElementById('profile'));                    //crear un nuevo formulario recuperndo el formulario pasado por parametros
            formData.append('accion', 'upload');                                                //añadir al campo accion  el valor upload
            formData.append('idRegistro', document.getElementById('profile')['idUser'].value)   //añadir el id del registro
            formData.append('_method', "PUT");
            uploadAjax('/sanitario/avatar', function (result) {                                 //carga del fichero en el servidor
                // console.log(result.exito);
                if (result.accion == 'exito') {
                    $("#ventanaModal").modal('hide');
                    tabla.ajax.reload(null, false);
                    return true;
                }
            }, formData);                                                                       //cuando la carga es correcta se envia el formulario relleno
        } else {
            alert('Comprueba el tipo y tamaño de imagen');
            $("#fAvatar").val('');
            return false;
        }
    }
}

