<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
            DETALLE FACTURA VENTA A CREDITO
            <!-- <marquee> Lista de Medicamentos</marquee> -->
        </h1>
    </section>
    <!-- Main content -->
    <?php
    $sell = VentaData::getById($_GET["id_venta"]);
    $ventas = CreditoDetalleData::getById($_GET["id"]);
    ?>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <?php if ($sell->numerocorraltivo == "") : ?>
                        <?php else : ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="color: blue;">Factura:</th>
                                    <th><?php if ($sell->numerocorraltivo >= 1 & $sell->numerocorraltivo < 10) : ?>
                                            <?php echo "000000" . $sell->numerocorraltivo; ?>
                                        <?php else : ?>
                                            <?php if ($sell->numerocorraltivo >= 10 & $sell->numerocorraltivo < 100) : ?>
                                                <?php echo "00000" . $sell->numerocorraltivo; ?>
                                            <?php else : ?>
                                                <?php if ($sell->numerocorraltivo >= 100 & $sell->numerocorraltivo < 1000) : ?>
                                                    <?php echo "0000" . $sell->numerocorraltivo; ?>
                                                <?php else : ?>
                                                    <?php if ($sell->numerocorraltivo >= 1000 & $sell->numerocorraltivo < 10000) : ?>
                                                        <?php echo "000" . $sell->numerocorraltivo; ?>
                                                    <?php else : ?>
                                                        <?php if ($sell->numerocorraltivo >= 10000 & $sell->numerocorraltivo < 100000) : ?>
                                                            <?php echo "00" . $sell->numerocorraltivo; ?>
                                                        <?php else : ?>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endif ?></th>
                                    <th style="color: blue;">Inicio Timbrado:</th>

                                    <th><?php echo  date('d-m-Y', strtotime($sell->VerConfiFactura()->inicio_timbrado)); ?></th>

                                    <th style="color: blue;">Fin. Timbrado:</th>
                                    <th><?php echo  date('d-m-Y', strtotime($sell->VerConfiFactura()->fin_timbrado)); ?></th>



                                    <th style="color: blue;">Tipo de Comprobante:</th>
                                    <th><?php echo $sell->VerConfiFactura()->comprobante1; ?></th>
                                </tr>
                            </table>
                        <?php endif ?>
                        <br>
                        <table class="table table-bordered">

                            <?php

                            if ($sell->cliente_id != "") :
                                $client = $sell->getCliente();
                            ?>
                                <tr>
                                    <td style="width:150px; text-transform:uppercase;" class="alert alert-warning"><b>Cliente</b></td>




                                    <?php if ($client->tipo_doc == "SIN NOMBRE") {
                                        echo  $client->tipo_doc;
                                    } else {
                                        echo  $client->nombre . " " . $client->apellido;
                                    } ?>

                                    <?php


                                    ?>



                                </tr>

                            <?php endif; ?>
                            <?php if ($sell->usuario_id != "") :
                                $user = $sell->getUser();
                            ?>
                                <tr>
                                    <td class="alert alert-warning"><b>Atendido por</b></td>
                                    <td class="alert alert-warning"><?php echo $user->nombre . " " . $user->apellido; ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>

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
                            $productosItem  = array();
                            $operations = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
                            foreach ($operations as $operation) {
                                $product  = $operation->getProducto();
                                // array_push($productosItem, json_encode(array("codigo" => $product->codigo, "cantidad" => $operation->q, "descripcion" => $product->nombre, "observacion" => "", "precioUnitario" => $operation->precio, "iva" =>  $product->impuesto)));
                                // array_push($productosItem, [array("codigo" => 'aaa')]);
                                // var_dump(array("Oso" => true, "Gato" => null));
                            ?>
                                <tr>
                                    <td><?php echo $product->codigo; ?></td>
                                    <td><?php echo $operation->q; ?></td>
                                    <td><?php echo $product->nombre; ?></td>





                                    <td><?php echo number_format(($operation->precio * $operation->q), 2, ",", "."); ?></td>



                                    <td><?php echo number_format(($operation->precio * $operation->q), 2, ",", "."); ?></td>
                                    </b></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                        <br><br>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">

                                    <tr>
                                        <td>
                                            <h4>Subtotal: </h4>
                                        </td>
                                        <td>
                                            <h4><?php echo number_format($sell->total, 2, ",", "."); ?></h4>
                                        </td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h4><b>Total:</b></h4>
                                        </td>

                                        <?php

                                        ?>

                                        <td>
                                            <h4><b><?php $total = $sell->total; ?></b></h4>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <h1 class="text-center">Cuotas</h1>
                            <div class="col-md-6">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th>Cuota</th>
                                        <th>Pagado</th>
                                        <th>Fecha de vencimiento</th>
                                        <th>Acción</th>
                                    </thead>
                                    <?php
                                    $abono = 0;
                                    foreach ($ventas as $venta) {
                                        // array_push($productosItem, json_encode(array("codigo" => $product->codigo, "cantidad" => $operation->q, "descripcion" => $product->nombre, "observacion" => "", "precioUnitario" => $operation->precio, "iva" =>  $product->impuesto)));
                                        // array_push($productosItem, [array("codigo" => 'aaa')]);
                                        // var_dump(array("Oso" => true, "Gato" => null));
                                    ?>
                                        <tr>
                                            <td><?php echo $venta->cuota; ?></td>
                                            <td><?php echo $venta->importe_credito;
                                                $abono += $venta->importe_credito; ?></td>
                                            <td><?php echo $venta->fecha_detalle; ?></td>
                                            <?php if ($venta->importe_credito == 0) { ?>
                                                <td>
                                                    <form method="post" action="index.php?action=agregarabono">
                                                        <input type="text" name="id_venta" hidden value="<?php echo $_GET["id_venta"]; ?>">
                                                        <input type="text" name="id" hidden value="<?php echo $venta->id; ?>">
                                                        <input type="number" name="monto" max="<?php echo $sell->total - $abono ?>" value="<?php echo ($sell->total / $_GET['cuotas']); ?>"> <button class="btn btn'success">Pendiente</button>
                                                    </form>
                                                </td>
                                            <?php } else { ?>
                                                <td>Couta pagada</td>
                                            <?php } ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>