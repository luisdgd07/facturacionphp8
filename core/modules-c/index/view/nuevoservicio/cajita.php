 <?php
   $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
 ?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-laptop' style="color: orange;"></i>
        REGISTRO DE SERVICIO
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- <div class="box-header with-border">
               <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
            </div> -->
            <div class="box-body">
              <div class="box box-warning">
                    <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="index.php?action=nuevoserv" enctype="multipart/form-data">
                      <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Imagen:</label>
                          <div class="col-lg-10">
                            <input type="file" name="imagen" class="form-control" id="imagen">
                            <span class="fa fa-image form-control-feedback"></span>
                          </div>
                        </div>
                      
            
                         <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo:</label>
                          <div class="col-lg-4">
                            <input type="text" name="codigo" class="form-control" id="codigo" required="" placeholder="Codigo del Producto">
                            <span class="fa fa-barcode form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Nombre:</label>
                          <div class="col-lg-4">
                            <input type="text" name="nombre" class="form-control" id="nombre"  placeholder="Nombre del Producto" maxlength="800" required="" >
                            <span class="fa fa-laptop form-control-feedback"></span>
                          </div>
                        </div>
                      
                       
                          

                          <div class="form-group has-feedback has-warning">
                      
                          
                            <input type="hidden" name="tipo_producto" class="form-control" id="tipo_producto"  value="<?php echo $sucursales->ti_producto ?>" placeholder="Nombre del Producto" maxlength="800" required="" >
                            <span class="fa fa-laptop form-control-feedback"></span>
                        
                         

                      
                          <label  class="col-lg-2 control-label">Presentación:</label>
                          <div class="col-lg-4">
                            <select class="form-control" name="presentacion" required="" >
                           
                              <option value="UNIDAD">UNIDAD</option>
                      
                            </select>
                          </div>
                          <label  class="col-lg-2 control-label">Descripción:</label>
                          <div class="col-lg-4">
                           <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion del Producto"></textarea>
                            <span class="fa fa-file-text form-control-feedback"></span>
                          </div>
                        </div>
                       
                        <div class="form-group has-feedback has-warning">
                          
                       
                       <label  class="col-lg-2 control-label">Precio Venta:</label>
                          <div class="col-lg-4">
                            <input type="text" name="precio_venta" class="form-control" id="precio1" placeholder="Precio de Venta" oninput="operacion()" required="">
                            <span class="fa fa-dollar form-control-feedback"></span>
                          </div>
                        
                          <!-- <div class="col-lg-1">
                           <i class="btn btn-success" onkeypress="return operacion(event)" oninput="operacion()">?</i>
                          </div> -->
                        </div>
                        <div class="form-group has-feedback has-warning">
                          
             
                      
                            <input type="hidden" name="tipo_producto" class="form-control" id="tipo_producto"  value="<?php
							echo $sucursales->ti_producto ;
                              ?>" placeholder="Nombre del Producto" maxlength="800" required="" >
                            <span class="fa fa-laptop form-control-feedback"></span>
							
							
							
              
              <label for="inputEmail1" class="col-lg-2 control-label">Impuesto:</label>
                          <div class="col-lg-4">
                            <select class="form-control" name="impuesto"  required="">
                              
                              <option value="10">10% Gravada</option>
                              <option value="5">5% Gravada</option>
                              <option value="0">0% Exenta</option>
                            </select>
                          </div>
                          
                        </div>
                        <!-- <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo Barra</label>
                          <div class="col-lg-10">
                         <svg id="barcoder"></svg>
                            <span class="fa fa-barcode fa fa-instirution form-control-feedback"></span>
                          </div>
                          
                        </div> -->
                        
                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                            <input type="hidden" name="sucursal_id" id="sucursal_id" value="<?php echo $sucursales->id_sucursal; ?>">
                            <button type="submit" class="btn btn-block btn-warning"><i class="fa fa-save"></i></button>
                          </div>
                        </div>
                      </form>                  
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>