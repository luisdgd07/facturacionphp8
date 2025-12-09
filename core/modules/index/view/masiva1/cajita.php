   <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
<?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
  <?php
    $sell = OperationData::getById($_GET["id_proceso"]);
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-institution' style="color: orange;"></i>
        GENERAR FACTURAS
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
              <table>
                <thead>
                  <tr>
                    <!-- <th>Impuesto</th>
                    <th>Iva</th>
                    <th>Grabada</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr>
				  
				  
				  
				  
                     <td><?php if ($sell->getProducto()->impuesto=="10"): ?>
                        <b style="color: blue;"><?php  $sell->getProducto()->impuesto ?> <?php   round((($sell->getVenta()->total)/$sell->q)/1.1);$total10imp=round((($sell->getVenta()->total)/$sell->q)/1.1);?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="5"): ?>
                        <b style="color: green;"><?php  $sell->getProducto()->impuesto ?> <?php   round((($sell->getVenta()->total)/$sell->q)/1.05);$total5imp=round((($sell->getVenta()->total)/$sell->q)/1.05);?></b>
                        <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="0"): ?>
                        <b style="color: red;"><?php  $sell->getProducto()->impuesto ?> <?php   round((($sell->getVenta()->total)/$sell->q));$tota0imp=round((($sell->getVenta()->total)/$sell->q));?></b>
                      <?php endif ?>
                      <?php endif ?>
                      <?php endif ?></td>
                      <td><?php if ($sell->getProducto()->impuesto=="10"): ?>
                        <b style="color: blue;"><?php   $total10imp?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="5"): ?>
                        <b style="color: blue;"><?php   $total5imp?></b>
                      <?php else: ?><?php if ($sell->getProducto()->impuesto=="0"): ?>
                        <b style="color: blue;"><?php   $tota0imp?></b>
                      <?php endif ?>
                      <?php endif ?>
                      <?php endif ?></td>
                      <td><?php if ($sell->getProducto()->impuesto=="10"): ?>
                        <b style="color: blue;"><?php   round((($sell->getVenta()->total)/$sell->q)/11);$totaliva10=round((($sell->getVenta()->total)/$sell->q)/11)?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="5"): ?>
                        <b style="color: blue;"><?php   round((($sell->getVenta()->total)/$sell->q)/21);$totaliva5=round((($sell->getVenta()->total)/$sell->q)/21)?></b>
                      <?php else: ?>
                        <?php if ($sell->getProducto()->impuesto=="0"): ?>
                        <b style="color: blue;"><?php  round((($sell->getVenta()->total)/$sell->q));$totaliva0=round((($sell->getVenta()->total)/$sell->q))?></b>
                      <?php endif ?>
                      <?php endif ?>
                      <?php endif ?></td>
                  </tr>
                </tbody>
              </table>
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
                                         <select required="" name="configfactura_id" id="factura1" class="form-control" oninput="configFactura()">
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
										 
										 
										 
									 
										 
										 
							  
							    <?php
				  $cotizacion = CotizacionData::versucursalcotizacion($sucursales->id_sucursal);
                    
                    if(count($cotizacion)>0){ ?>
					
					
					
				
              
				
                  <?php
				  
				  $valores=0;
                    foreach($cotizacion as $moneda){	
						$mon = MonedaData::cboObtenerValorPorSucursal3($sucursales->id_sucursal);
                    ?>
					  <?php foreach($mon as $mo):?>
					 
                  
				  <?php 
				  $nombre=$mo->nombre;
				  $fechacotiz=$mo->fecha_cotizacion;
				  $valores=$mo->valor;
				  $simbolo2=$mo->simbolo;
				  
				  ?>
				  
				   <?php endforeach;?>
                
                 
                  <?php
				 
                } }
					
?>
					
							  
							  
						  
							  
							  
							  <input type="hidden" name="cambio2" id="cambio2" value="<?php echo $valores; ?>"class="form-control">
							  <input type="hidden" name="simbolo2" id="simbolo2" value="<?php echo $simbolo2; ?>"class="form-control">
										 
										 
										 
										 
										 
										 
										 
										 
										 
										 
										 
										 
										 
                                         <input type="hidden" name="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                                          <input type="hidden" name="usuario_id" value="<?php echo $u->id_usuario ?>">
                                          <input type="hidden" name="cliente_id" value="<?php echo $sell->getVenta()->cliente_id ?>">
                                          <input type="hidden" name="producto_id" value="<?php echo $sell->producto_id ?>">
                                          <input type="hidden" name="tipomoneda_id" value="<?php echo $sell->getVenta()->tipomoneda_id ?>">
                                          <input type="hidden" name="venta_id" value="<?php echo $sell->venta_id ?>">
                                          <input type="hidden" name="precio" value="<?php echo (($sell->getVenta()->total)/$sell->q) ?>">
                                          <input type="hidden" name="total" value="<?php echo $sell->getVenta()->total ?>">
                                          <input type="hidden" name="cantidadd" value="<?php echo $sell->q ?>"> 
                                            <input type="hidden"  class="form-control" name="iva10" value="<?php  echo $sell->getVenta()->iva10 ?>"> 
                                            <input type="hidden"  class="form-control" name="total10" value="<?php  echo $sell->getVenta()->total10 ?>"> 
                                          <input type="hidden" class="form-control" name="iva5" value="<?php  echo $sell->getVenta()->iva5 ?>">
                                          <input type="hidden" class="form-control" name="total5" value="<?php  echo $sell->getVenta()->total5 ?>">
                                          <input type="hidden" class="form-control"  name="iva0" value="<?php  echo $sell->getVenta()->iva0?>"> 
                                          <input type="hidden" class="form-control"  name="exenta" value="<?php  echo $sell->getVenta()->exenta?>">
                                          <input type="hidden" name="impuesto" value="<?php echo $sell->getProducto()->impuesto  ?>">
                                          <input type="hidden" class="form-control"  name="cambio" value="<?php  echo $sell->getVenta()->cambio?>">
                                            <input type="hidden" class="form-control"  name="metodopago" value="<?php  echo $sell->getVenta()->metodopago?>">
                                            <input type="hidden" class="form-control"  name="formapago" value="<?php  echo $sell->getVenta()->formapago?>">
                                            <input type="hidden" class="form-control"  name="fechapago" value="<?php  echo $sell->getVenta()->fecha?>">
                                          <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                                          <input type="hidden" name="cantidaconfigmasiva" value="<?php echo trim(round($sell->getVenta()->cantidaconfigmasiva))?>">
                                          <input type="hidden" name="series" value="<?php echo $sell->getVenta()->VerConfiFactura()->serie?>">
                                          <input type="hidden" name="id_proceso" id="id_proceso" value="<?php echo $sell->id_proceso; ?>">
                                          <input type="hidden" name="masiva" id="masiva" value="1">
                                          <input type="hidden" name="id_venta" id="id_venta" value="<?php echo $sell->getVenta()->id_venta ?>">
                                          <input type="hidden" name="tipo_venta" id="tipo_venta" value="2">
                                          <input type="hidden" name="fecha" id="fecha" value="<?php echo $sell->getVenta()->fecha?>">
                                          <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Registrar</button>
              </form> 
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php endif ?>