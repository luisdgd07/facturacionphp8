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
      <h1><i class='fa fa-money' style="color: orange;"></i>
        Lista de Cotizaciones
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
                $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                if(count($cotizacion)>0){
                  // si hay categorias
                  ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
				  <th>Moneda</th>
                  <th>Valor Compra</th>
                  <th>Valor Venta</th>
                  <th>Fecha Cotización</th>
                 
                  <th><center>Acción</center></th>
                </thead>
                <tbody>
                  <?php
                    foreach($cotizacion as $moneda){
						
						
						
						$mon = MonedaData::cboObtenerValorPorSucursal2($sucursales->id_sucursal, $moneda->id_tipomoneda);
						
						
                    ?>
					
					
					
					  <?php foreach($mon as $mo):?>
                  <tr>
				  <td><?php echo $mo->nombre; ?></td>
				  
				   <?php endforeach;?>
                  <td><?php echo $moneda->valor_compra; ?></td>
                  <td><?php echo $moneda->valor_venta; ?></td>
                  <td><?php echo $moneda->fecha_cotizacion ?></td>
                
                  <td style="width:80px;">
                   
                    <a href="index.php?action=eleminarcotizacion&id_sucursal=<?php echo $sucursales->id_sucursal;?>&id_cotizacion=<?php echo $moneda->id_cotizacion;?>" class="btn btn-danger btn-sm btn-flat" title="Eliminar"><i class='fa fa-trash'></i></a>
                  </td>
                  </tr>
                  <?php
                }
                }else{
                  echo "<p class='alert alert-danger'>No hay Cotización registrada</p>";
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
              <h4 class="modal-title"><i class="fa fa-steam-square" style="color: orange;"></i><b style="color: black;"> Registrar Cotización del día</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="index.php?action=nuevacotizacion" role="form" method="post" enctype="multipart/form-data">
                
				
                         <div class="form-group has-feedback has-warning">
						 <label for="inputEmail1" class="col-sm-3 control-label">Tipo moneda</label>
						  <div class="col-sm-9">
                              <?php 
                                 $monedas = MonedaData::cboObtenerValorPorSucursal($sucursales->id_sucursal);
								 
								 $fecha= date("Y-m-d");
                              ?>
                              <select required="" name="id_tipomoneda" id="id_tipomoneda"  class="form-control" >
                                <!-- <option value="0">Seleccionar</option> -->
                              <?php foreach($monedas as $money):?>
                                <?php 
                                $valocito=null;
                                 ?>
                                <option value="<?php echo $money->id_tipomoneda;?>"><?php echo $money->nombre."-".$money->simbolo;?></option>

                              
                              <?php endforeach;?>
                                </select>
								 </div>
                          </div>
				
				
				
				
				
				
				
				
				
				
				
				<div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Valor compra</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="valor_compra" name="valor_compra" required  value="">
                      <span class="fa fa-money form-control-feedback"></span>
                    </div>
                </div>
                <!-- <div class="dDoNo ikb4Bb gsrt"><span class="DFlfde SwHCTb" data-precision="2" data-value="6816.0650000000005">6,816.07</span></div> -->
                <div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Valor venta</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="valor_venta" name="valor_venta"  required  value="">
                      <span class="fa fa-money form-control-feedback"></span>
                    </div>
                </div>
				
				
				<div class="form-group has-feedback has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Fecha</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="fecha_cotizacion" name="fecha_cotizacion"  required  value="<?php echo $fecha;?>" <?php echo $fecha;?>>
                     
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