<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class='fa fa-shopping-cart' style="color: orange;"></i>
      DETALLE COBROS
      <!-- <marquee> Lista de Medicamentos</marquee> -->
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <?php if (isset($_GET["COBRO_ID"]) && $_GET["COBRO_ID"] != "") : ?>
              <?php
              // $sell = VentaData::getById($_GET["COBRO_ID"]);


              // $operations = CobroDetalleData::totalcobrosdet($sell->COBRO_ID );

              $sucursales = new SuccursalData();
              $operations = CobroDetalleData::cobranza_credito($_GET["COBRO_ID"]);
              // var_dump($operations[0]->SUCURSAL_ID);
              $suc = $sucursales->VerId($operations[0]->SUCURSAL_ID);
              ?>



              <tr>



              </tr>


              <tr>

              </tr>

            <?php endif; ?>
            </table>
            <br>
            <table class="table table-bordered table-hover">
              <thead>
                <th>Codigo cobro</th>

                <th>Numero factura</th>
                <th>Cliente</th>
              
                <th>Importe cobro</th>
                <th>Importe credito</th>


              </thead>
              <?php
               $total_cobro=0;

              foreach ($operations as $operation) {

                
              ?>
                <tr>

                  <td style="width:30px;"><?php echo $operation->COBRO_ID; ?></td>






                  <td style="width:30px;"><?php echo $operation->NUMERO_FACTURA; ?></td>





                 <td style="width:30px;">

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


                  <td style="width:30px;"><?php echo number_format($operation->IMPORTE_COBRO, 2);

              

				  ?></td>


                  <td style="width:30px;"><?php echo number_format($operation->IMPORTE_CREDITO, 2);  ?></td>

                </tr>
              <?php
              }
			  
			  
			    $total_cobro =  $total_cobro+$operation->IMPORTE_COBRO;
              ?>



            </table>
            <br><br>
            <div class="row">
              <div class="col-md-4">
                <table class="table table-bordered">

 				
  <?php echo 'Total cobro: ' ; 
              ?>
			  
			  
			   <td style="width:30px;"><?php echo number_format($total_cobro, 2);


				  ?></td>
			  
			  
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
            <?php if ($suc->tipo_recibo == 0) { ?>
              <a target="_BLANK" href="impresioncobro.php?cobro=<?php echo $_GET["COBRO_ID"] ?>" class="btn btn-primary btn-sm btn-flat"><i class='fa fa-file-code-o' style="color: orange"></i> IMPRIMIR RECIBO</a>
            <?php }
            if ($suc->tipo_recibo == 1) { ?>
              <a target="_BLANK" href="impresioncobro_2.php?cobro=<?php echo $_GET["COBRO_ID"] ?>" class="btn btn-primary btn-sm btn-flat"><i class='fa fa-file-code-o' style="color: orange"></i> IMPRIMIR RECIBO</a>

            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>