 <?php
   $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
 ?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-laptop' style="color: orange;"></i>
        REGISTRO DE UN NUEVO PRODUCTO
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
                    <form class="form-horizontal" role="form" method="post" action="index.php?action=nuevoproducto1" enctype="multipart/form-data">
                      <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Imagen</label>
                          <div class="col-lg-10">
                            <input type="file" name="imagen" class="form-control" id="imagen">
                            <span class="fa fa-image form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo Fabricante</label>
                          <div class="col-lg-10">
                            <input type="text"  name="codigofabricante" class="form-control" id="codigofabricante" placeholder="Codigo del Fabriante"  maxlength="200">
                            <span class="fa fa-barcode form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo Importador</label>
                          <div class="col-lg-10">
                            <input type="text" name="codigoimportador" class="form-control" id="codigoimportador" placeholder="Codigo del Importador">
                            <span class="fa fa-barcode form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-error">
                          <label for="inputEmail1" class="col-lg-2 control-label">Categoria</label>
                          <div class="col-lg-10">
                            <?php
                              $categories = CategoriaData::vercategoriassucursal($sucursales->id_sucursal);
                               if(count($categories)>0):?>
                            <select name="categoria_id" id="categoria_id" required class="form-control">
                              <option value="">SELECCIONAR CATEGORIA</option>
                              <?php foreach($categories as $cat):?>
                              <option value="<?php echo $cat->id_categoria; ?>" style="color: orange;"><i class="fa fa-gg"></i><?php echo $cat->nombre; ?></option>
                              <?php endforeach; ?>
                            </select>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Codigo</label>
                          <div class="col-lg-4">
                            <input type="text" name="codigo" class="form-control" id="codigo" placeholder="Codigo del Producto">
                            <span class="fa fa-barcode form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">nombre</label>
                          <div class="col-lg-4">
                            <input type="text" name="nombre" class="form-control" id="nombre"  placeholder="Nombre del Producto" maxlength="800" required="" >
                            <span class="fa fa-laptop form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Serie</label>
                          <div class="col-lg-4">
                            <input type="text" name="serie" class="form-control" id="serie" placeholder="Serie del Producto" >
                            <span class="fa fa-cc-amex form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Modelo</label>
                          <div class="col-lg-4">
                            <input type="text" name="modelo" class="form-control" id="modelo" placeholder="Modelo del Producto" maxlength="800">
                            <span class="fa fa-gg form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Marca</label>
                          <div class="col-lg-4">
                            <input type="text" name="marca" class="form-control" id="marca" placeholder="Marca del Producto" >
                            <span class="fa fa-apple form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Estado</label>
                          <div class="col-lg-4">
                            <select name="estado" id="estado" class="form-control">
                              <option value="">Seleccionar</option>
                              <option value="NUEVO">Nuevo</option>
                              <option value="SEMI NUEVO">Semi Nuevo</option>
                              <option value="OTROS">Otros</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Presentacion</label>
                          <div class="col-lg-4">
                           <textarea name="presentacion" id="presentacion" class="form-control" placeholder="Presentacion del Producto"></textarea>
                            <span class="fa fa-cube form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Descripcion</label>
                          <div class="col-lg-4">
                           <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion del Producto"></textarea>
                            <span class="fa fa-file-text form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Cantidad</label>
                          <div class="col-lg-4">
                            <input type="text" name="q" class="form-control" id="q" placeholder="Cantidad del Producto" onkeypress="return solonumeross(event)" required="">
                            <span class="fa fa-sort-amount-desc form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Minimo Inventario</label>
                          <div class="col-lg-4">
                            <input type="text" name="inventario_minimo" class="form-control" id="inventario_minimo" onkeypress="return solonumeross(event);" placeholder="Cantidad del Producto" maxlength="800" required="" >
                            <span class="fa fa-laptop form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Precio Venta</label>
                          <div class="col-lg-4">
                            <input type="text" name="precio_venta" class="form-control" id="precio1" placeholder="Precio de Venta" oninput="operacion()" onkeypress="return solonumeross(event)" required="">
                            <span class="fa fa-dollar form-control-feedback"></span>
                          </div>
                          <label  class="col-lg-2 control-label">Precio Compra</label>
                          <div class="col-lg-4">
                            <input type="text" name="precio_compra" class="form-control" id="precio2" onkeypress="return solonumeross(event);" placeholder="Precio de Compra" maxlength="800" >
                            <span class="fa fa-dollar form-control-feedback"></span>
                          </div>
                          <!-- <div class="col-lg-1">
                           <i class="btn btn-success" onkeypress="return operacion(event)" oninput="operacion()">?</i>
                          </div> -->
                        </div>
                        <div class="form-group has-feedback has-warning">
                          <label for="inputEmail1" class="col-lg-2 control-label">Impuesto</label>
                          <div class="col-lg-4">
                            <select class="form-control" name="impuesto">
                              <option>Seleccionar</option>
                              <option value="10">10% Gragada</option>
                              <option value="5">5% Gragada</option>
                              <option value="0">0% Excenta</option>
                            </select>
                          </div>
                          <label for="inputEmail1" class="col-lg-2 control-label">% de Ganancia</label>
                          <div class="col-lg-4">
                            <input type="text" name="ganancia" id="resultado" class="form-control">
                            <span class="fa fa-dollar form-control-feedback"></span>
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