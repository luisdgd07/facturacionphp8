    <?php
    $u = null;
    if (isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != "") :
        $u = UserData::getById($_SESSION["admin_id"]);
    ?>
        <!-- Content Wrapper. Contains page content -->
        <?php if ($u->is_admin) : ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                        VENTAS REALIZADAS
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <?php
                                    $products = VentaData::getVentas();

                                    if (count($products) > 0) {

                                    ?>
                                        <br>
                                        <table class="table table-bordered table-hover  ">
                                            <thead>
                                                <th></th>
                                                <th>Productos</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                                <!-- <th></th> -->
                                            </thead>
                                            <?php foreach ($products as $sell) : ?>

                                                <tr>
                                                    <td style="width:30px;">
                                                        <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a>
                                                    </td>

                                                    <td>

                                                        <?php
                                                        $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                                                        echo count($operations);
                                                        ?>
                                                    <td>

                                                        <?php
                                                        $total = $sell->total - $sell->descuento;
                                                        echo "<b> " . number_format($total, 0, '.', '.') . "</b>";

                                                        ?>

                                                    </td>
                                                    <td><?php echo $sell->fecha; ?></td>
                                                </tr>

                                            <?php endforeach; ?>

                                        </table>

                                        <div class="clearfix"></div>

                                    <?php
                                    } else {
                                    ?>
                                        <div class="jumbotron">
                                            <h2>No hay ventas</h2>
                                            <p>No se ha realizado ninguna venta.</p>
                                        </div>
                                    <?php
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php endif ?>
        <?php if ($u->is_empleado) : ?>
            <?php
            $sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
            ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><i class='glyphicon glyphicon-shopping-cart' style="color: orange;"></i>
                        REGISTRO DE VENTAS
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <?php
                                    $sucursal = new SuccursalData();
                                    require 'core/modules/index/components/kudes.php';
                                    $products = VentaData::versucursaltipoventastot($sucursales->id_sucursal);
                                    $sucursalDatos = $sucursal->VerId($_GET['id_sucursal']);
                                    if (count($products) > 0) {

                                    ?>
                                        <br>
                                        <table id="example1" class="table table-bordered table-hover  ">

                                            <thead>

                                                <th></th>
                                                <th></th>
                                                <th></th>

                                                <th></th>
                                                <th></th>
                                                <th>Nro.</th>
                                                <th width="120px">N° Factura</th>
                                                <th width="120px">Cliente</th>

                                                <th>Total</th>
                                                <th width="120px">Metodo Pago</th>
                                                <th>Fecha </th>



                                                <th width="120px">N° Remision</th>

                                                <th width="120px">Cambio</th>

                                                <th width="120px">Tipo Moneda</th>
                                                <th>Sifen</th>
                                                <th>Correo</th>

                                                <th>Kude</th>
                                                <th>Modelo 2</th>
                                                <th width="120px">Estado</td>
                                            </thead>
                                            <?php foreach ($products as $sell) : ?>
                                                <tr>
                                                    <?php
                                                    $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                                                    count($operations);
                                                    ?>

                                                    <td style="width:30px;">
                                                        <abbr title="ver detalles">
                                                            <a href="index.php?view=detalleventaproducto&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open" style="color: orange;"></i></a></abbr>
                                                    </td>

                                                    <td>

                                                        <abbr title="Enviar a Nota de credito">
                                                            <a class="btn btn-primary" href="index.php?view=nota_credito&id_sucursal=<?php echo $_GET["id_sucursal"] ?>&id=<?php echo $sell->id_venta; ?>"><i class="glyphicon glyphicon-plus-sign"></i></a></abbr>


                                                    </td>


                                                    <td style="width:30px;">
                                                        <abbr title="Anular registro de venta">
                                                            <button onclick="anular2(<?php echo $sucursales->id_sucursal; ?>,<?php echo $sell->id_venta; ?>)" class="btn btn-warning btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>

                                                        <!-- <a href="index.php?action=eliminarcompra&id_sucursal=<?php echo $sucursales->id_sucursal; ?>&id_venta=<?php echo $sell->id_venta; ?>" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </a> -->
                                                    </td>
                                                    <td>
                                                        <abbr title="Anular registro de venta con resta de stock">
                                                            <button onclick="anular(<?php echo $sucursales->id_sucursal; ?>,<?php echo $sell->id_venta; ?>)" class="btn btn-danger btn-sm btn-flat"><i class='fa fa-trash'></i> </button></abbr>
                                                    </td>


                                                    <td>
                                                        <abbr title="Editar">
                                                            <a class="btn  btn-sm btn-flat" href="index.php?view=editarpagoventa&id_sucursal=<?php echo $_GET["id_sucursal"] ?>&id_venta=<?php echo $sell->id_venta; ?>"><i class='fa fa-pencil'></i> </a></abbr>
                                                    </td>




                                                    <td style="width:30px;">
                                                        <?php echo $sell->id_venta; ?>
                                                    </td>

                                                    <td class="width:30px;">
                                                        <?php if ($sell->tipo_venta == "1"  or $sell->tipo_venta == "0"  or $sell->tipo_venta == "5") : ?>

                                                            <?php echo $sell->factura; ?>
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



                                                    <td>
                                                        <?php
                                                        $total = $sell->total - $sell->descuento;
                                                        echo "<b> " . number_format($total, 2, ',', '.') . "</b>";
                                                        ?>
                                                    </td>
                                                    <td><?php echo $sell->metodopago ?></td>


                                                    <td><?php echo $sell->fecha; ?></td>



                                                    <td>



                                                        <?php if ($sell->numero_factura  == NULL) : ?>

                                                            <?php echo 'SIN RELACION'; ?>
                                                        <?php else : ?>
                                                            <?php echo $sell->numero_factura; ?>
                                                        <?php endif ?>



                                                    </td>

                                                    <!-- <td><?php echo $sell->formapago ?></td> -->

                                                    <td class="">
                                                        <?php if ($sell->VerTipoModena()->simbolo == "US$") {
                                                            echo  $sell->cambio2;
                                                        } else {
                                                            echo  1;
                                                        } ?>

                                                    </td>



                                                    <td><?php echo $sell->VerTipoModena()->nombre; ?></td>
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
                                                        <?php if ($sell->enviado == "Aprobado" || $sell->enviado == "Rechazado" || $sell->enviado == "Cancelado") {
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
                                                            $cuotas = 0;
                                                            $vencimiento = "";
                                                            if ($sell->metodopago == "Credito") {
                                                                $credito = CreditoData::getByVentaId($sell->id_venta);
                                                                $cuotas = $credito->cuotas;
                                                                $vencimiento = $credito->vencimiento;
                                                            }

                                                            $rucCLiente = $client->dni;
                                                        ?>
                                                            <?php if ($venta->email_enviado) {
                                                                echo 'Enviado';
                                                            } ?>

                                                            <?php if ($venta->tipo_venta == 5) {
                                                                $remi = VentaData::getId($sell->REMISION_ID);
                                                            ?>

                                                                <button class="btn btn-primary" onclick='genKude(<?php echo json_encode($productosItem) ?>,
                                                                    {
                                                                        cdc:"<?php echo $venta->cdc ?>",
                                                                        factura:"<?php echo $venta->factura ?>",
                                                                        fechaEmision:"<?php echo $venta->fecha_envio ?>",
                                                                        condicion:"<?php echo $venta->metodopago ?>",
                                                                        rucCliente:"<?php echo $rucCLiente  ?>",
                                                                        cambio:<?php echo $cambio;  ?>,
                                                                        razonCliente:"<?php echo $cliente ?>",
                                                                        moneda:"<?php echo $moneda; ?>",
                                                                        dirCliente:"<?php echo $direccionCliente; ?>",
                                                                        telCliente:"<?php echo $telefono; ?>",
                                                                        iva10:<?php echo $venta->iva10; ?>,
                                                                        iva5:<?php echo $venta->iva5; ?>,
                                                                        email:"<?php echo $client->email; ?>",
                                                                        vipoVenta: 1,
                                                                        cdcAsociado:"<?php echo $venta->cdc_fact; ?>",
                                                                        venta:"<?php echo $remi->factura; ?>",
                                                                        tipoFactura: "Factura",
                                                                        operacion: "Factura Electrónica",
                                                                        docAsociado: "Venta de mercaderia",
                                                                        kudeQr:"<?php echo $venta->kude; ?>",
                                                                        cel: "",
                                                                        envioCorreo:true
                                                                    })'>Enviar</button>

                                                            <?php
                                                            } else { ?>
                                                                <button class="btn btn-primary" onclick='genKude(<?php echo json_encode($productosItem) ?>,
                                                                    {
                                                                        cdc:"<?php echo $venta->cdc ?>",
                                                                        factura:"<?php echo $venta->factura ?>",
                                                                        fechaEmision:"<?php echo $venta->fecha_envio ?>",
                                                                        condicion:"<?php echo $venta->metodopago ?>",
                                                                        rucCliente:"<?php echo $rucCLiente  ?>",
                                                                        cambio:<?php echo $cambio;  ?>,
                                                                        razonCliente:"<?php echo $cliente ?>",
                                                                        moneda:"<?php echo $moneda; ?>",
                                                                        dirCliente:"<?php echo $direccionCliente; ?>",
                                                                        telCliente:"<?php echo $telefono; ?>",
                                                                        iva10:<?php echo $venta->iva10; ?>,
                                                                        iva5:<?php echo $venta->iva5; ?>,
                                                                        email:"<?php echo $client->email; ?>",
                                                                        vipoVenta: 1,
                                                                        tipoFactura: "Factura",
                                                                        operacion: "Factura Electrónica",
                                                                        docAsociado: "",
                                                                        cel: "",
                                                                        cdcAsociado: "",
                                                                        kudeQr:"<?php echo $venta->kude; ?>",
                                                                        envioCorreo:true
                                                                    })'>Enviar</button>


                                                            <?php } ?>

                                                        <?php } else {

                                                            echo "No enviado";
                                                        } ?>

                                                    </td>


                                                    <td>


                                                        <?php
                                                        var_dump($venta->tipo_venta);
                                                        if ($sell->enviado == "Aprobado" || $sell->enviado == "Rechazado" || $sell->enviado == "Cancelado") {
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
                                                            $tipo = ProductoData::verinsumo($operations[0]->sucursal_id);
                                                            $insumo = $tipo->ID_TIPO_PROD;
                                                            foreach ($operations as $operation) {
                                                                $product  = $operation->getProducto();
                                                                if ($product->ID_TIPO_PROD == $insumo) {
                                                                } else {
                                                                    $tipo = TipoProductoData::VerId($operation->getProducto()->ID_TIPO_PROD);

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
                                                            $cuotas = 0;
                                                            $vencimiento = "";
                                                            if ($sell->metodopago == "Credito") {
                                                                $credito = CreditoData::getByVentaId($sell->id_venta);
                                                                $cuotas = $credito->cuotas;
                                                                $vencimiento = $credito->vencimiento;
                                                            }

                                                            $rucCLiente = $client->dni;
                                                        ?>
                                                            <?php if ($venta->tipo_venta == 5) {
                                                                $remi = VentaData::getId($sell->REMISION_ID);
                                                            ?>

                                                                <button class="btn btn-success" onclick='genKude(<?php echo json_encode($productosItem) ?>,
                                                                    {
                                                                        cdc:"<?php echo $venta->cdc ?>",
                                                                        factura:"<?php echo $venta->factura ?>",
                                                                        fechaEmision:"<?php echo $venta->fecha_envio ?>",
                                                                        condicion:"<?php echo $venta->metodopago ?>",
                                                                        rucCliente:"<?php echo $rucCLiente  ?>",
                                                                        cambio:<?php echo $cambio;  ?>,
                                                                        razonCliente:"<?php echo $cliente ?>",
                                                                        moneda:"<?php echo $moneda; ?>",
                                                                        dirCliente:"<?php echo $direccionCliente; ?>",
                                                                        telCliente:"<?php echo $telefono; ?>",
                                                                        iva10:<?php echo $venta->iva10; ?>,
                                                                        iva5:<?php echo $venta->iva5; ?>,
                                                                        email:"<?php echo $client->email; ?>",
                                                                        vipoVenta: 1,
                                                                        cdcAsociado:"<?php echo $venta->cdc_fact; ?>",
                                                                        venta:"<?php echo $remi->factura; ?>",
                                                                        tipoFactura: "Factura",
                                                                        operacion: "Factura Electrónica",
                                                                        kudeQr:"<?php echo $venta->kude; ?>",
                                                                        docAsociado: "Venta de mercaderia",
                                                                        cel: "",
                                                                    })'>Descargar</button>

                                                            <?php
                                                            } else { ?>
                                                                <button class="btn btn-success" onclick='genKude(<?php echo json_encode($productosItem) ?>,
                                                                    {
                                                                        cdc:"<?php echo $venta->cdc ?>",
                                                                        factura:"<?php echo $venta->factura ?>",
                                                                        fechaEmision:"<?php echo $venta->fecha_envio ?>",
                                                                        condicion:"<?php echo $venta->metodopago ?>",
                                                                        rucCliente:"<?php echo $rucCLiente  ?>",
                                                                        cambio:<?php echo $cambio;  ?>,
                                                                        razonCliente:"<?php echo $cliente ?>",
                                                                        moneda:"<?php echo $moneda; ?>",
                                                                        dirCliente:"<?php echo $direccionCliente; ?>",
                                                                        telCliente:"<?php echo $telefono; ?>",
                                                                        iva10:<?php echo $venta->iva10; ?>,
                                                                        iva5:<?php echo $venta->iva5; ?>,
                                                                        email:"<?php echo $client->email; ?>",
                                                                        vipoVenta: 1,
                                                                        tipoFactura: "Factura",
                                                                        operacion: "Factura Electrónica",
                                                                        docAsociado: "",
                                                                        kudeQr:"<?php echo $venta->kude; ?>",
                                                                        cel: "",
                                                                        cdcAsociado: "",
                                                                    })'>Descargar</button>


                                                            <?php } ?>



                                                        <?php
                                                        } else {

                                                            echo "No enviado";
                                                        } ?>

                                                    </td>
                                                    <td>
                                                        <?php if ($_GET['id_sucursal'] == 20) { ?>
                                                            <a class="btn btn-primary" target="_blank" href="./impresion2.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar</a>
                                                        <?php
                                                        } else if ($_GET['id_sucursal'] == 21) { ?>
                                                            <a class="btn btn-primary" target="_blank" href="./impresion2_2.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar</a>
                                                        <?php
                                                        } else { ?>
                                                            <a class="btn btn-primary" target="_blank" href="./impresion.php?id_venta=<?php echo $sell->id_venta; ?>">Descargar</a>
                                                        <?php
                                                        } ?>

                                                    </td>
                                                    <td>

                                                        <?php if ($sell->estado == 2) {
                                                            echo '<p class="bg-danger text-white text-center">Anulado</p>';
                                                        } else if ($sell->estado == 1) {
                                                            echo
                                                            '<p class="bg-success text-white text-center">Activo</p>';
                                                        } ?>
                                                    </td>


                                                    <!-- <td style="width:30px;"><a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td> -->
                                                </tr>

                                            <?php endforeach; ?>

                                        </table>

                                        <div class="clearfix"></div>

                                    <?php
                                    } else {
                                    ?>
                                        <div class="jumbotron">
                                            <h2>No hay ventas</h2>
                                            <p>No se ha realizado ninguna venta.</p>
                                        </div>
                                    <?php
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php endif ?>
    <?php endif ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function eliminar(sucursal, venta) {
            Swal.fire({
                title: 'Desea eliminar esta venta?',
                showDenyButton: true,
                confirmButtonText: 'Eliminar',
                denyButtonText: `Cerrar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = `./index.php?action=eliminarcompra&id_sucursal=${sucursal}&id_venta=${venta}`;

                } else {}
            })
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
                    window.location.href = `./index.php?action=actualizar_estado_venta&id_sucursal=${sucursal}&id_venta=${venta}`;
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
                    window.location.href = `./index.php?action=actualizar_estado_venta2&id_sucursal=${sucursal}&id_venta=${venta}`;
                } else {}
            })

        }
    </script>