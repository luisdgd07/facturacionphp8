<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
      Lista de Cobros realizados
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
              $users = CobroCabecera::totalcobros3($sucursales->id_sucursal);

              //if(count($users)>0){
              

              ?>
              <table id="example1" class="table table-bordered table-dark" style="width:100%">
                <thead>
                  <th></th>
                  <th>Nro.</th>
                  <th width="120px">Recibo</th>

                  <th width="120px">Cliente</th>

                  <th>Total cobro</th>
                  <th>RETENCION</th>

                  <th>Cambio</th>

                  <th>Fecha de Cobro</th>

                  <th>Concepto</th>

                  <th>Estado</th>
                  <th>Anular</th>
                </thead>
                <tbody>
                  <?php
                  foreach ($users as $sell) {
                    if ($sell) {
                      ?>
                      <tr>
                        <?php
                        // $operations = CobroDetalleData::totalcobrosdet($sell->COBRO_ID );
                        //count($operations);
                    
                        ?>

                        <td style="width:30px;">
                          <a href="index.php?view=detallecobros&COBRO_ID=<?php echo $sell->COBRO_ID; ?>"
                            class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"
                              style="color: orange;"></i></a>
                        </td>
                        <td><?php
                        echo $sell->COBRO_ID;

                        ?>

                        </td>
                        <td class="width:30px;">

                          <?php echo $sell->RECIBO; ?>

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
                        echo number_format($sell->TOTAL_COBRO, 0, '.', '.')
                          ?></td>
                        <td>

                          <?php
                          $operations = CobroDetalleData::cobranza_credito($sell->COBRO_ID);
                          $cred = $operations[0]->IMPORTE_CREDITO;
                          $totalRetencion = 0;
                          // var_dump($operations);
                          $cred = $operations[0]->NUMERO_CREDITO;
                          $cuota = $operations[0]->CUOTA;
                          foreach ($operations as $op) {
                            $facturas = RetencionDetalleData::retencionfactura($sell->RECIBO);
                            // var_dump($facturas);
                            foreach ($facturas as $fact) {
                              $totalRetencion += (float) $fact->importe;
                            }
                            // $totalret += $totalRetencion;
                          }

                          echo number_format($totalRetencion, 0, '.', '.');
                          ?>
                        </td>

                        <?php $concepto = CajaDetalle::cajadetllecambio($sell->COBRO_ID); ?>
                        <?php

                        foreach ($concepto as $cambios) {
                          if ($cambios) {


                            $camnbio = $cambios->CAMBIO;
                          }
                        }

                        ?>


                        <td><?php echo number_format($camnbio, 0, '.', '.'); ?></td>






                        <?php $concepto = CajaCabecera::cajacabeceraconcepto($sell->COBRO_ID); ?>
                        <?php

                        foreach ($concepto as $cobrosdet) {
                          if ($cobrosdet) {


                            $conceptos = $cobrosdet->concepto;


                            $fechacobro = $cobrosdet->FECHA;
                          }
                        }

                        ?>





                        <td><?php echo $fechacobro; ?></td>




                        <td><?php echo $conceptos; ?></td>
                        <td><?php
                        if ($sell->anulado == 1) {
                          echo '<p class="bg-danger text-white text-center">Anulado</p>';
                        } else {
                          echo '<p class="bg-success text-white text-center">Activo</p>';
                        } ?></td>
                        <td style="width:30px;">
                          <abbr title="Anular registro de cobro">
                            <button
                              onclick="anular2(<?php echo $sell->COBRO_ID; ?>,<?php echo $cuota; ?>,<?php echo $cred; ?>)"
                              class="btn btn-warning btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
                          <!-- <a href="index.php?action=eliminarcompra&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </a> -->
                        </td>



                      </tr>
                      <?php
                    }
                  }
                  // }else{
                  // echo "<p class='alert alert-danger'>No hay cobro realizado</p>";
                  //}
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
  function anular2(venta, cuota, cred) {
    Swal.fire({
      title: 'Desea anular este registro',
      showDenyButton: true,
      confirmButtonText: 'Anular',
      denyButtonText: `Cerrar`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = `./index.php?action=anular_cobro&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&id=${venta}&cuota=${cuota}&cred=${cred}`;
      } else { }
    })

  }
</script>