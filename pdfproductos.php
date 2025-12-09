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
             @page {
                 size: A4;
                 margin: auto
             }

             @media print {

                 html,
                 body {
                     width: 210mm;
                     height: 297mm;

                 }

                 /* ... the rest of the rules ... */
             }
         </style>
     </head>

     <body id="cuerpoPagina">
         <div class="zona_impresion" style="width: 70%;margin:0px 100px">
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
                include "core/modules/index/model/StockData.php";

                $date1 = $_GET["sd"];
                $date2 = $_GET["ed"];

                ?>


             <?php if (isset($_GET['categoria'])) {
                    echo '<h1>Reporte de productos del ' . $date1 . ' al ' . $date2 . '</h1>'; ?>
                 <div style="margin-left:245px;"><button id="botonPrint" onClick="printPantalla()"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></button></div>
                 <br>
                 <?php
                    $operationData = "";
                    if ($_GET['categoria'] == 'todos') {

                        $operationData = ProductoData::verproductosucursal($_GET['id_sucursal']);
                    } else if ($_GET['producto'] == 'todos') {
                        $operationData = ProductoData::verproductoscate($_GET['categoria']);
                    } else {
                        $operationData = ProductoData::getProducto2($_GET['producto']);
                    }
                    foreach ($operationData as $op) {
                        $stocks2 = StockData::vercontenidos($op->id_producto);
                    ?>
                     <?php $concepto = ProductoData::categorian($op->categoria_id); ?>
                     <?php

                        foreach ($concepto as $cambios) {
                            if ($cambios) {


                                $categ = $cambios->nombre;
                            }
                        }

                        ?>
                     <b> <?php echo $op->codigo;
                            ?> </b>

                     <b>-- <?php echo $op->nombre ?></b>

                     <b> -- Stock Actual: <?php
                                            $stock = StockData::vercontenidos2($op->id_producto);
                                            echo $stock->CANTIDAD_STOCK;
                                            ?></b>























                     <?php $concepto = ProductoData::deposito($stock->DEPOSITO_ID); ?>
                     <?php

                        foreach ($concepto as $cambios) {
                            if ($cambios) {


                                $camnbio = $cambios->NOMBRE_DEPOSITO;
                            }
                        }

                        ?>


                     <td><b>-- Almacen: <?php echo $camnbio; ?></b></td>


                     <?php
                        $opert = OperationData::getByProductoId4($_GET['id_sucursal'], $op->id_producto, $_GET['sd'], $_GET['ed']);
                        $anterior = $stock->CANTIDAD_STOCK; ?>
                     <table class="table table-bordered table-hover table-responsive ">
                         <thead>
                             <th style="width: 50px;">ENTRADA</th>
                             <th style="width: 50px ;">SALIDA</th>
                             <th style="width: 50px;">STOCK</th>
                             <th style="width: 50px;">FECHA</th>

                         </thead>
                         <?php
                            if ($opert > 0) {
                                foreach ($opert as $op) {
                            ?>

                                 <tr>

                                     <?php if ($op->accion_id == 1) {
                                            $anterior -= $op->q;
                                        ?>
                                         <td>
                                             <?php
                                                echo  $op->q; ?></td>
                                         <td>0,00</td>
                                     <?php
                                        } else if ($op->accion_id == 2) {
                                            $anterior += $op->q;
                                        ?>
                                         <td>0,00</td>
                                         <td>
                                             <?php
                                                echo  $op->q; ?></td>

                                     <?php
                                        }  ?>


                                     <td><?php echo $anterior; ?></td>










                                     <td><?php echo $op->fecha ?> </td>















                                 </tr>
                         <?php }
                            } ?>
                     </table>

                 <?php } ?>




                 <br>
                 <hr>


                 <div class="row">
                     <div class="col-lg-2">


                         <!-- <h3>Total: <?php echo  number_format($total, 2, ',', ' '); ?></h3> -->



                     </div>


                 </div>




                 <div class="row">



                 </div>
                 <div class="form-group">

                 <?php } ?>

                 </div>

         </div>
     </body>

     </html>