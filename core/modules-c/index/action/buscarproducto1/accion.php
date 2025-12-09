  <?php 
    $u=null;
    if (isset($_SESSION["admin_id"])&& $_SESSION["admin_id"]!=""):
      $u=UserData::getById($_SESSION["admin_id"]);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <?php if($u->is_admin):?>
<?php if(isset($_GET["producto"]) && $_GET["producto"]!=""):?>
  <?php
$products = ProductoData::getLike($_GET["producto"]);
if(count($products)>0){
  ?>
<h3>Resultados de la Busqueda</h3>
<table class="table table-bordered table-hover">
  <thead>
    <th>Codigo</th>
    <th>Nombre</th>
    <!-- <th></th> -->
    <th>Precio unitario</th>
    <th>En inventario</th>
    <th>Cantidad</th>
  </thead>
  <?php
$sin_cantidad=0;
   foreach($products as $product):
$q= OperationData::getQYesFf($product->id_producto);
  ?>
<?php 
  if($q>0):?>
  <tr class="<?php if($q<=$product->minimo_inventario){ echo "danger"; }?>">
    <td style="width:80px;"><?php echo $product->id_producto; ?></td>
    <td><?php echo $product->nombre; ?></td>
    <!-- <td><?php echo $product->cantidad; ?></td> -->
    <td><b> <?php echo number_format($product->precio_venta,4,'.','.'); ?></b></td>
    <td>
      <?php echo $q; ?>
    </td>
    <td style="width:250px;"><form method="post" action="index.php?action=agregarcantidad2">
    <input type="hidden" name="producto_id" value="<?php echo $product->id_producto; ?>">
    <!-- <input type="text" name="stock" value="<?=$q; ?>"> -->

<div class="input-group">
    <input type="number" class="form-control" required name="q" placeholder="Cantidad ..." min="1">
	 <input type="hidden" name="precio" value="<?php echo round(($product->precio_venta),4); ?>">
      <span class="input-group-btn">
    <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
      </span>
    </div>

    </form></td>
  </tr>
  <?php else:$sin_cantidad++;
?>
<?php  endif; ?>
  <?php endforeach;?>
</table>
<?php if($sin_cantidad>0){ echo "<p class='alert alert-warning'>Se omitieron <b>productos</b> que no tienen existencias en el inventario. <a href='index.php?module=inventary'>Ir al Inventario</a></p>"; }?>

  <?php
}else{
  echo "<br><p class='alert alert-danger'>No se encontró el producto</p>";
}
?>
<hr><br>
<?php else:
?>
<?php endif; ?>
<?php endif ?>


  <?php if($u->is_empleado):?>
    <?php
    $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
  ?>
<?php if(isset($_GET["producto"]) && $_GET["producto"]!=""):?>
  <?php
$products = ProductoData::getLike($_GET["producto"]);
$proceso1 = OperationData1::getLike($_GET["producto"]);
// ->$sucursales->id_sucursal
if(count($products)>0){
  ?>
<h3>Resultados de la Búsqueda</h3>
<table class="table table-bordered table-hover">
  <thead>
    <th>Código</th>
    <th>Nombre</th>
    <!-- <th></th> -->
    <!-- <th>Precio unitario</th> -->
    <th>En existencia</th>
    <th>Cantidad</th>
  </thead>
  <?php
   foreach($products as $product):
    // $sucursal = $product->verSocursal($product->sucursal_id);
    $q= OperationData::getQYesFf($product->id_producto);
  ?>
  <tr class="<?php if($q<=$product->minimo_inventario){ echo "danger"; }?>">
    <?php if ($product->sucursal_id==$sucursales->id_sucursal): ?>
      <td style="width:80px;"><?php echo $product->codigo; ?></td>
    <td><?php echo $product->nombre; ?></td>
    <!-- <td><?php echo $product->cantidad; ?></td> -->
    <!-- <td><b><?php echo number_format($product->precio_venta,4,'.','.'); ?></b></td> -->
    <td>
    <?php if ($product->tipoproducto()->TIPO_PRODUCTO=="Producto") {
      echo $q;
    } else { echo "0"; } ?>  
    </td>
    <td style="width:300px;"><form method="post" action="index.php?action=agregarcantidad2">
    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
    <input type="hidden" name="stock" value="<?= $q; ?>">
    <input type="hidden" name="tipoproducto" value="<?php echo $product->tipoproducto()->TIPO_PRODUCTO; ?>">
    <input type="hidden" name="producto_id" value="<?php echo $product->id_producto; ?>">
	<input type="hidden" name="precios" value="<?php echo round(($product->precio_compra),4); ?>">
    <div class="input-group">
      <select name="precio" required="requered">
        <?php $extraerdata  = ProductoData::listar_precio_productos($product->id_producto);
        if (count($extraerdata)>0) {
          foreach ($extraerdata as $data) { ?>
              <option value="<?php echo $data->IMPORTE; ?>"><?php echo $data->IMPORTE; ?> <?php $datito = ProductoData::vertipomonedadescrip2($sucursales->id_sucursal, $data->PRECIO_ID);
              if (count($datito)>0) {
                 foreach ($datito as $dati) {
                   echo "".$dati->NOMBRE_PRECIO;
                 }
               } ?></option>
          <?php }
        }?>
      </select>
      <input type="hidden" name="cli" value="0">
      <input type="number" class="form-control" required name="q" placeholder="Cantidad ..." min="1">
        <span class="input-group-btn">
      <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
        </span>
    </div>
    </form></td>
    <?php endif ?>
  </tr>
  <?php endforeach;?>
</table>
  <?php
}else{
  echo "<br><p class='alert alert-danger'>No se encontró el producto</p>";
}
?>
<br>
<?php else:
?>
<?php endif; ?>
<?php endif ?>
<?php endif ?>