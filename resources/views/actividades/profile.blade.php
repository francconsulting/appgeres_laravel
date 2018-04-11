<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/10/2017
 * Time: 18:27
 */
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <div id="avatar" class="profile-user-img img-responsive img-circle" ></div>
                    <h3 id="NombreActividad" class="profile-username text-center">[Actividad]</h3>
                    <p id="TipoActividad" class="text-muted text-center">[Tipo]</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Followers</b> <a class="pull-right">1,322</a>
                        </li>
                        <li class="list-group-item">
                            <b>Following</b> <a class="pull-right">543</a>
                        </li>
                        <li class="list-group-item">
                            <b>Friends</b> <a class="pull-right">13,287</a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sobre mí</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Estudios</strong>
                    <p class="text-muted">
                        B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Dirección</strong>
                    <p class="text-muted">Malibu, California</p>
                    <hr>
                    <hr>
                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Notas</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#datosPersonales" data-toggle="tab">Datos Personales</a></li>
                    <li><a href="#expedienteLaboral" data-toggle="tab">Historial Clínico</a></li>
                    <li><a href="#actividad" data-toggle="tab">Actividades</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="datosPersonales">
                        <form id="profile" enctype="multipart/form-data" class="form-horizontal"
                              data-toggle="validator">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="idActividad">
                            <div class="form-group">
                                <label for="sNombreActividad" class="col-sm-2 control-label">Nombre:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control " id="sNombreActividad" name="sNombreActividad"
                                           placeholder="Nombre de la Actividad">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sDescripcionActividad" class="col-sm-2 control-label">Descripción:</label>
                                <div class="col-sm-10">
                                  <!--  <input type="text" class="form-control " id="sDescripcionActividad" name="sDescripcionActividad"
                                           placeholder="Descripción de la actividad">-->
                                    <textarea class="form-control " name="sDescripcionActividad" id="sDescripcionActividad" rows="10" cols="50">
                                    </textarea>
                                    <script>  CKEDITOR.replace('sDescripcionActividad' );</script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sTipoActividad" class="col-sm-2 control-label">Tipo:</label>
                                <div class="col-sm-10">
                                    <select  class="form-control" id="sTipoActividad" name="sTipoActividad">
                                     <option value="">Selecciona tipo de actividad</option>
                                     <option value="Taller">Taller</option>
                                     <option value="Salida">Salida</option>
                                     <option value="AVD">Actividad Vida Diaria</option>
                                    </select>
                                    <input type="hidden" name="sAuxTipoActividad" id="sAuxTipoActividad">
                                </div>
                            </div>
                            <!-- #messages is where the messages are placed inside -->
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <div id="messages"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button id="btnActualizar" type="submit" class="btn btn-primary">Actualizar</button>
                                </div>
                            </div>
                            <div id="mensaje"  style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-warning"></i> Aviso!</h4>
                                <p></p>
                            </div>
                        </form>
                        <div id="auditoria"></div>
                    </div>
                    <div class="tab-pane" id="expedienteLaboral">
                        <ul class="timeline timeline-inverse">
                        <li>
                            <i class="fa fa-info bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> 20/01/2018 12:05</span>
                                <h3 class="timeline-header"><a href="#">En Desarrollo</a> Historial Clínico</h3>
                                <div class="timeline-body">
                                    Estamos trabajando para implantar el área de Historial Clínico y
                                    poder ofrecer todos los servicio a traves de la aplicación.
                                </div>

                            </div>
                        </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="actividad">
                        <ul class="timeline timeline-inverse">
                            <li>
                                <i class="fa fa-info bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 20/01/2018 12:05</span>
                                    <h3 class="timeline-header"><a href="#">En Desarrollo</a> Actividades</h3>
                                    <div class="timeline-body">
                                        Estamos trabajando para implantar el área de Actividades y
                                        poder ofrecer todos los servicio a traves de la aplicación.
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
