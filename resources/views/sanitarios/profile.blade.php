<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 13/10/2017
 * Time: 18:27
 */
?>
<!-- Main content -->
<!-- Generic page styles -->
<link rel="stylesheet" href="/geres/app/js/jQuery-File-Upload/css/style.css">

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/geres/app/js/jQuery-File-Upload/css/jquery.fileupload.css">



<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img id="avatar" class="profile-user-img img-responsive img-circle" src="" alt="User profile picture">
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
                    <li ><a href="#activity" data-toggle="tab">Activity</a></li>
                    <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>
                            <ul class="list-inline">
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                </li>
                                <li class="pull-right">
                                    <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                        (5)</a></li>
                            </ul>

                            <input class="form-control input-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post clearfix">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description">Sent you a message - 3 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <form class="form-horizontal">
                                <div class="form-group margin-bottom-none">
                                    <div class="col-sm-9">
                                        <input class="form-control input-sm" placeholder="Response">
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description">Posted 5 photos - 5 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <div class="row margin-bottom">
                                <div class="col-sm-6">
                                    <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <img class="img-responsive" src="../../dist/img/photo2.png" alt="Photo">
                                            <br>
                                            <img class="img-responsive" src="../../dist/img/photo3.jpg" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <img class="img-responsive" src="../../dist/img/photo4.jpg" alt="Photo">
                                            <br>
                                            <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <ul class="list-inline">
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                </li>
                                <li class="pull-right">
                                    <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                        (5)</a></li>
                            </ul>

                            <input class="form-control input-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <!-- The timeline -->
                        <ul class="timeline timeline-inverse">
                            <!-- timeline time label -->
                            <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-envelope bg-blue"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                    <div class="timeline-body">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                        quora plaxo ideeli hulu weebly balihoo...
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-primary btn-xs">Read more</a>
                                        <a class="btn btn-danger btn-xs">Delete</a>
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-user bg-aqua"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                                    <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                                    </h3>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-comments bg-yellow"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                    <div class="timeline-body">
                                        Take me to your leader!
                                        Switzerland is small and neutral!
                                        We are more like Germany, ambitious and misunderstood!
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline time label -->
                            <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-camera bg-purple"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                    <div class="timeline-body">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="active tab-pane" id="settings">
                        <form id="profile" enctype="multipart/form-data" class="form-horizontal" data-toggle="validator">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="idUser" >
                            <div class="form-group">
                                <label for="sNombre" class="col-sm-2 control-label">Nombre</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control " id="sNombre" name="sNombre"  placeholder="Nombre">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sApellidos" class="col-sm-2 control-label">Apellidos</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sApellidos" name="sApellidos"  placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="cGenero" id="cGenero">
                                <label for="cGeneroAux" class="col-sm-2 control-label">Genero</label>
                                <div  class="col-sm-10">
                                    <label class="radio-inline">
                                        <input type="radio" name="cGeneroAux" id="cGeneroH" value="H"  >
                                        Hombre
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cGeneroAux" id="cGeneroM" value="M" >
                                        Mujer
                                    </label>

                                </div>

                            </div>
                            <div class="form-group">
                                <label for="sPassword" class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="sPassword" name="sPassword" placeholder="password" value="1Aa@aaaaa">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="sEmail" name="sEmail" placeholder="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sTelefono1" class="col-sm-2 control-label">Teléfono 1</label>

                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sTelefono1" name="sTelefono1" placeholder="Teléfono">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sTelefono2" class="col-sm-2 control-label">Teléfono 2</label>

                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sTelefono2" name="sTelefono2" placeholder="Teléfono">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sDireccion" class="col-sm-2 control-label">Dirección</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sDireccion" name="sDireccion" placeholder="Direccion">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sCodigoPostal" class="col-sm-2 control-label">C.P.</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sCodigoPostal" name="sCodigoPostal" placeholder="Código Postal">
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
                                        <input type="file" class="form-control" id="fAvatar" name="fAvatar" onchange="previewFile()">
                                    </div>
                                    <input type="file" name="archivo" id="archivo">
                                    <input type="hidden" name="sAvatar" id="sAvatar">
                                    <span id="msgfile"  >Tamaño máximo 2Mb</span>
                                </div>
                            </div>

                            <!-- #messages is where the messages are placed inside -->
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <div id="messages"></div>
                                </div>
                            </div>



                            <!-- <div class="form-group">
                                 <div class="col-sm-offset-2 col-sm-10">
                                     <div class="checkbox">
                                         <label>
                                             <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                         </label>
                                     </div>
                                 </div>
                             </div>
                             -->
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

