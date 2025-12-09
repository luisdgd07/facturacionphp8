
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-users' style="color: orange;"></i>
        LISTA DE ADMINISTRADORES DEL SISTEMA 
       <!-- <marquee> Lista</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-user-plus"></i> Nuevo Administrador</a>
               <a href="#trabajador" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-user-plus"></i> Nuevo Usuario</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <?php
                $users = UserData::getAll();
                if(count($users)>0){
                  // si hay admin
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre Completo</th>
                  <th>CI</th>
                  <th>E-Mail</th>
                  <th>Telefono</th>
                  <th>Activo</th>
                  <th><CENTER>Acción</CENTER></th>
                  <th><center>Imagen</center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($users as $user){
                      $url="storage/admin/".$user->imagen;
                    ?>
                  <tr>
                  <td><?php echo $user->nombre." ".$user->apellido; ?></td>
                  <td><?php echo $user->dni; ?></td>
                  <td><?php echo $user->email; ?></td>
                  <td><?php echo $user->telefono; ?></td>
                   <td style="width:90px;"><center><?php if($user->is_activo):?><i style="color: blue;" class="fa fa-check"></i><?php else: ?><i style="color: red;" class="fa fa-remove"></i><?php endif; ?></center> </td>
                  <td style="width:110px;">
                    <a href="index.php?view=actualizaradministrador&id_usuario=<?php echo $user->id_usuario;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i></a>
                  <!--  <a href="#edit" data-toggle="modal" class="btn btn-success btn-sm btn-flat" id="<?php echo $row['user']; ?>"><i class="fa fa-edit"></i> Editar</a> -->
                    <a href="#indicador-<?php echo $user->id_usuario; ?>" class="btn btn-success btn-sm btn-flat" title="Agregar Empresa" data-toggle="modal"><i class='fa fa-circle'></i> </a>
                    <div class="modal fade" id="indicador-<?php echo $user->id_usuario; ?>">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Administrador</b></h4>
                              </div>
                              <div class="modal-body">
                                <form class="form-horizontal" action="index.php?action=usuariosucursal" role="form" method="post" enctype="multipart/form-data">
                                  <div class="form-group has-feedback has-warning">
                                      <label for="inputEmail1" class="col-sm-3 control-label">Empresa</label>
                                      <div class="col-sm-9">
                                        <select class="form-control" required="" name="sucursal_id">
                                              <option> Seleccionar</option>
                                              <?php
                                              $sucursales = SuccursalData::vercontenido();
                                              if(count($sucursales)>0){
                                                ?>
                                              <?php
                                                  foreach($sucursales as $sucursal){
                                                    if($sucursal!=null):
                                                  ?>
                                              <option value="<?php echo $sucursal->id_sucursal; ?>" style="color: black;"><b><?php echo $sucursal->nombre; ?></b></option>
                                              <?php endif; ?>
                                              <?php
                                              }
                                              }else{
                                                echo "<option class='alert alert-danger'>No hay Registro</option>";
                                              }
                                              ?>
                                            </select>
                                      </div>
                                  </div>
                                  <h4 class="text-center" style="color: blue;">Sucursal Asignadas</h4>
                                        <?php $sucursalesss = SucursalUusarioData::verusuariosucursal($user->id_usuario);
                                        if (count($sucursalesss)>0) {?>

                                          <?php foreach ($sucursalesss as $condicion){
                                          $condi = $condicion->verSocursal();?>
                                         
                                        <div class="item form-group">
                                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">
                                          </label>
                                          <div class="col-md-9 col-sm-9 ">
                                          <li><?php echo $condi->nombre; ?> <a style="font-size: 17px" href="index.php?action=eliminarsucursalusuario&id_sucursalusuario=<?php echo $condicion->id_sucursalusuario;?>" title="Eliminar Indicador" class=""><i style="color: red;" class="fa fa-close"></i></a></li>
                                        </div>
                                        </div>
                                          <?php
                                          } 
                                          }else {
                                            echo "<p class='alert alert-danger'>No hay Registro</p>";
                                          } ?>
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $user->id_usuario; ?>">
                                <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                                <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>
                    <a href="#" class="btn btn-danger btn-sm btn-flat" title="No se Elimina por temas de Politica"><i class='fa fa-trash'></i> </a>
                  </td>
                  <td><center><a class="fancybox" href="<?php echo $url; ?>" target="_blank" data-fancybox-group="gallery" title="Imagen"><img class="fancyResponsive img-circle" src="<?php echo $url; ?>" alt="" width="30" height="30" /></a></center></td>
                  </tr>
                  <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay Admnistradores Registrados</p>";
                }
                ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
<!--       <div class="formulario__grupo" id="grupo__usuario">
        <label for="usuario" class="formulario__label">Usuario</label>
        <div class="formulario__grupo-input">
          <input type="text" class="formulario__input" name="usuario" id="usuario" placeholder="john123">
          <i class="formulario__validacion-estado fas fa-times-circle"></i>
        </div>
        <p class="formulario__input-error">El usuario tiene que ser de 4 a 16 dígitos y solo puede contener numeros, letras y guion bajo.</p>
      </div> -->
<!-- Agregar Nuevo Medicamento -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Administrador</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevoadministrador" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                    <div class="col-lg-9">
                      <input type="file" name="imagen" class="form-control">
                      <span class="fa fa-image form-control-feedback"></span>
                    </div>
                  </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre"   maxlength="80" placeholder="Nombre del Administrador">
                      <span class="fa fa-user form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Apellido</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="apellido" name="apellido"  maxlength="80" placeholder="Apellido">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">CI</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="dni" name="dni"  maxlength="10" placeholder="Cedula de Identidad ">
                      <span class="fa fa-credit-card form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="direccion" name="direccion"   onpaste="return false" maxlength="200" placeholder="Dirección del Administrador">
                      <span class="fa fa-map-marker form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">E-mail</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email"  maxlength="100" placeholder="Correo Electronico del Administrador"> <span class="fa fa-google form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="telefono" name="telefono"  onkeypress="return solonumeros(event);" pattern=".{9,99}" onpaste="return false" maxlength="12" placeholder="Numero Telefonico del Administrador">
                      <span class="fa fa-tty form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Usuario</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite su Usuario">
                      <span class="fa fa-user-secret form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Contraseña</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" required  placeholder="Digite su Contraseña">
                      <span class="fa  fa-expeditedssl form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="trabajador">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Trabajador</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevoatrabajador" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                    <div class="col-lg-9">
                      <input type="file" name="imagen" class="form-control">
                      <span class="fa fa-image form-control-feedback"></span>
                    </div>
                  </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required  maxlength="80" placeholder="Nombre ">
                      <span class="fa fa-user form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Apellido</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="apellido" name="apellido" required  maxlength="80" placeholder="Apellido ">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">CI</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="dni" name="dni"   onpaste="return false" maxlength="10" placeholder="Cedula de Identidad del ">
                      <span class="fa fa-credit-card form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="direccion" name="direccion"  maxlength="200" placeholder="Dirección del Administrador">
                      <span class="fa fa-map-marker form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">E-mail</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email"  maxlength="100" placeholder="Correo Electronico del Administrador"> <span class="fa fa-google form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="telefono" name="telefono"  " pattern=".{9,99}" onpaste="return false" maxlength="12" placeholder="Numero Telefonico del Administrador">
                      <span class="fa fa-tty form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Usuario</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="usuario" name="usuario"  required placeholder="Digite su Usuario">
                      <span class="fa fa-user-secret form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Contraseña</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" required  placeholder="Digite su Contraseña">
                      <span class="fa  fa-expeditedssl form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>