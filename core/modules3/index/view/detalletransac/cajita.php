
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
        DETALLE TRANSACCION
       <!-- <marquee> Lista de Medicamentos</marquee> -->
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
                <?php if(isset($_GET["id_venta"]) && $_GET["id_venta"]!=""):?>
                <?php
                $sell = VentaData::getById($_GET["id_venta"]);
                $operations = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
                $total = 0;
                ?>
                <?php
                if(isset($_COOKIE["selled"])){
                  foreach ($operations as $operation) {
                //    print_r($operation);
                    $qx = OperationData::getQYesFf($operation->producto_id);
                    // print "qx=$qx";
                      $p = $operation->getProducto();
                    if($qx==0){
                      echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->nombre</b> tiene existencia 0 realice compras para abastecer su stock.</p>";      
                    }else if($qx<=$p->inventario_minimo/2){
                      echo "<p class='alert alert-danger'>Atención el producto <b style='text-transform:uppercase;'> $p->nombre</b> ya tiene menos a su stock Minimo de abastecerlo</p>";
                    }else if($qx<=$p->inventario_minimo){
                      echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->nombre</b>ha llegado a su stock Minimo debe abastecerlo.</p>";
                    }
                  }
                  setcookie("selled","",time()-18600);
                }

                ?>
               <?php if ($sell->numerocorraltivo==""): ?>
                <?php else: ?>
                <table class="table table-bordered">
                   <tr>
                     <th style="color: blue;">Factura:</th>
                     <th><?php if ($sell->numerocorraltivo>=1&$sell->numerocorraltivo<10): ?>
                       <?php echo "000000".$sell->numerocorraltivo;?>
                     <?php else: ?>
                      <?php if ($sell->numerocorraltivo>=10&$sell->numerocorraltivo<100): ?>
                       <?php echo "00000".$sell->numerocorraltivo;?>
                     <?php else: ?>
                      <?php if ($sell->numerocorraltivo>=100&$sell->numerocorraltivo<1000): ?>
                       <?php echo "0000".$sell->numerocorraltivo;?>
                     <?php else: ?>
                      <?php if ($sell->numerocorraltivo>=1000&$sell->numerocorraltivo<10000): ?>
                       <?php echo "000".$sell->numerocorraltivo;?>
                     <?php else: ?>
                      <?php if ($sell->numerocorraltivo>=10000&$sell->numerocorraltivo<100000): ?>
                       <?php echo "00".$sell->numerocorraltivo;?>
                     <?php else: ?>
                     <?php endif ?>
                     <?php endif ?>
                     <?php endif ?>
                     <?php endif ?>
                     <?php endif ?></th>
                     <th style="color: blue;">Inicio Timbrado:</th>
                    
					  <th><?php echo  date('d-m-Y',strtotime($sell->VerConfiFactura()->inicio_timbrado));?></th>
					 
                     <th style="color: blue;">Fin. Timbrado:</th>
                     <th><?php echo  date('d-m-Y',strtotime($sell->VerConfiFactura()->fin_timbrado));?></th>
					 
					 
					
                     <th style="color: blue;">Tipo de Comprobante:</th>
                     <th><?php echo $sell->VerConfiFactura()->comprobante1;?></th>
                   </tr>
               </table> 
               <?php endif ?> 
              <br> 
                <table class="table table-bordered">
                <?php if($sell->cliente_id!=""):
                $client = $sell->getCliente();
                ?>
                <tr>
                  <td style="width:150px; text-transform:uppercase;" class="alert alert-warning"><b>Proveedor:</b></td>
           
				  
				  
				  
				    <td class="alert alert-warning"> <?php if ($client->tipo_doc=="SIN NOMBRE") {echo  $client->tipo_doc;
			 
			 }else {echo  $client->nombre." ".$client->apellido; }?>
		
			 <?php 
               				
			 
			 ?></td>
				  
				  
				  
                </tr>

                <?php endif; ?>
                <?php if($sell->usuario_id!=""):
                $user = $sell->getUser();
                ?>
                <tr>
                  <td class="alert alert-warning"><b>Realizado por:</b>
                <?php echo $user->nombre." ".$user->apellido;?></td>
                </tr>
				
                <?php endif; ?>
                </table>
                <br><table class="table table-bordered table-hover">
                <thead>
                  <th>Codigo</th>
                  <th>Cantidad</th>
                  <th>Nombre del Producto</th>
				  <th>Tipo transacción</th>
				   <th>Motivo</th>
                  <th>Depósito</th>
				    <th>Observación</th>
				  
				  <th>Fecha</th>
                 

                </thead>
              <?php
			  $precio=0;
			  $total3=0;
			  $total4=0;
                foreach($operations as $operation){
				
					
                  $product  = $operation->getProducto();
              ?>
              <tr>
                <td style="width:30px;"><?php echo $product->codigo ;?></td>
                <td style="width:30px;"><?php echo $operation->q ;?></td>
                <td style="width:30px;"><?php echo $product->nombre ;?></td>
				
				
				   
				
				
                <td style="width:30px;">
                  
				    <?php if ($sell->accion_id==1) {echo  "Entrada";
			 
			 }else if ($sell->accion_id==2) {  echo  "Salida"; }
			 else if ($sell->accion_id==3) {  echo  "Trasferencia"; }?></td>
				
				  
               <?php

                 $cant  = StockData::vercontenidos($product->id_producto);
	          foreach($cant as $can){
	          $q1=$can->CANTIDAD_STOCK;
	          $id_dep=$can->DEPOSITO_ID;
			  $precio_com=$can->COSTO_COMPRA;
	
	                                }
	
	          $deposit  = StockData::verdeposito($id_dep);
	          foreach($deposit as $dep){
	          $de=$dep->NOMBRE_DEPOSITO;
	                                   } 

                  ?>


         
         <td style="width:30px;"><?php echo $operation->motivo ;?></td>

				  
				
                <td style="width:30px;"> <?php echo $de;
				?></td>
				
				
				
                <td style="width:30px;"> <?php echo $operation->observacion;
				?></td>
				
				<td style="width:30px;"><?php echo $operation->fecha ;?></td>
              </tr>
              <?php
                }
                ?>
				
				
				
              </table>
              <br><br>
              <div class="row">
              <div class="col-md-4">
              <table class="table table-bordered">
              
             
              </table>
              </div>
              </div>
              <div class="box">
                    <div class="box-body">
                      <div class="box box-danger">
                      </div>
					  
					  
					  
                          </div>
                  </div>
                <?php else:?>
                  501 Internal Error
                <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>