<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" type="text/css" href="ticket.css">
    <script>
        function printPantalla() {
            document.getElementById('cuerpoPagina').style.marginRight = "0";
            document.getElementById('cuerpoPagina').style.marginTop = "1";
            document.getElementById('cuerpoPagina').style.marginLeft = "1";
            document.getElementById('cuerpoPagina').style.marginBottom = "0";
            document.getElementById('botonPrint').style.display = "none";
            window.print();
        }
    </script>
    <style>
        @media print {
            #cuerpoPagina {
                margin: 0 auto;
            }

            @page {
                margin-left: 0.8in;
                margin-right: 0.8in;
                margin-top: 0;
                margin-bottom: 0;
            }
        }
    </style>
</head>

<body id="cuerpoPagina" style="margin: 0px 50px;">
    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png"
                border="0" style="cursor:pointer" title="Imprimir"></a></div>

    <div class="zona_impresion" style="width: 90%;">
        <?php
        include "core/autoload.php";
        include "core/modules/index/model/VentaData.php";
        include "core/modules/index/model/SuccursalData.php";
        include "core/modules/index/model/SucursalUusarioData.php";
        include "core/modules/index/model/UserData.php";
        include "core/modules/index/model/ProveedorData.php";
        include "core/modules/index/model/ClienteData.php";
        include "core/modules/index/model/AccionData.php";
        include "core/modules/index/model/MonedaData.php";
        include "core/modules/index/model/OperationData.php";
        include "core/modules/index/model/ConfigFacturaData.php";
        include "core/modules/index/model/ProductoData.php";
        $date1 = $_GET["sd"];
        $date2 = $_GET["ed"];

        $sucurs = $_GET["id_sucursal"];
        $date1 = $_GET["sd"];
        $date2 = $_GET["ed"];

        $sucurs = $_GET["id_sucursal"];
        if ($_GET["prod"] === "todos") {
            $ops = OperationData::getByProductoId2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
        } else {
            $ops = OperationData::getByProductoId($_GET["id_sucursal"], $_GET["prod"], $_GET["sd"], $_GET["ed"]);
        }
        //$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        $operations = array();
        $cantidad = array();
        // var_dump($ops);
        if (count($ops) > 0) {
            foreach ($ops as $op) {
                // var_dump()
                $d = VentaData::getId($op->venta_id);
                if ($_GET['cliente'] == 'todos') {
                    if ($d->cliente_id !== NULL) {
                        array_push($operations, VentaData::getId($op->venta_id));
                        array_push($cantidad, $op->q);
                    }
                } else if ($d->cliente_id == $_GET['cliente']) {
                    array_push($operations, VentaData::getId($op->venta_id));
                    array_push($cantidad, $op->q);
                }
                // $operations = VentaData::getId($op->venta_id);
            }
        } else {
            echo "No hay Ventas";
        }
        if (count($ops) > 0) {
            foreach ($ops as $op) {
                // var_dump()
                $d = VentaData::getId($op->venta_id);
                if ($_GET['cliente'] == 'todos') {
                    if ($d->cliente_id !== NULL) {
                        array_push($operations, VentaData::getId($op->venta_id));
                    }
                } else if ($d->cliente_id == $_GET['cliente']) {
                    array_push($operations, VentaData::getId($op->venta_id));
                }
                // $operations = VentaData::getId($op->venta_id);
            }
        } else {
            echo "No hay Ventas";
        }
        // var_dump($ops);
        
        $total = 0;
        $totall = 0;
        $sucur = SuccursalData::VerId($_GET["id_sucursal"]);

        ?>
        <div class="" style="text-align: end;">
            <?php
            $DateAndTime = date('d-m-Y h:i:s a', time());
            echo " Fecha: $DateAndTime.";
            ?>
        </div>
        <div class="" style="text-align: center;">
            <img src="./<?php echo $sucur->logo ?>" height="150" alt="">
        </div>
        <h1 style="text-align: center;">Libro ventas del <?php echo $date1 ?> al <?php echo $date2 ?></h1>

        <?php

        $date1 = $_GET["sd"];
        $date2 = $_GET["ed"];

        $sucurs = $_GET["id_sucursal"];
        if ($_GET["prod"] == "todos") {
            $ops = OperationData::getByProductoId2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
        } else {
            $ops = OperationData::getByProductoId($_GET["id_sucursal"], $_GET["prod"], $_GET["sd"], $_GET["ed"]);
        }
        // echo $ops;
        //$sucursales = SuccursalData::VerId($_GET["id_sucursal"]);
        $operations = array();
        $cantidad = array();
        // var_dump($ops);
        if (count($ops) > 0) {
            foreach ($ops as $op) {
                // var_dump()
                $d = VentaData::getId($op->venta_id);
                if ($_GET['cliente'] == 'todos') {
                    if ($d->cliente_id !== NULL) {
                        array_push($operations, VentaData::getId($op->venta_id));
                        array_push($cantidad, $op->q);
                    }
                } else if ($d->cliente_id == $_GET['cliente']) {
                    array_push($operations, VentaData::getId($op->venta_id));
                    array_push($cantidad, $op->q);
                }
                // $operations = VentaData::getId($op->venta_id);
            }
        } else {
            echo "No hay Ventas";
        }
        $total = 0;
        $totall = 0;
        ?>
        <h1>Libro ventas del <?php echo $date1 ?> al <?php echo $date2 ?></h1>
        <table class="table">
            <thead>
                <tr>
                    <th>RUC</th>

                    <th>Cliente</th>
                    <th>Factura</th>
                    <th>Timbrado</th>
                    <th>Fecha</th>
                    <th>Cajas</th>
                    <th>Producto</th>
                    <th>Gravada 10</th>
                    <th>IVA 10</th>
                    <th>Gravada 5</th>
                    <th>IVA 5</th>
                    <th>Exentas</th>
                    <th>Total</th>
                    <th>Total $USD</th>
                    <th>Cambio</th>
                    <th>Cond. de venta</th>
                    <th>Fecha</th>

                </tr>
            </thead>


            <?php
            $total = 0;
            $totalg = 0;
            $totali = 0;

            $totalg5 = 0;
            $totalii5 = 0;
            $totalexent = 0;
            $totalusd = 0;
            $totalcajas = 0;
            $cambio = 0;
            $j = 0;
            foreach ($operations as $operation) {
                $totalg = $totalg + $operation->total10;
                $totali = $totali + $operation->iva10;

                $totalg5 = $totalg5 + $operation->total5;
                $totalii5 = $totalii5 + $operation->iva5;
                $totalexent = $totalexent + $operation->exenta;



                if ($operation->simbolo2 == "US$") {
                    $cambio = $operation->cambio;
                } else if (($operation->simbolo2 == "₲") and ($operation->cambio == 1)) {
                    $cambio = $operation->cambio2;
                } else if (($operation->simbolo2 == "₲") and ($operation->cambio > 1)) {
                    $cambio = 1;
                }


                $cambio = $operation->cambio2;
                $total = $total + ($operation->total - $operation->descuento) * $cambio;

                $totalusd = $totalusd + $operation->total;
                ?>
                <tr>
                    <td>
                        <?php
                        if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                            echo "X";
                        } else {
                            echo substr($operation->getCliente()->dni, 0, 12);
                        }
                        ?>
                    </td>


                    <td><?php echo ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                        : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido) ?></td>
                    <td><?php echo $operation->factura ?></td>
                    <td><?php echo $operation->VerConfiFactura()->timbrado1 ?></td>
                    <td><?php echo $operation->fecha ?></td>
                    <td><?php echo $cantidad[$j];
                    $totalcajas += $cantidad[$j]; ?></td>
                    <td>
                        <?php
                        $op = OperationData::getAllProductsBySellIddd($operation->id_venta);
                        $fila = $op[0]->is_sqlserver ? "id_sqlserver" : "id_producto";
                        echo ProductoData::getById($op[0]->producto_id, $fila)->nombre ?>
                    </td>
                    <td><?php echo number_format(($operation->total10 * $cambio), 0, ',', '.') ?></td>
                    <td><?php echo number_format(($operation->iva10 * $cambio), 0, ',', '.') ?></td>
                    <td><?php echo number_format(($operation->total5 * $cambio), 0, ',', '.') ?></td>
                    <td><?php echo number_format(($operation->iva5 * $cambio), 0, ',', '.') ?></td>
                    <td><?php echo number_format($operation->descuento, 0, '.', '.') ?></td>
                    <td><?php echo number_format(($operation->total * $cambio), 0, ',', '.') ?></td>
                    <td><?php

                    echo number_format(($operation->total), 2, ',', '.') ?></td>
                    <td><?php echo number_format(($cambio), 2, ',', '.') ?></td>
                    <td><?php echo $operation->metodopago ?></td>
                    <td><?php echo $operation->fecha ?></td>

                </tr>
                <?php $j += 1;
            } ?>
            <tr>
                <td></td>
                <td></td>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $totalcajas ?></td>

                <td><?= number_format(($totalg * $cambio), 0, ',', '.') ?></td>
                <td><?= number_format(($totali * $cambio), 0, ',', '.') ?></td>
                <td><?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></td>

                <td><?= number_format(($totalii5 * $cambio), 0, ',', '.') ?></td>
                <td><?= number_format(($totalexent * $cambio), 0, ',', '.') ?></td>

                <td><?php echo number_format(($total), 2, ',', '.') ?></td>
                <td><?php echo number_format(($totalusd), 2, ',', '.') ?></td>
                <td></td>
                <td></td>

                <td></td>
                <td></td>
            </tr>



        </table>
    </div>
</body>

</html>