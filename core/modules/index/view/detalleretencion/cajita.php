<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
            DETALLE RETENCION
            <!-- <marquee> Lista de Medicamentos</marquee> -->
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <?php if (isset($_GET["id"]) && $_GET["id"] != "") : ?>
                            <?php
                            // $sell = VentaData::getById($_GET["COBRO_ID"]);


                            // $operations = CobroDetalleData::totalcobrosdet($sell->COBRO_ID );

                            $sucursales = new SuccursalData();
                            $operations = RetencionDetalleData::retencion($_GET["id"]);
                            // var_dump($operations[0]->SUCURSAL_ID);
                            $suc = $sucursales->VerId($operations[0]->sucursal);
                            ?>



                            

                        <?php endif; ?>
                        </table>
                        <br>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>N°</th>

                                <th>FACTURA</th>
                                <th>CLIENTE</th>
                                <th>IMPOROTE RETENCION</th>
                                <th>FECHA</th>



                            </thead>
                            <?php

                            foreach ($operations as $operation) {



                            ?>
                                <tr>

                                    <td style="width:100px;"><?php echo $operation->usuario; ?></td>






                                    <td style="width:150px;"><?php echo $operation->factura; ?></td>





                                    <td>


                       <?php if ($operation->getCliente()->tipo_doc == "SIN NOMBRE") {
                      $operation->getCliente()->tipo_doc;
                $cliente = $operation->getCliente()->tipo_doc;
                        echo $cliente;
                        } else {
                       $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido;
                         $cliente = $operation->getCliente()->nombre . " " . $operation->getCliente()->apellido;

                           echo $cliente;
                    }                                                ?>


                       </td>


                                    <td ><?php echo number_format($operation->importe, 2); ?></td>


                                    <td ><?php echo $operation->fecha_auditoria;  ?></td>

                                </tr>
                            <?php
                            }
                            ?>



                        </table>
                        <br><br>
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table table-bordered">


                                </table>
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-body">
                                <div class="box box-danger">
                                </div>



                            </div>
                        </div>
                        <!-- <a href="btn btn-primary btn-sm btn-flat">Imprimir recibo</a> -->
                      
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>