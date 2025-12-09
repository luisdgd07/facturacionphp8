


 <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  
   <?php if($u->is_admin):?>
   
  <?php endif ?>
  
   <?php if($u->is_empleado):?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-users' style="color: orange;"></i>
        Lista de Proveedores 
       <!-- <marquee> Lista</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-user-plus"></i> Nuevo</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <?php
               
				   $users = ProveedorData::verproveedorssucursal($sucursales->id_sucursal);
                if(count($users)>0){
                  // si hay proveedores
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre Completo</th>
                  <th>Imagen</th>
                  <th>CI</th>
				   <th>Tipo doc.</th>
                  <th>E-Mail</th>
                  <th>Telefono</th>
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($users as $user){
                      $url="storage/proveedor/".$user->imagen;
                    ?>
                  <tr>
                  <td><?php echo $user->nombre." ".$user->apellido; ?></td>
                  <td><center><a class="fancybox" href="<?php echo $url; ?>" target="_blank" data-fancybox-group="gallery" title="Imagen"><img class="fancyResponsive img-circle" src="<?php echo $url; ?>" alt="" width="30" height="30" /></a></center></td>
                  <td><?php echo $user->dni; ?></td>
				   <td><?php echo $user->tipo_doc; ?></td>
                  <td><?php  echo $user->email; ?></td>
                  <td><?php echo $user->telefono; ?></td>
                  <td style="width:200px;">
                   
				 
				  <a href="index.php?view=actualizarproveedor&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_cliente=<?php echo $user->id_cliente;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                    <a href="index.php?action=eliminarproveedor&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_cliente=<?php echo $user->id_cliente;?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                  
				 
				 
				 </td>
                  </tr>
                  <?php
                    }
                    }else{
                      echo "<p class='alert alert-danger'>No hay Proveedores Registrados</p>";
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
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-user-circle" style="color: orange;"></i><b> Agregar Nuevo Proveedor</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevoproveedor" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                    <div class="col-lg-9">
                      <input type="file" name="imagen" class="form-control">
                      <span class="fa fa-image form-control-feedback"></span>
                    </div>
                  </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Empresa</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="empresa" name="empresa"  onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" placeholder="Nombre de la Empresa">
                      <span class="fa fa-institution form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre"  onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" placeholder="Nombre del Proveedor">
                      <span class="fa fa-user-secret form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Apellido</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="apellido" name="apellido"  onKeyUP="this.value=this.value.toUpperCase();" maxlength="80" placeholder="Apellido del Proveedor">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Tipo Doc.</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="tipo_doc">
                        <option value="RUC">RUC</option>
                        <option value="CI">C.I.</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                        <option value="CEDULA EXTRANJERO">CEDULA DE EXTRANJERO</option>
                        <option value="SIN NOMBRE">SIN NOMBRE</option>
                        <option value="DIPLOMATICO">DIPLOMATICO</option>
                        <option value="IDENTIFICACION TRIBUTARIA">IDENTIFICACIÓN TRIBUTARIA</option>
                      </select>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">N° Documento</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="dni" name="dni" required  onpaste="return false" maxlength="30" placeholder="Sin Nombre: X">
                      <span class="fa fa-credit-card form-control-feedback"></span>
                    </div>
                </div>
               <!--  <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">RUC</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="ruc" name="ruc"   onpaste="return false" maxlength="11" placeholder="RUC del Proveedor">
                      <span class="fa fa-barcode form-control-feedback"></span>
                    </div>
                </div> -->
               
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Ciudad</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="ciudad" name="ciudad"    placeholder="Ciudad del Proveedor">
                      <span class="fa fa-map form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="direccion" name="direccion"  maxlength="200" placeholder="Dirección del Proveedor">
                      <span class="fa fa-map-marker form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">E-mail</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email"  placeholder="Correo Electronico del Proveedor"> <span class="fa fa-google form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="telefono" name="telefono"  onpaste="return false" maxlength="15" placeholder="Numero Telefonico del Proveedor">
                      <span class="fa fa-tty form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Celular</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="celular" name="celular"  onpaste="return false" maxlength="12" placeholder="Numero de Celular del Proveedor">
                      <span class="fa fa-phone form-control-feedback"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
				  <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
              <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->nombre; ?>">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>

<?php endif ?>
<?php endif ?>