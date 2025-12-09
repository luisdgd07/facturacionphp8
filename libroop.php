         <script>
             function printPantalla() {

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
            $sucur = SuccursalData::VerId($_GET["id_sucursal"]);
            $sucurs = $_GET["id_sucursal"];
            $operations  = VentaData::versucursaltipotrans2($_GET["id_sucursal"], $_GET["sd"], $_GET["ed"]);
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
         <div style="margin-left:245px; "><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>

         <h1 style="text-align: center;">Operaciones del <?php

                                                            $date1 = $_GET["sd"];
                                                            $date2 = $_GET["ed"];
                                                            echo $date1 ?> al <?php echo $date2 ?></h1>
         <table class="table table-bordered table-dark">
             <thead>
                 <tr>
                     <th>Nro.</th>
                     <th>Producto.</th>
                     <th>Cajas</th>
                     <th>Tipo de transacción</th>
                     <th>Usuario</th>
                     <th>Fecha</th>
                 </tr>
             </thead>

             <tbody>
                 <?php
                    $totalcajas = 0;

                    $total = 0;
                    $totalg = 0;
                    $totali = 0;

                    $totalg5 = 0;
                    $totalii5 = 0;
                    $totalexent = 0;
                    $totalusd = 0;

                    $cambio = 0;
                    $j = 0;
                    foreach ($operations as $sell) {
                        $totalproducts = 0;
                        // $totalg = $totalg + $operation->total10;
                        // $totali = $totali + $operation->iva10;

                        // $totalg5 = $totalg5 + $operation->total5;
                        // $totalii5 = $totalii5 + $operation->iva5;
                        // $totalexent = $totalexent + $operation->exenta;



                        // if ($operation->simbolo2 == "US$") {
                        //     $cambio = $operation->cambio;
                        // } else if (($operation->simbolo2 == "₲") and  ($operation->cambio == 1)) {
                        //     $cambio = $operation->cambio2;
                        // } else if (($operation->simbolo2 == "₲") and  ($operation->cambio > 1)) {
                        //     $cambio = 1;
                        // }


                        // $cambio = $operation->cambio2;
                        // $total = $total + ($operation->total - $operation->descuento) * $cambio;

                        // $totalusd = $totalusd + $operation->total;
                    ?>
                     <tr>
                         <?php
                            $operations = OperationData::getAllProductsBySellIddd($sell->id_venta);
                            count($operations);
                            foreach ($operations as $selldetalle) {

                                if ($_GET['prod'] == "todos") {
                                    $totalcajas
                                        += $selldetalle->q;
                            ?>
                                 <td><?php echo $sell->id_venta; ?>
                                 </td>


                                 <td>
                                     <?php $prod = ProductoData::getProducto2($selldetalle->producto_id);  ?>


                                     <?php foreach ($prod as $detalle) : ?>


                                         <?php echo $detalle->nombre; ?>

                                     <?php endforeach; ?></td>
                                 <td> <?php echo $selldetalle->q; ?></td>
                                 <td> <?php if ($sell->accion_id == 1) {
                                            echo  "Entrada";
                                        } else if ($sell->accion_id == 2) {
                                            echo  "Salida";
                                        } else if ($sell->accion_id == 3) {
                                            echo  "Trasferencia";
                                        } ?></td>
                                 <td><?php if ($sell->usuario_id != "") {
                                            $user = $sell->getUser();
                                        ?>
                                     <?php echo $user->nombre . " " . $user->apellido;
                                        } ?></td>
                                 <td><?php echo $sell->fecha; ?></td>


                                 <?php } else {
                                    if ($selldetalle->producto_id == $_GET['prod']) {
                                        $totalcajas
                                            += $selldetalle->q;
                                    ?>

                                     <td><?php echo $sell->id_venta; ?>
                                     </td>


                                     <td>
                                         <?php $prod = ProductoData::getProducto2($selldetalle->producto_id);  ?>


                                         <?php foreach ($prod as $detalle) : ?>


                                             <?php echo $detalle->nombre; ?>

                                         <?php endforeach; ?></td>
                                     <td> <?php echo $selldetalle->q; ?></td>
                                     <td> <?php if ($sell->accion_id == 1) {
                                                echo  "Entrada";
                                            } else if ($sell->accion_id == 2) {
                                                echo  "Salida";
                                            } else if ($sell->accion_id == 3) {
                                                echo  "Trasferencia";
                                            } ?></td>
                                     <td><?php if ($sell->usuario_id != "") {
                                                $user = $sell->getUser();
                                            ?>
                                         <?php echo $user->nombre . " " . $user->apellido;
                                            } ?></td>
                                     <td><?php echo $sell->fecha; ?></td>
                     <?php
                                    }
                                }
                            }
                            $j += 1;
                        } ?>

                     </tr>

                     <tr>
                         <td>
                         </td>


                         <td>
                         </td>
                         <td><?php echo $totalcajas ?></td>
                         <td></td>
                         <td></td>
                         <td></td>

                     </tr>
             </tbody>
         </table>