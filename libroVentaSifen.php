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
               @page {
                   margin: 2px;
                   size: auto;
               }
           }
       </style>
   </head>

   <body id="cuerpoPagina">
       <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>

       <div class="zona_impresion" style="width: 100%;">
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

            $date1 = $_GET["sd"];
            $date2 = $_GET["ed"];
            $sucurs = $_GET["id_sucursal"];
            $ops = VentaData::getAllPersonalizado($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta'], $_GET['cliente']);
            // var_dump($suc);

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
           <?php
            $date1 = $_GET["sd"];
            $date2 = $_GET["ed"];
            $sucurs = $_GET["id_sucursal"];
            $ops = VentaData::getAllPersonalizado($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta'], $_GET['cliente']);
            // echo $ops;
            // if ($_GET["prod"] == "todos" && $_GET['venta'] == "todos") {
            // $ops = VentaData::getAllByDateOfficialGs3($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"]);
            // } else if ($_GET['prod'] != "todos" && $_GET['venta'] == "todos") {
            // $ops = VentaData::getAllByDateOfficialGs4($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod']);
            // } else if ($_GET['prod'] == "todos" && $_GET['venta'] != "todos") {
            // $ops = VentaData::getAllByDateOfficialGs5($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['venta']);
            // } else if ($_GET['prod'] != "todos" && $_GET['venta'] == "todos") {
            // $ops = VentaData::getAllByDateOfficialGs4($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod']);
            // } else if ($_GET['prod'] == "todos" && $_GET['venta'] != "todos") {
            // $ops = VentaData::getAllByDateOfficialGs5($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['venta']);
            // } else if ($_GET['prod'] != "todos" && $_GET['venta'] == "todos") {
            // $ops = VentaData::getAllByDateOfficialGs4($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod']);
            // } else if ($_GET['prod'] == "todos" && $_GET['venta'] != "todos") {
            // $ops = VentaData::getAllByDateOfficialGs5($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['venta']);
            // } else {
            // $ops = VentaData::getAllByDateOfficialGs6($_GET["sd"], $_GET["ed"], $_GET["id_sucursal"], $_GET['prod'], $_GET['venta']);
            // }


            $total = 0;
            $totall = 0;
            $totalg = 0;
            $totali = 0;

            $totalg5 = 0;
            $totalii5 = 0;
            $totalexent = 0;
            $totalusd = 0;
            $tg10 = 0;
            $ti10 = 0;

            $cambio = 0;
            $totalcajas = 0;
            ?>
           <h1>Libro ventas del <?php echo $date1 ?> al <?php echo $date2 ?></h1>


           <table>
               <thead>
                   <th>RUC</th>
                   <th>Cliente</th>
                   <th>Factura</th>
                   <th>Cajas</th>
                   <th>Producto</th>
                   <th>Fecha</th>
                   <th>Gravada 10</th>
                   <th>IVA 10</th>
                   <th>Gravada 5</th>
                   <th>IVA 5</th>
                   <th>Exentas</th>
                   <th>Total</th>
                   <th>Total $USD</th>
                   <th>Cambio</th>
                   <th>Cond. de venta</th>
                   <th>Tipo</th>
                   <th>Aprobado SIFEN</th>



               </thead>
               <tbody>
                   <?php
                    foreach ($ops as $operation) {


                        $totalg = $totalg + $operation->total10;
                        $totali = $totali + $operation->iva10;

                        $totalg5 = $totalg5 + $operation->total5;
                        $totalii5 = $totalii5 + $operation->iva5;
                        $totalexent = $totalexent + $operation->exenta;



                        if ($operation->simbolo2 == "US$") {
                            $cambio = $operation->cambio;
                        } else {
                            $cambio = 1;
                        }


                        $cambio = $operation->cambio2;
                        $total = $total + ($operation->total - $operation->descuento) * $cambio;
                        $totalusd = $totalusd + $operation->total;
                        if ($operation->cliente_id !== NULL) {
                    ?>
                           <tr>
                               <td><?php
                                    $tg10 += $operation->total10 * $cambio;
                                    $ti10 += $operation->iva10 * $cambio;
                                    if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                                        echo "X";
                                    } else {
                                        echo substr($operation->getCliente()->dni, 0, 12);
                                    }
                                    ?></td>
                               <td><?php echo ($operation->getCliente()->tipo_doc == "SIN NOMBRE" ? $operation->getCliente()->tipo_doc
                                        : $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido) ?></td>
                               <td><?php echo $operation->factura ?></td>

                               <td><?php
                                    $prods = OperationData::getAllProductsBySellIddd($operation->id_venta);
                                    $q = 0;
                                    foreach ($prods as $prod) {
                                        $q += $prod->q;
                                    }
                                    $totalcajas += $q;
                                    echo $q;
                                    ?></td>
                               <td><?php echo ProductoData::getById($prods[0]->producto_id)->nombre ?></td>

                               <td><?php echo $operation->fecha ?></td>

                               <td><?php echo number_format(($operation->total10 * $cambio), 0, ',', '.') ?></td>
                               <td><?php echo number_format(($operation->iva10 * $cambio), 0, ',', '.') ?></td>
                               <td><?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></td>
                               <td><?= number_format(($totalii5 * $cambio), 0, ',', '.') ?></td>

                               <td style=""><?php echo number_format(($operation->total5 * $cambio), 0, ',', '.') ?></td>
                               <td><?php echo number_format(($operation->total * $cambio), 0, ',', '.') ?></td>

                               <td><?php

                                    echo number_format(($operation->total), 2, ',', '.') ?></td>
                               <td><?php echo number_format(($cambio), 2, ',', '.') ?></td>
                               <td><?php echo $operation->metodopago ?></td>
                               <td><?php if ($operation->tipo_venta == 4) {
                                        echo "Remision";
                                    } else if ($operation->tipo_venta == 0) {
                                        echo "Venta";
                                    } else if ($operation->tipo_venta == 5) {
                                        echo "Venta de una remision";
                                    } else {
                                        echo $operation->tipo_venta;
                                    }
                                    ?></td>
                               <td><?php echo $operation->enviado ?></td>
                           </tr>
                   <?php }
                    } ?>
                   <tr>
                       <td><b>Total</b></td>
                       <td><b></td>
                       <td><b></td>
                       <td><b><?php echo $totalcajas ?></b></td>
                       <td><b></td>
                       <td><b></td>
                       <td><b> <?= number_format($tg10, 0, ',', '.') ?></b></td>
                       <td><b> <?= number_format($ti10, 0, ',', '.') ?></b></td>
                       <!-- <td><b><?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></b></td> -->
                       <td><b><?= number_format(($totalg5 * $cambio), 0, ',', '.') ?></b></td>
                       <td><b><?= number_format(($totalii5 * $cambio), 0, ',', '.') ?></b></td>
                       <td><b><?= number_format(($totalexent * $cambio), 0, ',', '.') ?></b></td>
                       <td><b><?php echo number_format(($total), 2, ',', '.') ?></b></td>
                       <td><b><?php echo number_format(($totalusd), 2, ',', '.')  ?></b></td>
                       <td><b></td>
                       <td><b></td>
                       <td><b></td>
                       <td><b></td>
                   </tr>
               </tbody>
           </table>
       </div>
   </body>

   </html>