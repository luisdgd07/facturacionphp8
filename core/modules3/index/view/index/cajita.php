  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
  
  
    
  
<?php
  $config = ConfigData::getAll();
    if(count($config)>0){
      ?>
	  
	  
	  
	
	
	  
      <?php
        foreach($config as $configuracion){ 
          $url = "storage/sis/admin/".$configuracion->imagen;?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <!-- <center>SISTEMA DE Onlibo      <small>Version 1.0</small></center> -->
    </h1>
  </section>
  <section class="content">
    <div class="row">
      <br>
      <br>
     
      <!-- /.col -->
      <!-- <svg id="barcode"></svg> -->
     
      <!-- /.col -->
      <!-- fix for small devices only -->
      
      <!-- /.col -->

      <!-- /.col -->
     
      <!-- /.col -->
     
      <!-- /.col -->
     
      <!-- /.col -->
      
      <!-- /.col -->
    </div>
    <h1>
      <center>SISTEMA DE <?php echo $configuracion->texto1; ?>      <small>Version 1.0</small></center>
	  
	  
	  
    </h1>
    <!-- ---------------------------------------INICIO DE LA PRIMERA CLUMNA------------- -->
    <!-- /.row -->
    <div class="row">
    
 <!-- ------------------------------------------------------TERMINA LA PRIMERA COLUMNA -------->
 <!-- ------------------------------------------------INICIA LA SEGUNDA COLUMNA------------ -->
      <section class="col-xs-12">
        <!-- Map box -->
          <div class="box box-warning bg-light-blue-gradient">
            <div class="box-header">
              <img src="<?php echo $url; ?>" class="img-responsive" width="100%" height="100%">
            </div>
          </div>
          <!-- /.box -->
      </section>
  <!-- ---------------------------------------------------------FINAL DE LA SEGUNDA COLUMNA--- -->
    </div>
  </section>
</div>
<?php
  }
  }else{}
?>
<?php endif ?>
<?php if($u->is_empleado):?>
  <?php
       $usuarioss = UserData::getById($u->id_usuario);
       $sucursales = SucursalUusarioData::verusucursalusuarios($usuarioss->id_usuario);
	
     ?>
     <?php if (count($sucursales)>0):?>
      <?php foreach ($sucursales as $sucur)  :
      $sucursal = $sucur->verSocursal();?>
