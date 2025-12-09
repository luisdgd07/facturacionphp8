<?php
$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
      Lista de Remisiones
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
              $users = VentaData::versucursaltipoventasremi4($sucursales->id_sucursal);
              $sucursal = new SuccursalData();

              $products = VentaData::versucursaltipoventastot($sucursales->id_sucursal);
              $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
              if (count($users) > 0) {
              ?>
                <table id="example1" class="table table-bordered table-dark" style="width:100%">
                  <thead>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Nro.</th>
                    <th width="120px">N° Remision</th>

                    <th width="120px">Cliente</th>
                    <th>Total</th>
                    <th>Fecha de Venta</th>
                    <td>Cajas</td>
                    <td>Estado</td>
                    <td>Sifen</td>

                    <td>Kude</td>
                    <td>Kude</td>
                    <td>Editar</td>

                  </thead>
                  <tbody>
                    <?php
                    $u = UserData::getById($_SESSION["admin_id"]);
                    foreach ($users as $sell) {
                    ?>
                      <tr>
                        <?php
                        $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                        count($operations);

                        ?>

                        <td style="width:30px;">
                          <abbr title="ver detalles">
                            <a href="index.php?view=detalleventaproductoremision&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a></abbr>
                        </td>

                        <td style="width:30px;">
                          <abbr title="Anular registro sin actualización de stock">
                            <button onclick="anular2(<?php echo $sucursales->id_sucursal; ?>,<?php echo $sell->id_venta; ?>)" class="btn btn-warning btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
                          <!-- <a href="index.php?action=eliminarcompra&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </a> -->
                        </td>


                        <td style="width:30px;">
                          <abbr title="Anular registro con actualización de stock">
                            <button onclick="anular(<?php echo $sucursales->id_sucursal; ?>,<?php echo $sell->id_venta; ?>)" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </a></abbr>
                          <!-- <a href="index.php?action=actualizar_estado_venta&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-warning btn-sm btn-flat"><i class='fa fa-trash'></i> </a> -->
                        </td>



                        <td><?php echo $sell->id_venta; ?></td>
                        <td class="width:30px;">
                          <?php if ($sell->tipo_venta == "4") : ?> <?php echo $sell->factura; ?>
                          <?php else : ?>
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
                          }                                                ?>


                        </td>

                        <td><?php
                            $total = $sell->total - $sell->descuento;
                            echo "<b> " . number_format($total, 2, ',', '.') . "</b>";
                            ?></td>
                        <!-- <td><?php echo $sell->metodopago ?></td> -->
                        <td><?php echo $sell->fecha; ?></td>
                        <td><?php
                            $data = OperationData::getAllProductsBySellIddd($sell->id_venta);
                            // var_dump($data)
                            $count = 0;
                            foreach ($data as $d) {
                              $count += $d->q;
                            }
                            echo $count;
                            ?></td>




                        <td>


                          <?php
                          if ($sell->estado == 2) {
                            echo '<p class="bg-danger text-white text-center">Anulado</p>';
                          } else if ($sell->estado == 1) {
                            echo
                            '<p class="bg-success text-white text-center">Pendiente a facturar</p>';
                          } else if ($sell->estado == 0) {
                            echo
                            '<p class="bg-success text-white text-center">enviado a facturar</p>';
                          } else if ($sell->estado == 7) {
                            echo
                            '<p class="bg-success text-white text-center">Remision sin factura</p>';
                          }

                          ?>

                        </td>
                        <td>

                          <?php if ($sell->enviado == "Rechazado") {
                            echo '<p class="bg-danger text-white text-center">Rechazado</p>';
                          } else if ($sell->enviado == "Aprobado") {
                            echo
                            '<p class="bg-success text-white text-center">Aprobado</p>';
                          } else if ($sell->enviado == "Cancelado") {
                            echo
                            '<p class="bg-danger text-white text-center">Cancelado</p>';
                          } else {

                            echo "No enviado";
                          } ?>
                        </td>
                        <td>

                          <?php if ($sell->enviado == "Cancelado" || $sell->enviado == "Aprobado" || $sell->enviado == "Rechazado") {
                            $venta = VentaData::getById($sell->id_venta);
                            $telefonoEmisor =  $venta->verSocursal()->telefono;
                            $rucEmisor = $venta->verSocursal()->ruc;
                            $direccionCliente = $venta->getCliente()->direccion;
                            $telefono = $venta->getCliente()->telefono;
                            if ($venta->getCliente()->tipo_doc == "SIN NOMBRE") {
                              $venta->getCliente()->tipo_doc;
                              $cliente = $venta->getCliente()->tipo_doc;
                            } else {
                              $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                              $cliente = $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                            }
                            if ($venta->VerTipoModena()->simbolo == "₲") {
                              $moneda = 'PYG';
                            } else {
                              $moneda = 'USD';
                            }
                            $productosItem  = array();
                            // var_dump($operations);
                            $tipo = ProductoData::verinsumo($operations[0]->sucursal_id);
                            $insumo = $tipo->ID_TIPO_PROD;
                            foreach ($operations as $operation) {
                              $product  = $operation->getProducto();
                              if ($product->ID_TIPO_PROD == $insumo) {
                              } else {
                                $tipo = TipoProductoData::VerId($operation->getProducto()->ID_TIPO_PROD);
                                // var_dump($operation);

                                // if ($operation->q == 0) {
                                //     $cant = $operation->precio3;
                                // } else {
                                //     $cant = $operation->q;
                                // };
                                $precio =  floatval($operation->precio);
                                $cant = $operation->q;

                                $array = [
                                  "precioUnitario" => $precio,
                                  "codigo" => $product->codigo,
                                  "descripcion" => $product->nombre,
                                  "observacion" => "",
                                  "tipo" => $tipo->TIPO_PRODUCTO,
                                  "unidadMedida" =>  UnidadesData::getById($product->presentacion)->nombre,
                                  "cantidad" => $cant,
                                  "cambio" => "0",
                                  "ivaTipo" => 1,
                                  "ivaBase" => "100",
                                  "iva" => $product->impuesto,
                                  "lote" => "",
                                  "vencimiento" => "",
                                  "numeroSerie" => "",
                                  "numeroPedido" => ""
                                ];
                                $array2 = json_encode($array);
                                array_push($productosItem, $array2);
                              }
                            }
                            $pro = $productosItem;
                            $factura = substr($sell->factura, 8);
                            $fechaventa = date("Y-m-d-h-i", strtotime($venta->fecha));
                            $tipo = $sell->metodopago;
                            if ($sell->VerTipoModena()->simbolo == "US$") {
                              $cambio = $venta->cambio2;
                            } else {
                              $cambio = 1;
                            }
                            $client = $sell->getCliente();
                            $dptClient = $client->departamento_id;
                            $ciudadCliente = $client->ciudad;
                            $distClient = $client->distrito_id;
                            $vehiculo = VehiculoData::getId($venta->id_vehiculo);
                            $chofer = ChoferData::getId($venta->id_chofer);
                            $rucCLiente = $client->dni;
                            $placas = new PlacaData();
                            $p = $placas->obtener($sell->id_venta);
                            // $p = [];
                          ?>
                            <?php if ($venta->email_enviado) {
                              echo 'Enviado';
                            } ?>
                            <?php

                            ?><?php
                              if ($sucursalDatos->tipo_recibo == 0) { ?>
                            <button class="btn btn-primary" onclick='kude(<?php echo json_encode($productosItem) ?>,"<?php echo $venta->cdc ?>","<?php echo $venta->factura ?>","<?php echo $venta->fecha_envio ?>","<?php echo $venta->metodopago ?>","<?php echo $rucCLiente  ?>",<?php echo $cambio;  ?>,"<?php echo $cliente ?>","<?php echo $moneda; ?>","<?php echo $direccionCliente; ?>","<?php echo $telefono; ?>",<?php echo $venta->iva10; ?>,<?php echo $venta->iva5; ?>,0,"<?php echo $client->email; ?>","<?php echo $venta->tipo_remision; ?>","<?php echo $u->nombre . " " . $u->apellido ?>","<?php echo $vehiculo->marca ?>","<?php echo $vehiculo->chapa_nro ?>","<?php echo $chofer->nombre ?>","<?php echo $chofer->direccion ?>","<?php echo $chofer->cedula ?>",<?php echo $venta->id_venta ?>,<?php echo json_encode($p) ?>,<?php echo $venta->tipo_remision ?>)'>Enviar</button>


                          <?php }
                              if ($sucursalDatos->tipo_recibo == 1) { ?>
                            <button class="btn btn-primary" onclick='kude(<?php echo json_encode($productosItem) ?>,"<?php echo $venta->cdc ?>","<?php echo $venta->factura ?>","<?php echo $venta->fecha_envio ?>","<?php echo $venta->metodopago ?>","<?php echo $rucCLiente  ?>",<?php echo $cambio;  ?>,"<?php echo $cliente ?>","<?php echo $moneda; ?>","<?php echo $direccionCliente; ?>","<?php echo $telefono; ?>",<?php echo $venta->iva10; ?>,<?php echo $venta->iva5; ?>,1,"<?php echo $client->email; ?>","<?php echo $venta->tipo_remision; ?>","<?php echo $u->nombre . " " . $u->apellido ?>","<?php echo $vehiculo->marca ?>","<?php echo $vehiculo->chapa_nro ?>","<?php echo $chofer->nombre ?>","<?php echo $chofer->direccion ?>","<?php echo $chofer->cedula ?>",<?php echo $venta->id_venta ?>,<?php echo json_encode($p) ?>,<?php echo $venta->tipo_remision ?>)'>Enviar</button>
                          <?php } ?>

                        <?php
                          } else if ($sell->enviado == "Cancelado") {
                            echo '<p class="bg-danger text-white text-center">Cancelado</p>';
                          } else {

                            echo "No enviado";
                          } ?>

                        </td>
                        <td>
                          <?php

                          ?>
                          <?php if ($sell->enviado == "Rechazado") { ?>


                          <?php } else if ($sell->enviado == "Aprobado" || $sell->enviado == "Cancelado") {
                            $venta = VentaData::getById($sell->id_venta);
                            $telefonoEmisor =  $venta->verSocursal()->telefono;
                            $rucEmisor = $venta->verSocursal()->ruc;
                            $direccionCliente = $venta->getCliente()->direccion;
                            $telefono = $venta->getCliente()->telefono;
                            if ($venta->getCliente()->tipo_doc == "SIN NOMBRE") {
                              $venta->getCliente()->tipo_doc;
                              $cliente = $venta->getCliente()->tipo_doc;
                            } else {
                              $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                              $cliente = $venta->getCliente()->nombre . " " . $venta->getCliente()->apellido;
                            }
                            if ($venta->VerTipoModena()->simbolo == "₲") {
                              $moneda = 'PYG';
                            } else {
                              $moneda = 'USD';
                            }
                            $productosItem  = array();
                            // var_dump($operations);
                            $tipo = ProductoData::verinsumo($operations[0]->sucursal_id);
                            $insumo = $tipo->ID_TIPO_PROD;
                            foreach ($operations as $operation) {
                              $product  = $operation->getProducto();
                              if ($product->ID_TIPO_PROD == $insumo) {
                              } else {
                                $tipo = TipoProductoData::VerId($operation->getProducto()->ID_TIPO_PROD);
                                // var_dump($operation);

                                // if ($operation->q == 0) {
                                //     $cant = $operation->precio3;
                                // } else {
                                //     $cant = $operation->q;
                                // };
                                $precio =  floatval($operation->precio);
                                $cant = $operation->q;

                                $array = [
                                  "precioUnitario" => $precio,
                                  "codigo" => $product->codigo,
                                  "descripcion" => $product->nombre,
                                  "observacion" => "",
                                  "tipo" => $tipo->TIPO_PRODUCTO,
                                  "unidadMedida" => UnidadesData::getById($product->presentacion)->nombre,
                                  "cantidad" => $cant,
                                  "cambio" => "0",
                                  "ivaTipo" => 1,
                                  "ivaBase" => "100",
                                  "iva" => $product->impuesto,
                                  "lote" => "",
                                  "vencimiento" => "",
                                  "numeroSerie" => "",
                                  "numeroPedido" => ""
                                ];
                                $array2 = json_encode($array);
                                array_push($productosItem, $array2);
                              }
                            }
                            $pro = $productosItem;
                            $factura = substr($sell->factura, 8);
                            $fechaventa = date("Y-m-d-h-i", strtotime($venta->fecha));
                            $tipo = $sell->metodopago;
                            if ($sell->VerTipoModena()->simbolo == "US$") {
                              $cambio = $venta->cambio2;
                            } else {
                              $cambio = 1;
                            }
                            $client = $sell->getCliente();
                            $dptClient = $client->departamento_id;
                            $ciudadCliente = $client->ciudad;
                            $distClient = $client->distrito_id;

                            $placas = new PlacaData();
                            $p = $placas->obtener($sell->id_venta);
                            // $p = [];
                            $rucCLiente = $client->dni;
                          ?>

                            <!-- ./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?> -->
                            <!-- <a class="btn btn-primary" href="http://18.208.224.72:3000/downloadkude/<?php echo $sell->kude; ?>">Descargar Kude</a> -->
                            <!-- <a class="btn btn-primary" href="./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar Kude</a> -->
                            <?php
                            ?>

                            <?php if ($sucursalDatos->tipo_recibo == 0) { ?>
                              <!-- <a class="btn btn-primary" href="./impresionkude2.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar Kude</a> -->
                              <button class="btn btn-success" onclick='kudedescargar(<?php echo json_encode($productosItem) ?>,"<?php echo $venta->cdc ?>","<?php echo $venta->factura ?>","<?php echo $venta->fecha_envio ?>","<?php echo $venta->metodopago ?>","<?php echo $rucCLiente  ?>",<?php echo $cambio;  ?>,"<?php echo $cliente ?>","<?php echo $moneda; ?>","<?php echo $direccionCliente; ?>","<?php echo $telefono; ?>",<?php echo $venta->iva10; ?>,<?php echo $venta->iva5; ?>,0,"<?php echo $client->email; ?>","<?php echo $venta->tipo_remision; ?>","<?php if ($sucursalDatos->id_sucursal == 19) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $u = UserData::getById($venta->usuario_id);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $u->nombre . " " . $u->apellido;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $u->nombre . " " . $u->apellido;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          } ?>","<?php echo $vehiculo->marca ?>","<?php echo $vehiculo->chapa_nro ?>","<?php echo $chofer->nombre ?>","<?php echo $chofer->direccion ?>","<?php echo $chofer->cedula ?>",<?php echo json_encode($p) ?>,<?php echo $venta->tipo_remision ?>,<?php echo $venta->tipo_transporte ?>,"<?php echo $venta->destino ?>")'>Descargar</button>


                              <!-- <button onclick='kude(<?php echo json_encode($productosItem) ?>,"<?php echo $venta->cdc ?>")'>Enviar</button> -->
                            <?php }
                            if ($sucursalDatos->tipo_recibo == 1) { ?>
                              <!-- <a class="btn btn-primary" href="./impresionkude.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar Kude</a> -->
                              <button class="btn btn-success" onclick='kudedescargar(<?php echo json_encode($productosItem) ?>,"<?php echo $venta->cdc ?>","<?php echo $venta->factura ?>","<?php echo $venta->fecha_envio ?>","<?php echo $venta->metodopago ?>","<?php echo $rucCLiente  ?>",<?php echo $cambio;  ?>,"<?php echo $cliente ?>","<?php echo $moneda; ?>","<?php echo $direccionCliente; ?>","<?php echo $telefono; ?>",<?php echo $venta->iva10; ?>,<?php echo $venta->iva5; ?>,1,"<?php echo $client->email; ?>","<?php echo $venta->tipo_remision; ?>","<?php if ($sucursalDatos->id_sucursal == 19) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $u = UserData::getById($venta->usuario_id);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $u->nombre . " " . $u->apellido;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo $u->nombre . " " . $u->apellido;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          } ?>","<?php echo $vehiculo->marca ?>","<?php echo $vehiculo->chapa_nro ?>","<?php echo $chofer->nombre ?>","<?php echo $chofer->direccion ?>","<?php echo $chofer->cedula ?>",<?php echo json_encode($p) ?>,<?php echo $venta->tipo_remision ?>,<?php echo $venta->tipo_transporte ?>,"<?php echo $venta->destino ?>")'>Descargar</button>
                              <!-- kude(items, cdc, factura, fecha, condicion, rucCliente, cambio, cliente, moneda, direccion, telefono, cel) -->
                            <?php } ?>

                          <?php
                          } else if ($sell->enviado == "Cancelado") {
                            echo '<p class="bg-danger text-white text-center">Cancelado</p>';
                          } else {

                            echo "No enviado";
                          } ?>

                        </td>
                        <td>
                          <a href="index.php?view=editarplacas&id_sucursal=<?php echo $_GET['id_sucursal'] ?>&id=<?php echo $sell->id_venta ?>" class="btn btn-warning">Editar</a>
                        </td>

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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function kude(items, cdc, factura, fecha, condicion, rucCliente, cambio, cliente, moneda, direccion, telefono, iva10, iva5, tipo, email, tiporemi, usuario, marca, chapa, chofer, dircho, cicho, id, placas, motivo) {
    console.log(items)
    Swal.fire({
      title: 'Enviando correo',
      icon: 'info',
    })
    let itemsVenta = JSON.stringify(items);
    let placas2 = JSON.stringify(placas);
    let logo = 'logo.png';
    if (<?php echo $sucursalDatos->id_sucursal == 19 ?>) {
      logo = 'logo3.png';
      tipo = 3;
    }
    $.ajax({
      url: "http://18.208.224.72:3100/enviarcorreo",
      // url: "<?php echo $GLOBALS['URLKUDE'] ?>/enviarcorreo",
      type: "POST",
      data: {
        cdc: cdc,
        sucursal: '<?php echo $sucursalDatos->razon_social ?>',
        timbrado: '<?php echo $sucursalDatos->timbrado ?>',
        actividad: `<?php echo $sucursalDatos->actividad ?>`,
        telefonoSucursal: '<?php echo $sucursalDatos->telefono ?>',
        direccion: '<?php echo $sucursalDatos->direccion ?>',
        distrito: '<?php echo $sucursalDatos->distrito_descripcion ?>',
        rucSuc: '<?php echo $sucursalDatos->ruc ?>',
        tipoFactura: 'Remisión',
        factura: factura,
        fechaEmision: fecha,
        condicion: condicion,
        rucCliente: rucCliente,
        cambio: cambio,
        razonCliente: cliente,
        moneda: moneda,
        dirCliente: direccion,
        operacion: 'Remisión Electrónica',
        telCliente: telefono,
        docAsociado: '',
        cel: '',
        iva10,
        iva5,
        logo,
        host: '<?php echo $sucursalDatos->host ?>',
        port: <?php echo $sucursalDatos->port ?>,
        secure: false,
        timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>',
        user: '<?php echo $sucursalDatos->email ?>',
        pass: '<?php echo $sucursalDatos->pass ?>',
        from: '<?php echo $sucursalDatos->email ?>',
        to: email,
        cdcAsociado: '',
        tipo,
        vipoVenta: 2,
        itemsVenta,
        motivo: motivo,
        respon: usuario,
        inicio: fecha,
        fin: fecha,
        puntodir: "<?php echo $sucursalDatos->direccion ?>",
        puntociu: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
        puntodep: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
        casasalida: '',
        casaentrega: '',
        kms: '0',
        tipotrans: 'Propio',
        flete: '<?php echo $sucursalDatos->razon_social ?>',
        iniciotras: fecha,
        fintras: fecha,
        marca: marca,
        ident: '',
        chapa: chapa,
        transpor: '',
        transpor2: '<?php echo $sucursalDatos->razon_social ?>',
        idtrans: '',
        chofer: chofer,
        razonchofer: chofer,
        rucchofer: cicho,
        dirchofer: dircho,
        correo: email,
        placas: placas2
      },

      success: function(dataResult) {

        try {
          console.log(dataResult)

          if (dataResult.success) {
            Swal.fire({
              title: 'Kude enviado',
              text: `El correo se envio correctamente a ${email}`,
              icon: 'success',
              confirmButtonColor: '#00c853',
              showDenyButton: true,
              confirmButtonText: 'Descargar Kude'
            }).then((result) => {
              $.ajax({
                url: 'index.php?action=enviocorreo&id=' + id,
                type: 'POST',
                cache: false,
                dataType: 'json',
                success: function(json) {


                },
                error: function(xhr, status) {
                  console.log("Ha ocurrido un error.");
                }
              });
              window.open(`http://18.208.224.72:3100/kude/${dataResult.file}`)
              // window.location.href = `http://18.208.224.72:3100/kude/${dataResult.file}`
              // if (result.isConfirmed) {
              //     $.ajax({
              //         url: `<?php echo $GLOBALS['URLKUDE'] ?>/kude/${dataResult.file}`,
              //         type: 'GET',
              //         cache: false,
              //         dataType: 'json',
              //         success: function(json) {


              //         },
              //         error: function(xhr, status) {
              //             console.log("Ha ocurrido un error.");
              //         }
              //     });
              // }
            })
          } else {
            console.log("error")
            Swal.fire({
              title: 'Error al enviar correo',
              icon: 'error',
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: `http://18.208.224.72:3100/kude/${dataResult.file}`,
                  type: 'GET',
                  cache: false,
                  dataType: 'json',
                  success: function(json) {


                  },
                  error: function(xhr, status) {
                    console.log("Ha ocurrido un error.");
                  }
                });
              }
            })
          }


        } catch (e) {
          Swal.fire({
            title: 'Error al recibir datos del lote',
            text: `El lote ${$("#lote").val()} esta en procesamiento, espere en 30 segundos automaticamente se volvera a realizar la consulta`,
            icon: 'error',
            confirmButtonColor: '#ff0000',
            confirmButtonText: 'Recargar pagina'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload()
            }
          })
          setTimeout(function() {
            consultaLote(lote);
          }, 30000);
        }

      },

    });
  }


  function kudedescargar(items, cdc, factura, fecha, condicion, rucCliente, cambio, cliente, moneda, direccion, telefono, iva10, iva5, tipo, email, tiporemi, usuario, marca, chapa, chofer, dircho, cicho, placas, motivo, tipo_transporte, puntoLlegada) {
    console.log(tiporemi)
    Swal.fire({
      title: 'Generando kude',
      icon: 'info',
    })
    let itemsVenta = JSON.stringify(items);
    let placas2 = {}
    if (placas) {
      placas2 = JSON.stringify(placas);
    }
    tipo = 0;
    let logo = 'logo.png';
    if (<?php echo $sucursalDatos->id_sucursal == 19 ? 'true' :  'false'; ?>) {
      logo = 'logo3.png';
      tipo = 3;
    }
    if (<?php echo $sucursalDatos->id_sucursal == 18 ? 'true' :  'false'; ?>) {
      tipo = 1
    }
    $.ajax({
      // url: "http://localhost:3100/generarkude",
      url: "http://18.208.224.72:3100/generarkude",
      type: "POST",
      data: {
        cdc: cdc,
        sucursal: '<?php echo $sucursalDatos->razon_social ?>',
        timbrado: '<?php echo $sucursalDatos->timbrado ?>',
        actividad: `<?php echo $sucursalDatos->actividad ?>`,
        telefonoSucursal: '<?php echo $sucursalDatos->telefono ?>',
        direccion: '<?php echo $sucursalDatos->direccion ?>',
        distrito: '<?php echo $sucursalDatos->distrito_descripcion ?>',
        rucSuc: '<?php echo $sucursalDatos->ruc ?>',
        tipoFactura: 'Remisión',
        factura: factura,
        fechaEmision: fecha,
        condicion: condicion,
        rucCliente: rucCliente,
        cambio: cambio,
        razonCliente: cliente,
        moneda: moneda,
        dirCliente: direccion,
        operacion: 'Remisión Electrónica',
        telCliente: telefono,
        docAsociado: '',
        cel: '',
        iva10,
        iva5,
        logo,
        host: '<?php echo $sucursalDatos->host ?>',
        port: <?php echo $sucursalDatos->port ?>,
        secure: false,
        timbradoVi: '<?php echo $sucursalDatos->fecha_tim ?>',
        user: '<?php echo $sucursalDatos->email ?>',
        pass: '<?php echo $sucursalDatos->pass ?>',
        from: '<?php echo $sucursalDatos->email ?>',
        to: email,
        cdcAsociado: '',
        tipo,
        vipoVenta: 2,
        itemsVenta,
        motivo: motivo,
        respon: usuario,
        inicio: fecha,
        fin: fecha,
        puntodir: "<?php echo $sucursalDatos->direccion ?>",
        puntociu: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
        puntodep: "<?php echo $sucursalDatos->ciudad_descripcion ?>",
        casasalida: '',
        casaentrega: '',
        kms: '0',
        tipotrans: 'Propio',
        flete: '<?php echo $sucursalDatos->razon_social ?>',
        iniciotras: fecha,
        fintras: fecha,
        marca: marca,
        ident: '',
        chapa: chapa,
        transpor: '',
        transpor2: '<?php echo $sucursalDatos->razon_social ?>',
        idtrans: '',
        chofer: chofer,
        razonchofer: chofer,
        rucchofer: cicho,
        correo: email,
        dirchofer: dircho,
        tipo_transporte,
        <?php if ($sucursalDatos->id_sucursal == 19) {
        ?>
          puntoLlegada,
        <?php
        } ?>
        placas: placas2

      },

      success: function(dataResult) {
        try {
          console.log(dataResult)

          if (dataResult.success) {
            window.open(`http://18.208.224.72:3100/kude/${dataResult.file}`)

          } else {
            Swal.fire({
              title: 'Error al generar kude',
              text: `El lote ${$("#lote").val()} esta en procesamiento, espere en 30 segundos automaticamente se volvera a realizar la consulta`,
              icon: 'error',
              confirmButtonColor: '#ff0000',
              confirmButtonText: 'Recargar pagina'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload()
              }
            })

          }
        } catch (e) {
          Swal.fire({
            title: 'Error al generar kude',
            text: ``,
            icon: 'error',
            confirmButtonColor: '#ff0000',
            confirmButtonText: 'Recargar pagina'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.reload()
            }
          })

        }

      },

    });
  }




  function anular(sucursal, venta) {
    Swal.fire({
      title: 'Desea anular este registro',
      showDenyButton: true,
      confirmButtonText: 'Anular',
      denyButtonText: `Cerrar`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = `./index.php?action=actualizar_estado_venta3&id_sucursal=${sucursal}&id_venta=${venta}`;
      } else {}
    })

  }


  function anular2(sucursal, venta) {
    Swal.fire({
      title: 'Desea anular este registro',
      showDenyButton: true,
      confirmButtonText: 'Anular',
      denyButtonText: `Cerrar`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        window.location.href = `./index.php?action=actualizar_estado_venta4&id_sucursal=${sucursal}&id_venta=${venta}`;
      } else {}
    })

  }
</script>