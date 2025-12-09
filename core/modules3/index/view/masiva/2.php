    <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
        VENTAS REALIZADAS
      </h1>
    </section>
    <!-- Main content -->     
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <?php
                $products = VentaData::getVentas();

                if(count($products)>0){

                  ?>
                <br>
                <table class="table table-bordered table-hover  ">
                  <thead>
                    <th></th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <!-- <th></th> -->
                  </thead>
                  <?php foreach($products as $sell):?>

                  <tr>
                    <td style="width:30px;">
                    <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a></td>

                    <td>

                <?php
                $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                echo count($operations);
                ?>
                    <td>

                <?php
                $total= $sell->total-$sell->descuento;
                    echo "<b>Bs ".number_format($total,0,'.','.')."</b>";

                ?>      

                    </td>
                    <td><?php echo $sell->fecha; ?></td>
                    <!-- <td style="width:30px;"><a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td> -->
                  </tr>

                <?php endforeach; ?>

                </table>

                <div class="clearfix"></div>

                  <?php
                }else{
                  ?>
                  <div class="jumbotron">
                    <h2>No hay ventas</h2>
                    <p>No se ha realizado ninguna venta.</p>
                  </div>
                  <?php
                }

                ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php endif ?>
  <?php if($u->is_empleado):?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
        REGISTRO DE VENTAS MASIVAS
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <?php
              $total10imp=0;
              $total5imp=0;
              $tota0imp=0;
              $totaliva10=0;
              $totaliva5=0;
              $totaliva0=0;
                $products = OperationData::verproductoprocesos($sucursales->id_sucursal);

                if(count($products)>0){

                  ?>
                <br>
                <table id="example1" class="table table-bordered table-hover  ">
                  <thead>
                    <th># De Venta</th>
                    <th>producto</th>
                    <th>Cantida</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Impuesto</th>
                    <th>IVA</th>
                    <th>Grabada</th>
                    <th>Acciones</th>
                  </thead>
                  <?php foreach($products as $sell):?>
                  <tr <?php if ($sell->masiva==0): ?>
                    class="alert alert-warning"
                  <?php endif ?>>
                    <?php if ((($sell->q*$sell->getProducto()->precio_venta)*$sell->getVenta()->cambio)>$sell->getVenta()->cambio*$sell->getVenta()->cantidaconfigmasiva&$sell->getVenta()->getCliente()->nombre=="X"): ?>
                      <td> <?php echo $sell->id_proceso; ?></td> 
                      <td><?php echo $sell->getProducto()->nombre ?></td>
                      <td><?php echo $sell->q ?></td>
                      <td><?php echo $sell->getProducto()->precio_venta*$sell->q ?></td>
                      <td><?php echo $sell->fecha ?></td>
                      <td><?php if ($sell->getProducto()->impuesto=="10"): ?>
                        <b style="color: blue;"><?php echo $sell->getProducto()->impuesto ?>% <?php   (($sell->getProducto()->precio_venta*$sell->q)/11);$total10imp=(($sell->getProducto()->precio_venta*$sell->q)/11);?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="5"): ?>
                        <b style="color: green;"><?php echo $sell->getProducto()->impuesto ?>% <?php   (($sell->getProducto()->precio_venta*$sell->q)/21);$total5imp=(($sell->getProducto()->precio_venta*$sell->q)/21);?></b>
                        <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="0"): ?>
                        <b style="color: red;"><?php echo $sell->getProducto()->impuesto ?>% <?php   ($sell->getProducto()->precio_venta*$sell->q);$tota0imp=($sell->getProducto()->precio_venta*$sell->q);?></b>
                      <?php endif ?>
                      <?php endif ?>
                      <?php endif ?></td>
                      <td><?php if ($sell->getProducto()->impuesto=="10"): ?>
                        <b style="color: blue;"><?php  echo round($total10imp)?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="5"): ?>
                        <b style="color: blue;"><?php  echo round($total5imp)?></b>
                      <?php else: ?><?php if ($sell->getProducto()->impuesto=="0"): ?>
                        <b style="color: blue;"><?php  echo round($tota0imp)?></b>
                      <?php endif ?>
                      <?php endif ?>
                      <?php endif ?></td>
                      <td><?php if ($sell->getProducto()->impuesto=="10"): ?>
                        <b style="color: blue;"><?php  echo round(($sell->getProducto()->precio_venta*$sell->q)/1.1);$totaliva10=(($sell->getProducto()->precio_venta*$sell->q)/1.1)?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="5"): ?>
                        <b style="color: blue;"><?php  echo round(($sell->getProducto()->precio_venta*$sell->q)/1.05);$totaliva5=(($sell->getProducto()->precio_venta*$sell->q)/1.05)?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="0"): ?>
                        <b style="color: blue;"><?php  echo round($sell->getProducto()->precio_venta*$sell->q);$totaliva0=($sell->getProducto()->precio_venta*$sell->q)?></b>
                      <?php endif ?>
                      <?php endif ?>
                      <?php endif ?></td>
                      <!-- <td><input type="text" name="num1" id="serie"></td> -->
                      <?php if ($sell->masiva==0): ?>
                      <td width="140px">
                        <a href="index.php?view=masiva1&id_sucursal=<?php echo $_GET["id_sucursal"]; ?>&id_proceso=<?php echo $sell->id_proceso; ?>" class="btn btn-success">Registrar Masivo </a><div class="modal fade" id="registromasivo-<?php echo $sell->id_proceso; ?>">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"><i  style="color: blue;"></i><b style="color: black;"> REGISTRO DE LA VENTA MASIVO</b></h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="tab-pane active" id="tab_1">
                                      <form class="form-horizontal" action="index.php?action=nuevomasiva1" role="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group has-feedback has-error">
                                           <label for="inputEmail1" class="col-lg-2 control-label">Factura</label>
                                          <div class="col-lg-10">
                                            <input type="hidden"  name="num1" id="num1">
                                              <input type="hidden"  name="numinicio" id="numinicio">
                                              <input type="hidden"  name="numfin" id="numfin">
                                              <input type="hidden"  name="serie" id="serie">
                                              <input type="hidden"  name="id_configfactura" id="id_configfactura">
                                              <input type="hidden" class="form-control" name="diferencia" id="diferencia">
                                            <?php 
                                          $clients = ConfigFacturaData::verfacturasucursal($sucursales->id_sucursal);
                                              ?>
                                         <select required="" name="factura1" id="factura1" class="form-control" oninput="configFactura()">
                                                <option>Seleccionar</option>
                                              <?php foreach($clients as $client):?>
                                                <option requered="" <?php if ($client->diferencia==-1): ?>disabled=""<?php else: ?><?php endif ?> value="<?php echo $client->id_configfactura;?>"><?php echo $client->comprobante1;?></option>
                                                <script type="text/javascript">
                                                function configFactura()
                                                  {
                                                    $.ajax({
                                                      url: 'index.php?action=consultafactura',
                                                      type: 'POST',
                                                      data:{
                                                        confiFactura: Number(document.getElementById("factura1").value)
                                                      },
                                                      dataType: 'json',
                                                      success: function(json){
                                                        
                                                        // console.log(json[0].valor);
                                                        document.getElementById('num1').value=json[0].numeroactual1;
                                                        document.getElementById('numinicio').value=json[0].numeracion_inicial;
                                                        document.getElementById('numfin').value=json[0].numeracion_final;
                                                        document.getElementById('serie').value=json[0].serie1;
                                                        document.getElementById('id_configfactura').value=json[0].id_configfactura;
                                                        document.getElementById('diferencia').value=json[0].diferencia;
                                                      }, error: function(xhr, status){
                                                        console.log("Ha ocurrido un error.");
                                                      }
                                                    });

                                                  }
                                              </script>
                                              <?php endforeach;?>
                                            </select>
                                           </div>
                                         </div>
                                         <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                                          <input type="hidden" name="usuario_id" value="<?php echo $u->id_usuario ?>">
                                          <input type="hidden" name="cliente_id" value="<?php echo $sell->getVenta()->cliente_id ?>">
                                          <input type="hidden" name="producto_id" value="<?php echo $sell->producto_id ?>">
                                          <input type="hidden" name="tipomoneda_id" value="<?php echo $sell->getVenta()->tipomoneda_id ?>">
                                          <input type="hidden" name="configfactura_id" value="<?php echo $sell->getVenta()->configfactura_id ?>">
                                          <input type="hidden" name="venta_id" value="<?php echo $sell->venta_id ?>">
                                          <input type="hidden" name="precio" value="<?php echo $sell->getProducto()->precio_venta ?>">
                                          <input type="hidden" name="total" value="<?php echo $sell->getProducto()->precio_venta*$sell->q ?>">
                                          <input type="hidden" name="cantidadd" value="<?php echo $sell->q ?>"> 
                                          <?php if ($sell->getProducto()->impuesto=="10"): ?>
                                            <input type="hidden"  class="form-control" name="iva10" value="<?php  echo ($sell->getProducto()->precio_venta)/11;?>">
                                            <input type="hidden"  class="form-control" name="total10" value="<?php  echo ($sell->getProducto()->precio_venta)/1.1?>">
                                            <?php else: ?>
                                            <?php if ($sell->getProducto()->impuesto=="5"): ?>
                                            <input type="text" class="form-control" name="iva5" value="<?php  echo ($sell->getProducto()->precio_venta)/21?>">
                                            <input type="text" class="form-control" name="total5" value="<?php  echo ($sell->getProducto()->precio_venta)/1.05?>">
                                            <?php else: ?> 
                                              <?php if ($sell->getProducto()->impuesto=="0"): ?>
                                            <input type="hidden" class="form-control"  name="iva0" value="<?php  echo $sell->getProducto()->precio_venta?>">
                                            <input type="hidden" class="form-control"  name="exenta" value="<?php  echo $sell->getProducto()->precio_venta?>">
                                          <?php endif ?>
                                          <?php endif ?>                           
                                          <?php endif ?>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                                        <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Registrar</button>
                                      </div>
                                      </form>
                                </div>              
                                  </div>
                              </div>
                          </div>
                      </div>
                      </td>
                      <?php else: ?>
                        <td width="120">
                          <!-- <a href="ticket1.php?id_venta=125" class="btn btn-prymari btn-sm btn-flat" target="_BLANK"><i class="fa fa-file-code-o" style="color: orange"></i> Generar Ticket</a> -->
                          <a href="" class="btn btn-info">Detalle</a> <a href="ticket2.php?id_venta=<?php echo $sell->getVenta()->id_venta;?>" class="btn btn-warning" target="_BLANCK">Ticket</a>
                        </td>
                      <?php endif ?>
                    <?php endif ?>
                  </tr>
                <?php endforeach; ?>

                </table>

                <div class="clearfix"></div>

                  <?php
                }else{
                  ?>
                  <div class="jumbotron">
                    <h2>No hay ventas</h2>
                    <p>No se ha realizado ninguna venta.</p>
                  </div>
                  <?php
                }

                ?>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php endif ?>
<?php endif ?>