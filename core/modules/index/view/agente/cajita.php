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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-steam-square' style="color: orange;"></i>
        Registro de Agente
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
                $configfacturas = AgenteData::listar($sucursales->id_sucursal);
                if(count($configfacturas)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>ID Agente</th>
                  <th>Nombre:</th>
                  <th>Direccion:</th>
                  <th>Telefono</th>
                  <th>Ruc</th>
          
                  <th>Estado</th> 				  
                  <th><center>Accion</center></th>
                  <th><center><i class="fa fa-cog"></i></center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($configfacturas as $configfactura){
                    ?>
                  <tr>
                  <td><?php echo $configfactura->id_agente; ?></td>
                  <td><?php echo $configfactura->nombre_agente; ?></td>
				  
				
				  
                  <td><?php echo $configfactura->direccion; ?></td>
				  
				  
                  <td><?php echo $configfactura->telefono ; ?></td>
				  
				  
                  <td><?php echo $configfactura->ruc; ?></td>
               
				 
         
                  <td><?php if ($configfactura->estado==1): ?>
                    <b style="color: green;">Activo</b>
                   <?php else: ?> 
                    <b style="color: red;">Desactivado</b>
                  <?php endif ?></td>
                  <td style="width:150px;">
                    <a href="index.php?view=actualizaragente&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_agente=<?php echo $configfactura->id_agente;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                
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
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Agregar nuevo Agente</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=creaagente" role="form" method="post" enctype="multipart/form-data">
               
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre del Agente:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre_agente" name="nombre_agente" required  onpaste="return false" maxlength="100">
                    </div>
                </div>
				
				
				 <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Ruc:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="ruc" name="ruc" required  onpaste="return false" maxlength="100">
                    </div>
                </div>
				
				
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Direccion:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="direccion" name="direccion" required  maxlength="500">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="telefono" name="telefono" required  maxlength="500">
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
         
                  <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
              
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
              </form>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
<?php endif ?>