<?php
  $config = ConfigData::getAll();
    if(count($config)>0){
      ?>
      <?php
        foreach($config as $configuracion){ 
          $url = "storage/sis/admin/".$configuracion->imagen;?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <!-- <center>SISTEMA DE Onlibo      <small>Version 1.0</small></center> -->
    </h1>
  </section>
  <section class="content">
    <div class="row">
      <br>
      <br>
      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">COMPRAS</span>
              <span class="info-box-number"><?php echo count (VentaData::versucursaltipocompras($sucursal->id_sucursal));?><!-- <small>%</small> --></span>
              <a href="./?view=compras1&id_sucursal=<?php echo $sucursal->id_sucursal;?>" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- <svg id="barcode"></svg> -->
      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user-circle"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PROVEEDORES</span>
              <span class="info-box-number"><?php echo count(ProveedorData::verproveedorssucursal($sucursal->id_sucursal));?></span>
              <a href="./?view=proveedor&id_sucursal=<?php echo $sucursal->id_sucursal;?>" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <!-- <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span> -->
            <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">CLIENTES</span>
                  <span class="info-box-number"><?php echo count(ClienteData::verclientessucursal($sucursal->id_sucursal));?></span>
              <a href="./?view=cliente&id_sucursal=<?php echo $sucursal->id_sucursal;?>" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
    
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">VENTAS</span>
              <span class="info-box-number"><?php echo count(VentaData::getVentas($sucursal->id_sucursal));?> <small></small></span>
              <a href="./?view=ventas&id_sucursal=<?php echo $sucursal->id_sucursal;?>" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
 
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-laptop"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PRODUCTOS</span>
              <span class="info-box-number"><?php echo count(ProductoData::getAll($sucursal->id_sucursal));?></span>
              <a href="./?view=producto&id_sucursal=<?php echo $sucursal->id_sucursal;?>" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-black"><i class="fa fa-cube"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">CAJA</span>
              <!-- <span class="info-box-number"><?php echo count(CajaData::getAll());?></span> -->
              <a href="./?view=caja&id_sucursal=<?php echo $sucursal->id_sucursal;?>" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <h1>
      <center><b>! BIENVENIDO !</b> A LA EMPRESA <b style="text-transform: uppercase;"><?php echo $sucursal->nombre ?></b></center>
    </h1>
	
	
	
 <?php
	 
	
	   // $sucursales2 = SuccursalData::VerId($_GET["id_sucursal"]);
	 $sucursales = SuccursalData::VerId($sucursal->id_sucursal);
	
	
	?>
	         
	
	       <?php
                $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                if(count($cotizacion)>0){
                  // si hay categorias
                  ?>
				<div class="box-body">
              <div class="table-responsive">  
				  
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
				  <th>Moneda</th>
                  <th>Valor Compra</th>
                  <th>Valor Venta</th>
                  <th>Fecha Cotización</th>
                 
                 
                </thead>
                <tbody>
                  <?php
                    foreach($cotizacion as $moneda){
						
						
						
						$mon = MonedaData::cboObtenerValorPorSucursal2($sucursales->id_sucursal, $moneda->id_tipomoneda);
						
						
                    ?>
					
					
					
					  <?php foreach($mon as $mo):?>
					  
					  
					  
                  <tr>
				  <td><?php echo $mo->nombre; 
				  
				  
				  $nombre=$mo->nombre;
				  $fechacotiz=$mo->fecha_cotizacion;
				  ?></td>
				  
				 
				  
				  
				   <?php endforeach;?>
                  <td><?php echo $moneda->valor_compra; ?></td>
                  <td><?php echo $moneda->valor_venta; ?></td>
                  <td><?php echo $moneda->fecha_cotizacion; ?></td>
				  
				  
				  
                
                 
                  </tr>
                  <?php
				  
				  
				 
                }
				
				
				 // INICIO CONDICION DE FECHA COTIZACION
				   $fecha_hoy=date('d-m-Y');
				   
				   $fecha_cotizacion=strtotime($fechacotiz);
				   
				    $fecha_cot=date('d-m-Y', ($fecha_cotizacion)); 
				   
					
					if($fecha_cot >=$fecha_hoy) {
					
                    //Core::alert("Cotizacion del día actualizada...!");
					
					echo "<p class='alert alert-yelow'>Tiene la cotización  actualizada al dia:".$fecha_cot."</p>";
					//Core::redir("index.php?view=index&id_sucursal=".$sucursales->id_sucursal);
					  echo $fecha_cot;
					}
					else if ($fecha_cot < $fecha_hoy ){
					
					Core::alert("Atención debe de actualizar la moneda a la cotización del día...en Configuraciones/Cotizacion/Nuevo!");
					Core::redir("index.php?view=cotizacion&id_sucursal=".$sucursales->id_sucursal);
					//echo "<p class='alert alert-danger'>Fecha de la última cotización:".$fecha_cot."</p>";
					
					
                    }
					
				  
				  // FIN CONDICION DE COIZACION
				
				
                }else{
                  echo "<p class='alert alert-danger'>No hay Cotización registrada</p>";
                }
                ?>
	              </tbody>
              </table>
              </div>
		      </div>
				   <div class="modal-footer">
              <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
              <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
      
            </div>
				  
				 
				   

	
	
    <!-- ---------------------------------------INICIO DE LA PRIMERA CLUMNA------------- -->
    <!-- /.row -->
    <div class="row">
    
 <!-- ------------------------------------------------------TERMINA LA PRIMERA COLUMNA -------->
 <!-- ------------------------------------------------INICIA LA SEGUNDA COLUMNA------------ -->
      <section class="col-xs-12">
        <!-- Map box -->
          <div class="box box-warning bg-light-blue-gradient">
            <div class="box-header">
              <img src="<?php echo $url; ?>" class="img-responsive" width="100%" height="100%">
            </div>
          </div>
          <!-- /.box -->
      </section>
  <!-- ---------------------------------------------------------FINAL DE LA SEGUNDA COLUMNA--- -->
    </div>
	
	
	
	
  </section>
</div>
<?php
  }
  }else{}
?>
<?php endforeach ?>
      <?php endif ?>
<?php endif ?>
<?php endif ?>