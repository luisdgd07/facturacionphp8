<?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
$cliente = ProveedorData::getById($_GET["id_cliente"]);
$url = "storage/proveedor".$cliente->id_cliente."/".$cliente->imagen;
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1> <i class="fa fa-cubes"></i> 
        ACTUALIZAR DATOS DEL PROVEEDOR
        <small> </small>
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <?php
             if(isset($_SESSION["actualizar_datos"])):?>
              <p class="alert alert-info"><i class="fa fa-check"></i> Datos del proveedor acturalizados correctamente</p>
            <?php 
            unset($_SESSION["actualizar_datos"]);
            endif; ?>
          <div class="box-tools pull-left">
            <a href="index.php?view=proveedor" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa  fa-arrow-left"></i> Atrás</a>
            <!-- <a href="index.php?view=actualizarcliente" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i></a> -->
          </div>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data"  method="post" action="index.php?action=actualizarproveedor" role="form">
                      <center><div>
                        <img src="storage/proveedor/<?php echo $cliente->imagen; ?>" class="img-responsive img-circle" alt="" width="30%" height="30%">
                      </div></center>
                <div class="form-group has-warning has-feedback">
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Empresa</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="empresa" id="empresa" value="<?php echo $cliente->empresa; ?>">
                      <span class="fa fa-user-secret form-control-feedback"></span>
                    </div>
                </div>
                  <div class="form-group has-warning has-feedback">
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Nombre</label>
                    <div class="col-lg-7">
                      <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $cliente->nombre; ?>">
                      <span class="fa fa-user-secret form-control-feedback"></span>
                    </div>
                  
                </div>
                    <div class="form-group has-warning has-feedback">
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Apellidos</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="apellido" id="apellido" value="<?php echo $cliente->apellido; ?>">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-warning has-feedback">
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Telefono</label>
                    <div class="col-lg-2">
                      <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $cliente->telefono; ?>">
                      <span class="fa fa-tty form-control-feedback"></span>
                    </div>
                    <label for="inputEmail1" class="col-lg-1 control-label">Celular</label>
                    <div class="col-lg-2">
                      <input type="text" class="form-control" name="celular" id="celular" value="<?php echo $cliente->celular; ?>">
                      <span class="fa fa-phone form-control-feedback"></span>
                    </div>
                    <label for="inputEmail1" class="col-sm-1 control-label">Tipo Doc.</label>
                    <div class="col-lg-2">
                      <select class="form-control" name="tipo_doc">
                        <option value="<?php echo $cliente->tipo_doc; ?>"><?php echo $cliente->tipo_doc; ?></option>
                        <option value="RUC">RUC</option>
                        <option value="CI">C.I.</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                        <option value="CEDULA DE EXTRANJERO">CEDULA DE EXTRANJERO</option>
                        <option value="SIN NOMBRE">SIN NOMBRE</option>
                        <option value="DIPLOMATICO">DIPLOMATICO</option>
                        <option value="IDENTIFICACION TRIBUTARIA">IDENTIFICACIÓN TRIBUTARIA</option>
                      </select>
                    </div>
					 <label for="inputEmail1" class="col-sm-1 control-label">Nro doc.</label>
                    <div class="col-lg-2">
					
                      <input type="text" class="form-control" name= "dni" value="<?php echo $cliente->dni; ?>">
                      <!-- <span class="fa fa-barcode form-control-feedback"></span> -->
                    </div>
                  </div>
                  <div class="form-group has-warning has-feedback">
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Direccion</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $cliente->direccion; ?>">
                      <span class="fa fa-map-marker form-control-feedback"></span>
                    </div>
                </div>
                 <div class="form-group has-warning has-feedback">
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Ciudad</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?php echo $cliente->ciudad; ?>">
                      <span class="fa fa-map form-control-feedback"></span>
                    </div>
                </div>
                   <div class="form-group has-warning has-feedback">
                    <!-- <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> RUC</label>
                    <div class="col-lg-2">
                      <input type="text" class="form-control" name="ruc" id="ruc" value="<?php echo $cliente->ruc; ?>">
                      <span class="fa fa-code form-control-feedback"></span>
                    </div> -->
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Email</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="email" id="email" value="<?php echo $cliente->email; ?>">
                      <span class="fa fa-google-plus form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group has-warning has-feedback">
                    <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-times-circle-o"></i> Imagen</label>
                    <div class="col-lg-10">
                      <input type="file" class="form-control" name="imagen" id="imagen">
                      <span class="fa fa-image form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-2">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="is_publico" <?php if($cliente->is_publico){ echo "checked";} ?> > Público
                          </label>
                        </div>
                      </div>
<!--                       <div class="col-lg-2">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="is_admin" <?php if($cliente->is_admin){ echo "checked";} ?>> Admin
                          </label>
                        </div>
                      </div> -->
                      <div class="col-lg-2">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="is_activo" <?php if($cliente->is_activo){ echo "checked";} ?>> Activo
                          </label>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="is_cliente" <?php if($cliente->is_cliente){ echo "checked";} ?>> Cliente
                          </label>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="is_proveedor" <?php if($cliente->is_proveedor){ echo "checked";} ?>> Proveedor
                          </label>
                        </div>
                      </div>
                    </div>
                <div class="form-group">
                <div class="col-lg-offset-2 col-lg-12">
                  <input type="hidden" name="id_cliente" value="<?php echo $_GET["id_cliente"];?>">
                  <button type="submit" class="btn btn-warning "><i class="fa fa-cog fa-spin fa-1x fa-fw"></i> Actualizar Datos</button>
                  <button type="reset" class="btn btn-info "><i class="fa fa-eraser fa-spin fa-1x fa-fw"></i> Borrar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>


<?php else:?>
          <?php endif;?>