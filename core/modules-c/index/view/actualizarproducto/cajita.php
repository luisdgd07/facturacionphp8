 <?php if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"]!=""):?>
            <?php 
            $u=null;
            if($_SESSION["admin_id"]!=""){
          $u = UserData::getById($_SESSION["admin_id"]);
          // $user = $u->nombre." ".$u->apellido;
          }?>
 <?php
$cliente = ProductoData::getById($_GET["id_producto"]);
// $url = "storage/plato/".$cliente->id_plato."/".$cliente->imagen;
?>
 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class='fa fa-laptop' style="color: orange;"></i>
        ACTUALIZAR DATOS DEL PRODUCTO <?php echo $cliente->nombre; ?>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-body">
              <a href="index.php?view=producto" class="btn btn-warning btn-lg btn-block btn-flat"><i class="fa fa-arrow-left"></i> Atras</a>
              <br>
              <img src="storage/producto/<?php echo $cliente->imagen ?>" alt="" class="img-responsive">
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="box">
            <div class="box-body">
              <div class="box box-warning">
                    <div class="panel-body">
               <form class="form-horizontal" method="post" enctype="multipart/form-data"  action="index.php?action=actualizarproducto" role="form">
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-lg-3 control-label">Imagen</label>
                    <div class="col-lg-9">
                      <input type="file" class="form-control" name="imagen" id="imagen">
                    </div>
                  </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Codigo Fabricante</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="codigofabricante" id="codigofabricante" maxlength="30" value="<?php echo $cliente->codigofabricante; ?>">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Codigo Importador</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="codigoimportador" id="codigoimportador" maxlength="30" value="<?php echo $cliente->codigoimportador; ?>">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Codigo</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="codigo" id="codigo" maxlength="30" value="<?php echo $cliente->codigo; ?>">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Nombre</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" required onKeyUP="this.value=this.value.toLowerCase();" maxlength="80" value="<?php echo $cliente->nombre; ?>">
                    </div>
                </div>
                 <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Categoria</label>
                    <div class="col-sm-9">
                      <?php
                        $categories = CategoriaData::getAll();
                         if(count($categories)>0):?>
                      <select name="categoria_id" id="categoria_id" class="form-control">
                        <option value="<?php echo $cliente->id_categoria ?>">SELECCIONAR CATEGORIA</option>
                        <?php foreach($categories as $cat):?>
                        <!-- <option value="<?php echo $cat->id_categoria; ?>"><i class="fa fa-gg"></i><?php echo $cat->nombre; ?></option> -->
                        <option value="<?php echo $cat->id_categoria; ?>" <?php if($cliente->categoria_id==$cat->id_categoria){ echo "selected";} ?>><?php echo $cat->nombre; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php endif; ?>

                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Serie</label>

                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="serie" name="serie"   onpaste="return false" maxlength="500" value="<?php echo $cliente->serie; ?>">
                    </div>
                    <label for="inputEmail1" class="col-sm-1 control-label">Modelo</label>

                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="modelo" name="modelo"   onpaste="return false" maxlength="500" value="<?php echo $cliente->modelo; ?>">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Marca</label>

                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="marca" name="marca"   onpaste="return false" maxlength="500" value="<?php echo $cliente->marca; ?>">
                    </div>
                    <label for="inputEmail1" class="col-sm-1 control-label">Estado</label>
                    <div class="col-sm-4">
                      <select name="estado" id="estado" class="form-control">
                              <option value="<?php echo $cliente->estado; ?>"><?php echo $cliente->estado; ?></option>
                              <option value="NUEVO">Nuevo</option>
                              <option value="SEMI NUEVO">Semi Nuevo</option>
                              <option value="OTROS">Otros</option>
                    </select>
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Descripcion</label>
                    <div class="col-sm-4">
                      <textarea name="descripcion" class="form-control"><?php echo $cliente->descripcion; ?></textarea>
                    </div>
                    <label for="inputEmail1" class="col-sm-2 control-label">Presentacion</label>
                    <div class="col-sm-3">
                      <textarea name="presentacion" class="form-control"><?php echo $cliente->presentacion; ?></textarea>
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Unidad</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="unidades" name="unidades"  onkeypress="return solonumeros(event);"  onpaste="return false" maxlength="100" value="<?php echo $cliente->unidades; ?>">
                    </div>
                </div>
               <!--  <div class="form-group has-feedback has-warning">
                  <label  class="col-lg-3 control-label">Estado</label>
                  <div class="col-lg-9">
                    <select name="estado" id="estado" class="form-control">
                              <option value="<?php echo $cliente->estado; ?>"><?php echo $cliente->estado; ?></option>
                              <option value="NUEVO">Nuevo</option>
                              <option value="SEMI NUEVO">Semi Nuevo</option>
                              <option value="OTROS">Otros</option>
                    </select>
                  </div>
                </div> -->
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Precio Compra <b>$</b></label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="precio_compra" name="precio_compra" required onkeypress="return solonumeross(event);" onpaste="return false" maxlength="100" value="<?php echo $cliente->precio_compra; ?>">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Precio Venta <b>$</b></label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="precio_venta" name="precio_venta" required onkeypress="return solonumeross(event);" onpaste="return false" maxlength="100" value="<?php echo $cliente->precio_venta; ?>">
                    </div>
                </div>
                <div class="form-group has-warning">
                    <label for="inputEmail1" class="col-sm-3 control-label">Minimo Inventario</label>

                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="inventario_minimo" name="inventario_minimo" required onkeypress="return solonumeros(event);" onpaste="return false" maxlength="10" value="<?php echo $cliente->inventario_minimo; ?>">
                    </div>
                    <label for="inputEmail1" class="col-sm-2 control-label">Activo</label>
                    <div class="col-sm-2">
                      <div class="checkbox">
                          <label>
                            <input type="checkbox" name="activo" <?php if($cliente->activo){ echo "checked";} ?> > 
                          </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Borrar</button>
              <input type="hidden" name="id_producto" value="<?php echo $_GET["id_producto"];?>">
              <button type="submit" class="btn btn-warning btn-flat" ><i class="fa fa-save"></i> Guardar</button>
              </form>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php else:?>
   <?php endif;?>