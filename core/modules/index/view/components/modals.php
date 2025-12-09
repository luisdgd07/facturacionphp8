<?php
/**
 * Modals Component
 * Contiene todos los modales del sistema
 */
?>

<!-- Modal de Perfil -->
<div class="modal fade" id="profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Perfil Administrador</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="index.php?action=editarusuario"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname" class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                value="<?php echo $u->nombre; ?>" disabled="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-3 control-label">Apellido</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                value="<?php echo $u->apellido; ?>" disabled="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Foto:</label>
                        <div class="col-sm-9">
                            <input type="file" id="image" name="image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-3 control-label">Esta activo</label>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_active" <?php if ($u->is_active)
                                        echo "checked"; ?>
                                        disabled="">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-3 control-label">Es administrador</label>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_admin" <?php if ($u->is_admin)
                                        echo "checked"; ?>
                                        disabled="">
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="username" class="col-sm-3 control-label">Usuario</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?php echo $u->username; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-3 control-label">Nueva Contraseña</label>
                        <div class="col-md-8">
                            <input type="password" name="password" class="form-control" id="inputEmail1"
                                placeholder="Contraseña">
                            <p class="help-block">La contraseña solo se modificara si escribes algo, en caso contrario
                                no se modifica.</p>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Cerrar</button>
                <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i>
                    Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Perfil Detallado -->
<div class="modal fade bs-example-modal-lg" id="perfil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <label>
                        <marquee> DATOS DEL ADMINISTRADOR</marquee>
                    </label>
                </h4>
            </div>
            <div class="modal-body">
                <div class="contendor_kn">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="POST" id="update-form-administrador">
                                <div class="col-md-6">
                                    <input type="text" id="personal_id" name="personal_id" hidden
                                        value="<?php echo $u->nombre; ?>">
                                    <label class="col-sm-4 control-label">Nombres </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nombres_personal"
                                            id="nombres_personal" placeholder="Ingrese Nombres"
                                            value="<?php echo $u->nombre; ?>" disabled="">
                                        <br>
                                    </div>
                                    <label class="col-sm-4 control-label">Apellidos</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="apePate_personal"
                                            id="apePate_personal" placeholder="Ingrese Apellido Paterno"
                                            value="<?php echo $u->apellido; ?>" disabled="">
                                        <br>
                                    </div>
                                    <label class="col-sm-4 control-label">Apellido Materno </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="apeMate_personal"
                                            id="apeMate_personal" placeholder="Ingrese Apelido Materno" disabled="">
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-sm-12" style="text-align:center">
                                        <label class="control-label">Fotografía</label><br>
                                        <div id="txtimagen2">
                                            <?php if ($u->imagen != ""): ?>
                                                <img src="storage/usuario/<?php echo $u->imagen; ?>" class="img-circle"
                                                    alt="User Image" style="width:90px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="col-sm-2 control-label">Email </label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" style="width: 94%"
                                            name="email_personal" id="email_personal" placeholder="Ingrese email"
                                            value="<?php echo $u->email; ?>" disabled="">
                                        <br>
                                    </div>
                                    <label class="col-sm-2 control-label">Teléfono </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="telefono_personal"
                                            id="telefono_personal" placeholder="Ingrese nro telefóno" value="910122259"
                                            disabled="">
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xs-12" style="text-align:center;">
                                    <br>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i
                        class="fa fa-close"></i><strong> Close</strong></button>
            </div>
        </div>
    </div>
</div>