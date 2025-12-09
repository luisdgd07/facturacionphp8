  <?php
  $u = null;
  if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
    $u = UserData::getById($_SESSION["admin_id"]);
  ?>

    <?php if ($u->is_empleado) : ?>
      <?php
      $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
      ?>
      <?php if (isset($_GET["producto"]) && $_GET["producto"] != "") : ?>
        <?php
        $products = ProductoData::getLike($_GET["producto"]);



        // ->$sucursales->id_sucursal
        if (count($products) > 0) {
        ?>
          <h3>Resultados: </h3>
          <table class="table table-bordered table-hover">
            <thead>
              <th>Codigo</th>
              <th>Nombre</th>
              <!-- <th></th> -->
              <th>Depósito</th>
              <th>Precio venta</th>
              <th>En inventario</th>
              <th>Cantidad</th>
            </thead>
            <?php
            $sin_cantidad = 0;

            $q = 0;

            $id_dep = 0;

            $de = "";
            foreach ($products as $product) :


              $cant  = StockData::vercontenidos($product->id_producto);
              foreach ($cant as $can) {
                $q = $can->CANTIDAD_STOCK;
                $id_dep = $can->DEPOSITO_ID;
              }

              $deposit  = StockData::verdeposito($id_dep);
              foreach ($deposit as $dep) {
                $de = $dep->NOMBRE_DEPOSITO;
              }

            ?>

              <tr class="<?php if ($q <= $product->minimo_inventario) {
                            echo "danger";
                          } ?>">
                <?php if ($product->sucursal_id == $sucursales->id_sucursal) : ?>
                  <td style="width:80px;"><?php echo $product->codigo; ?></td>
                  <td><?php echo $product->nombre; ?></td>
                  <td><?php echo $de; ?></td>
                  <td><b><?php echo $product->precio_venta; ?></b></td>
                  <td>
                    <?php echo $q; ?>
                  </td>
                  <td style="width:250px;">
                    <form method="post" action="index.php?action=agregarcantidadtransaccion">
                      <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $sucursales->id_sucursal; ?>">
                      <input type="hidden" name="producto_id" value="<?php echo $product->id_producto; ?>">
                      <input type="hidden" name="deposito_id" value="<?php echo $$de; ?>">

                      <div class="input-group">
                        <input type="number" class="form-control" required name="q" placeholder="Cantidad ..." min="1">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
                        </span>
                      </div>

                    </form>
                  </td>

              </tr>

            <?php endif; ?>
          <?php endforeach; ?>
          </table>
        <?php
        } else {
          echo "<br><p class='alert alert-danger'>No se encontro el producto</p>";
        }
        ?>
        <hr><br>
      <?php else :
      ?>
      <?php endif; ?>
    <?php endif ?>
  <?php endif ?>