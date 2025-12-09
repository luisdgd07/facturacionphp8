  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-steam-square' style="color: orange;"></i>
        Configuración Factura
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-plus"></i> Nueva</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
             <?php
                $categorias = CategoriaData::getAll();
                if(count($categorias)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($categorias as $categoria){
                    ?>
                  <tr>
                  <td><?php echo $categoria->nombre; ?></td>
                  <td><?php echo $categoria->descripcion; ?></td>
                  <td style="width:150px;">
                    <a href="index.php?view=actualizarcategoria&id_categoria=<?php echo $categoria->id_categoria;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                    <a href="index.php?action=eliminarcategoria&id_categoria=<?php echo $categoria->id_categoria;?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                  </td>
                  </tr>
                  <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay Categorias Registrados</p>";
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
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Agregar Nueva Categoria</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevocategoria" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500" placeholder="Nombre de la Categoria">
                      <span class="fa fa-steam form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion de la Categoria"></textarea>
                      <span class="fa fa-file-text form-control-feedback"></span>
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
<?php endif ?>
  <?php if($u->is_empleado):?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-steam-square' style="color: orange;"></i>
        Lista de Configuración de Facturas
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
            </div>
            <div class="box-body">
              <div class="table-responsive">
             <?php
                $configfacturas = ConfigFacturaData::verfacturasucursalall($sucursales->id_sucursal);
                if(count($configfacturas)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>ID</th>
                  <th>Serie</th>
                  <th>Comprobante</th>
                  <th># Actual</th>
                  <th>Timbrado</th>
                  <th>N° Inicial</th>
                  <th>N° Final</th>
                  <th>Inicio Timbrado</th>
                  <th>Fin Timbrado</th>
                  <th><center>Estado</center></th>
                  <th><center><i class="fa fa-cog"></i></center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($configfacturas as $configfactura){
                    ?>
                  <tr>
                  <td><?php echo $configfactura->id_configfactura; ?></td>
                  <td><?php echo $configfactura->serie1; ?></td>
				  
				
				  
                  <td><?php echo $configfactura->comprobante1; ?></td>
				  
				  
                  <td><?php echo $configfactura->numeracion_final-$configfactura->diferencia; ?></td>
				  
				  
                  <td><?php echo $configfactura->timbrado1; ?></td>
                  <td><?php echo $configfactura->numeracion_inicial; ?></td>
                  <td><?php echo $configfactura->numeracion_final; ?></td>
                  <td><?php echo $configfactura->inicio_timbrado; ?></td>
                  <td><?php echo $configfactura->fin_timbrado; ?></td>
                  <td><?php if ($configfactura->activo==1): ?>
                    <b style="color: green;">Activo</b>
                   <?php else: ?> 
                    <b style="color: red;">Desactivado</b>
                  <?php endif ?></td>
                  <td style="width:150px;">
                    <a href="index.php?view=actualizarconfigfactura1&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_configfactura=<?php echo $configfactura->id_configfactura;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                    <a href="index.php?action=eliminarconfigfactura1&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_configfactura=<?php echo $configfactura->id_configfactura;?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
                  </td>
                  </tr>
                  <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay Categorias Registrados</p>";
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
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Agregar nueva Configuracion Factura</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevoconfiguracionfactura1" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Comprobante</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="comprobante1" name="comprobante1">
                        <option>Seleccionar</option>
                        <option value="Factura">Factura</option>
                      
                       <option value="Remision">Remision</option>
					   <option value="Recibo">Recibo</option>
					   
                        <option value="Masiva">Masiva</option>
                       
                        <option disabled="" value="Nota de Debito">Nota de Debito</option>
                        <option  value="Nota de Credito">Nota de Credito</option>
                      </select>
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Serie</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="serie1" name="serie1" required  onpaste="return false" maxlength="10">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Timbrado</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="timbrado1" name="timbrado1" required onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Numero Actual</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="numeroactual1" name="numeroactual1" required onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">N°. Inicial</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="numeracion_inicial" name="numeracion_inicial"  onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500">
                    </div>
                    <label for="inputEmail1" class="col-sm-2 control-label">N°. Final</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="numeracion_final" name="numeracion_final"  onkeypress="return solonumeross(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500" >
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Inicio Timbrado:</label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" id="inicio_timbrado" name="inicio_timbrado"   maxlength="500">
                    </div>
                   
                </div>
				
				 <div class="form-group has-warning">
                   
                    <label for="inputEmail1" class="col-sm-3 control-label">Fin Timbrado:</label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" id="fin_timbrado" name="fin_timbrado" maxlength="500" >
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