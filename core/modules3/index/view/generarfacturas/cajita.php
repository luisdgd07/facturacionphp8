
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
        DETALLE DE LA VENTA DE LOS PRODUCTOS
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
                      echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->nombre</b> no tiene existencias en inventario.</p>";      
                    }else if($qx<=$p->inventario_minimo/2){
                      echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->nombre</b> tiene muy pocas existencias en inventario.</p>";
                    }else if($qx<=$p->inventario_minimo){
                      echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->nombre</b> tiene pocas existencias en inventario.</p>";
                    }
                  }
                  setcookie("selled","",time()-18600);
                }

                ?>
               <table class="table table-bordered">
                   <tr>
                     <th style="color: blue;">Factura</th>
                     <th><?php echo $sell->VerConfiFactura()->serie1." - ".$sell->VerConfiFactura()->numeroactual1;?></th>
                     <th style="color: blue;">Inicio Timbrado</th>
                     <th><?php echo $sell->VerConfiFactura()->inicio_timbrado;?></th>
                     <th style="color: blue;">Fin. Timbrado</th>
                     <th><?php echo $sell->VerConfiFactura()->fin_timbrado;?></th>
                     <th style="color: blue;">Tipo de Comprobante</th>
                     <th><?php echo $sell->VerConfiFactura()->comprobante1;?></th>
                   </tr>
               </table> 
              <br> 
                <table class="table table-bordered">
                <?php if($sell->cliente_id!=""):
                $client = $sell->getCliente();
                ?>
                <tr>
                  <td style="width:150px; text-transform:uppercase;" class="alert alert-warning"><b>Cliente</b></td>
                  <td class="alert alert-warning"><?php echo $client->nombre." ".$client->apellido;?></td>
                </tr>

                <?php endif; ?>
                <?php if($sell->usuario_id!=""):
                $user = $sell->getUser();
                ?>
                <tr>
                  <td class="alert alert-warning"><b>Atendido por</b></td>
                  <td class="alert alert-warning"><?php echo $user->nombre." ".$user->apellido;?></td>
                </tr>
                <?php endif; ?>
                </table>
                <br><table class="table table-bordered table-hover">
                <thead>
                  <th>Codigo</th>
                  <th>Cantidad</th>
                  <th>Nombre del Producto</th>
                  <th>Precio Unitario</th>
                  <th>Total</th>

                </thead>
              <?php
                foreach($operations as $operation){
                  $product  = $operation->getProducto();
              ?>
              <tr>
                <td><?php echo $product->id_producto ;?></td>
                <td><?php echo $operation->q ;?></td>
                <td><?php echo $product->nombre ;?></td>
                <td><?php echo $sell->VerTipoModena()->simbolo; ?> <?php echo number_format($product->precio_venta,0,".",",") ;?></td>
                <td><b><?php echo $sell->VerTipoModena()->simbolo; ?> <?php echo (($operation->q*$product->precio_venta)*$sell->cambio);$total+=(($operation->q*$product->precio_venta)*$sell->cambio);?></b></td>
              </tr>
              <?php
                }
                ?>
              </table>
              <br><br>
              <div class="row">
              <div class="col-md-4">
              <table class="table table-bordered">
                <tr>
                  <td><h4>Descuento:</h4></td>
                  <td><h4><?php echo $sell->VerTipoModena()->simbolo; ?> <?php echo number_format($sell->descuento,0,'.',','); ?></h4></td>
                </tr>
                <tr>
                  <td><h4>Subtotal:</h4></td>
                  <td><h4><?php echo $sell->VerTipoModena()->simbolo; ?> <?php echo number_format($total,0,'.',','); ?></h4></td>
                </tr>
                <tr>
                  <td><h4><b>Total:</b></h4></td>
                  <td><h4><b><?php echo $sell->VerTipoModena()->simbolo; ?> <?php echo number_format($total-  $sell->descuento,0,'.',','); ?></b></h4></td>
                </tr>
              </table>
              <p><?php echo $radumprincipal= rand(1700,1900) ?></p>
              <p><?php echo ($total-$radumprincipal)?></p>
              <p><?php echo $radumprincipal1= rand(1700,1900) ?></p>
              <p><?php echo ($total-$radumprincipal1)?></p>
              <p><?php echo $radumprincipal2= rand(1700,1900) ?></p>
              <p><?php echo ($total-$radumprincipal2)?></p>
              </div>
              </div>

                <?php else:?>
                  501 Internal Error
                <?php endif; ?>
                <?php if ($total>="2000"&$sell->getCliente()->nombre=="X"): ?>
                  <div class="box">
                    <div class="box-body">
                      <a href="index.php?view=generarfacturas&id_venta=<?php echo $_GET["id_venta"]?>" class="btn btn-primary btn-sm btn-flat" Target="_BLANK"><i class='fa fa-file-code-o' style="color: orange"></i> Generar Facturas</a>
                    </div>
                  </div>
                  <?php else: ?>
                  <div class="box">
                    <div class="box-body">
                      <div class="box box-danger">
                      </div>
                          <a href="index.php?view=generarfacturaproducto&id_venta=<?php echo $_GET["id_venta"]?>" class="btn btn-success btn-sm btn-flat" target="_blank"><i class='fa fa-file-code-o' style="color: orange"></i> Generar Factura</a>
                          <a href="index.php?view=recibo&id_venta=<?php echo $_GET["id_venta"]?>" class="btn btn-info btn-sm btn-flat"><i class='fa fa-file-code-o' style="color: orange"></i> Generar Recibo</a>
                          <a href="ticket1.php?id_venta=<?php echo $_GET["id_venta"]?>" class="btn btn-prymari btn-sm btn-flat" Target="_BLANK"><i class='fa fa-file-code-o' style="color: orange"></i> Generar Ticket</a>
                    </div>
                  </div>
                <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>