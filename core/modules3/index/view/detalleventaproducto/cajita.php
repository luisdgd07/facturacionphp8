<!-- Content Wrapper. Contains page content -->

<body id="cuerpoPagina">
  <div class="zona_impresion">
    <?php
    $total = 0;
    $moneda = 'PYG';
    $ventas = VentaData::getById($_GET["id_venta"]);
    $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
    if ($ventas->VerTipoModena()->simbolo == "₲") {
      $moneda = 'PYG';
    } else {
      $moneda = 'USD';
    }
    ?>
    <?= $rucEmisor = $ventas->verSocursal()->ruc ?>
    <?= $telefonoEmisor =  $ventas->verSocursal()->telefono ?>
    <?= $ventas->VerConfiFactura()->timbrado1 ?>

    <?php if ($ventas->numerocorraltivo >= 1 & $ventas->numerocorraltivo < 10) : ?>
      <?= $facturaN =    "000000" . $ventas->numerocorraltivo ?>
    <?php else : ?>
      <?php if ($ventas->numerocorraltivo >= 10 & $ventas->numerocorraltivo < 100) : ?>
        <?= $facturaN = "00000" . $ventas->numerocorraltivo ?>
      <?php else : ?>
        <?php if ($ventas->numerocorraltivo >= 100 & $ventas->numerocorraltivo < 1000) : ?>
          <?= $facturaN =  "0000" . $ventas->numerocorraltivo ?>
        <?php else : ?>
          <?php if ($ventas->numerocorraltivo >= 1000 & $ventas->numerocorraltivo < 10000) : ?>
            <?= $facturaN = "000" . $ventas->numerocorraltivo ?>
          <?php else : ?>
            <?php if ($ventas->numerocorraltivo >= 100000 & $ventas->numerocorraltivo < 1000000) : ?>
              <?= $facturaN = "00" . $ventas->numerocorraltivo ?>
            <?php else : ?>
              <?php if ($ventas->numerocorraltivo >= 1000000 & $ventas->numerocorraltivo < 10000000) : ?>
                <?= $facturaN = "0" . $ventas->numerocorraltivo ?>
              <?php else : ?>
                SIN ACCION
              <?php endif ?>
            <?php endif ?>
          <?php endif ?>
        <?php endif ?>
      <?php endif ?>
    <?php endif ?>
    <?php if ($ventas->getCliente()->tipo_doc == "SIN NOMBRE") {
      $ventas->getCliente()->tipo_doc;
      $cliente = $ventas->getCliente()->tipo_doc;
    } else {
      $ventas->getCliente()->nombre . " " . $ventas->getCliente()->apellido;
      $cliente = $ventas->getCliente()->nombre . " " . $ventas->getCliente()->apellido;
    } ?>

    <?= $rucCliente = $ventas->getCliente()->dni ?>


    <?= $direccionCliente = $ventas->getCliente()->direccion ?>


    <?= $vendedor = $ventas->getUser()->nombre . " " . $ventas->getUser()->apellido ?>

  </div>

