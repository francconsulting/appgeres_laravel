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
                    <img id="avatar" class="profile-user-img img-responsive img-circle" src=""
                         alt="User profile picture">
                    <h3 id="NombrePerfil" class="profile-username text-center">#NOMBRE#</h3>
                    <p id="ApellidosPerfil" class="text-muted text-center">#APELLIDO#</p>
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
                    <li><a href="#activity" data-toggle="tab">Activity</a></li>
                    <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">
                        <form id="profile" enctype="multipart/form-data" class="form-horizontal"
                              data-toggle="validator">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="idUser">
                            <div class="form-group">
                                <label for="sNombre" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control " id="sNombre" name="sNombre"
                                           placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sApellidos" class="col-sm-2 control-label">Apellidos</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sApellidos" name="sApellidos"
                                           placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="cGenero" id="cGenero">
                                <label for="cGeneroAux" class="col-sm-2 control-label">Genero</label>
                                <div class="col-sm-10">
                                    <label class="radio-inline">
                                        <input type="radio" name="cGeneroAux" id="cGeneroH" value="H">
                                        Hombre
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cGeneroAux" id="cGeneroM" value="M">
                                        Mujer
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sPassword" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="sPassword" name="sPassword"
                                           placeholder="password" value="1Aa@aaaaa">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sEmail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="sEmail" name="sEmail"
                                           placeholder="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sTelefono1" class="col-sm-2 control-label">Teléfono 1</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sTelefono1" name="sTelefono1"
                                           placeholder="Teléfono">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sTelefono2" class="col-sm-2 control-label">Teléfono 2</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sTelefono2" name="sTelefono2"
                                           placeholder="Teléfono">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sDireccion" class="col-sm-2 control-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sDireccion" name="sDireccion"
                                           placeholder="Direccion">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sCodigoPostal" class="col-sm-2 control-label">C.P.</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sCodigoPostal" name="sCodigoPostal"
                                           placeholder="Código Postal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="aRol" class="col-sm-2 control-label">Rol</label>
                                <div class="col-sm-10">
                                    <input type="hidden" class="form-control" id="aRol">
                                    <label class="radio-inline">
                                        <input type="checkbox" name="aRolAux" value="Adm">
                                        Administrador
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="aRolAux" value="Sup" checked>
                                        Supervisor
                                    </label>
                                    <label class="radio-inline">
                                        <input type="checkbox" name="aRolAux" value="Per">
                                        Personal
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fAvatar" class="col-sm-2 control-label">Avatar</label>
                                <div class="col-sm-10">
                                    <div class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-camera"></i>
                                        <span>subir imagen...</span>
                                        <input type="file" class="form-control" id="fAvatar" name="fAvatar"
                                               onchange="previewFile()">
                                    </div>
                                    <input type="hiddenn" name="sAvatar" id="sAvatar">
                                    <span id="msgfile">Tamaño máximo 2Mb</span>
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
                                    <button id="btnActualizar" type="submit" class="btn btn-danger">Actualizar</button>
                                </div>
                            </div>
                        </form>
                        <div id="auditoria"></div>
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