 <?php
  $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
 <div class="content-wrapper">
   <section class="content-header">
     <h1><i class='fa fa-laptop' style="color: orange;"></i>
       REGISTRO DE CONTRATO
     </h1>
   </section>
   <!-- Main content -->
   <section class="content">

     <div class="row">

       <div class="col-xs-12">
         <form method="post" action="index.php?action=creacontrato" role="form">
           <div class="box">
             <div class="box-body">
               <div class="box box-warning">
                 <div class="panel-body">
                   <div class="form-horizontal">
				   
				   
				
				   
				   
                     <div class="form-group has-feedback has-warning">
					 
					     <label class="col-lg-2 control-label">Nro de Contrato</label>
                       <div class="col-lg-4">
                         <input type="text" name="datos" class="form-control" id="descripcion" maxlength="800">
                         <span class="fa fa-dollar form-control-feedback"></span>
                       </div>
					 
					   <label class="col-lg-2 control-label">Monto</label>
                       <div class="col-lg-4">
                         <input type="number" name="monto" class="form-control" id="monto" maxlength="800" required>
                         <span class="fa fa-laptop form-control-feedback"></span>
                       </div>
                       <label for="cuota" class="col-lg-2 control-label">Cuotas:</label>
                       <div class="col-lg-4">
                         <input type="number" name="cuota" class="form-control" id="cuota" required>
                         <span class="fa fa-barcode form-control-feedback"></span>
                       </div>
                     
                     </div>
                     <div class="form-group has-feedback has-warning">
                       <label class="col-lg-2 control-label">Total</label>
                       <div class="col-lg-4">
                         <input type="number" name="total" class="form-control" id="total" onkeypress="return solonumeross(event)">
                         <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                       </div>
                       <label class="col-lg-2 control-label">Entrega</label>
                       <div class="col-lg-4">
                         <input type="text" name="entrega" class="form-control" id="entrega" maxlength="800">
                         <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                       </div>
                     </div>
                     <div class="form-group has-feedback has-warning">
                       <label class="col-lg-2 control-label">Cliente</label>
                       <div class="col-lg-4">
                         <select name="cliente" onchange="clienteTipo()" class="selectpicker show-menu-arrow form-control" data-style="form-control" data-live-search="true" id="cliente_id" class="form-control">
                           <option value="">SELECCIONAR CLIENTE</option>

                           <?php
                            $clients = ClienteData::verclientessucursal($sucursales->id_sucursal);
                            foreach ($clients as $client) :
                              // $tipocliente = ProductoData::listar_tipo_precio($client->id_precio);
                              if ($client->id_cliente == $venta->cliente_id) { ?>
                               <option selected value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                             <?php
                              } else {
                              ?>
                               <option value="<?php echo $client->id_cliente; ?>"><?php echo $client->dni . " - " . $client->nombre . " " . $client->apellido . " - " . $client->tipo_doc; ?></option>
                           <?php }
                            endforeach;

                            ?>
                         </select>
                         <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                       </div>
                       <label class="col-lg-2 control-label">Fecha</label>
                       <div class="col-lg-4">
                         <input type="date" name="fecha" class="form-control" id="fecha" maxlength="800">
                         <span class="fa fa-dollar form-control-feedback"></span>
                       </div>
                     </div>
                     <div class="form-group has-feedback has-warning">
                       <label class="col-lg-2 control-label">Zona</label>
                       <div class="col-lg-4">
                         <input type="text" name="zona" class="form-control" id="zona" maxlength="800">
                         <span class="fa fa-dollar form-control-feedback"></span>
                       </div>
                       <label class="col-lg-2 control-label">Descripción</label>
                       <div class="col-lg-4">
                         <input type="text" name="descripcion" class="form-control" id="descripcion" maxlength="800">
                         <span class="fa fa-dollar form-control-feedback"></span>
                       </div>
                      
                       <label class="col-lg-2 control-label">Inicial</label>
                       <div class="col-lg-4">
                         <input type="text" name="inicial" class="form-control" id="entrega" onkeypress="return solonumeross(event);" maxlength="800">
                         <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                       </div>
                     </div>
                     <div class="form-group">
                       <div class="col-lg-offset-2 col-lg-10">
                         <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                         <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                         <button type="submit" class="btn btn-warning btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
                       </div>
                     </div>
                     <div id="insumos"></div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </form>

       </div>

     </div>
   </section>
 </div>
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
 </script>