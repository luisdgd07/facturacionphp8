<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
      Lista de Remisiones pendientes a facturar
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="table-responsive">
              <?php
              $users = VentaData::versucursaltipoventasremi($sucursales->id_sucursal);
              if (count($users) > 0) {
                ?>
                <table id="example1" class="table table-bordered table-dark" style="width:100%">
                  <thead>
                    <th></th>
                    <th></th>
                    <th>Nro.</th>
                    <th width="120px">N° Remision</th>

                    <th width="120px">Cliente</th>
                    <th>Total</th>

                    <th width="120px">Metodo Pago</th>
                    <th>Fecha</th>
                    <th>Cambio</th>
                    <td>Tipo Moneda</td>
                    <th>Facturar</th>


                  </thead>
                  <tbody>
                    <?php
                    foreach ($users as $sell) {
                      ?>
                      <tr>
                        <?php
                        $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                        count($operations);

                        ?>

                        <td style="width:30px;">
                          <a href="index.php?view=detalleventaproductoremision&id_venta=<?php echo $sell->id_venta; ?>"
                            class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"
                              style="color: orange;"></i></a>
                        </td>

                        <td style="width:30px;">
                          <abbr title="Cancelar facturacion de Remision">
                            <button
                              onclick="anular2(<?php echo $sucursales->id_sucursal; ?>,<?php echo $sell->id_venta; ?>)"
                              class="btn btn-warning btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
                          <!-- <a href="index.php?action=eliminarcompra&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </a> -->
                        </td>



                        <td><?php echo $sell->id_venta; ?></td>
                        <td class="width:30px;">
                          <?php if ($sell->tipo_venta == "4"): ?>       <?php echo $sell->factura; ?>
                          <?php else: ?>
                            <?php echo count($operations) ?>
                          <?php endif ?>
                        </td>

                        <td class="width:30px;">


                          <?php if ($sell->getCliente()->tipo_doc == "SIN NOMBRE") {
                            $sell->getCliente()->tipo_doc;
                            $cliente = $sell->getCliente()->tipo_doc;
                            echo $cliente;
                          } else {
                            $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;
                            $cliente = $sell->getCliente()->nombre . " " . $sell->getCliente()->apellido;

                            echo $cliente;
                          } ?>


                        </td>

                        <td><?php
                        $total = $sell->total - $sell->descuento;
                        echo "<b> " . number_format($total, 2, ',', '.') . "</b>";
                        ?></td>
                        <td><?php echo $sell->metodopago ?></td>
                        <td><?php echo $sell->fecha; ?></td>
                        <td><?php if ($sell->tipomoneda_id == "") {
                          echo "--";
                        } else {
                          if ($sell->VerTipoModena()->simbolo == "US$") {
                            echo $sell->cambio2;
                          } else {
                            echo 1;
                          }
                        } ?></td>
                        <td style="width:200px;">
                          <?php if ($sell->tipomoneda_id == "") {
                            echo "--";
                          } else {
                            echo $sell->VerTipoModena()->nombre;
                          } ?>
                        </td>
                        <td><a
                            href="index.php?view=vender&id_sucursal=<?php echo $_GET["id_sucursal"]; ?>&tid=<?= $sell->id_venta; ?>"
                            class="btn btn-xs btn-default"><i class="fa fa-share" style="color: orange;"></i></a></td>
                      </tr>
                      <?php
                    }
              } else {
                echo "<p class='alert alert-danger'>No hay remision Registrada</p>";
              }
              ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
  function anular2(sucursal, venta) {
    Swal.fire({
      title: 'Desea cancelar facturacion de remision',
      showDenyButton: true,
      confirmButtonText: 'No Facturar',
      denyButtonText: `Cerrar`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = `./index.php?action=actualizar_estado_venta5&id_sucursal=${sucursal}&id_venta=${venta}`;
      } else { }
    })

  }
</script>