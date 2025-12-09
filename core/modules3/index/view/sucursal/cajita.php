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
        EMPRESAS
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
                $categorias = SuccursalData::vercontenido();
                if(count($categorias)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th>Nombre</th>
                  <th>Direccion</th>
				  <th>Ruc</th>
				  <th>Representante</th>
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($categorias as $categoria){
                    ?>
                  <tr>
                  <td><?php echo $categoria->nombre; ?></td>
                  <td><?php echo $categoria->direccion; ?></td>
				  <td><?php echo $categoria->ruc; ?></td>
				  <td><?php echo $categoria->representante; ?></td>
                  <td style="width:150px;">
                    <a href="index.php?view=actualizarsucursal&id_sucursal=<?php echo $categoria->id_sucursal;?>" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-cog"></i> Editar</a>
                    <a href="index.php?action=eliminarsucursal&id_sucursal=<?php echo $categoria->id_sucursal;?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> Eliminar</a>
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
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Agregar Nueva Empresa</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevosucursal" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required  maxlength="500">
                      <span class="fa fa-file-text form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Ruc</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="ruc" name="ruc" required  maxlength="500" >
                      <span class="fa fa-credit-card form-control-feedback"></span>
                    </div>
                </div>
				
				 <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Representante</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="representante" name="representante" required  maxlength="500" >
                      <span class="fa fa-credit-card form-control-feedback"></span>
                    </div>
                </div> 
				
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Telefono</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="telefono" name="telefono"   maxlength="500" >
                      <span class="fa fa-phone form-control-feedback"></span>
                    </div>
                  <!--   <label for="inputEmail1" class="col-sm-2 control-label">Representante</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="nombre" name="rep"  onkeypress="return sololetras(event)" onpaste="return false" onKeyUP="this.value=this.value.toUpperCase();" maxlength="500" >
                      <span class="fa fa-steam form-control-feedback"></span>
                    </div> -->
                </div>
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Direccion</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="direccion" name="direccion"></textarea>
                      <span class="fa fa-map-marker form-control-feedback"></span>
                    </div>
                </div>
				
				
				
				
				<div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Departamento</label>
                    <div class="col-sm-9">
                            <select name="dpt_id"  id="dpt_id" class="form-control">
                              <?php
                              $dpts = DptData::getAll();
                              foreach ($dpts as $dpt) :
                              ?>
                                <option value="<?php echo $dpt->codigo;
                                                ?>"><?php echo $dpt->name
                                                    ?></option>
                              <?php endforeach;
                              ?>
                            </select>
                          </div>
                        </div>
				
				
				
				
				
				<div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Distrito</label>
                    <div class="col-sm-9">
                            <select name="distrito_id"  id="distrito_id" class="form-control">
                              <?php
                              $DISTRI = DptData::getAll2();
                              foreach ($DISTRI as $DIST) :
                              ?>
                                <option value="<?php echo $DIST->codigo;
                                                ?>"><?php echo $DIST->descripcion
                                                    ?></option>
                              <?php endforeach;
                              ?>
                            </select>
                          </div>
                        </div>
				
				
				
				
				
				
				<div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Ciudad</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                      <span class="fa fa-map-marker form-control-feedback"></span>
                    </div>
                </div>
				
				
					
				
				
				    <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Es Facturador electrónico:.</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="is_facturador">
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                        
                      </select>
                    </div>
                    </div>
					
					
					 <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Especializada en Venta de:.</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="venta_de">
                        <option value="1">Productos</option>
                        <option value="2">Servicios</option>
						<option value="3">Productos y Servicios</option>
                        
                      </select>
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
<?php endif ?>