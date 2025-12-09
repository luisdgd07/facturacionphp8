<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <!-- <link rel="stylesheet" type="text/css" href="ticket.css"> -->
    <script>
        function printPantalla() {
            // document.getElementById('cuerpoPagina').style.marginRight = "0";
            // document.getElementById('cuerpoPagina').style.marginTop = "1";
            // document.getElementById('cuerpoPagina').style.marginLeft = "1";
            document.getElementById('cuerpoPagina').style.marginBottom = "0";
            document.getElementById('botonPrint').style.display = "none";
            var elms = document.querySelectorAll("[id='impresion']");

            for (var i = 0; i < elms.length; i++) {

                elms[i].style.marginBottom = "-125px";

            }
            // document.getElementsByClassName("impresion").style.marginBottom = "-125px";
            // document.getElementById('impresion').style.marginBottom = "-125px";
            // document.getElementById('impresion')[1].style.marginBottom = "-125px";
            // document.getElementById('impresion')[2].style.marginBottom = "-125px";
            // document.getElementById('impresion').style.marginBottom = "-125px";
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
    <?php
    include "core/autoload.php";
    include "core/modules/index/model/ChoferData.php";
    include "core/modules/index/model/VehiculoData.php";
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
    ?>
    <div class="zona_impresion">

        <?php for ($i = 0; $i < 4; $i++) { ?>

            <?php
            // $caja = new CajaCabecera();
            // $cobro = new CobroCabecera();
            // $cifra = new CifrasEnLetras();

            // $dataCobro = $cobro->getCobro($_GET['cobro']);
            // // var_dump($dataCobro);

            // // $detalle = $caja->obtener($_GET['cobro']);
            $total = 0;
            $sucuarsal = new SuccursalData();
            $ventas = VentaData::getById($_GET["id_venta"]);
            $choferid = $ventas->id_chofer;
            $vehiId = $ventas->id_vehiculo;

            $sucursal = $sucuarsal->VerId($ventas->sucursal_id);

            $procesos = OperationData::getAllProductsBySellIddd($_GET["id_venta"]);
            // var_dump($ventas);
            $cliente = new ClienteData();
            $dataCliente = $cliente->getById($ventas->cliente_id);
            $vehi = new VehiculoData();
            $vehiculo = $vehi->getId($vehiId);
            $cho = new ChoferData();
            $chofer = $cho->getId($choferid);
            ?>
            <div id="impresion" style="
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  ">

                <table style="  width: 33%;margin-left:10%">
                    <thead>
                        <td style="width:50%;  font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" align="center"></td>

                    </thead>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($ventas->numerocorraltivo >= 1 & $ventas->numerocorraltivo < 10) : ?>
                            <?= $ventas->VerConfiFactura()->serie1 . "-" . "000000" . $ventas->numerocorraltivo ?>
                        <?php else : ?>
                            <?php if ($ventas->numerocorraltivo >= 10 & $ventas->numerocorraltivo < 100) : ?>
                                <?= $ventas->VerConfiFactura()->serie1 . "-" . "00000" . $ventas->numerocorraltivo ?>
                            <?php else : ?>
                                <?php if ($ventas->numerocorraltivo >= 100 & $ventas->numerocorraltivo < 1000) : ?>
                                    <?= $ventas->VerConfiFactura()->serie1 . "-" . "0000" . $ventas->numerocorraltivo ?>
                                <?php else : ?>
                                    <?php if ($ventas->numerocorraltivo >= 1000 & $ventas->numerocorraltivo < 10000) : ?>
                                        <?= $ventas->VerConfiFactura()->serie1 . "-" . "000" . $ventas->numerocorraltivo ?>
                                    <?php else : ?>
                                        <?php if ($ventas->numerocorraltivo >= 100000 & $ventas->numerocorraltivo < 1000000) : ?>
                                            <?= $ventas->VerConfiFactura()->serie1 . "-" . "00" . $ventas->numerocorraltivo ?>
                                        <?php else : ?>
                                            <?php if ($ventas->numerocorraltivo >= 1000000 & $ventas->numerocorraltivo < 10000000) : ?>
                                                <?= $ventas->VerConfiFactura()->serie1 . "-" . "0" . $ventas->numerocorraltivo ?>
                                            <?php else : ?>
                                                SIN ACCION
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endif ?>
                            <?php endif ?>
                        <?php endif ?></td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"> <?= $ventas->fecha ?></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"><?php echo $dataCliente->nombre . " " . $dataCliente->apellido;
                                                                                                            ?></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"> <?php if ($dataCliente->dni != NULL) {
                                                                                                                    echo $dataCliente->dni;
                                                                                                                } else {
                                                                                                                    echo $dataCliente->ruc;
                                                                                                                }
                                                                                                                ?></td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>
                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"><?= $ventas->timbrado2 ?> </td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"> <?= $ventas->fecha ?></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;">
                            <?php echo $sucursal->descripcion ?></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"></td>

                    </tr>
                    <tr>
                        <td style="width:20%;font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"><?php
                                                                                                            echo $vehiculo->marca;
                                                                                                            ?></td>

                    </tr>
                    <tr>
                        <td style="width:20%;font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"><?php
                                                                                                            echo $vehiculo->chapa_nro;
                                                                                                            ?></td>

                    </tr>
                    <tr>
                        <td style="width:20%;font-size: 12px; font-family:  Arial, Helvetica, sans-serif;"><?php
                                                                                                            echo $chofer->nombre;
                                                                                                            ?></td>

                    </tr>
                    <tr>
                        <td style="width:20%;font-size: 12px; font-family:  Arial, Helvetica, sans-serif;">Placa Inicio: <?php echo $ventas->ninicio ?> Fin: <?php echo $ventas->nfin ?></td>

                    </tr>
                </table>
                <table style="  width: 30%;">
                    <thead>
                        <td style="width:30%;  font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" align="center"> </td>
                    </thead>
                    <tr>
                        <td style="width:5%; font-size: 12px; font-family:  Arial, Helvetica, sans-serif;" align="center"></td>
                        <td style="font-size: 12px; font-family:  Arial, Helvetica, sans-serif;" align="center"></td>
                        <td style="width:20%;font-size: 12px; font-family:  Arial, Helvetica, sans-serif;" align="center"></td>
                    </tr>
                    <?php
                    $c = 70;
                    foreach ($procesos as $proceso) :
                        $c--;
                        $ventas1  = $proceso->getProducto(); ?>
                        <tr>

                            <td style="width:5%; font-size: 11px; font-family:  Arial, Helvetica, sans-serif;" align="center"><?= $proceso->q ?>&nbsp;&nbsp;</td>
                            <td style="width:5%; font-size: 11px; font-family:  Arial, Helvetica, sans-serif;" align="center">Caja &nbsp;&nbsp;</td>

                            <!-- <td style="width:50%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"></td> -->
                            <td align="right" style="width:10%; font-size: 11px;font-family:  Arial, Helvetica, sans-serif;"><?= $ventas1->nombre ?>&nbsp;&nbsp; </td>
                        </tr>
                    <?php endforeach;

                    for ($p = 0; $p < $c; $p++) { ?>
                        <tr>
                            <td style="width:10%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;" align="center"></td>
                            <td style="width:50%; font-size: 14px; font-family:  Arial, Helvetica, sans-serif;"></td>
                            <td align="right" style="width:10%; font-size: 14px;font-family:  Arial, Helvetica, sans-serif;"></td>
                        </tr>
                    <?php
                    }
                    ?>


                </table>
            </div>



            <br>

            <!-- <span>
                Fecha:&nbsp;&nbsp; Asunción <?= date('d', time());
                                            echo " de " . $meses[date('n') - 1];
                                            echo " de " . date('Y', time()); ?>&nbsp;&nbsp;
            </span> -->
            <br>
        <?php } ?>
    </div>
    <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>

    <!-- <div style="margin-left:445px;" class=""><a href="/index.php?view=cobranza1&id_sucursal=<?php echo $detalle->SUCURSAL_ID ?>">Volver</a></div> -->


    <br>
</body>

</html>