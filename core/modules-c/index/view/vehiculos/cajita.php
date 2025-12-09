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
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Agregar Nuevo Vehiculo</b></h4>
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
        Registro de Vehiculos
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
                $configfacturas = VehiculoData::listar($sucursales->id_sucursal);
                if(count($configfacturas)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>ID vehiculo</th>
                  <th>Marca:</th>
                  <th>Chapa:</th>
                  <th>Rua</th>
                
          
                  <th>Fecha</th> 				  
                  <th><center>Estado</center></th>
                  <th><center><i class="fa fa-cog"></i></center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($configfacturas as $configfactura){
                    ?>
                  <tr>
                  <td><?php echo $configfactura->id_vehiculo; ?></td>
                  <td><?php echo $configfactura->marca; ?></td>
				  
				
				  
                  <td><?php echo $configfactura->chapa_nro; ?></td>
				  
				  
                  <td><?php echo $configfactura->rua_nro; ?></td>
				  
			
               
				  <td><?php echo $configfactura->fecha; ?></td>
         
                  <td><?php if ($configfactura->estado==1): ?>
                    <b style="color: green;">Activo</b>
                   <?php else: ?> 
                    <b style="color: red;">Desactivado</b>
                  <?php endif ?></td>
                  <td style="width:150px;">
                    <a href="index.php?view=actualizarvehiculo&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_vehiculo=<?php echo $configfactura->id_vehiculo;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                
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
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Agregar nuevo Vehiculo</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevo_vehiculo" role="form" method="post" enctype="multipart/form-data">
               
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Marca:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="marca" name="marca" required  maxlength="100">
                    </div>
                </div>
				
				
				 <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Chapa:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="chapa_nro" name="chapa_nro" required  maxlength="100">
                    </div>
                </div>
				
				
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Rua:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="rua_nro" name="rua_nro" required  maxlength="500">
                    </div>
                </div>
               
              
				
				 <div class="form-group has-warning">
                   
                    <label for="inputEmail1" class="col-sm-3 control-label">Estado:</label>
                    <div class="col-sm-4">
               
					  
					  <select class="form-control" id="estado" name="estado">
        
                        <option value="1">Activo</option>
                      
                       <option value="2">Inactivo</option>
					   
                      </select>
					  
					  
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