</body>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

    <form class="form-horizontal" role="form" method="post" hidden name="facturacion" action="index.php?action=agregarenvio" enctype="multipart/form-data">
      <input type="text" name="venta" id="venta" value="<?php echo $_GET['id_venta'] ?>">
      <input type="text" name="estado" id="estado" value="">
      <input type="text" name="cdc" id="cdc" value="">
      <input type="text" name="xml" id="xml" value="">
      <button type="submit">envio</button>
    </form>
    <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
      DETALLE FACTURA VENTA
      <!-- <marquee> Lista de Medicamentos</marquee> -->
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <input type="hidden" name="xml_string" id="xml_string">
            <input type="hidden" name="certandkey" id="certandkey">
            <?php if (isset($_GET["id_venta"]) && $_GET["id_venta"] != "") : ?>
              <?php

              $sell = VentaData::getById($_GET["id_venta"]);
              $operations = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
              $total = 0;
              ?>
              <?php
              if (isset($_COOKIE["selled"])) {
                foreach ($operations as $operation) {
                  //    print_r($operation);
                  $qx = OperationData::getQYesFf($operation->producto_id);
                  // print "qx=$qx";
                  $p = $operation->getProducto();
                  if ($qx == 0) {
                    echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->nombre</b> tiene existencia 0 realice compras para abastecer su stock.</p>";
                  } else if ($qx <= $p->inventario_minimo / 2) {
                    echo "<p class='alert alert-danger'>Atención el producto <b style='text-transform:uppercase;'> $p->nombre</b> ya tiene menos a su stock Minimo de abastecerlo</p>";
                  } else if ($qx <= $p->inventario_minimo) {
                    echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->nombre</b>ha llegado a su stock Minimo debe abastecerlo.</p>";
                  }
                }
                setcookie("selled", "", time() - 18600);
              }

              ?>
              <?php if ($sell->numerocorraltivo == "") : ?>
              <?php else : ?>
                <table class="table table-bordered">
                  <tr>
                    <th style="color: blue;">Factura N°:</th>

                    <th><?php echo $sell->factura; ?></th>
                    <th style="color: blue;">Tipo Venta:</th>

                    <th><?php echo $sell->metodopago; ?></th>






                    <th style="color: blue;">Tipo de Comprobante:</th>
                    <th><?php echo $sell->VerConfiFactura()->comprobante1; ?></th>


                    <th style="color: blue;">Fecha venta:</th>
                    <th><?php echo $sell->fecha; ?></th>


                    <th style="color: blue;">Moneda:</th>

                    <th><?php echo $sell->VerTipoModena()->nombre; ?></th>


                  </tr>
                </table>
              <?php endif ?>
              <br>
              <table class="table table-bordered">
                <?php if ($sell->cliente_id != "") :
                  $client = $sell->getCliente();
                ?>

                  <td class="alert alert-warning"><b>CLIENTE:</b></td>


                  <td class="alert alert-warning">

                    <?php
                    $dptClient = $client->departamento_id;
                    $distClient = $client->distrito_id;
                    if ($client->tipo_doc == "SIN NOMBRE") {
                      echo  $client->tipo_doc;
                    } else {
                      echo  $client->nombre . " " . $client->apellido;
                    } ?>

                    <?php


                    ?>
                  </td>

                <?php endif; ?>
                <?php if ($sell->usuario_id != "") :
                  $user = $sell->getUser();
                ?>

                  <td class="alert alert-warning"><b>USUARIO:</b></td>
                  <td class="alert alert-warning"><?php echo $user->nombre . " " . $user->apellido; ?></td>

                <?php endif; ?>
              </table>
              <br>
              <table class="table table-bordered table-hover">
                <thead>
                  <th>Codigo</th>
                  <th>Cantidad</th>
                  <th>Nombre del Producto</th>
                  <th>Precio Unitario</th>
                  <th>Total</th>

                </thead>
                <?php
                $precio = 0;
                $total3 = 0;
                $total4 = 0;
                $cant = 0;
                $productosItem  = array();
                $tipo = ProductoData::verinsumo($operations[0]->sucursal_id);
                $insumo = $tipo->ID_TIPO_PROD;
                foreach ($operations as $operation) {
                  $product  = $operation->getProducto();
                  if ($product->ID_TIPO_PROD == $insumo) {
                  } else {

                    if ($operation->q == 0) {
                      $cant = $operation->precio3;
                    } else {
                      $cant = $operation->q;
                    };

                    array_push($productosItem, json_encode(array(
                      "codigo" => $product->codigo,
                      "descripcion" => $product->nombre,
                      "observacion" => "",
                      "unidadMedida" => UnidadesData::getById($product->presentacion)->nombre,
                      "cantidad" => $cant,
                      "precioUnitario" => $operation->precio,
                      "cambio" => "0",
                      "ivaTipo" => 1,
                      "ivaBase" => "100",
                      "iva" => $product->impuesto,
                      "lote" => "",
                      "vencimiento" => "",
                      "numeroSerie" => "",
                      "numeroPedido" => ""
                    )));

                    // array_push($productosItem, json_encode(array("codigo" => $product->codigo, "cantidad" => $operation->q, "descripcion" => $product->nombre, "observacion" => "", "precioUnitario" => $operation->precio, "iva" =>  $product->impuesto)));
                    // array_push($productosItem, [array("codigo" => 'aaa')]);
                    // var_dump(array("Oso" => true, "Gato" => null));
                ?>
                    <tr>
                      <td><?php echo $product->codigo; ?></td>
                      <td><?php echo $cant; ?></td>
                      <td><?php echo $product->nombre; ?></td>





                      <td><?php echo number_format(($operation->precio), 2, ",", "."); ?></td>



                      <td><?php echo number_format(($operation->precio * $cant), 2, ",", "."); ?></td>
                      </b></td>
                    </tr>
                <?php
                  }
                }
                ?>
              </table>
              <br><br>
              <div class="row">
                <div class="col-md-4">
                  <table class="table table-bordered">

                    <tr>
                      <td>
                        <h4>SUBTOTAL: </h4>
                      </td>
                      <td>
                        <h4><?php echo number_format($sell->total, 2, ",", "."); ?></h4>





                      </td>

                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h4>TOTAL: </h4>
                      </td>
                      <td>
                        <h4><?php echo number_format($sell->total, 2, ",", ".");

                            $cuotas = 0;
                            $vencimiento = "";
                            if ($sell->metodopago == "Credito") {
                              $credito = CreditoData::getByVentaId($_GET['id_venta']);
                              $cuotas = $credito->cuotas;
                              $vencimiento = $credito->vencimiento;
                            }
                            ?></h4>
                      </td>

                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="box">
                <div class="box-body">
                  <div class="box box-danger">
                  </div>
                  <div class="row">
                    <div class="col-sm">
                      <a target="_BLANK" href="impresionticket.php?id_venta=<?php echo $_GET["id_venta"] ?>" class="btn btn-primary btn-sm btn-flat"><i class='fa fa-file-code-o' style="color: orange"></i> IMPRIMIR</a>
                    </div>
                    <br>
                    <?php if ($sell->enviado === 'Aprobado') {
                      echo '<span style="padding:10px" class=" bg bg-success">Aprobado por SIFEN </span>';
                      echo '<span style="padding:0px 30px"> CDC: ' . $sell->cdc . '</span>';
                    } else { ?>
                      <div class="col-sm">
                        <!-- <button onclick="enviar()" class="btn btn-primary btn-sm btn-flat" id="boton_firma" name="boton_firma"><i class='fa fa-file-code-o' style="color: orange"></i> ENVIAR A SIFEN</button> -->
                      </div>
                    <?php } ?>
                    <div>

                    </div>
                    <!-- <div class="col-sm">
                      <a target="_BLANK" class="btn btn-primary btn-sm btn-flat" id="boton_prueba" name="boton_prueba"><i class='fa fa-file-code-o' style="color: orange"></i> Generar XML</a>
                    </div> -->



                  </div>
                </div>

              </div>
            <?php else : ?>
              501 Internal Error
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function enviar() {
    console.log("envio");
    Swal.fire({
      title: 'Enviando',
      icon: 'info',
    })
    var cambio = '<?php echo $ventas->cambio2 ?>'
    console.log(cambio);
    var tipo = '<?php echo $sell->metodopago ?>';
    //  if (tipo == 'CONTADO')
    var telEmisor = '<?php echo $telefonoEmisor ?>';
    var factura = '<?php echo substr($sell->factura, 8); ?>';
    var rucEmisor = '<?php echo $rucEmisor ?>';
    var cliente = '<?php echo $cliente ?>';
    var dirCliente = '<?php echo $direccionCliente ?>';
    var telCliente = '<?php echo $ventas->getCliente()->telefono ?>';
    var rucCliente = '<?= $ventas->getCliente()->dni ?>';
    var fechaVenta = '<?php echo date("Y-m-d-h-i", strtotime($ventas->fecha)) ?>'
    var items = JSON.stringify(<?php echo json_encode($productosItem) ?>);
    var departamentoCliente = '<?= $dptClient ?>';
    var distritoCliente = '<?= $distClient ?>';
    console.log(items);
    var total = '<?= $total ?>';
    var moneda = '<?= $moneda ?>';
    var cuotas = '<?= $cuotas ?>';
    var vencimiento = '<?= $vencimiento ?>';
    $.ajax({
      url: "http://18.208.224.72:3000/enviar",
      // url: "http://18.208.224.72:3000/consultaruc",
      // url: "<?php echo $GLOBALS['URL'] ?>/enviar",
      type: "POST",
      data: {
        telEmisor: telEmisor,
        rucEmisor: rucEmisor,
        rucCliente: rucCliente,
        cliente: cliente,
        dirCliente: dirCliente,
        telCliente: telCliente,
        factura: factura,
        total: total,
        moneda: moneda,
        fechaVenta: fechaVenta,
        items: items,
        tipo: tipo,
        cambio: cambio,
        departamentoCliente: departamentoCliente,
        distritoCliente: distritoCliente,
        cuotas: cuotas,
        vencimiento: vencimiento,
        env: 'test',
        cert: './3997053.pfx',
        pass: 'Die1905982022',
        logo: "./METASA_logo.png"
      },
      success: function(dataResult) {
        console.log('enviando')
        try {
          let data = dataResult;
          console.log(data['file']);
          document.getElementById('xml').value = data['file'];
          document.getElementById('estado').value = data['response']['ns2:rRetEnviDe']['ns2:rProtDe']['ns2:dEstRes'];
          document.getElementById('cdc').value = data['response']['ns2:rRetEnviDe']['ns2:rProtDe']['ns2:Id'];
          Swal.fire({
            title: data['response']['ns2:rRetEnviDe']['ns2:rProtDe']['ns2:dEstRes'],
            text: 'Respuesta: ' + data['response']['ns2:rRetEnviDe']['ns2:rProtDe']['ns2:gResProc']['ns2:dMsgRes'],
            icon: 'info',
            confirmButtonText: 'Aceptar'
          });
          setTimeout(function() {
            document.facturacion.submit();

          }, 5000);
        } catch (e) {
          Swal.fire({
            title: "Error",
            icon: 'danger',
            confirmButtonText: 'Aceptar'
          });
        }

      },

    });

    // $.ajax({
    //   // url: "http://18.208.224.72:3000/enviar",
    //   url: "<?php echo $GLOBALS['URL'] ?>/consultaruc",
    //   type: "POST",
    //   data: {
    //     ruc: rucEmisor,
    //   },
    //   success: function(dataResult) {
    //     console.log('enviando')
    //     console.log(dataResult)

    //   },

    // });




  }
</script>